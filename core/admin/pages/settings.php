<?php
	
	$langs = $magic->get_langs();
	$lang_map = $magic->langs();
	
	$active_langs = array();
	$use_langs = array('en' => 'English');
	
	foreach($langs as $code) {
		if (!empty($code)) {
			$active_langs[$code] = '<img src="'.$magic->cfg->assets_url.'assets/flags/'.$code.'.png" height="20" /> '.$lang_map[$code];
			if (is_array($magic->cfg->settings['activate_langs']) && in_array($code, $magic->cfg->settings['activate_langs']))
				$use_langs[$code] = $lang_map[$code];
		}
	}
	$section = 'settings';
	
	$components = array();
	foreach ($magic->cfg->editor_menus as $key => $menu) {
		$components[$key] = $menu['label'];
	}
	
	$components = array_merge($components, array(
		'shop' => $magic->lang('Shopping cart'),
		'back' => $magic->lang('Back to Shop'),
	));
	
	$arg = array(
		
		'tabs' => array(
			
			'general:' . $magic->lang('General') => array(
				array(
					'type' => 'upload',
					'name' => 'logo',
					'label' => $magic->lang('Upload logo'),
					'path' => 'settings'.DS,
					'desc' => $magic->lang('Upload your own logo to display in the editor (recommented height 80px)')
				),
				array(
					'type' => 'input',
					'name' => 'logo_link',
					'label' => $magic->lang('Logo url'),
					'desc' => $magic->lang('The link will be redirect when click on the logo'),
				),
				array(
					'type' => 'input',
					'name' => 'title',
					'label' => $magic->lang('Site title'),
					'desc' => $magic->lang('The title of browser'),
				),
				array(
					'type' => 'upload',
					'name' => 'favicon',
					'label' => $magic->lang('Upload favicon'),
					'path' => 'settings'.DS,
					'desc' => $magic->lang('Upload your favicon to display in the editor (recommented .PNG and height 50px)')
				),
				array(
					'type' => 'color',
					'name' => 'primary_color',
					'label' => $magic->lang('Theme color'),
					'default' => '#3fc7ba:#546e7a,#757575,#6d4c41,#f4511e,#fb8c00,#ffb300,#fdd835,#c0cA33,#a0ce4e,#7cb342,#43a047,#00897b,#00acc1,#3fc7ba,#039be5,#3949ab,#5e35b1,#8e24aa,#d81b60,#eeeeee,#3a3a3a'
				),
				array(
					'type' => 'text',
					'name' => 'conditions',
					'label' => $magic->lang('Terms & conditions'),
					'desc' => $magic->lang('The terms and conditions show before placing the order (option)'),
				),
			),
			'editor:' . $magic->lang('Editor') => array(
				array(
					'type' => 'toggle',
					'name' => 'enable_colors',
					'label' => $magic->lang('Color picker'),
					'desc' => $magic->lang('Allow users select colors from the color picker and users can add new color to their colors list'),
					'default' => 'yes',
					'value' => null
				),
				array(
					'type' => 'color',
					'name' => 'colors',
					'selection' => false,
					'label' => $magic->lang('List colors'),
					'default' => '#3fc7ba:#546e7a,#757575,#6d4c41,#f4511e,#fb8c00,#ffb300,#fdd835,#c0cA33,#a0ce4e,#7cb342,#43a047,#00897b,#00acc1,#3fc7ba,#039be5,#3949ab,#5e35b1,#8e24aa,#d81b60,#eeeeee,#3a3a3a',
					'desc' => $magic->lang('The default colors are used to fill objects'),
				),
				array(
					'type' => 'toggle',
					'name' => 'rtl',
					'label' => $magic->lang('Right to left (RTL)'),
					'desc' => $magic->lang('Enable right to left reading mode'),
					'default' => 'no',
					'value' => null
				),
				array(
					'type' => 'toggle',
					'name' => 'share',
					'label' => $magic->lang('User can sharing'),
					'desc' => $magic->lang('Allow non-admin users to share their designs'),
					'default' => 'no',
					'value' => null
				),
				array(
					'type' => 'toggle',
					'name' => 'user_print',
					'label' => $magic->lang('User can print'),
					'desc' => $magic->lang('Allow non-admin users to print their designs'),
					'default' => 'no',
					'value' => null
				),
				array(
					'type' => 'toggle',
					'name' => 'user_download',
					'label' => $magic->lang('User can download'),
					'desc' => $magic->lang('Allow non-admin users to download their designs as a file'),
					'default' => 'yes',
					'value' => null
				),
				array(
					'type' => 'checkboxes',
					'name' => 'components',
					'label' => $magic->lang('Components'),
					'desc' => $magic->lang('Show/hide components of editor, you also can arrange them as how you want'),
					'default' => '',
					'value' => null,
					'options' => $components
				),
				array(
					'type' => 'toggle',
					'name' => 'disable_resources',
					'label' => $magic->lang('Disable resources'),
					'desc' => $magic->lang('Disable online resources for none-admin users (Facebook, Instagram, Free images..)'),
					'default' => 'no',
					'value' => null
				),
				array(
					'type' => 'input',
					'name' => 'min_upload',
					'label' => $magic->lang('Min size upload'),
					'desc' => $magic->lang('The minimum size (kilobyte) that users can upload photos (eg: 100)'),
					'default' => '',
					'placeholder' => $magic->lang('Enter number in KB'),
					'value' => null
				),
				array(
					'type' => 'input',
					'name' => 'max_upload',
					'label' => $magic->lang('Max size upload'),
					'desc' => $magic->lang('The maximum size (kilobyte) that users can upload photos (eg: 5000)'),
					'default' => '',
					'placeholder' => $magic->lang('Enter number in KB'),
					'value' => null
				),
				array(
					'type' => 'input',
					'name' => 'min_dimensions',
					'label' => $magic->lang('Min dimensions'),
					'desc' => $magic->lang('The min width x height in pixel of images can be added'),
					'default' => '',
					'placeholder' => $magic->lang('Enter dimensions width x height (eg: 100x100)'),
					'value' => null
				),
				array(
					'type' => 'input',
					'name' => 'max_dimensions',
					'label' => $magic->lang('Max dimensions'),
					'desc' => $magic->lang('The max width x height in pixel of images can be added, Automatically decreases if bigger'),
					'default' => '',
					'placeholder' => $magic->lang('Enter dimensions width x height (eg: 500x500)'),
					'value' => null
				),
				array(
					'type' => 'input',
					'name' => 'min_ppi',
					'label' => $magic->lang('Min PPI'),
					'desc' => $magic->lang('The min PPI (pixel per inch) of images can be added (It depends on the size you have configured)'),
					'default' => '',
					'placeholder' => $magic->lang('Recommened minimum 150 PPI'),
					'value' => null
				),
				array(
					'type' => 'input',
					'name' => 'max_ppi',
					'label' => $magic->lang('Max PPI'),
					'desc' => $magic->lang('The max PPI of images can be added (It depends on the size you have configured)'),
					'default' => '',
					'value' => null
				),
				array(
					'type' => 'toggle',
					'name' => 'ppi_notice',
					'label' => $magic->lang('Low resolution notice'),
					'desc' => $magic->lang('Allows to add low resolution images with a notice (when its resolution is lower than Min PPI)'),
					'default' => 'no',
					'value' => null
				),
				array(
					'type' => 'toggle',
					'name' => 'required_full_design',
					'label' => $magic->lang('Design all stages'),
					'desc' => $magic->lang('Required design all stages before add to cart'),
					'default' => 'no',
					'value' => null
				),
				array(
					'type' => 'toggle',
					'name' => 'auto_fit',
					'label' => $magic->lang('Auto zoom to fit'),
					'desc' => $magic->lang('Automatically zooms to fit the product with the screen'),
					'default' => 'yes',
					'value' => null
				),
				array(
					'type' => 'toggle',
					'name' => 'calc_formula',
					'label' => $magic->lang('Show calculation formula'),
					'default' => 'yes',
					'value' => null
				),
				array(
					'type' => 'radios',
					'name' => 'report_bugs',
					'label' => $magic->lang('Enable bug reporting'),
					'desc' => $magic->lang('Allow users report bugs from editor'),
					'default' => '2',
					'value' => null,
					'options' => array(
						'0' => $magic->lang('Disable'),
						'1' => $magic->lang('Enable, but do not send to magicrugs.com'),
						'2' => $magic->lang('Enable, and send to magicrugs.com'),
					)
				),
				array(
					'type' => 'text',
					'name' => 'custom_css',
					'label' => $magic->lang('Custom CSS'),
					'desc' => $magic->lang('Your custom CSS code will run in editor'),
				),
				array(
					'type' => 'text',
					'name' => 'custom_js',
					'label' => $magic->lang('Custom JS'),
					'desc' => $magic->lang('Your custom JS code will run in editor'),
				),
				array(
					'type' => 'input',
					'name' => 'prefix_file',
					'label' => $magic->lang('Prefix name'),
					'desc' => $magic->lang('The prefix of file name download'),
					'default' => 'Front'
				),
				// array(
				// 	'type' => 'toggle',
				// 	'name' => 'text_direction',
				// 	'label' => $magic->lang('Text direction'),
				// 	'desc' => $magic->lang('Fix the text direction when writing, left as default and right for RTL mode'),
				// 	'default' => 'no'
				// ),
				array(
					'type' => 'toggle',
					'name' => 'dis_qrcode',
					'label' => $magic->lang('Disable QRCode'),
					'desc' => $magic->lang('Do not show the QRCode generator'),
					'default' => '',
					'value' => null
				),
				array(
					'type' => 'toggle',
					'name' => 'auto_snap',
					'label' => $magic->lang('Auto snap'),
					'desc' => $magic->lang('Automatically align the position of the active object with other objects'),
					'default' => 'no'
				),
				array(
					'type' => 'toggle',
					'name' => 'template_append',
					'label' => $magic->lang('Template append'),
					'desc' => $magic->lang('Keep all current objects and append the template into'),
					'default' => '',
					'value' => null
				),
				array(
					'type' => 'toggle',
					'name' => 'replace_image',
					'label' => $magic->lang('Replace image'),
					'desc' => $magic->lang('Replace the selected image object instead of creating a new one'),
					'default' => '',
					'value' => null
				),
			),
			'shop:' . $magic->lang('Shop') => array(
				array(
					'type' => 'input',
					'name' => 'currency',
					'label' => $magic->lang('Currency symbol')
				),
				array(
					'type' => 'toggle',
					'name' => 'currency_position',
					'label' => $magic->lang('Currency first?'),
					'desc' => $magic->lang('Display the currency symbol before or after the price number'),
					'default' => 'yes',
					'value' => null
				),
				array(
					'type' => 'input',
					'name' => 'currency_code',
					'label' => $magic->lang('Currency code'),
					'desc' => $magic->lang('The currency code which use for payment'),
				),
				
				array(
					'type' => 'input',
					'name' => 'thousand_separator',
					'label' => $magic->lang('Thousand separator'),
					'desc' => $magic->lang('This sets the thousand separator of displayed price'),
				),
				array(
					'type' => 'input',
					'name' => 'decimal_separator',
					'label' => $magic->lang('Decimal separator'),
					'desc' => $magic->lang('This sets the decimal separator of displayed price'),
				),
				array(
					'type' => 'input',
					'numberic' => 'int',
					'name' => 'number_decimals',
					'label' => $magic->lang('Number of decimals'),
					'desc' => $magic->lang('This sets the number of decimals points show in displayed price'),
				)
			),
			'fonts:' . $magic->lang('Google Fonts') => array(
				array(
					'type' => 'toggle',
					'name' => 'user_font',
					'label' => $magic->lang('User can manage fonts'),
					'desc' => $magic->lang('Allow non-admin users to add new or remove fonts to their browser'),
					'default' => 'yes',
					'value' => null
				),
				array(
					'type' => 'google_fonts',
					'name' => 'google_fonts',
					'label' => $magic->lang('Default Google fonts'),
					'desc' => $magic->lang('Users can add new or remove Google fonts in their profile when using the tool'),
				)
			),
			'languages:' . $magic->lang('Languages') => array(
				array(
					'type' => 'dropbox',
					'name' => 'admin_lang',
					'label' => $magic->lang('Backend language'),
					'options' => $use_langs
				),
				array(
					'type' => 'dropbox',
					'name' => 'editor_lang',
					'label' => $magic->lang('Editor language'),
					'options' => $use_langs
				),
				array(
					'type' => 'toggle',
					'name' => 'allow_select_lang',
					'label' => $magic->lang('Allow users change'),
					'desc' => $magic->lang('Allow users selecting the language in the tool'),
					'default' => 1
				),
				array(
					'type' => 'checkboxes',
					'name' => 'activate_langs',
					'label' => $magic->lang('Activate languages'),
					'options' => $active_langs,
					'desc' => '<a href="'.$magic->cfg->admin_url.'magic-page=languages"><i class="fa fa-plus"></i> '.$magic->lang('Add new language ').'</a>'
				),
			),
			'help:' . $magic->lang('Help contents') => array(
				array(
					'type' => 'input',
					'name' => 'help_title',
					'label' => $magic->lang('Help title'),
					'desc' => $magic->lang('This content will be display under menu "Help" on the editor'),
				),
				array(
					'type' => 'tabs',
					'name' => 'helps',
					'label' => $magic->lang('Help contents'),
					'desc' => $magic->lang('Add the content as plain text, rick text or HTML code, you can translate the title or the content to another language by creating new language text'),
					'tabs' => 5,
					'default' => '[{"title":"Hot keys","content":"<b data-view=\"key\">ctrl<\/b>+<b data-view=\"key\">a<\/b>\r\nSelect all objects<br>\r\n<b data-view=\"key\">ctrl<\/b>+<b data-view=\"key\">d<\/b>\r\nDouble the activate object<br>\r\n<b data-view=\"key\">ctrl<\/b>+<b data-view=\"key\">e<\/b>\r\nClear all objects<br>\r\n<b data-view=\"key\">ctrl<\/b>+<b data-view=\"key\">s<\/b>\r\nSave current stage to my design<br>\r\n<b data-view=\"key\">ctrl<\/b>+<b data-view=\"key\">o<\/b>\r\nOpen a file to import design<br>\r\n<b data-view=\"key\">ctrl<\/b>+<b data-view=\"key\">p<\/b>\r\nPrint<br>\r\n<b data-view=\"key\">ctrl<\/b>+<b data-view=\"key\">+<\/b>\r\nZoom out<br>\r\n<b data-view=\"key\">ctrl<\/b>+<b data-view=\"key\">-<\/b>\r\nZoom in<br>\r\n<b data-view=\"key\">ctrl<\/b>+<b data-view=\"key\">0<\/b>\r\nReset zoom<br>\r\n<b data-view=\"key\">ctrl<\/b>+<b data-view=\"key\">z<\/b>\r\nUndo changes<br>\r\n<b data-view=\"key\">ctrl<\/b>+<b data-view=\"key\">shift<\/b>+<b data-view=\"key\">z<\/b>\r\nRedo changes<br>\r\n<b data-view=\"key\">ctrl<\/b>+<b data-view=\"key\">shift<\/b>+<b data-view=\"key\">s<\/b>\r\nDownload current design<br>\r\n<b data-view=\"key\">delete<\/b> Delete the activate object<br>\r\n<b data-view=\"key\">\u2190<\/b> Move the activate object to left<br>\r\n<b data-view=\"key\">\u2191<\/b> Move the activate object to top<br>\r\n<b data-view=\"key\">\u2192<\/b> Move the activate object to right<br>\r\n<b data-view=\"key\">\u2193<\/b> Move the activate object to bottom<br>\r\n<b data-view=\"key\">shift<\/b>+<b data-view=\"key\">\u2190<\/b>\r\nMove the activate object to left 10px<br>\r\n<b data-view=\"key\">shift<\/b>+<b data-view=\"key\">\u2191<\/b>\r\nMove the activate object to top 10px<br>\r\n<b data-view=\"key\">shift<\/b>+<b data-view=\"key\">\u2192<\/b>\r\nMove the activate object to right 10px<br>\r\n<b data-view=\"key\">shift<\/b>+<b data-view=\"key\">\u2193<\/b>\r\nMove the activate object to bottom 10px<br>"},{"title":"Custom","content":"Custom help content"}]'
				),
				array(
					'type' => 'text',
					'name' => 'about',
					'label' => $magic->lang('About content'),
					'desc' => $magic->lang('This content will be display on the about tab under your logo, you can use the rick text or HTML format here'),
				)
			)
		)
	);
	
	if ($magic->connector->platform == 'woocommerce') {
		$arg['tabs']['shop:'.$magic->lang('Shop')][] =  array(
			'type' => 'toggle',
			'name' => 'show_only_design',
			'label' => $magic->lang('Show only design'),
			'desc' => $magic->lang('Show only design in cart page (hide product)'),
		);
	}

	if ($magic->connector->platform == 'php') {
		$arg['tabs']['admin:'.$magic->lang('Admin login')] =  array(
			array(
				'type' => 'admin_login'
			)
		);
	}
	
	if ($magic->connector->platform == 'php') {
		$arg['tabs']['shop:'.$magic->lang('Shop')][] = array(
			'type' => 'input',
			'name' => 'merchant_id',
			'label' => $magic->lang('Merchant Paypal Id'),
			'desc' => $magic->lang('The Paypal username to receive payments'),
		);
		
		$arg['tabs']['shop:'.$magic->lang('Shop')][] = array(
			'type' => 'toggle',
			'name' => 'sanbox_mode',
			'label' => $magic->lang('Sanbox Mode'),
			'desc' => $magic->lang('Enable sanbox paypal mode for testing. If No, it is live production mode.'),
			'default' => 1
		);
	}
	
	$arg = $magic->apply_filters('settings_fields', $arg);
	
	$fields = $magic_admin->process_settings_data($arg);

?>

<div class="magic_wrapper" id="magic-<?php echo $section; ?>-page">
	<div class="magic_content">
		<form action="<?php echo $magic->cfg->admin_url; ?>magic-page=<?php 
			echo $section.(isset($_GET['callback']) ? '&callback='.$_GET['callback'] : '');
		?>" id="magic-settings-form" method="post" class="magic_form" enctype="multipart/form-data">
			
			<?php 
				$magic->views->header_message();
				$magic->views->tabs_render($fields, 'settings'); 
			?>
			
			<div class="magic_form_group" style="margin-top: 20px">
				<input type="submit" class="magic-button magic-button-primary" value="<?php echo $magic->lang('Save Settings'); ?>"/>
				<input type="hidden" name="do" value="action" />
				<input type="hidden" name="magic-section" value="<?php echo $section; ?>">
			</div>
		</form>
	</div>
</div>
