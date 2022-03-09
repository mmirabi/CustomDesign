<?php
	global $magic;

	$section = 'printing';

	$components = array();
	foreach ($magic->cfg->editor_menus as $key => $menu) {
		$components[$key] = $menu['label'];
	}

	$components = array_merge($components, array(
		'shop' => $magic->lang('Shopping cart'),
		'back' => $magic->lang('Back to Shop'),
	));
	
	$default_fonts = !empty($magic->cfg->default_fonts) ? stripslashes($magic->cfg->default_fonts) : array();
	$font = $magic->get_fonts();
	$default_fonts = json_decode(htmlspecialchars_decode($default_fonts), true);
	$font_available = array_merge(array_keys($default_fonts),array_column($font,'name_desc'));
	$font_available = array_map('urldecode', $font_available);

	$resource_args =array(
		'font' => array(
			'title'  => $magic->lang('Font'),
			'priority' => 10,
			'fields' => array(
				array(
					'type' => 'multiselect',
					'name' => 'font_available',
					'label' => $magic->lang('Font available'),
					'default' => $font_available,
					'value' => null,
					'options' => $font_available
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
					'name' => 'color_picker',
					'label' => $magic->lang('Color picker'),
					'default' => 'yes',
					'desc' => $magic->lang('Allow users select colors from the color picker'),
					'value' => null
				),
				array(
					'type' => 'advance_option',
					'name' => 'options',
					'label' => $magic->lang('Advance option'),
					'option_fields' => $magic->views->get_resource_fields('font'),
				),
			)
		),  
		'cliparts'=> array(
			'title'  => $magic->lang('Clipart'),
			'priority' => 20,
			'fields' => array(
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
					'name' => 'color_picker',
					'label' => $magic->lang('Color picker'),
					'default' => 'yes',
					'desc' => $magic->lang('Allow users select colors from the color picker'),
					'value' => null
				),
				array(
					'type' => 'categories',
					'cate_type' => 'cliparts',
					'parent' => 0,
					'name' => 'categories',
					'label' => $magic->lang('Categories'),
					'id' => 0,

				),
				array(
					'type' => 'advance_option',
					'name' => 'options',
					'label' => $magic->lang('Advance option'),
					'option_fields' => $magic->views->get_resource_fields('cliparts'),
					
				),
			)
		), 
		'templates'=> array(
			'title'  => $magic->lang('Template'),
			'priority' => 30,
			'fields' => array(
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
					'name' => 'color_picker',
					'label' => $magic->lang('Color picker'),
					'default' => 'yes',
					'desc' => $magic->lang('Allow users select colors from the color picker'),
					'value' => null
				),
				array(
					'type' => 'categories',
					'cate_type' => 'templates',
					'parent' => 0,
					'name' => 'categories',
					'label' => $magic->lang('Categories'),
					'id' => 0,
				),
				array(
					'type' => 'advance_option',
					'name' => 'options',
					'label' => $magic->lang('Advance option'),
					'option_fields' => $magic->views->get_resource_fields('templates'),		
				),
			)
		),  
		'image_upload'=> array(
			'title'  => $magic->lang('Image Upload'),
			'priority' => 40,
			'fields' => array(
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
					'name' => 'color_picker',
					'label' => $magic->lang('Color picker'),
					'default' => 'yes',
					'desc' => $magic->lang('Allow users select colors from the color picker'),
					'value' => null
				),
				array(
					'type' => 'advance_option',
					'name' => 'options',
					'label' => $magic->lang('Advance option'),
					'option_fields' => $magic->views->get_resource_fields('image'),
					
				),
			)
		),  
		'shapes'=> array(
			'title'  => $magic->lang('Shape'),
			'priority' => 50,
			'fields' => array(
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
					'name' => 'color_picker',
					'label' => $magic->lang('Color picker'),
					'default' => 'yes',
					'desc' => $magic->lang('Allow users select colors from the color picker'),
					'value' => null
				),
				array(
					'type' => 'advance_option',
					'name' => 'options',
					'label' => $magic->lang('Advance option'),
					'option_fields' => $magic->views->get_resource_fields('shapes'),
					
				),
			)
		),  
	);
	
	$actives = $magic->get_option('active_addons');
	if ($actives !== null && !empty($actives))
		$actives = (Array)@json_decode($actives);
	
	if(in_array('images', array_keys($actives)) && $actives['images']){
		$resource_args['image'] = array(
			'title'  => $magic->lang('Image'),
			'priority' => 35,
			'fields' => array(
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
					'name' => 'color_picker',
					'label' => $magic->lang('Color picker'),
					'default' => 'yes',
					'desc' => $magic->lang('Allow users select colors from the color picker'),
					'value' => null
				),
				array(
					'type' => 'categories',
					'cate_type' => 'images',
					'parent' => 0,
					'name' => 'categories',
					'label' => $magic->lang('Categories'),
					'id' => 0,	
				),
				array(
					'type' => 'advance_option',
					'name' => 'options',
					'label' => $magic->lang('Advance option'),
					'option_fields' => $magic->views->get_resource_fields('image'),
					
				),
			)
		);
	}

	if(in_array('backgrounds', array_keys($actives)) && $actives['backgrounds']){
		$resource_args['backgrounds'] = array(
			'title'  => $magic->lang('Background'),
			'priority' => 60,
			'fields' => array(
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
					'name' => 'color_picker',
					'label' => $magic->lang('Color picker'),
					'default' => 'yes',
					'desc' => $magic->lang('Allow users select colors from the color picker'),
					'value' => null
				),
				array(
					'type' => 'categories',
					'cate_type' => 'backgrounds',
					'parent' => 0,
					'name' => 'categories',
					'label' => $magic->lang('Categories'),
					'id' => 0,	
				),
				array(
					'type' => 'advance_option',
					'name' => 'options',
					'label' => $magic->lang('Advance option'),
					'option_fields' => $magic->views->get_resource_fields('background'),
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
			'general:' . $magic->lang('General') => array(
				array(
					'type' => 'input',
					'name' => 'title',
					'label' => $magic->lang('Printing Title'),
					'required' => true,
					'default' => 'Untitled'
				),
				array(
					'type' => 'upload',
					'name' => 'upload',
					'thumbn' => 'thumbnail',
					'thumbn_width' => 320,
					'path' => 'printings'.DS,
					'label' => $magic->lang('Printing thumbnail'),
					'desc' => $magic->lang('Supported files svg, png, jpg, jpeg. Max size 5MB'),
				),
				array(
					'type' => 'text',
					'name' => 'description',
					'label' => $magic->lang('Description'),
				),
				array(
					'type' => 'toggle',
					'name' => 'active',
					'label' => $magic->lang('Active'),
					'default' => 'yes',
					'value' => null
				),
			),
			'ruler:' . $magic->lang('Price ruler') => array(
				array(
					'type' => 'print',
					'name' => 'calculate',
					'label' => $magic->lang('Calculation Price'),
					'prints_type' => $magic->lib->get_print_types()
				),
			),
			'resource:' . $magic->lang('Resource') => array(
				array(
					'type' => 'resource',
					'name' => 'resource',	
					'desc' => $magic->lang('Resource'),
					'tabs' => $resource_args,
					'default' => '[]',
				),
			),
			'layout:' . $magic->lang('Layout') => array(
				array(
					'type' => 'groups',
					'name' => 'layout',
					'fields' => array(
						// array(
						// 	'type' => 'dropbox',
						// 	'name' => 'open_type',
						// 	'label' => $magic->lang('Open product designer in'),
						// 	'default' => 'page',
						// 	'options' => array(
						// 		'popup' => 'Popup',
						// 		'page' => 'Design editor page',
						// 	)
						// ),
						array(
							'type' => 'checkboxes',
							'name' => 'components',
							'label' => $magic->lang('Select component'),
							'desc' => $magic->lang('Show/hide components of editor, you also can arrange them as how you want'),
							'default' => $magic->cfg->settings['components'],//implode(',', array_keys($components)),
							'value' => null,
							'options' => $components
						),
						array(
							'type' => 'multiselect',
							'name' => 'actions',
							'label' => $magic->lang('Select action'),
							'default' => 'file,design,print,share,help,undo,redo,zoom,preview,qrcode',
							'value' => null,
							'options' => ['file', 'design', 'print', 'share', 'help', 'undo', 'redo', 'zoom', 'preview', 'qrcode']
						),
						array(
							'type' => 'multiselect',
							'name' => 'toolbars',
							'label' => $magic->lang('Select toolbar '),
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
	$fields = $magic_admin->process_data($args, 'printings');

?>

<div class="magic_wrapper" id="magic-<?php echo $section; ?>-page">
	<div class="magic_content">
		<?php
			$magic->views->detail_header(array(
				'add' => $magic->lang('Add new printing'),
				'edit' => $fields['tabs']['general:' . $magic->lang('General')][0]['value'],
				'page' => $section
			));
		?>
		<form action="<?php echo $magic->cfg->admin_url; ?>magic-page=<?php
			echo $section.(isset($_GET['callback']) ? '&callback='.$_GET['callback'] : '');
		?>" id="magic-<?php echo $section; ?>-form" method="post" class="magic_form" enctype="multipart/form-data">

			<?php $magic->views->tabs_render($fields); ?>

			<div class="magic_form_group magic_form_submit">
				<input type="submit" class="magic-button magic-button-primary" value="<?php echo $magic->lang('Save Printing'); ?>"/>
				<input type="hidden" name="do" value="action" />
				<a class="magic_cancel" href="<?php echo $magic->cfg->admin_url;?>magic-page=<?php echo $section; ?>s">
					<?php echo $magic->lang('Cancel'); ?>
				</a>
				<input type="hidden" name="magic-section" value="<?php echo $section; ?>">
			</div>
		</form>
	</div>
</div>
