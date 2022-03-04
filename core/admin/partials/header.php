header<?php
/**
*
*	(c) copyright:	magicrugs
*	(i) website:	magicrugs
*
*/
global $customdesign, $customdesign_router;

if ($customdesign->connector->platform == 'php') {
?><!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title><?php echo (isset($title) ? $title : 'MagicRugs Control Panel'); ?></title><?php
}
$customdesign->do_action('admin-header');
?>
		<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,400i,500,700,900" rel="stylesheet">
		<link rel="stylesheet" href="<?php echo $customdesign->cfg->admin_assets_url;?>css/font-awesome.min.css?version=<?php echo CUSTOMDESIGN; ?>">
		<link rel="stylesheet" href="<?php echo $customdesign->cfg->admin_assets_url;?>css/admin.css?version=<?php echo CUSTOMDESIGN; ?>">
		<link rel="stylesheet" href="<?php echo $customdesign->cfg->admin_assets_url;?>css/responsive.css?version=<?php echo CUSTOMDESIGN; ?>">
		<?php if (is_file($customdesign->cfg->upload_path.'user_data'.DS.'custom.css')) { ?>
		<link rel="stylesheet" href="<?php echo $customdesign->cfg->upload_url; ?>user_data/custom.css?version=<?php echo $customdesign->cfg->settings['last_update']; ?>">
		<?php }
		if ($customdesign->cfg->load_jquery){ ?>
			<script src="<?php echo $customdesign->apply_filters('editor/jquery.min.js', $customdesign->cfg->assets_url.'assets/js/jquery.min.js?version='.CUSTOMDESIGN); ?>"></script>
		<?php }
			
	$customdesign->do_action('editor-header');

	if ($customdesign->connector->platform == 'php') {
		echo '</head><body class="CustomdesignDesign">';
	}

	if (isset($_GET['callback'])) {
		echo '<link rel="stylesheet" href="'.$customdesign->cfg->admin_assets_url.'css/iframe.css?version='.CUSTOMDESIGN.'" />';
		return;
	}

?>
	<div class="customdesign_backtotop"><i class="fa fa-chevron-up"></i></div>
	<div class="customdesign_sidebar">
		<div class="customdesign_logo">
			<a href="<?php echo $customdesign->cfg->admin_url; ?>" title="<?php echo $customdesign->lang("Home"); ?>"><img src="<?php echo $customdesign->cfg->admin_assets_url;?>images/logo.png"></a>
			<div class="btn-toggle-sidebar"><i class="fa fa-bars"></i></div>
		</div>
		<?php
			
			$menus = $customdesign_router->menus;
			$customdesign_page = isset($_GET['customdesign-page']) ? $_GET['customdesign-page'] : '';
			$id = isset($_GET['id']) ? $_GET['id'] : '';
			$type = isset($_GET['type']) ? $_GET['type'] : '';
			$html = '<ul class="customdesign_menu">';

			foreach ($menus as $keys => $values) {
				if (
					!isset($values['capability']) || 
					$customdesign->caps($values['capability']) || 
					$customdesign->caps(str_replace('_read_', '_edit_', $values['capability']))
				) {
				
					$active = $open = '';
					if (isset($values['child']) && count($values['child']) > 0){
	
	
						if (
							(
								isset($values['child'][$customdesign_page]) && 
								( 
									empty($values['child'][$customdesign_page]['type']) || 
									(
										!empty($values['child'][$customdesign_page]['type']) && 
										$values['child'][$customdesign_page]['type'] == $type
									)
								)
							) || (empty($customdesign_page) && $keys == 'dashboard')
						) {
							$open = 'open';
							$active = 'active';
						}
	
						$html .= '<li>
									<a href="#" class="'.$active.'">
										'.$values['icon'].'
										<span class="title">'.$values['title'].'</span>
										<span class="customdesign_icon_dropdown '.$open.'">
											<i class="fa fa-angle-down"></i>
										</span>
									</a>
									<ul class="customdesign_sub_menu '.$open.'">';
	
						foreach ($values['child'] as $key => $child) {
	
							if (!isset($child['hidden']) || (isset($child['hidden']) && $child['hidden'] == false)) {
	
								if (
									(
										$key == $customdesign_page && 
										(
											empty($values['child'][$key]['type']) && 
											empty($id) || (
												!empty($values['child'][$key]['type']) && 
												$values['child'][$key]['type'] == $type
											)
										)
									)  || (empty($customdesign_page) && $key == 'dashboard')
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
	
							if ($keys == $customdesign_page || (empty($customdesign_page) && $keys == 'dashboard')) 
								$active = 'active';
								
							$html .= '<li><a href="'.$values['link'].'" class="'.$active.'">'.$values['icon'].'<span class="title">'.$values['title'].'</span>'.'</a></li>';
	
						} else {
							$html .= '<li><a href="#">'.$values['icon'].'<span class="title">'.$values['title'].'</span>'.'</a></li>';
						}
	
					}
				
				}

			}
			
			if ($customdesign->connector->platform == 'php') {
				$html .= '<li><a href="'.$customdesign->cfg->admin_url.'signout=true"><i class="fa fa-sign-out"></i> '.$customdesign->lang('Sign out').'</a></li>';
			}
			
			$html .= '</ul>';
			echo $html;

		?>
		<ver><span><a href="https://www.magicrugs.com/?utm_source=codecanyon&utm_medium=version-link&utm_campaign=client-site&utm_term=backend-link&utm_content=woocommerce" target=_blank>MagicRugs Version</span> <?php echo CUSTOMDESIGN; ?></a></ver>
	</div>

	<div class="customdesign_sidebar customdesign_mobile">
		<div class="customdesign_logo">
			<img src="<?php echo $customdesign->cfg->admin_assets_url;?>images/logo.png">
			<div class="btn-toggle-sidebar-mb"><i class="fa fa-bars"></i></div>
		</div>
		<?php

			$customdesign_page = isset($_GET['customdesign-page']) ? $_GET['customdesign-page'] : '';
			$id = isset($_GET['id']) ? $_GET['id'] : '';
			$type = isset($_GET['type']) ? $_GET['type'] : '';
			$html = '<ul class="customdesign_menu">';

			foreach ($menus as $keys => $values) {
				
				if (
					!isset($values['capability']) || 
					$customdesign->caps($values['capability']) || 
					$customdesign->caps(str_replace('_read_', '_edit_', $values['capability']))
				) {
					
					$active = $open = '';
					
					if (isset($values['child']) && count($values['child']) > 0){
	
	
						if (isset($values['child'][$customdesign_page]) && ( empty($values['child'][$customdesign_page]['type']) || (!empty($values['child'][$customdesign_page]['type']) && $values['child'][$customdesign_page]['type'] == $type) )) {
							$open = 'open';
							$active = 'active';
						}
	
						$html .= '<li><a href="#" class="'.$active.'">'.$values['icon'].'<span class="title">'.$values['title'].'</span>'.'<span class="customdesign_icon_dropdown '.$open.'"><i class="fa fa-angle-down"></i></span></a>';
						$html .= '<ul class="customdesign_sub_menu '.$open.'">';
	
						foreach ($values['child'] as $key => $child) {
	
							if (!isset($child['hidden']) || (isset($child['hidden']) && $child['hidden'] == false)) {
	
								if ($key == $customdesign_page && (empty($values['child'][$key]['type']) && empty($id) || (!empty($values['child'][$key]['type']) && $values['child'][$key]['type'] == $type))) {
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
	
							if ($keys == $customdesign_page) $active = 'active';
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
