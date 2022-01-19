<?php 
	
	global $customdesign_woo, $customdesign; 
	$editor_page = get_option('customdesign_editor_page', 0);
	$active_plugins = get_option( 'active_plugins', array() );
	$fields = array(
		array(
			'type' => 'upload',
			'name' => 'logo',
			'label' => __('Upload Your Logo', 'customdesign'),
			'path' => 'settings'.DS,
			'value' => $customdesign->cfg->settings['logo'],
			'desc' => $customdesign->lang('Upload your own logo to display in the editor (recommented height 80px)')
		),
		array(
			'type' => 'color',
			'name' => 'primary_color',
			'label' => __('Choose Theme Color for Editor', 'customdesign'),
			'value' => $customdesign->cfg->settings['primary_color'],
			'default' => '#3fc7ba:#546e7a,#757575,#6d4c41,#f4511e,#ffb300,#fdd835,#c0cA33,#a0ce4e,#7cb342,#43a047,#00acc1,#3fc7ba,#039be5,#3949ab,#5e35b1,#d81b60,#eeeeee,#3a3a3a'
		)
	);
	
?><!DOCTYPE html>
<html lang="en-US">
<head>
	<meta name="viewport" content="width=device-width" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php _e('Customdesign &rsaquo; Setup Wizard', 'customdesign'); ?></title>
	<link rel='stylesheet' href='<?php echo admin_url('load-styles.php?c=1&amp;dir=ltr&amp;load%5B%5D=dashicons,admin-bar,buttons,install'); ?>' type='text/css' media='all' />
	<link rel='stylesheet' id='customdesign-setup-css'  href='<?php echo $customdesign_woo->assets_url; ?>../woo/assets/css/setup.css?ver=<?php echo USTOMDESIGN_WOO; ?>' type='text/css' media='all' />
	<link rel='stylesheet' id='customdesign-admin-css'  href='<?php echo $customdesign_woo->assets_url; ?>admin/assets/css/admin.css?ver=<?php echo USTOMDESIGN_WOO; ?>' type='text/css' media='all' />
	<link rel='stylesheet' id='customdesign-admin-css'  href='<?php echo $customdesign_woo->assets_url; ?>admin/assets/css/font-awesome.min.css?ver=<?php echo USTOMDESIGN_WOO; ?>' type='text/css' media='all' />
</head>
<body class="customdesign-setup wp-core-ui">
	
	<h1 id="customdesign-logo">
		<a href="#">
			<img src="<?php echo $customdesign_woo->assets_url; ?>assets/images/logo.v5.png" alt="customdesign" />
		</a>
	</h1>
	
	<ol class="customdesign-setup-steps">
			<li data-step="1" class="active"><?php _e('Editor setup', 'customdesign'); ?></li>
			<li data-step="2"><?php _e('customdesign theme', 'customdesign'); ?></li>
			<li data-step="3"><?php _e('Sample data', 'customdesign'); ?></li>
			<li data-step="4"><?php _e('Ready!', 'customdesign'); ?></li>
		</ol>
	
	<div class="customdesign-setup-content customdesign_wrapper" id="setup-body">		
		<form method="post" class="address-step">
			<div class="store-container customdesign_content editor-setup" data-step="1">
				<p class="store-setup" style="display:none">
					<?php _e('The following wizard will help you configure your customdesign and get you started quickly.', 'customdesign'); ?>
				</p>
				<?php 
					$customdesign->views->tabs_render($fields, 'settings');
				?>
				<div class="two-cols">
					<div>
						<label class="location-prompt"><?php _e('Currency symbol', 'customdesign'); ?></label>
						<input type="text" class="location-input" name="currency" value="<?php echo $customdesign->cfg->settings['currency']; ?>" />
					</div>
					<div>
						<label class="location-prompt"><?php _e('Assign the Editor to a Page', 'customdesign'); ?></label>
						<select id="store_state" name="editor_page" class="location-input customdesign-enhanced-select dropdown">
							<?php
								
								$pages = get_pages();
								
								foreach ($pages as $page) {
									echo '<option '.($page->ID == $editor_page ? 'selected' : '').' value="'.$page->ID.'">'.$page->post_title.'</option>';
								}
								
							?>
						</select>
					</div>
				</div>
				<label class="location-prompt"><?php _e('Terms & conditions (option)', 'customdesign'); ?></label>
				<textarea class="location-input" name="terms"><?php echo $customdesign->cfg->settings['conditions']; ?></textarea>
			</div>
			
			<div class="store-container customdesign_content customdesign-theme" data-step="2" style="display: none;">
				<h1><?php _e('customdesign theme', 'customdesign'); ?></h1>
				<p class="store-setup">
					<?php _e('We offer a Wordpress theme, which we customize and create for customdesign. It looks the same with our', 'customdesign'); ?> <a href="#" target=_blank><?php _e('live demo', 'customdesign'); ?> &rarr;</a>
				</p>
				<ul class="customdesign-wizard-services in-cart">
					<li class="customdesign-wizard-service-item" style="width: 100%;">
						<div class="customdesign-wizard-service-name">
							<img src="<?php echo $customdesign_woo->assets_url; ?>assets/images/logo.v5.png" alt="customdesign Wordpress Theme">
						</div>
						<div class="customdesign-wizard-service-description">
							<p>
								<strong><?php _e('customdesign Wordpress Theme', 'customdesign'); ?></strong>
								<br> 
								<?php _e('It brings to you a simple & clean styling for your store and ready to use with customdesign.', 'customdesign'); ?>
							</p>
						</div>
						
						<div class="customdesign-wizard-service-enable">
							<?php
								$theme = wp_get_theme();
								$theme = strtolower($theme);
								if ($theme != 'customdesign') {
							?>
							<span class="customdesign-wizard-service-toggle" data-toggle="customdesign-theme"></span>
							<?php } else { echo '<i class="fa fa-check"></i>'; } ?>
						</div>
					</li>
					<li class="customdesign-wizard-service-item">
						<div class="customdesign-wizard-service-name">
							<img src="https://kingcomposer.com/wp-content/themes/king/images/og_image.png" alt="Kingcomposer - Professional pagebuilder for Wordpress">
						</div>
						<div class="customdesign-wizard-service-description">
							<p>
								<strong><?php _e('Kingcomposer Pagebuilder', 'customdesign'); ?></strong>
								<br> 
								<?php _e('customdesign theme has built on Kingcomposer Pagebuilder, it is another product of customdesign team.', 'customdesign'); ?> 
								<a href="https://kingcomposer.com/" target="_blank"><?php _e('Learn more', 'customdesign'); ?> &rarr;</a>
							</p>
						</div>
						<div class="customdesign-wizard-service-enable">
							<?php if (!in_array('kingcomposer'.DS.'kingcomposer.php', $active_plugins)) { ?>
							<span class="customdesign-wizard-service-toggle" data-toggle="kingcomposer"></span>
							<?php } else { echo '<i class="fa fa-check"></i>';	} ?>
						</div>
					</li>
				</ul>
			</div>
			
			<div class="store-container customdesign_content sample-data" data-step="3" style="display: none;">
				<h1><?php _e('Sample data', 'customdesign'); ?></h1>
				<p class="store-setup">
					<?php _e('We offer the sample data for getting started quickly. You can check our docs for how to import to your site', 'customdesign'); ?>
				</p>
				<ul class="customdesign-wizard-services in-cart">
					<li class="customdesign-wizard-service-item">
						<div class="customdesign-wizard-service-name">
							<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px" width="60" height="60" viewBox="0 0 473.8 473.8" xml:space="preserve">
<path d="M454.8,111.7c0-1.8-0.4-3.6-1.2-5.3c-1.6-3.4-4.7-5.7-8.1-6.4L241.8,1.2c-3.3-1.6-7.2-1.6-10.5,0L25.6,100.9   c-4,1.9-6.6,5.9-6.8,10.4v0.1c0,0.1,0,0.2,0,0.4V362c0,4.6,2.6,8.8,6.8,10.8l205.7,99.7c0.1,0,0.1,0,0.2,0.1   c0.3,0.1,0.6,0.2,0.9,0.4c0.1,0,0.2,0.1,0.4,0.1c0.3,0.1,0.6,0.2,0.9,0.3c0.1,0,0.2,0.1,0.3,0.1c0.3,0.1,0.7,0.1,1,0.2   c0.1,0,0.2,0,0.3,0c0.4,0,0.9,0.1,1.3,0.1c0.4,0,0.9,0,1.3-0.1c0.1,0,0.2,0,0.3,0c0.3,0,0.7-0.1,1-0.2c0.1,0,0.2-0.1,0.3-0.1   c0.3-0.1,0.6-0.2,0.9-0.3c0.1,0,0.2-0.1,0.4-0.1c0.3-0.1,0.6-0.2,0.9-0.4c0.1,0,0.1,0,0.2-0.1l206.3-100c4.1-2,6.8-6.2,6.8-10.8   V112C454.8,111.9,454.8,111.8,454.8,111.7z M236.5,25.3l178.4,86.5l-65.7,31.9L170.8,57.2L236.5,25.3z M236.5,198.3L58.1,111.8   l85.2-41.3L321.7,157L236.5,198.3z M42.8,131.1l181.7,88.1v223.3L42.8,354.4V131.1z M248.5,442.5V219.2l85.3-41.4v58.4   c0,6.6,5.4,12,12,12s12-5.4,12-12v-70.1l73-35.4V354L248.5,442.5z" style="fill: rgb(99, 99, 99);"></path></svg>
						</div>
						<div class="customdesign-wizard-service-description">
							<p>
								<strong><?php _e('Sample Data Package', 'customdesign'); ?></strong>
								<br> 
								<?php _e('This package does not include the copyright of images, it is for demo purpose only. It includes cliparts, templates from our', 'customdesign'); ?> <a href="#" target=_blank>demo.customdesign.com</a>
							</p>
						</div>
					</li>
				</ul>
				<p class="customdesign-setup-actions">
					<a class="button-primary button button-large" href="#" target=_blank>
						<?php _e('Download Package', 'customdesign'); ?> &nbsp; 
						<i class="fa fa-download"></i>
					</a>
				</p>
			</div>
			
			<div class="store-container customdesign_content ready" data-step="4" style="display: none;">
				<h1><?php _e('You are ready to start designing!', 'customdesign'); ?></h1>
				<?php if (!in_array('woocommerce'.DS.'woocommerce.php', $active_plugins)) { ?>
				<p class="store-setup error">
					<?php _e('The Woocommerce plugin is not activated', 'customdesign'); ?> <a style="float: right;" target=_blank href="<?php echo admin_url('plugins.php'); ?>"><?php _e('Active here', 'customdesign'); ?> &rarr;</a>
				</p>
				<?php } ?>
				<ul class="customdesign-wizard-services customdesign-wizard-next-steps">
					<li class="customdesign-wizard-service-item">
						<div class="customdesign-wizard-next-step-description">
							<p class="next-step-heading"><?php _e('You can also:', 'customdesign'); ?></p>
						</div>
						<div class="customdesign-wizard-next-step-action">
							<p class="customdesign-setup-actions">
								<a class="button button-large" href="<?php echo $customdesign->cfg->admin_url; ?>ref=setup">
									<?php _e('Visit Dashboard', 'customdesign'); ?>						
								</a>
								<a class="button button-large" href="<?php echo $customdesign->cfg->admin_url; ?>customdesign-page=settings">
									<?php _e('Review Settings', 'customdesign'); ?>					
								</a>
								<a class="button button-large" href="<?php echo $customdesign->cfg->admin_url; ?>customdesign-page=product">
									<?php _e('Create Product', 'customdesign'); ?>				
								</a>
							</p>
						</div>
					</li>
				</ul>
				<p class="next-steps-help-text">
					
					<?php _e('Watch our', 'customdesign'); ?> <a href="#" target="_blank"><?php _e('guided tour videos</a> to learn more about customdesign, and visit customdesign.com to learn more about ', 'customdesign'); ?><a href="#" target="_blank"><?php _e('getting started', 'customdesign'); ?></a>.
				</p>
			</div>
			
			<p class="customdesign-setup-actions step">
				<button type="submit" class="button-primary button button-large button-next" data-txt="<?php _e('Continue', 'customdesign'); ?>" id="save-step">
					<?php _e('Let\'s go!', 'customdesign'); ?>
				</button>
			</p>
		</form>
	</div>
	
	<a class="customdesign-setup-footer-links" data-txt="<?php _e('Not right now', 'customdesign'); ?>" data-skip="<?php _e('Skip this step', 'customdesign'); ?>" href="<?php echo admin_url(); ?>">
		<?php _e('Not right now', 'customdesign'); ?>
	</a>
	
	<script>
		var CustomdesignDesign = {
			url : "<?php echo htmlspecialchars_decode($customdesign->cfg->url); ?>",
			admin_url : "<?php echo htmlspecialchars_decode($customdesign->cfg->admin_url); ?>",
			ajax : "<?php echo htmlspecialchars_decode($customdesign->cfg->admin_ajax_url); ?>",
			assets : "<?php echo $customdesign->cfg->assets_url; ?>",
			jquery : "<?php echo $customdesign->cfg->load_jquery; ?>",
			nonce : "<?php echo customdesign_secure::create_nonce('USTOMDESIGN_ADMIN') ?>",
			filter_ajax: function(ops) {
				return ops;
			},
			js_lang : <?php echo json_encode($customdesign->cfg->js_lang); ?>,
		};
	</script>
	<script src="<?php echo $customdesign_woo->assets_url; ?>admin/assets/js/vendors.js?ver=<?php echo CUSTOMDESIGN_WOO; ?>"></script>
	<script src="<?php echo $customdesign_woo->assets_url; ?>admin/assets/js/main.js?ver=<?php echo USTOMDESIGN_WOO; ?>"></script>
	<script src="<?php echo $customdesign_woo->assets_url; ?>../woo/assets/js/setup.js?ver=<?php echo USTOMDESIGN_WOO; ?>"></script>
</body>
</html>
		