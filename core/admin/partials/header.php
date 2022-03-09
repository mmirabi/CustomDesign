<?php
/**
*
*	(c) copyright:	magicrugs
*	(i) website:	magicrugs
*
*/
global $magic, $magic_router;

if ($magic->connector->platform == 'php') {
?><!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title><?php echo (isset($title) ? $title : 'MagicRugs Control Panel'); ?></title><?php
}
$magic->do_action('admin-header');
?>
		<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,400i,500,700,900" rel="stylesheet">
		<link rel="stylesheet" href="<?php echo $magic->cfg->admin_assets_url;?>css/font-awesome.min.css?version=<?php echo MAGIC; ?>">
		<link rel="stylesheet" href="<?php echo $magic->cfg->admin_assets_url;?>css/admin.css?version=<?php echo MAGIC; ?>">
		<link rel="stylesheet" href="<?php echo $magic->cfg->admin_assets_url;?>css/responsive.css?version=<?php echo MAGIC; ?>">
		<?php if (is_file($magic->cfg->upload_path.'user_data'.DS.'custom.css')) { ?>
		<link rel="stylesheet" href="<?php echo $magic->cfg->upload_url; ?>user_data/custom.css?version=<?php echo $magic->cfg->settings['last_update']; ?>">
		<?php }
		if ($magic->cfg->load_jquery){ ?>
			<script src="<?php echo $magic->apply_filters('editor/jquery.min.js', $magic->cfg->assets_url.'assets/js/jquery.min.js?version='.MAGIC); ?>"></script>
		<?php }
			
	$magic->do_action('editor-header');

	if ($magic->connector->platform == 'php') {
		echo '</head><body class="MagicDesign">';
	}

	if (isset($_GET['callback'])) {
		echo '<link rel="stylesheet" href="'.$magic->cfg->admin_assets_url.'css/iframe.css?version='.MAGIC.'" />';
		return;
	}

?>
	<div class="magic_backtotop"><i class="fa fa-chevron-up"></i></div>
	<div class="magic_sidebar">
		<div class="magic_logo">
			<a href="<?php echo $magic->cfg->admin_url; ?>" title="<?php echo $magic->lang("Home"); ?>"><img src="<?php echo $magic->cfg->admin_assets_url;?>images/logo.png"></a>
			<div class="btn-toggle-sidebar"><i class="fa fa-bars"></i></div>
		</div>
		<?php
			
			$menus = $magic_router->menus;
			$magic_page = isset($_GET['magic-page']) ? $_GET['magic-page'] : '';
			$id = isset($_GET['id']) ? $_GET['id'] : '';
			$type = isset($_GET['type']) ? $_GET['type'] : '';
			$html = '<ul class="magic_menu">';

			foreach ($menus as $keys => $values) {
				if (
					!isset($values['capability']) || 
					$magic->caps($values['capability']) || 
					$magic->caps(str_replace('_read_', '_edit_', $values['capability']))
				) {
				
					$active = $open = '';
					if (isset($values['child']) && count($values['child']) > 0){
	
	
						if (
							(
								isset($values['child'][$magic_page]) && 
								( 
									empty($values['child'][$magic_page]['type']) || 
									(
										!empty($values['child'][$magic_page]['type']) && 
										$values['child'][$magic_page]['type'] == $type
									)
								)
							) || (empty($magic_page) && $keys == 'dashboard')
						) {
							$open = 'open';
							$active = 'active';
						}
	
						$html .= '<li>
									<a href="#" class="'.$active.'">
										'.$values['icon'].'
										<span class="title">'.$values['title'].'</span>
										<span class="magic_icon_dropdown '.$open.'">
											<i class="fa fa-angle-down"></i>
										</span>
									</a>
									<ul class="magic_sub_menu '.$open.'">';
	
						foreach ($values['child'] as $key => $child) {
	
							if (!isset($child['hidden']) || (isset($child['hidden']) && $child['hidden'] == false)) {
	
								if (
									(
										$key == $magic_page && 
										(
											empty($values['child'][$key]['type']) && 
											empty($id) || (
												!empty($values['child'][$key]['type']) && 
												$values['child'][$key]['type'] == $type
											)
										)
									)  || (empty($magic_page) && $key == 'dashboard')
								) {
									$active = 'active';
								} else {
									$active = '';
								}
								$html .= '<li><a href="'.$child['link'].'" class="'.$active.'">'.$child['title'].'</a></li>';
	
							}
	
						}
	
						$html .= '</ul></li>';
	
					} 
					else {
	
						if (isset($values['link'])) {
	
							if ($keys == $magic_page || (empty($magic_page) && $keys == 'dashboard')) 
								$active = 'active';
								
							$html .= '<li><a href="'.$values['link'].'" class="'.$active.'">'.$values['icon'].'<span class="title">'.$values['title'].'</span>'.'</a></li>';
	
						} else {
							$html .= '<li><a href="#">'.$values['icon'].'<span class="title">'.$values['title'].'</span>'.'</a></li>';
						}
	
					}
				
				}

			}
			
			if ($magic->connector->platform == 'php') {
				$html .= '<li><a href="'.$magic->cfg->admin_url.'signout=true"><i class="fa fa-sign-out"></i> '.$magic->lang('Sign out').'</a></li>';
			}
			
			$html .= '</ul>';
			echo $html;

		?>
		<ver><span><a href="https://www.magicrugs.com/?utm_source=codecanyon&utm_medium=version-link&utm_campaign=client-site&utm_term=backend-link&utm_content=woocommerce" target=_blank>MagicRugs Version</span> <?php echo MAGIC; ?></a></ver>
	</div>

	<div class="magic_sidebar magic_mobile">
		<div class="magic_logo">
			<img src="<?php echo $magic->cfg->admin_assets_url;?>images/logo.png">
			<div class="btn-toggle-sidebar-mb"><i class="fa fa-bars"></i></div>
		</div>
		<?php

			$magic_page = isset($_GET['magic-page']) ? $_GET['magic-page'] : '';
			$id = isset($_GET['id']) ? $_GET['id'] : '';
			$type = isset($_GET['type']) ? $_GET['type'] : '';
			$html = '<ul class="magic_menu">';

			foreach ($menus as $keys => $values) {
				
				if (
					!isset($values['capability']) || 
					$magic->caps($values['capability']) || 
					$magic->caps(str_replace('_read_', '_edit_', $values['capability']))
				) {
					
					$active = $open = '';
					
					if (isset($values['child']) && count($values['child']) > 0){
	
	
						if (isset($values['child'][$magic_page]) && ( empty($values['child'][$magic_page]['type']) || (!empty($values['child'][$magic_page]['type']) && $values['child'][$magic_page]['type'] == $type) )) {
							$open = 'open';
							$active = 'active';
						}
	
						$html .= '<li><a href="#" class="'.$active.'">'.$values['icon'].'<span class="title">'.$values['title'].'</span>'.'<span class="magic_icon_dropdown '.$open.'"><i class="fa fa-angle-down"></i></span></a>';
						$html .= '<ul class="magic_sub_menu '.$open.'">';
	
						foreach ($values['child'] as $key => $child) {
	
							if (!isset($child['hidden']) || (isset($child['hidden']) && $child['hidden'] == false)) {
	
								if ($key == $magic_page && (empty($values['child'][$key]['type']) && empty($id) || (!empty($values['child'][$key]['type']) && $values['child'][$key]['type'] == $type))) {
									$active = 'active';
								} else {
									$active = '';
								}
								$html .= '<li><a href="'.$child['link'].'" class="'.$active.'">'.$child['title'].'</a></li>';
	
							}
	
						}
	
						$html .= '</ul></li>';
	
					} else {
	
						if (isset($values['link'])) {
	
							if ($keys == $magic_page) $active = 'active';
							$html .= '<li><a href="'.$values['link'].'" class="'.$active.'">'.$values['icon'].'<span class="title">'.$values['title'].'</span>'.'</a></li>';
	
						} else {
							$html .= '<li><a href="#">'.$values['icon'].'<span class="title">'.$values['title'].'</span>'.'</a></li>';
						}
	
					}
				}

			}

			$html .= '</ul>';
			echo $html;

		?>
		<div class="overlay_mb"></div>
	</div>
