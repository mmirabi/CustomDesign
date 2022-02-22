<?php
/**
*	
*	(p) package: CustomDesign
*	(c) author:	Mehdi Mirabi
*	(i) website: https://www.magicrugs.com
*
*/

if (!defined('CUSTOMDESIGN')) {
	header('HTTP/1.0 403 Forbidden');
	die();
}

global $customdesign;

$customdesign->add_action('editor-header', 'customdesign_editor_header');

function customdesign_editor_header() {
	
	global $customdesign, $customdesign_admin;
	
	if (isset($customdesign_admin)) {
		
		$check_update = @json_decode($customdesign->get_option('last_check_update'));
		
		if (!isset($check_update) || time()-$check_update->time > 60*60*24) {
			echo '<script>window.addEventListener("load", function(){jQuery.get("'.$customdesign->cfg->ajax_url.'&action=check-update")});</script>';
		}
		
		return;
		
	}
	
	$url = $customdesign->cfg->tool_url;
	$purl = parse_url($url);
	$img = $customdesign->cfg->settings['logo'];
	$title = $customdesign->lang($customdesign->cfg->settings['title']);
	
	if (isset($_GET['share'])) {
		$share = $customdesign->lib->get_share($_GET['share']);
		if ($share !== null) {
			$title = $share['name'];
			$url = str_replace('?&', '?' ,$url.(strpos($url, '?') === false ? '?' : '&').'product_base='.$share['product'].'&product_cms='.$share['product_cms'].'&share='.$share['share_id']);
			$img = $customdesign->cfg->upload_url.'shares/'.date('Y/m/', strtotime($share['created'])).$share['share_id'].'.jpg';
		}
	}
	
	echo '		<meta name="description" content="'.$customdesign->lang('The online product designer tool').'" />'."\n";
	echo '		<meta property="og:title" content="'.$title.'" />'."\n";
	echo '		<meta property="og:type" content="website" />'."\n";
	echo '		<meta property="og:url" content="'.$url.'" />'."\n";
	echo '		<meta property="og:image" content="'.$img.'" />'."\n";
	echo '		<meta property="og:description" content="'.$customdesign->lang('The online product designer tool').'" />'."\n";
	echo '		<meta property="og:site_name" content="'.ucfirst($purl['host']).'" />'."\n";
	
	if ($customdesign->cfg->settings['rtl'] == '1') {
	echo '		<link rel="stylesheet" href="'.$customdesign->cfg->assets_url.'/assets/css/rtl.css">'."\n";
	}
	
	$favicon = $customdesign->cfg->settings['favicon'];
	
	if (isset($favicon) && !empty($favicon)) {
		if (strpos($favicon, 'http') === false)
			$favicon = $customdesign->cfg->upload_url.$favicon;
		echo '		<link rel="icon" type="image/x-icon" href="'.$favicon.'" />'."\n";
		echo '		<link rel="shortcut icon" type="image/x-icon" href="'.$favicon.'" />'."\n";
	}
	
	echo "\n";
	
}