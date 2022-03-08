<?php
	global $customdesign;

	$section = 'printing';

	$components = array();
	foreach ($customdesign->cfg->editor_menus as $key => $menu) {
		$components[$key] = $menu['label'];
	}

	$components = array_merge($components, array(
		'shop' => $customdesign->lang('Shopping cart'),
		'back' => $customdesign->lang('Back to Shop'),
	));
	
	$default_fonts = !empty($customdesign->cfg->default_fonts) ? stripslashes($customdesign->cfg->default_fonts) : array();
	$font = $customdesign->get_fonts();
	$default_fonts = json_decode(htmlspecialchars_decode($default_fonts), true);
	$font_available = array_merge(array_keys($default_fonts),array_column($font,'name_desc'));
	$font_available = array_map('urldecode', $font_available);

	$resource_args =array(
		'font' => array(
			'title'  => $customdesign->lang('Font'),
			'priority' => 10,
			'fields' => array(
				array(
					'type' => 'multiselect',
					'name' => 'font_available',
					'label' => $customdesign->lang('Font available'),
					'default' => $font_available,
					'value' => null,
					'options' => $font_available
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
					'name' => 'color_picker',
					'label' => $customdesign->lang('Color picker'),
					'default' => 'yes',
					'desc' => $customdesign->lang('Allow users select colors from the color picker'),
					'value' => null
				),
				array(
					'type' => 'advance_option',
					'name' => 'options',
					'label' => $customdesign->lang('Advance option'),
					'option_fields' => $customdesign->views->get_resource_fields('font'),
				),
			)
		),  
		'cliparts'=> array(
			'title'  => $customdesign->lang('Clipart'),
			'priority' => 20,
			'fields' => array(
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
					'name' => 'color_picker',
					'label' => $customdesign->lang('Color picker'),
					'default' => 'yes',
					'desc' => $customdesign->lang('Allow users select colors from the color picker'),
					'value' => null
				),
				array(
					'type' => 'categories',
					'cate_type' => 'cliparts',
					'parent' => 0,
					'name' => 'categories',
					'label' => $customdesign->lang('Categories'),
					'id' => 0,

				),
				array(
					'type' => 'advance_option',
					'name' => 'options',
					'label' => $customdesign->lang('Advance option'),
					'option_fields' => $customdesign->views->get_resource_fields('cliparts'),
					
				),
			)
		), 
		'templates'=> array(
			'title'  => $customdesign->lang('Template'),
			'priority' => 30,
			'fields' => array(
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
					'name' => 'color_picker',
					'label' => $customdesign->lang('Color picker'),
					'default' => 'yes',
					'desc' => $customdesign->lang('Allow users select colors from the color picker'),
					'value' => null
				),
				array(
					'type' => 'categories',
					'cate_type' => 'templates',
					'parent' => 0,
					'name' => 'categories',
					'label' => $customdesign->lang('Categories'),
					'id' => 0,
				),
				array(
					'type' => 'advance_option',
					'name' => 'options',
					'label' => $customdesign->lang('Advance option'),
					'option_fields' => $customdesign->views->get_resource_fields('templates'),		
				),
			)
		),  
		'image_upload'=> array(
			'title'  => $customdesign->lang('Image Upload'),
			'priority' => 40,
			'fields' => array(
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
					'name' => 'color_picker',
					'label' => $customdesign->lang('Color picker'),
					'default' => 'yes',
					'desc' => $customdesign->lang('Allow users select colors from the color picker'),
					'value' => null
				),
				array(
					'type' => 'advance_option',
					'name' => 'options',
					'label' => $customdesign->lang('Advance option'),
					'option_fields' => $customdesign->views->get_resource_fields('image'),
					
				),
			)
		),  
		'shapes'=> array(
			'title'  => $customdesign->lang('Shape'),
			'priority' => 50,
			'fields' => array(
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
					'name' => 'color_picker',
					'label' => $customdesign->lang('Color picker'),
					'default' => 'yes',
					'desc' => $customdesign->lang('Allow users select colors from the color picker'),
					'value' => null
				),
				array(
					'type' => 'advance_option',
					'name' => 'options',
					'label' => $customdesign->lang('Advance option'),
					'option_fields' => $customdesign->views->get_resource_fields('shapes'),
					
				),
			)
		),  
	);
	
	$actives = $customdesign->get_option('active_addons');
	if ($actives !== null && !empty($actives))
		$actives = (Array)@json_decode($actives);
	
	if(in_array('images', array_keys($actives)) && $actives['images']){
		$resource_args['image'] = array(
			'title'  => $customdesign->lang('Image'),
			'priority' => 35,
			'fields' => array(
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
					'name' => 'color_picker',
					'label' => $customdesign->lang('Color picker'),
					'default' => 'yes',
					'desc' => $customdesign->lang('Allow users select colors from the color picker'),
					'value' => null
				),
				array(
					'type' => 'categories',
					'cate_type' => 'images',
					'parent' => 0,
					'name' => 'categories',
					'label' => $customdesign->lang('Categories'),
					'id' => 0,	
				),
				array(
					'type' => 'advance_option',
					'name' => 'options',
					'label' => $customdesign->lang('Advance option'),
					'option_fields' => $customdesign->views->get_resource_fields('image'),
					
				),
			)
		);
	}

	if(in_array('backgrounds', array_keys($actives)) && $actives['backgrounds']){
		$resource_args['backgrounds'] = array(
			'title'  => $customdesign->lang('Background'),
			'priority' => 60,
			'fields' => array(
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
					'name' => 'color_picker',
					'label' => $customdesign->lang('Color picker'),
					'default' => 'yes',
					'desc' => $customdesign->lang('Allow users select colors from the color picker'),
					'value' => null
				),
				array(
					'type' => 'categories',
					'cate_type' => 'backgrounds',
					'parent' => 0,
					'name' => 'categories',
					'label' => $customdesign->lang('Categories'),
					'id' => 0,	
				),
				array(
					'type' => 'advance_option',
					'name' => 'options',
					'label' => $customdesign->lang('Advance option'),
					'option_fields' => $customdesign->views->get_resource_fields('background'),
				),
			)
		);
	}

	uasort( $resource_args, function($a, $b){
		if ( ! isset( $a['priority'], $b['priority'] ) || $a['priority'] === $b['priority'] ) {
			return 0;
		}
		return ( $a['priority'] < $b['priority'] ) ? -1 : 1;
	});	
	
	$args = array(
		'tabs' => array(
			'general:' . $customdesign->lang('General') => array(
				array(
					'type' => 'input',
					'name' => 'title',
					'label' => $customdesign->lang('Printing Title'),
					'required' => true,
					'default' => 'Untitled'
				),
				array(
					'type' => 'upload',
					'name' => 'upload',
					'thumbn' => 'thumbnail',
					'thumbn_width' => 320,
					'path' => 'printings'.DS,
					'label' => $customdesign->lang('Printing thumbnail'),
					'desc' => $customdesign->lang('Supported files svg, png, jpg, jpeg. Max size 5MB'),
				),
				array(
					'type' => 'text',
					'name' => 'description',
					'label' => $customdesign->lang('Description'),
				),
				array(
					'type' => 'toggle',
					'name' => 'active',
					'label' => $customdesign->lang('Active'),
					'default' => 'yes',
					'value' => null
				),
			),
			'ruler:' . $customdesign->lang('Price ruler') => array(
				array(
					'type' => 'print',
					'name' => 'calculate',
					'label' => $customdesign->lang('Calculation Price'),
					'prints_type' => $customdesign->lib->get_print_types()
				),
			),
			'resource:' . $customdesign->lang('Resource') => array(
				array(
					'type' => 'resource',
					'name' => 'resource',	
					'desc' => $customdesign->lang('Resource'),
					'tabs' => $resource_args,
					'default' => '[]',
				),
			),
			'layout:' . $customdesign->lang('Layout') => array(
				array(
					'type' => 'groups',
					'name' => 'layout',
					'fields' => array(
						// array(
						// 	'type' => 'dropbox',
						// 	'name' => 'open_type',
						// 	'label' => $customdesign->lang('Open product designer in'),
						// 	'default' => 'page',
						// 	'options' => array(
						// 		'popup' => 'Popup',
						// 		'page' => 'Design editor page',
						// 	)
						// ),
						array(
							'type' => 'checkboxes',
							'name' => 'components',
							'label' => $customdesign->lang('Select component'),
							'desc' => $customdesign->lang('Show/hide components of editor, you also can arrange them as how you want'),
							'default' => $customdesign->cfg->settings['components'],//implode(',', array_keys($components)),
							'value' => null,
							'options' => $components
						),
						array(
							'type' => 'multiselect',
							'name' => 'actions',
							'label' => $customdesign->lang('Select action'),
							'default' => 'file,design,print,share,help,undo,redo,zoom,preview,qrcode',
							'value' => null,
							'options' => ['file', 'design', 'print', 'share', 'help', 'undo', 'redo', 'zoom', 'preview', 'qrcode']
						),
						array(
							'type' => 'multiselect',
							'name' => 'toolbars',
							'label' => $customdesign->lang('Select toolbar '),
							'default' => 'replace-image,crop,mask,remove-bg,filter,fill,layer,position,transform,advance-SVG,select-font,text-effect,font-size,line-height,letter-spacing,text-align,font-style',
							'value' => null,
							'options' => array (
								'replace-image',
								'crop',
								'mask',
								'remove-bg',
								'filter',
								'fill',
								'layer',
								'position',
								'transform',
								'advance-SVG',
								'select-font',
								'text-effect',
								'font-size',
								'line-height',
								'letter-spacing',
								'text-align',
								'font-style',
							)
						),
					)
				),
				
			),
		)
	);
	$fields = $customdesign_admin->process_data($args, 'printings');

?>

<div class="customdesign_wrapper" id="customdesign-<?php echo $section; ?>-page">
	<div class="customdesign_content">
		<?php
			$customdesign->views->detail_header(array(
				'add' => $customdesign->lang('Add new printing'),
				'edit' => $fields['tabs']['general:' . $customdesign->lang('General')][0]['value'],
				'page' => $section
			));
		?>
		<form action="<?php echo $customdesign->cfg->admin_url; ?>customdesign-page=<?php
			echo $section.(isset($_GET['callback']) ? '&callback='.$_GET['callback'] : '');
		?>" id="customdesign-<?php echo $section; ?>-form" method="post" class="customdesign_form" enctype="multipart/form-data">

			<?php $customdesign->views->tabs_render($fields); ?>

			<div class="customdesign_form_group customdesign_form_submit">
				<input type="submit" class="customdesign-button customdesign-button-primary" value="<?php echo $customdesign->lang('Save Printing'); ?>"/>
				<input type="hidden" name="do" value="action" />
				<a class="customdesign_cancel" href="<?php echo $customdesign->cfg->admin_url;?>customdesign-page=<?php echo $section; ?>s">
					<?php echo $customdesign->lang('Cancel'); ?>
				</a>
				<input type="hidden" name="customdesign-section" value="<?php echo $section; ?>">
			</div>
		</form>
	</div>
</div>
