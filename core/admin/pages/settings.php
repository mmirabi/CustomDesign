<?php
	
	$langs = $customdesign->get_langs();
	$lang_map = $customdesign->langs();
	
	$active_langs = array();
	$use_langs = array('en' => 'English');
	
	foreach($langs as $code) {
		if (!empty($code)) {
			$active_langs[$code] = '<img src="'.$customdesign->cfg->assets_url.'assets/flags/'.$code.'.png" height="20" /> '.$lang_map[$code];
			if (is_array($customdesign->cfg->settings['activate_langs']) && in_array($code, $customdesign->cfg->settings['activate_langs']))
				$use_langs[$code] = $lang_map[$code];
		}
	}
	$section = 'settings';
	
	$components = array();
	foreach ($customdesign->cfg->editor_menus as $key => $menu) {
		$components[$key] = $menu['label'];
	}
	
	$components = array_merge($components, array(
		'shop' => $customdesign->lang('Shopping cart'),
		'back' => $customdesign->lang('Back to Shop'),
	));
	
	$arg = array(
		
		'tabs' => array(
			
			'general:' . $customdesign->lang('General') => array(
				array(
					'type' => 'upload',
					'name' => 'logo',
					'label' => $customdesign->lang('Upload logo'),
					'path' => 'settings'.DS,
					'desc' => $customdesign->lang('Upload your own logo to display in the editor (recommented height 80px)')
				),
				array(
					'type' => 'input',
					'name' => 'logo_link',
					'label' => $customdesign->lang('Logo url'),
					'desc' => $customdesign->lang('The link will be redirect when click on the logo'),
				),
				array(
					'type' => 'input',
					'name' => 'title',
					'label' => $customdesign->lang('Site title'),
					'desc' => $customdesign->lang('The title of browser'),
				),
				array(
					'type' => 'upload',
					'name' => 'favicon',
					'label' => $customdesign->lang('Upload favicon'),
					'path' => 'settings'.DS,
					'desc' => $customdesign->lang('Upload your favicon to display in the editor (recommented .PNG and height 50px)')
				),
				array(
					'type' => 'color',
					'name' => 'primary_color',
					'label' => $customdesign->lang('Theme color'),
					'default' => '#3fc7ba:#546e7a,#757575,#6d4c41,#f4511e,#fb8c00,#ffb300,#fdd835,#c0cA33,#a0ce4e,#7cb342,#43a047,#00897b,#00acc1,#3fc7ba,#039be5,#3949ab,#5e35b1,#8e24aa,#d81b60,#eeeeee,#3a3a3a'
				),
				array(
					'type' => 'text',
					'name' => 'conditions',
					'label' => $customdesign->lang('Terms & conditions'),
					'desc' => $customdesign->lang('The terms and conditions show before placing the order (option)'),
				),
			),
			'editor:' . $customdesign->lang('Editor') => array(
				array(
					'type' => 'toggle',
					'name' => 'enable_colors',
					'label' => $customdesign->lang('Color picker'),
					'desc' => $customdesign->lang('Allow users select colors from the color picker and users can add new color to their colors list'),
					'default' => 'yes',
					'value' => null
				),
				array(
					'type' => 'color',
					'name' => 'colors',
					'selection' => false,
					'label' => $customdesign->lang('List colors'),
					'default' => '#3fc7ba:#546e7a,#757575,#6d4c41,#f4511e,#fb8c00,#ffb300,#fdd835,#c0cA33,#a0ce4e,#7cb342,#43a047,#00897b,#00acc1,#3fc7ba,#039be5,#3949ab,#5e35b1,#8e24aa,#d81b60,#eeeeee,#3a3a3a',
					'desc' => $customdesign->lang('The default colors are used to fill objects'),
				),
				array(
					'type' => 'toggle',
					'name' => 'rtl',
					'label' => $customdesign->lang('Right to left (RTL)'),
					'desc' => $customdesign->lang('Enable right to left reading mode'),
					'default' => 'no',
					'value' => null
				),
				array(
					'type' => 'toggle',
					'name' => 'share',
					'label' => $customdesign->lang('User can sharing'),
					'desc' => $customdesign->lang('Allow non-admin users to share their designs'),
					'default' => 'no',
					'value' => null
				),
				array(
					'type' => 'toggle',
					'name' => 'user_print',
					'label' => $customdesign->lang('User can print'),
					'desc' => $customdesign->lang('Allow non-admin users to print their designs'),
					'default' => 'no',
					'value' => null
				),
				array(
					'type' => 'toggle',
					'name' => 'user_download',
					'label' => $customdesign->lang('User can download'),
					'desc' => $customdesign->lang('Allow non-admin users to download their designs as a file'),
					'default' => 'yes',
					'value' => null
				),
				array(
					'type' => 'checkboxes',
					'name' => 'components',
					'label' => $customdesign->lang('Components'),
					'desc' => $customdesign->lang('Show/hide components of editor, you also can arrange them as how you want'),
					'default' => '',
					'value' => null,
					'options' => $components
				),
				array(
					'type' => 'toggle',
					'name' => 'disable_resources',
					'label' => $customdesign->lang('Disable resources'),
					'desc' => $customdesign->lang('Disable online resources for none-admin users (Facebook, Instagram, Free images..)'),
					'default' => 'no',
					'value' => null
				),
				array(
					'type' => 'input',
					'name' => 'min_upload',
					'label' => $customdesign->lang('Min size upload'),
					'desc' => $customdesign->lang('The minimum size (kilobyte) that users can upload photos (eg: 100)'),
					'default' => '',
					'placeholder' => $customdesign->lang('Enter number in KB'),
					'value' => null
				),
				array(
					'type' => 'input',
					'name' => 'max_upload',
					'label' => $customdesign->lang('Max size upload'),
					'desc' => $customdesign->lang('The maximum size (kilobyte) that users can upload photos (eg: 5000)'),
					'default' => '',
					'placeholder' => $customdesign->lang('Enter number in KB'),
					'value' => null
				),
				array(
					'type' => 'input',
					'name' => 'min_dimensions',
					'label' => $customdesign->lang('Min dimensions'),
					'desc' => $customdesign->lang('The min width x height in pixel of images can be added'),
					'default' => '',
					'placeholder' => $customdesign->lang('Enter dimensions width x height (eg: 100x100)'),
					'value' => null
				),
				array(
					'type' => 'input',
					'name' => 'max_dimensions',
					'label' => $customdesign->lang('Max dimensions'),
					'desc' => $customdesign->lang('The max width x height in pixel of images can be added, Automatically decreases if bigger'),
					'default' => '',
					'placeholder' => $customdesign->lang('Enter dimensions width x height (eg: 500x500)'),
					'value' => null
				),
				array(
					'type' => 'input',
					'name' => 'min_ppi',
					'label' => $customdesign->lang('Min PPI'),
					'desc' => $customdesign->lang('The min PPI (pixel per inch) of images can be added (It depends on the size you have configured)'),
					'default' => '',
					'placeholder' => $customdesign->lang('Recommened minimum 150 PPI'),
					'value' => null
				),
				array(
					'type' => 'input',
					'name' => 'max_ppi',
					'label' => $customdesign->lang('Max PPI'),
					'desc' => $customdesign->lang('The max PPI of images can be added (It depends on the size you have configured)'),
					'default' => '',
					'value' => null
				),
				array(
					'type' => 'toggle',
					'name' => 'ppi_notice',
					'label' => $customdesign->lang('Low resolution notice'),
					'desc' => $customdesign->lang('Allows to add low resolution images with a notice (when its resolution is lower than Min PPI)'),
					'default' => 'no',
					'value' => null
				),
				array(
					'type' => 'toggle',
					'name' => 'required_full_design',
					'label' => $customdesign->lang('Design all stages'),
					'desc' => $customdesign->lang('Required design all stages before add to cart'),
					'default' => 'no',
					'value' => null
				),
				array(
					'type' => 'toggle',
					'name' => 'auto_fit',
					'label' => $customdesign->lang('Auto zoom to fit'),
					'desc' => $customdesign->lang('Automatically zooms to fit the product with the screen'),
					'default' => 'yes',
					'value' => null
				),
				array(
					'type' => 'toggle',
					'name' => 'calc_formula',
					'label' => $customdesign->lang('Show calculation formula'),
					'default' => 'yes',
					'value' => null
				),
				array(
					'type' => 'radios',
					'name' => 'report_bugs',
					'label' => $customdesign->lang('Enable bug reporting'),
					'desc' => $customdesign->lang('Allow users report bugs from editor'),
					'default' => '2',
					'value' => null,
					'options' => array(
						'0' => $customdesign->lang('Disable'),
						'1' => $customdesign->lang('Enable, but do not send to magicrugs.com'),
						'2' => $customdesign->lang('Enable, and send to magicrugs.com'),
					)
				),
				array(
					'type' => 'text',
					'name' => 'custom_css',
					'label' => $customdesign->lang('Custom CSS'),
					'desc' => $customdesign->lang('Your custom CSS code will run in editor'),
				),
				array(
					'type' => 'text',
					'name' => 'custom_js',
					'label' => $customdesign->lang('Custom JS'),
					'desc' => $customdesign->lang('Your custom JS code will run in editor'),
				),
				array(
					'type' => 'input',
					'name' => 'prefix_file',
					'label' => $customdesign->lang('Prefix name'),
					'desc' => $customdesign->lang('The prefix of file name download'),
					'default' => 'Front'
				),
				// array(
				// 	'type' => 'toggle',
				// 	'name' => 'text_direction',
				// 	'label' => $customdesign->lang('Text direction'),
				// 	'desc' => $customdesign->lang('Fix the text direction when writing, left as default and right for RTL mode'),
				// 	'default' => 'no'
				// ),
				array(
					'type' => 'toggle',
					'name' => 'dis_qrcode',
					'label' => $customdesign->lang('Disable QRCode'),
					'desc' => $customdesign->lang('Do not show the QRCode generator'),
					'default' => '',
					'value' => null
				),
				array(
					'type' => 'toggle',
					'name' => 'auto_snap',
					'label' => $customdesign->lang('Auto snap'),
					'desc' => $customdesign->lang('Automatically align the position of the active object with other objects'),
					'default' => 'no'
				),
				array(
					'type' => 'toggle',
					'name' => 'template_append',
					'label' => $customdesign->lang('Template append'),
					'desc' => $customdesign->lang('Keep all current objects and append the template into'),
					'default' => '',
					'value' => null
				),
				array(
					'type' => 'toggle',
					'name' => 'replace_image',
					'label' => $customdesign->lang('Replace image'),
					'desc' => $customdesign->lang('Replace the selected image object instead of creating a new one'),
					'default' => '',
					'value' => null
				),
			),
			'shop:' . $customdesign->lang('Shop') => array(
				array(
					'type' => 'input',
					'name' => 'currency',
					'label' => $customdesign->lang('Currency symbol')
				),
				array(
					'type' => 'toggle',
					'name' => 'currency_position',
					'label' => $customdesign->lang('Currency first?'),
					'desc' => $customdesign->lang('Display the currency symbol before or after the price number'),
					'default' => 'yes',
					'value' => null
				),
				array(
					'type' => 'input',
					'name' => 'currency_code',
					'label' => $customdesign->lang('Currency code'),
					'desc' => $customdesign->lang('The currency code which use for payment'),
				),
				
				array(
					'type' => 'input',
					'name' => 'thousand_separator',
					'label' => $customdesign->lang('Thousand separator'),
					'desc' => $customdesign->lang('This sets the thousand separator of displayed price'),
				),
				array(
					'type' => 'input',
					'name' => 'decimal_separator',
					'label' => $customdesign->lang('Decimal separator'),
					'desc' => $customdesign->lang('This sets the decimal separator of displayed price'),
				),
				array(
					'type' => 'input',
					'numberic' => 'int',
					'name' => 'number_decimals',
					'label' => $customdesign->lang('Number of decimals'),
					'desc' => $customdesign->lang('This sets the number of decimals points show in displayed price'),
				)
			),
			'fonts:' . $customdesign->lang('Google Fonts') => array(
				array(
					'type' => 'toggle',
					'name' => 'user_font',
					'label' => $customdesign->lang('User can manage fonts'),
					'desc' => $customdesign->lang('Allow non-admin users to add new or remove fonts to their browser'),
					'default' => 'yes',
					'value' => null
				),
				array(
					'type' => 'google_fonts',
					'name' => 'google_fonts',
					'label' => $customdesign->lang('Default Google fonts'),
					'desc' => $customdesign->lang('Users can add new or remove Google fonts in their profile when using the tool'),
				)
			),
			'languages:' . $customdesign->lang('Languages') => array(
				array(
					'type' => 'dropbox',
					'name' => 'admin_lang',
					'label' => $customdesign->lang('Backend language'),
					'options' => $use_langs
				),
				array(
					'type' => 'dropbox',
					'name' => 'editor_lang',
					'label' => $customdesign->lang('Editor language'),
					'options' => $use_langs
				),
				array(
					'type' => 'toggle',
					'name' => 'allow_select_lang',
					'label' => $customdesign->lang('Allow users change'),
					'desc' => $customdesign->lang('Allow users selecting the language in the tool'),
					'default' => 1
				),
				array(
					'type' => 'checkboxes',
					'name' => 'activate_langs',
					'label' => $customdesign->lang('Activate languages'),
					'options' => $active_langs,
					'desc' => '<a href="'.$customdesign->cfg->admin_url.'customdesign-page=languages"><i class="fa fa-plus"></i> '.$customdesign->lang('Add new language ').'</a>'
				),
			),
			'help:' . $customdesign->lang('Help contents') => array(
				array(
					'type' => 'input',
					'name' => 'help_title',
					'label' => $customdesign->lang('Help title'),
					'desc' => $customdesign->lang('This content will be display under menu "Help" on the editor'),
				),
				array(
					'type' => 'tabs',
					'name' => 'helps',
					'label' => $customdesign->lang('Help contents'),
					'desc' => $customdesign->lang('Add the content as plain text, rick text or HTML code, you can translate the title or the content to another language by creating new language text'),
					'tabs' => 5,
					'default' => '[{"title":"Hot keys","content":"<b data-view=\"key\">ctrl<\/b>+<b data-view=\"key\">a<\/b>\r\nSelect all objects<br>\r\n<b data-view=\"key\">ctrl<\/b>+<b data-view=\"key\">d<\/b>\r\nDouble the activate object<br>\r\n<b data-view=\"key\">ctrl<\/b>+<b data-view=\"key\">e<\/b>\r\nClear all objects<br>\r\n<b data-view=\"key\">ctrl<\/b>+<b data-view=\"key\">s<\/b>\r\nSave current stage to my design<br>\r\n<b data-view=\"key\">ctrl<\/b>+<b data-view=\"key\">o<\/b>\r\nOpen a file to import design<br>\r\n<b data-view=\"key\">ctrl<\/b>+<b data-view=\"key\">p<\/b>\r\nPrint<br>\r\n<b data-view=\"key\">ctrl<\/b>+<b data-view=\"key\">+<\/b>\r\nZoom out<br>\r\n<b data-view=\"key\">ctrl<\/b>+<b data-view=\"key\">-<\/b>\r\nZoom in<br>\r\n<b data-view=\"key\">ctrl<\/b>+<b data-view=\"key\">0<\/b>\r\nReset zoom<br>\r\n<b data-view=\"key\">ctrl<\/b>+<b data-view=\"key\">z<\/b>\r\nUndo changes<br>\r\n<b data-view=\"key\">ctrl<\/b>+<b data-view=\"key\">shift<\/b>+<b data-view=\"key\">z<\/b>\r\nRedo changes<br>\r\n<b data-view=\"key\">ctrl<\/b>+<b data-view=\"key\">shift<\/b>+<b data-view=\"key\">s<\/b>\r\nDownload current design<br>\r\n<b data-view=\"key\">delete<\/b> Delete the activate object<br>\r\n<b data-view=\"key\">\u2190<\/b> Move the activate object to left<br>\r\n<b data-view=\"key\">\u2191<\/b> Move the activate object to top<br>\r\n<b data-view=\"key\">\u2192<\/b> Move the activate object to right<br>\r\n<b data-view=\"key\">\u2193<\/b> Move the activate object to bottom<br>\r\n<b data-view=\"key\">shift<\/b>+<b data-view=\"key\">\u2190<\/b>\r\nMove the activate object to left 10px<br>\r\n<b data-view=\"key\">shift<\/b>+<b data-view=\"key\">\u2191<\/b>\r\nMove the activate object to top 10px<br>\r\n<b data-view=\"key\">shift<\/b>+<b data-view=\"key\">\u2192<\/b>\r\nMove the activate object to right 10px<br>\r\n<b data-view=\"key\">shift<\/b>+<b data-view=\"key\">\u2193<\/b>\r\nMove the activate object to bottom 10px<br>"},{"title":"Custom","content":"Custom help content"}]'
				),
				array(
					'type' => 'text',
					'name' => 'about',
					'label' => $customdesign->lang('About content'),
					'desc' => $customdesign->lang('This content will be display on the about tab under your logo, you can use the rick text or HTML format here'),
				)
			)
		)
	);
	
	if ($customdesign->connector->platform == 'woocommerce') {
		$arg['tabs']['shop:'.$customdesign->lang('Shop')][] =  array(
			'type' => 'toggle',
			'name' => 'show_only_design',
			'label' => $customdesign->lang('Show only design'),
			'desc' => $customdesign->lang('Show only design in cart page (hide product)'),
		);
	}

	if ($customdesign->connector->platform == 'php') {
		$arg['tabs']['admin:'.$customdesign->lang('Admin login')] =  array(
			array(
				'type' => 'admin_login'
			)
		);
	}
	
	if ($customdesign->connector->platform == 'php') {
		$arg['tabs']['shop:'.$customdesign->lang('Shop')][] = array(
			'type' => 'input',
			'name' => 'merchant_id',
			'label' => $customdesign->lang('Merchant Paypal Id'),
			'desc' => $customdesign->lang('The Paypal username to receive payments'),
		);
		
		$arg['tabs']['shop:'.$customdesign->lang('Shop')][] = array(
			'type' => 'toggle',
			'name' => 'sanbox_mode',
			'label' => $customdesign->lang('Sanbox Mode'),
			'desc' => $customdesign->lang('Enable sanbox paypal mode for testing. If No, it is live production mode.'),
			'default' => 1
		);
	}
	
	$arg = $customdesign->apply_filters('settings_fields', $arg);
	
	$fields = $customdesign_admin->process_settings_data($arg);

?>

<div class="customdesign_wrapper" id="customdesign-<?php echo $section; ?>-page">
	<div class="customdesign_content">
		<form action="<?php echo $customdesign->cfg->admin_url; ?>customdesign-page=<?php 
			echo $section.(isset($_GET['callback']) ? '&callback='.$_GET['callback'] : '');
		?>" id="customdesign-settings-form" method="post" class="customdesign_form" enctype="multipart/form-data">
			
			<?php 
				$customdesign->views->header_message();
				$customdesign->views->tabs_render($fields, 'settings'); 
			?>
			
			<div class="customdesign_form_group" style="margin-top: 20px">
				<input type="submit" class="customdesign-button customdesign-button-primary" value="<?php echo $customdesign->lang('Save Settings'); ?>"/>
				<input type="hidden" name="do" value="action" />
				<input type="hidden" name="customdesign-section" value="<?php echo $section; ?>">
			</div>
		</form>
	</div>
</div>
