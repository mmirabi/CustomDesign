<?php
/**
*
*   (p) package: Custom Design
*   (c) author: Mehdi Mirabi
*   (i) website: https://www.magicrugs.com
*
*/

if (!defined('CUSTOMDESIGN')) {
	return header('HTTP/1.0 403 Forbidden');
}

class customdesign_secure{
	
	static function create_nonce($name) {
		
		global $customdesign;
		
		$session_id	 = customdesign_secure::esc($_COOKIE['CUSTOMDESIGNSESSID']);
		$name		 = customdesign_secure::esc($name);
		$time 		 = time();
		$db 		 = "{$customdesign->db->prefix}sessions";
		
		$nonce 		 = $customdesign->db->rawQuery(
			"SELECT `id`, `value`, `expires` 
				FROM `$db` 
				WHERE `author`='{$customdesign->vendor_id}' AND `session_id`='{$session_id}' AND `name`='{$name}'"
		);
		
		if (count($nonce) > 0) {
			
			$valid = false;
			
			foreach ($nonce as $no) {

				if (
					$no['expires'] > $time &&
					$valid === false
				) {
					
					if ($no['expires'] < $time+1000) {
						$customdesign->db->rawQuery(
							"UPDATE `$db` 
							SET `expires`=".($time+(60*60*24))." 
							WHERE `author`='{$customdesign->vendor_id}' AND `id`='{$no['id']}'"
						);
					}
					
					$valid = $no;
					
				}
				
			}
			
			if ( $valid !== false ) {
				
				if ( count($nonce) > 1 ) {
					$customdesign->db->rawQuery(
						"DELETE FROM `$db` WHERE `author`='{$customdesign->vendor_id}' AND `name`='{$name}' AND `session_id`='{$session_id}' AND `id` <> ".$valid['id']
					);
				}
				
				return $valid['value'];
			
			} else {
				$customdesign->db->rawQuery(
					"DELETE FROM `$db` WHERE `author`='{$customdesign->vendor_id}' AND `name`='{$name}' AND `session_id`='{$session_id}'"
				);
			}
			
		}
		
		$val = strtoupper($customdesign->generate_id(8));
		
		$customdesign->db->rawQuery(
			"INSERT INTO `$db` 
				(`id`, `name`, `value`, `author`, `expires`, `session_id`) 
				VALUES (NULL, '{$name}', '{$val}', '{$customdesign->vendor_id}', ".($time+(60*60*24)).", '{$session_id}')"
		);
		
		return $val;
		
	}
	
	static function check_nonce($name, $value) {
		
		global $customdesign;
		
		$db 			= "{$customdesign->db->prefix}sessions";
		$query			= "DELETE FROM `$db` WHERE `author`='{$customdesign->vendor_id}' AND `expires` < ".time();
		$nonce			= $customdesign->db->rawQuery($query);
		$time			= time();
		
		$session_id 	= customdesign_secure::esc($_COOKIE['CUSTOMDESIGNSESSID']);
		$name 			= customdesign_secure::esc($name);
		
		$nonce 			= $customdesign->db->rawQuery(
			"SELECT `id`, `value`, `expires` 
				FROM `$db` 
				WHERE `author`='{$customdesign->vendor_id}' AND `name`='{$name}' AND `session_id`='{$session_id}'"
		);
		
		$_return = false;
		
		if ( count($nonce) > 0 ) {
			
			foreach ($nonce as $no) {
				if (
					$no["value"] == $value &&
					$no['expires'] > $time &&
					$_return === false
				) {
					if (
						$no['expires'] < $time+1000
					) {
						$customdesign->db->rawQuery(
							"UPDATE `$db` 
							SET `expires`=".($time+(60*60*24))." 
							WHERE `author`='{$customdesign->vendor_id}' AND `id`='{$no['id']}'"
						);
					}
					
					$_return = $no['id'];
					
				}
				
			}
			
			$_return = $customdesign->apply_filters('check-nonce', $_return, $name, $value);
			
			if ( $_return !== false ) {
				
				if ( count($nonce) > 1 ) {
					$customdesign->db->rawQuery(
						"DELETE FROM `$db` WHERE `author`='{$customdesign->vendor_id}' AND `name`='{$name}' AND `session_id`='{$session_id}' AND `id` <> ".$_return
					);
				}
				
				return true;
			
			} else {
				return false;
			}
			
		} else {
			$_return = $customdesign->apply_filters('check-nonce', $_return, $name, $value);
			return $_return;
		}
		
	}
	
	static function nonce_exist($name, $value) {
		
		global $customdesign;
		
		$session_id	 = customdesign_secure::esc($_COOKIE['CUSTOMDESIGNSESSID']);
		$name		 = customdesign_secure::esc($name);
		$db 		 = "{$customdesign->db->prefix}sessions";
		$nonce 		 = $customdesign->db->rawQuery(
			"SELECT `value`, `expires` 
				FROM `$db`
				WHERE `author`='{$customdesign->vendor_id}' AND `name`='{$name}' AND `session_id`='{$session_id}'"
		);
		
		if (count($nonce) > 0 && $nonce[0]["value"] == $value) {
			return true;
		}else return false;
		
	}
	
	static function esc($string = '') {
		
	   $string = preg_replace('/[^A-Za-z0-9\-\_]/', '', $string);
	
	   return $string;

	}
	
}
