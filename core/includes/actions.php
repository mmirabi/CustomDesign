<?php
/**
*	
*	(p) package: Magic
*	(c) author:	Mehdi Mirabi
*	(i) website: https://www.magicrugs.com
*
*/

if (!defined('MAGIC')) {
	header('HTTP/1.0 403 Forbidden');
	die();
}

global $magic;

$magic->add_action('editor-header', 'magic_editor_header');

function magic_editor_header() {
	
	global $magic, $magic_admin;
	
	if (isset($magic_admin)) {
		
		$check_update = @json_decode($magic->get_option('last_check_update'));
		
		if (!isset($check_update) || time()-$check_update->time > 60*60*24) {
			echo '<script>window.addEventListener("load", function(){jQuery.get("'.$magic->cfg->ajax_url.'&action=check-update")});</script>';
		}
		
		return;
		
	}
	
	$url = $magic->cfg->tool_url;
	$purl = parse_url($url);
	$img = $magic->cfg->settings['logo'];
	$title = $magic->lang($magic->cfg->settings['title']);
	
	if (isset($_GET['share'])) {
		$share = $magic->lib->get_share($_GET['share']);
		if ($share !== null) {
			$title = $share['name'];
			$url = str_replace('?&', '?' ,$url.(strpos($url, '?') === false ? '?' : '&').'product_base='.$share['product'].'&product_cms='.$share['product_cms'].'&share='.$share['share_id']);
			$img = $magic->cfg->upload_url.'shares/'.date('Y/m/', strtotime($share['created'])).$share['share_id'].'.jpg';
		}
	}
	
	echo '		<meta name="description" content="'.$magic->lang('The online product designer tool').'" />'."\n";
	echo '		<meta property="og:title" content="'.$title.'" />'."\n";
	echo '		<meta property="og:type" content="website" />'."\n";
	echo '		<meta property="og:url" content="'.$url.'" />'."\n";
	echo '		<meta property="og:image" content="'.$img.'" />'."\n";
	echo '		<meta property="og:description" content="'.$magic->lang('The online product designer tool').'" />'."\n";
	echo '		<meta property="og:site_name" content="'.ucfirst($purl['host']).'" />'."\n";
	
	if ($magic->cfg->settings['rtl'] == '1') {
		echo '		<link rel="stylesheet" href="'.$magic->cfg->assets_url.'/assets/css/rtl.css">'."\n";
	}
	
	$favicon = $magic->cfg->settings['favicon'];
	
	if (isset($favicon) && !empty($favicon)) {
		if (strpos($favicon, 'http') === false)
			$favicon = $magic->cfg->upload_url.$favicon;
		echo '		<link rel="icon" type="image/x-icon" href="'.$favicon.'" />'."\n";
		echo '		<link rel="shortcut icon" type="image/x-icon" href="'.$favicon.'" />'."\n";
	}
	
	echo "\n";
	
}