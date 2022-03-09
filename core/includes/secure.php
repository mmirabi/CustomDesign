<?php
/**
*	
*	(p) package: MagicRugs
*	(c) author:	Mehdi Mirabi
*	(i) website: https://www.magicrugs.com
*
*/

if (!defined('MAGIC')) {
	return header('HTTP/1.0 403 Forbidden');
}

class magic_secure{
	
	static function create_nonce($name) {
		
		global $magic;
		
		$session_id	 = magic_secure::esc($_COOKIE['MAGICSESSID']);
		$name		 = magic_secure::esc($name);
		$time 		 = time();
		$db 		 = "{$magic->db->prefix}sessions";
		
		$nonce 		 = $magic->db->rawQuery(
			"SELECT `id`, `value`, `expires` 
				FROM `$db` 
				WHERE `author`='{$magic->vendor_id}' AND `session_id`='{$session_id}' AND `name`='{$name}'"
		);
		
		if (count($nonce) > 0) {
			
			$valid = false;
			
			foreach ($nonce as $no) {

				if (
					$no['expires'] > $time &&
					$valid === false
				) {
					
					if ($no['expires'] < $time+1000) {
						$magic->db->rawQuery(
							"UPDATE `$db` 
							SET `expires`=".($time+(60*60*24))." 
							WHERE `author`='{$magic->vendor_id}' AND `id`='{$no['id']}'"
						);
					}
					
					$valid = $no;
					
				}
				
			}
			
			if ( $valid !== false ) {
				
				if ( count($nonce) > 1 ) {
					$magic->db->rawQuery(
						"DELETE FROM `$db` WHERE `author`='{$magic->vendor_id}' AND `name`='{$name}' AND `session_id`='{$session_id}' AND `id` <> ".$valid['id']
					);
				}
				
				return $valid['value'];
			
			} else {
				$magic->db->rawQuery(
					"DELETE FROM `$db` WHERE `author`='{$magic->vendor_id}' AND `name`='{$name}' AND `session_id`='{$session_id}'"
				);
			}
			
		}
		
		$val = strtoupper($magic->generate_id(8));
		
		$magic->db->rawQuery(
			"INSERT INTO `$db` 
				(`id`, `name`, `value`, `author`, `expires`, `session_id`) 
				VALUES (NULL, '{$name}', '{$val}', '{$magic->vendor_id}', ".($time+(60*60*24)).", '{$session_id}')"
		);
		
		return $val;
		
	}
	
	static function check_nonce($name, $value) {
		
		global $magic;
		
		$db 			= "{$magic->db->prefix}sessions";
		$query			= "DELETE FROM `$db` WHERE `author`='{$magic->vendor_id}' AND `expires` < ".time();
		$nonce			= $magic->db->rawQuery($query);
		$time			= time();
		
		$session_id 	= magic_secure::esc($_COOKIE['MAGICSESSID']);
		$name 			= magic_secure::esc($name);
		
		$nonce 			= $magic->db->rawQuery(
			"SELECT `id`, `value`, `expires` 
				FROM `$db` 
				WHERE `author`='{$magic->vendor_id}' AND `name`='{$name}' AND `session_id`='{$session_id}'"
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
						$magic->db->rawQuery(
							"UPDATE `$db` 
							SET `expires`=".($time+(60*60*24))." 
							WHERE `author`='{$magic->vendor_id}' AND `id`='{$no['id']}'"
						);
					}
					
					$_return = $no['id'];
					
				}
				
			}
			
			$_return = $magic->apply_filters('check-nonce', $_return, $name, $value);
			
			if ( $_return !== false ) {
				
				if ( count($nonce) > 1 ) {
					$magic->db->rawQuery(
						"DELETE FROM `$db` WHERE `author`='{$magic->vendor_id}' AND `name`='{$name}' AND `session_id`='{$session_id}' AND `id` <> ".$_return
					);
				}
				
				return true;
			
			} else {
				return false;
			}
			
		} else {
			$_return = $magic->apply_filters('check-nonce', $_return, $name, $value);
			return $_return;
		}
		
	}
	
	static function nonce_exist($name, $value) {
		
		global $magic;
		
		$session_id	 = magic_secure::esc($_COOKIE['MAGICSESSID']);
		$name		 = magic_secure::esc($name);
		$db 		 = "{$magic->db->prefix}sessions";
		$nonce 		 = $magic->db->rawQuery(
			"SELECT `value`, `expires` 
				FROM `$db`
				WHERE `author`='{$magic->vendor_id}' AND `name`='{$name}' AND `session_id`='{$session_id}'"
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
