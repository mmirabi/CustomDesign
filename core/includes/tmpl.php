<?php
/**
*
*	(p) package: MagicRugs
*	(c) author:	Mehdi Mirabi
*	(i) website: https://www.magicrugs.com
*
*/

class magic_tmpl_register {
	
	public function reg_editor_menus() {

		global $magic;
		
		return array(
			
			'product' => array(
				"label" => $magic->lang('Product'),
				"icon" => "magicx-cube",
				"callback" => "",
				"load" => "",
				"content" =>
					'<header>
						<name></name>
						<price></price>
						<sku></sku>'.
						(
							!isset($_GET['product_base']) || strpos($_GET['product_base'], 'variable:') === false ?
							'<button class="magic-btn white" id="magic-change-product">
								'.$magic->lang('Change product').'
								<i class="magicx-arrow-swap"></i>
							</button>' : ''
						).
						'<desc>
							<span></span>
							&nbsp;&nbsp;<a href="#more">'.$magic->lang('More').'</a>
						</desc>
					</header>
					<div id="magic-cart-wrp" data-view="attributes" class="smooth">
						<div class="magic-cart-options">
							<div class="magic-prints"></div>
							<div class="magic-cart-attributes" id="magic-cart-attributes"></div>
						</div>
					</div>'
			),
			
			'templates' => array(
				"label" => $magic->lang('Templates'),
				"icon" => "magic-icon-star",
				"callback" => "",
				"load" => "templates",
				"class" => "magic-x-thumbn",
				"content" =>
					'<header>
						<span class="magic-templates-search">
							<input type="search" id="magic-templates-search-inp" placeholder="'.$magic->lang('Search templates').'" />
							<i class="magicx-android-search"></i>
						</span>
						<div class="magic-template-categories" data-prevent-click="true">
							<button data-func="show-categories" data-type="templates">
								<span>'.$magic->lang('All categories').'</span>
								<i class="magicx-ios-arrow-forward"></i>
							</button>
						</div>
					</header>
					<div id="magic-templates-list" class="smooth">
						<ul class="magic-list-items">
							<i class="magic-spinner white x3 mt2"></i>
						</ul>
					</div>'
			),
			
			'cliparts' => array(
				"label" => $magic->lang('Cliparts'),
				"icon" => "magic-icon-heart",
				"callback" => "",
				"load" => "cliparts",
				"class" => "magic-x-thumbn",
				"content" =>
					'<header>
						<span class="magic-cliparts-search">
							<input type="search" id="magic-cliparts-search-inp" placeholder="'.$magic->lang('Search cliparts').'" />
							<i class="magicx-android-search"></i>
						</span>
						<div class="magic-clipart-categories" data-prevent-click="true">
							<button data-func="show-categories" data-type="cliparts">
								<span>'.$magic->lang('All categories').'</span>
								<i class="magicx-ios-arrow-forward"></i>
							</button>
						</div>
					</header>
					<div id="magic-cliparts-list" class="smooth">
						<ul class="magic-list-items">
							<i class="magic-spinner white x3 mt2"></i>
						</ul>
					</div>'
			),
			
			'text' => array(
				"label" => $magic->lang('Text'),
				"icon" => "magicx-character",
				"callback" => "",
				"load" => "",
				"class" => "smooth",
				"content" =>
					'<p class="gray">'.$magic->lang('Click or drag to add text').'</p>
					<span draggable="true" data-act="add" data-ops=\'[{"fontFamily":"Anton","text": "CurvedText", "fontSize": 30, "font":["","regular"],"bridge":{"bottom":2,"curve":-4.5,"oblique":false,"offsetY":0.5,"trident":false},"type":"curvedText"}]\'>
						<img height="70" src="'.$magic->cfg->assets_url.'assets/images/text-sample-curved.png" />
					</span>
					<span draggable="true" data-act="add" data-ops=\'[{"fontFamily":"Anton","text": "10", "fontSize": 100, "font":["","regular"],"type":"i-text", "charSpacing": 40, "top": -50},{"fontFamily":"Poppins","text": "Messi", "fontSize": 30, "font":["","regular"],"type":"i-text", "charSpacing": 40, "top": 10}]\' style="text-align: center;">
						<img height="70" src="'.$magic->cfg->assets_url.'assets/images/text-number.png" />
					</span>
					<span draggable="true" data-act="add" data-ops=\'[{"fontFamily":"Anton","text": "Oblique","fontSize":60,"font":["","regular"],"bridge":{"bottom":4.5,"curve":10,"oblique":true,"offsetY":0.5,"trident":false},"type":"text-fx"}]\'>
						<img height="70" src="'.$magic->cfg->assets_url.'assets/images/text-sample-oblique.png" />
					</span>
					<span draggable="true" data-act="add" data-ops=\'[{"fontFamily":"Anton","text": "Bridge","fontSize":70,"font":["","regular"],"bridge":{"bottom":2,"curve":-4.5,"oblique":false,"offsetY":0.5,"trident":false},"type":"text-fx"}]\'>
						<img height="70" src="'.$magic->cfg->assets_url.'assets/images/text-sample-bridge-1.png" />
					</span>
					<span draggable="true" data-act="add" data-ops=\'[{"fontFamily":"Anton","text": "Bridge","fontSize":70,"font":["","regular"],"bridge":{"bottom":2,"curve":-2.5,"oblique":false,"offsetY":0.1,"trident":false},"type":"text-fx"}]\'>
						<img height="70" src="'.$magic->cfg->assets_url.'assets/images/text-sample-bridge-2.png" />
					</span>
					<span draggable="true" data-act="add" data-ops=\'[{"fontFamily":"Anton","text": "Bridge","fontSize":70,"font":["","regular"],"bridge":{"bottom":2,"curve":-3,"oblique":false,"offsetY":0.5,"trident":true},"type":"text-fx"}]\'>
						<img height="70" src="'.$magic->cfg->assets_url.'assets/images/text-sample-bridge-3.png" />
					</span>
					<span draggable="true" data-act="add" data-ops=\'[{"fontFamily":"Anton","text": "Bridge","fontSize":70,"font":["","regular"],"bridge":{"bottom":5,"curve":5,"oblique":false,"offsetY":0.5,"trident":false},"type":"text-fx"}]\'>
						<img height="70" src="'.$magic->cfg->assets_url.'assets/images/text-sample-bridge-4.png" />
					</span>
					<span draggable="true" data-act="add" data-ops=\'[{"fontFamily":"Anton","text": "Bridge","fontSize":70,"font":["","regular"],"bridge":{"bottom":2.5,"curve":2.5,"oblique":false,"offsetY":0.05,"trident":false},"type":"text-fx"}]\'>
						<img height="70" src="'.$magic->cfg->assets_url.'assets/images/text-sample-bridge-5.png" />
					</span>
					<span draggable="true" data-act="add" data-ops=\'[{"fontFamily":"Anton","text": "Bridge","fontSize":70,"font":["","regular"],"bridge":{"bottom":3,"curve":2.5,"oblique":false,"offsetY":0.5,"trident":true},"type":"text-fx"}]\'>
						<img height="70" src="'.$magic->cfg->assets_url.'assets/images/text-sample-bridge-6.png" />
					</span>
					<span id="magic-text-mask-guide">
						<img height="70" src="'.$magic->cfg->assets_url.'assets/images/text-sample-mask.png" />
					</span>
					<div id="magic-text-ext"></div>'.
					($magic->connector->is_admin() || $magic->cfg->settings['user_font'] !== '0' ? '<button class="magic-btn mb2 magic-more-fonts">'.$magic->lang('Load more 878+ fonts').'</button>' : '')
			),
			
			'uploads' => array(
				"label" => $magic->lang('Images'),
				"icon" => "magic-icon-picture",
				"callback" => "",
				"load" => "images",
				"class" => "magic-x-thumbn",
				"content" =>
					(($magic->connector->is_admin() || $magic->cfg->settings['disable_resources'] != 1) ? 
					'<header class="images-from-socials magic_form_group">
						<button class="active" data-nav="internal">
							<i class="magic-icon-cloud-upload"></i>
							'.$magic->lang('Upload').'
						</button>
						<button data-nav="external">
							<i class="magic-icon-magnifier"></i>
							'.$magic->lang('Resources').'
						</button>
					</header>' : '').
					'<div data-tab="internal" class="active">
						<div id="magic-upload-form">
							<i class="magic-icon-cloud-upload"></i>
							<span>'.$magic->lang('Click or drop images here').'</span>
							<input type="file" multiple="true" />
						</div>
						<div id="magic-upload-list">
							<ul class="magic-list-items"></ul>
						</div>
					</div>
					<div data-tab="external" id="magic-external-images"></div>'
			),
			
			'shapes' => array(
				"label" => $magic->lang('Shapes'),
				"icon" => "magicx-diamond",
				"callback" => "",
				"load" => "shapes",
				"class" => "smooth",
				"content" => ""
			),
			
			'layers' => array(
				"label" => $magic->lang('Layers'),
				"icon" => "magic-icon-layers",
				"callback" => "layers",
				"load" => "",
				"class" => "smooth",
				"content" => "<ul></ul>"
			),
			
			'drawing' => array(
				"label" => $magic->lang('Drawing'),
				"icon" => "magic-icon-note",
				"callback" => "",
				"load" => "",
				"class" => "magic-left-form",
				"content" => 
					'<h3>'.$magic->lang('Free drawing mode').'</h3>
					<div>
						<label>'.$magic->lang('Size').'</label>
						<inp data-range="helper" data-value="1">
							<input id="magic-drawing-width" data-callback="drawing" value="1" min="1" max="100" data-value="1" type="range" />
						</inp>
					</div>
					<div'.($magic->cfg->settings['enable_colors'] == '0' ? ' class="hidden"' : '').'>
						<input id="magic-drawing-color" placeholder="'.$magic->lang('Click to choose color').'" type="search" class="color" />
						<span class="magic-save-color" data-tip="true" data-target="drawing-color">
							<i class="magicx-android-add"></i>
							<span>'.$magic->lang('Save this color').'</span>
						</span>
					</div>
					<div>
						<ul class="magic-color-presets" data-target="drawing-color"></ul>
					</div>
					<div class="gray">
						<span>
							<i class="magicx-android-bulb"></i>
							'.$magic->lang('Tips: Mouse wheel on the canvas to quick change the brush size').'
						</span>
					</div>'
			)
		);
	}
	
	public function reg_product_attributes() {
		
		global $magic;
		
		$arg = $this->color_options();
		
		$color_options = $this->build_form( $arg );
		
		$arg['extend']['content'] = '<input type="checkbox" data-op-name="is_multiple" \'+(data.multiple ? "checked" : "")+\' id="multiple-\'+random_id+\'" /> \
			<label for="multiple-\'+random_id+\'">'.$magic->lang('Allow select multiple colors').'</label>';
		$arg['extend']['return'] = 'values.multiple = wrp.find(\'input[data-op-name="is_multiple"]\').prop(\'checked\');';
		
		$picker_options = $this->build_form( $arg );
		
		return array(
			
			'printing' => array(
				'hidden' => true,
				'render' => ''
			),
			
			'select' => array(
				'title' => $magic->lang('Drop down'),
				'use_variation' => true,
				'values' => $this->build_form($this->form_options()),
				'render' => $this->render_select()
			),
			
			'product_color' => array(
				'title' => $magic->lang('Product colors'),
				'unique' => true,
				'use_variation' => true,
				'values' => $color_options,
				'render' => $this->render_color()
			),
			
			'color' => array(
				'title' => $magic->lang('Color picker'),
				'values' => $picker_options,
				'render' => $this->render_picker()
			),
			
			'input' => array(
				'title' => $magic->lang('Input text'),
				'default' => '',
				'placeholder' => '',
				'render' => <<<EOF
					return '<input type="text" name="'+data.id+'" class="magic-cart-param" value="'+data.value.replace(/\"/g, '&#x22;')+'" '+(data.required ? 'required' : '')+' />';			
EOF
			),
			
			'text' => array(
				'title' => $magic->lang('Textarea'),
				'default' => '',
				'placeholder' => '',
				'render' => <<<EOF
					return '<textarea type="text" name="'+data.id+'" class="magic-cart-param" '+(data.required ? 'required' : '')+'>'+data.value.replace(/\>/g, '&gt;').replace(/\</g, '&lt;')+'</textarea>';			
EOF
			),
			
			/*'checkbox' => array(
				'title' => $magic->lang('Multiple checkbox'),
				'values' => $select_options,
				'render' => <<<EOF
					
					var wrp = $('<div class="magic_checkboxes"></div>');
					
					if (!data.value)
						data.value = [];
					else if (typeof data.value == 'string')
						data.value = data.value.split(decodeURI("%0A"));
					
					data.values.map(function(op) {
						
						var new_op 	= '<div class="magic_checkbox">';
						
						new_op 	+= '<input type="checkbox" name="'+data.id+'" class="magic-cart-param action_check" value="'+op.value+'" id="'+(data.id + '-' +op.value)+'" '+(data.required ? 'required' : '')+' '+(data.value.indexOf(op.value) > -1 ? 'checked' : '')+' />';
						new_op 	+= '<label for="'+(data.id + '-' +op.value)+'" class="magic-cart-option-label">'+
										op.title.replace(/\</g, '&lt;').replace(/\>/g, '&gt;')+
										'<em class="check"><svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="12px" height="14px" viewBox="0 0 12 13" xml:space="preserve"><path fill="#4DB6AC" d="M0.211,6.663C0.119,6.571,0.074,6.435,0.074,6.343c0-0.091,0.045-0.229,0.137-0.32l0.64-0.64 c0.184-0.183,0.458-0.183,0.64,0L1.538,5.43l2.515,2.697c0.092,0.094,0.229,0.094,0.321,0l6.13-6.358l0.032-0.026l0.039-0.037 c0.186-0.183,0.432-0.12,0.613,0.063l0.64,0.642c0.183,0.184,0.183,0.457,0,0.64l0,0l-7.317,7.592 c-0.093,0.092-0.184,0.139-0.321,0.139s-0.228-0.047-0.319-0.139L0.302,6.8L0.211,6.663z"/></svg></em>'+
										'</label>';
									
						new_op 	+= '<em></em></div>';
										
						wrp.append(new_op);
						
					});
					
					return wrp;
					
EOF
			),*/

			'options' => array(
				'title' => $magic->lang('Options'),
				'values' => $this->build_form($this->form_options(array(
					"multiple" => true,
					"extend" => array(
						"content" => '<input type="checkbox" data-op-name="is_multiple" \'+(data.multiple ? "checked" : "")+\' id="multiple-\'+random_id+\'" /> \
					<label for="multiple-\'+random_id+\'">'.$magic->lang('Allow select multiple options').'</label>',
						"return" => 'values.multiple = wrp.find(\'input[data-op-name="is_multiple"]\').prop(\'checked\');'
					)
				))),
				'render' => $this->render_options()
			),
			
			'quantity' => array(
				'title' => $magic->lang('Quantity'),
				'unique' => true,
				'values' => $this->quantity_options(),
				'render' => $this->render_quantity()
			)
			
		);
	}
	
	public function build_form($ops = array()) {
		
		global $magic;
		
		/*array(
			"id" => __,
			"cols" => array(
				"10" => array(
					"id" => '',
					"label" => '',
					"content" => ''
				),
			),
			"btns" => array(
				"add" => '',
				"clear" => ''
			),
			"extend" => array(
				"content" => "",
				"return" => "",
				"trigger" => ""
			)
		)*/
		
		if (!is_array($ops))
			$ops = array();
			
		if (!isset($ops['id']))
			$ops['id'] = $magic->generate_id();
		
		if (!isset($ops['cols']))
			$ops['cols'] = array();
		
		if (!isset($ops['return']))
			$ops['return'] = '';
		
		if (!isset($ops['extend'])) {
			$ops['extend'] = array(
				"content" => "",
				"return" => "",
				"trigger" => ""
			);
		}
		
		if (!isset($ops['btns'])) {
			$ops['btns'] = array(
				"add" => $magic->lang('Add option'),
				"clear" => $magic->lang('Clear options')
			);
		}
		
		$thead = '';
		$tbody = '';
		$returns = '';
		
		$_content = (isset($ops['extend']['content']) ? $ops['extend']['content'] : '');
		$_return = (isset($ops['extend']['return']) ? $ops['extend']['return'] : '');
		$_trigger = (isset($ops['extend']['trigger']) ? $ops['extend']['trigger'] : '');
		$_add = (isset($ops['extend']['add']) ? $ops['extend']['add'] : $magic->lang('Add option'));
		$_clear = (isset($ops['extend']['clear']) ? $ops['extend']['clear'] : $magic->lang('Clear options'));
		
		foreach ($ops['cols'] as $col) {
			$thead .= '<th width="'.$col['width'].'">'.$col['title'].'</th>';
			$tbody .= '<td width="'.$col['width'].'">'.$col['content'].'</td>';
			if (isset($col['id']) && !empty($col['id']) && isset($col['return']) && !empty($col['return']))
				$returns .= $col['id'].':'.$col['return'].',';
		}
		
		return <<<EOF
			
			var data = {}, random_id = new Date().getTime().toString(36);	
				
			try {	
				if (typeof values === 'string')
					data = JSON.parse(values);
				else if (values !== null)
					data = values;
			} catch (ex) {data = {};};
			
			var content = '<div class="magic-field-options-wrp rbd">\
						{$_content}\
						<table class="magic-field-options rtc">\
							<thead>{$thead}</thead>\
							<tbody>';
						
			if (values !== '' && data !== null && data.options !== undefined && data.options.length > 0) {
				
				data.options.map(function(option) {
					content += '<tr>{$tbody}</tr>';
				});
			}
			
			content += '</tbody>\
					<tfoot>\
						<tr>\
							<td colspan="5" style="text-align:center;">\
								<button class="magic-button magic-button-primary" data-func="add-option">\
									<i class="fa fa-plus"></i> {$_add}\
								</button> &nbsp; \
								<button class="magic-button" data-func="clear-options">\
									<i class="fa fa-eraser"></i> {$_clear}\
								</button>\
							</td>\
						</tr>\
					</tfoot>\
				</table>';
			
			content += '<textarea data-name="values" class="hidden">'+(values !== undefined && data !== null ? JSON.stringify(data).replace(/\<\/textarea\>/g, '&#x3C;/textarea&#x3E;') : '')+'</textarea></div>';
					
			wrp.html(content);
			
			wrp.export_value = function() {
				var values = {
					options: []
				};
				wrp.find('tbody tr').each(function() {
					
					var option = {
						{$returns}
					};
					
					if (
						(option.value === undefined || option.value === '') &&
						option.title !== undefined
					) {
						// option.value = magic.slugify(option.title); old code, not support non ascii value
						option.value = encodeURIComponent(option.title);
					}
					
					{$_return}
					
					values.options.push(option);
					
				});
				wrp.find('textarea[data-name="values"]').val(JSON.stringify(values)).trigger('change');
			};
			
			wrp.find('[data-op-name]').on('change', wrp.export_value);
			
			if (typeof wrp.sortable == 'function') {
				wrp.find('table tbody').sortable({update: wrp.export_value});
			};
			
			var add_option = function(option) {
					
				var row = $('<tr>{$tbody}</tr>');
				
				wrp.find('table.magic-field-options tbody').append(row);
				row.find('input').on('change', wrp.export_value);
					
				wrp.export_value();
				
			};
			
			trigger({
				el: wrp,
				events: {
					'button[data-func="add-option"]': 'add_option',
					'button[data-func="clear-options"]': 'clear_options',
					'table.magic-field-options tbody': 'func',
					'input[data-op-name="is_multiple"]': 'is_multiple'
				},
				add_option: function(e) {
					
					add_option({value: '', title: '', price: '', min_qty: '', max_qty: ''});
					
					e.preventDefault();	
				},
				clear_options: function(e) {
					$(this).closest('table').find('tbody tr').remove();
					wrp.export_value();
					e.preventDefault();	
				},
				func: function(e) {
					if (
						e.target.getAttribute('data-func') == 'delete' ||
						e.target.getAttribute('data-color') == 'delete'
					) {
						$(e.target).closest('tr').remove();
						wrp.export_value();
						e.preventDefault();	
					}	
				},
				is_multiple: function(e) {
					data.multiple = $(this).prop('checked');
					wrp.find('input[data-op-name="default"]').attr({type: data.multiple ? 'checkbox' : 'radio'});
				}
			});
			
			{$_trigger}
					
EOF;
	}
	
	public function form_options($ops = array()) {
		
		global $magic;
		
		$args = array(
			'cols' => array(
				array(
					'width' => '60%',
					'id' => 'title',
					'title' => $magic->lang('Title').'\
								<span class="tip">\
									<i class="fa fa-question-circle"></i>\
									<span>\
									'.$magic->lang('The title of this option, it will display for select').'\
									</span>\
								</span>',
					'content' => '<input type="text" data-op-name="title" value="\'+magic.esc(option.title)+\'" />',
					'return' => '$(this).find(\'input[data-op-name="title"]\').val()'
				),
				array(
					'width' => '20%',
					'id' => 'price',
					'title' => $magic->lang('Price').'\
								<span class="tip">\
									<i class="fa fa-question-circle"></i>\
									<span>\
									'.$magic->lang('The custom price + or - to the total when select this option').'\
									</span>\
								</span>',
					'content' => '<input type="text" data-op-name="price" value="\'+magic.esc(option.price)+\'" />',
					'return' => '$(this).find(\'input[data-op-name="price"]\').val()'
				),
				array(
					'width' => '10%',
					'id' => 'default',
					'title' => $magic->lang('Default'),
					'content' => '<center><input type="'.(isset($ops['multiple']) && $ops['multiple'] === true ? '\'+(data.multiple ? \'checkbox\' : \'radio\')+\'' : 'radio').'" name="\'+random_id+\'" data-op-name="default" \'+(option.default ? \'checked\' : \'\')+\' /></center>',
					'return' => '$(this).find(\'input[data-op-name="default"]\').prop(\'checked\')'
				),
				array(
					'width' => '10%',
					'id' => '',
					'title' => '',
					'content' => '<i class="fa fa-times" data-func="delete"></i>'
				)
			)
		);
		
		if (isset($ops['extend']))
			$args['extend'] = $ops['extend'];
		
		return $args;
		
	}
	
	public function render_select() {
		
		global $magic;
		
		return <<<EOF
				
			var el = '<select name="'+(data.id)+'" class="magic-cart-param" '+(data.required ? 'required' : '')+'>';
			
			if (typeof data.values == 'object' && typeof data.values.options == 'object') {
				data.values.options.map(function (op){
					var new_title = op.title.replace(/-/g, " ");
					//new_title = new_title.replace(/[^a-zA-Z0-9 ]+/g, "");
					el += '<option value="'+op.value.replace(/\"/g, '&quot;')+'"'+(data.value == op.value ? ' selected' : '')+'>'+new_title+(op.price !== '' ? ' ('+magic.fn.price(op.price)+')' : '')+'</option>';
				});
			};
			
			el += '</select>';
			
			return $(el);				
EOF;

	}
	
	public function render_color() {
		
		global $magic;
		
		return <<<EOF
				
			var el = $('<ul class="magic-product-color"></ul>'), 
				valid_value = false;
				
			el.append('<li data-color="" data-tip="true"><span>{$magic->lang('Clear selected')}</span></li>');
			if (typeof data.values == 'object' && typeof data.values.options == 'object') {
				data.values.options.map(function(v) {
					if (v.value !== '') {
						el.append('<li data-color="'+v.value+'" style="background-color:'+v.value+'" data-tip="true"><span>'+v.title.replace(/\"/g, '&quot;')+(v.price !== '' ? (' ('+(parseFloat(v.price) > 0 ? '+' : '')+magic.fn.price(v.price)+')') : '')+'</span></li>');
						if (data.value === v.value) 
							valid_value = true;
					}
				});
			};
			
			el.append('<input type="hidden" name="'+data.id+'" class="color magic-cart-param" value="'+(valid_value ? data.value : '')+'" '+(data.required ? 'required' : '')+' />');
			
			el.find('li[data-color]').on('click', function(e) {
				$(this).parent().find('li.choosed').removeClass('choosed');
				$(this).addClass('choosed')
					   .closest('.magic_form_content')
					   .find('input.magic-cart-param')
					   .val(this.getAttribute('data-color'))
					   .trigger('change');
				setTimeout(magic.fn.product_color, 1, this.getAttribute('data-color'));
				e.preventDefault();
			});
			
			if (valid_value && data.value !== undefined && data.value !== '')
				el.find('li[data-color="'+data.value+'"]').trigger('click');
			
			return el;
						
EOF;

	}
	
	public function render_picker() {
		
		global $magic;
		
		return <<<EOF
		
			var el = $('<ul class="magic-product-color"></ul>'), valid_value = false;
			
			el.append('<li data-color="" data-tip="true"><span>{$magic->lang('Clear color')}</span></li>');
			if (typeof data.values == 'object' && typeof data.values.options == 'object') {
				data.values.options.map(function(v) {
					if (v.value !== '') {
						el.append('<li data-color="'+v.value+'" style="background-color:'+v.value+'" data-tip="true"><span>'+v.title.replace(/\"/g, '&quot;')+(v.price !== '' ? (' ('+(parseFloat(v.price) > 0 ? '+' : '')+magic.fn.price(v.price)+')') : '')+'</span></li>');
						if (data.value === v.value)
							valid_value = true;
					}
				});
			};
			el.append('<input type="hidden" name="'+data.id+'" class="magic-cart-param" value="'+(valid_value ? data.value : '')+'" '+(data.required ? 'required' : '')+' />');
			
			el.find('li[data-color]').on('click', function(e) {
				
				var val = [],
					_this = $(this),
					items = $(this).parent().find('li[data-color]');
				
				if (_this.attr('data-color') === '') {
					items.removeClass('choosed');
				} else if (typeof data.values == 'object' && data.values.multiple === true) {
					if (_this.hasClass('choosed'))
						_this.removeClass('choosed');
					else
						_this.addClass('choosed');
				} else {
					items.removeClass('choosed');
					_this.addClass('choosed');
				};
				
				items.each(function() {
					if ($(this).hasClass('choosed'))
						val.push(this.getAttribute('data-color'));	
				});
				
				_this.closest('.magic_form_content')
					   .find('input.magic-cart-param')
					   .val(val.join(decodeURI("%0A")))
					   .trigger('change');
					   
				e.preventDefault();
				
			});
			
			if (valid_value && data.value !== undefined && data.value !== '') {
				data.value.split(decodeURI("%0A")).map(function(v) {
					if (v !== '')
						el.find('li[data-color="'+v+'"]').trigger('click');
				});
			};
			
			return el;
						
EOF;

	}	
	
	public function render_options() {
		
		global $magic;
		
		return <<<EOF
			
			var wrp = $('<div class="'+(data.multiple === true ? 'magic_checkboxes' : 'magic_radios')+'"></div>');
			
			if (!data.value)
				data.value = [];
			else if (typeof data.value == 'string')
				data.value = data.value.split(decodeURI("%0A")); /*.split(',');*/
				
			if (typeof data.values == 'object' && typeof data.values.options == 'object') {
				data.values.options.map(function (op){
					
					var tip = '';
					if (op.price !== '') {
						tip = ' &nbsp; <span data-tip="true" style="line-height: 28px;"><i class="magicx-android-alert"></i><span style="text-align:left">{$magic->lang('Price/quantity')}: '+(parseFloat(op.price) > 0 ? '+' : '' )+magic.fn.price(op.price)+'</span></span>';
					}
					
					if (data.values.multiple === true) {
						
						var new_op 	= '<div class="magic_checkbox">';
						
						new_op 	+= '<input type="checkbox" name="'+data.id+'" class="magic-cart-param action_check" value="'+op.value+'" id="'+(data.id + '-' +op.value)+'" '+(data.required ? 'required' : '')+' '+(data.value.indexOf(op.value) > -1 ? 'checked' : '')+' />';
						new_op 	+= '<label for="'+(data.id + '-' +op.value)+'" class="magic-cart-option-label">'+
										op.title.replace(/\</g, '&lt;').replace(/\>/g, '&gt;')+
										'<em class="check"><svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="12px" height="14px" viewBox="0 0 12 13" xml:space="preserve"><path fill="#4DB6AC" d="M0.211,6.663C0.119,6.571,0.074,6.435,0.074,6.343c0-0.091,0.045-0.229,0.137-0.32l0.64-0.64 c0.184-0.183,0.458-0.183,0.64,0L1.538,5.43l2.515,2.697c0.092,0.094,0.229,0.094,0.321,0l6.13-6.358l0.032-0.026l0.039-0.037 c0.186-0.183,0.432-0.12,0.613,0.063l0.64,0.642c0.183,0.184,0.183,0.457,0,0.64l0,0l-7.317,7.592 c-0.093,0.092-0.184,0.139-0.321,0.139s-0.228-0.047-0.319-0.139L0.302,6.8L0.211,6.663z"/></svg></em>'+
										'</label>'+tip;
									
						new_op 	+= '<em></em></div>';
						
					} else {
						
						var new_op 	= $('<div class="magic-radio">'+
								'<input type="radio" class="magic-cart-param" name="'+data.id+'" value="'+op.value+'" id="'+data.id+'-'+op.value+'"'+(data.value.indexOf(op.value) > -1 ? ' checked' : '')+(data.required ? ' required' : '')+' />'+
			                	'<label class="magic-cart-option-label" for="'+data.id+'-'+op.value+'">'+op.title+' <em class="check"></em></label>'+tip+
								'<em class="magic-cart-option-desc"></em>'+
							'</div>');
							
					};
					
					wrp.append(new_op);
					
				});
			}	
			return wrp;
								
EOF;

	}
	
	public function render_quantity() {
		
		global $magic;
		
		return <<<EOF
			
			if (typeof data.values != 'object')
				data.values = {type: 'standard', min_qty: '', max_qty: ''};
			
			if (data.values.type == 'package' && data.values.package_options !== undefined) {
				
				var el = '<select '+(data.required ? 'required' : '')+' name="'+data.id+'" class="magic-cart-param" required>';
				
				data.values.package_options.map(function (op){
					el += '<option value="'+encodeURI(op.value)+'"'+(data.value == op.value ? ' selected' : '')+'>'+op.title+'</option>';
				});
				
				el += '</select>';
				
				return $(el);		
			}
			
			var minmax = [];
			
			if (data.values.min_qty !== undefined && data.values.min_qty !== '')
				minmax.push('{$magic->lang('Min total')}: '+data.values.min_qty);
			if (data.values.max_qty !== undefined && data.values.max_qty !== '')
				minmax.push('{$magic->lang('Max total')}: '+data.values.max_qty);
			
			if (data.values.type == 'multiple' && data.values.multiple_options !== undefined) {
				
				if (data.value === undefined || data.value === '') {
					data.value = {};
					data.value[data.values.multiple_options[0].value] = 1;
				} else if (typeof data.value == 'string') {
						data.value = JSON.parse(data.value);
					try {
					} catch (ex) {data.value = {};}		
				};
				
				var el = '<div class="magic-cart-field-quantity">', val, tip;
		
				data.values.multiple_options.map(function (op, i){
					
					val = (
						typeof data.value == 'object' && data.value[op.value] !== undefined ? 
						data.value[op.value].toString().replace(/[^0-9\.]/g, '') : 
						0
					);
					
					tip = [];
					
					if (op.min_qty !== '' && parseInt(op.min_qty) > val) {
						val = parseInt(op.min_qty);
					};
					
					if (op.max_qty !== '' && parseInt(op.max_qty) < val) {
						val = parseInt(op.max_qty);
					};
					
					if (op.min_qty !== '')
						tip.push('{$magic->lang('Min quantity')}: '+op.min_qty);
					if (op.max_qty !== '')
						tip.push('{$magic->lang('Max quantity')}: '+op.max_qty);
					if (op.price !== '')
						tip.push('{$magic->lang('Price/quantity')}: '+(parseFloat(op.price) > 0 ? '+' : '' )+magic.fn.price(op.price));
					
					el += '<p>\
							<em>\
								<input type="number" data-min="'+op.min_qty+'" data-max="'+op.max_qty+'" data-id="'+op.value+'" value="'+val+'" />\
							</em>\
							<strong>'+op.title+'</strong>\
							'+(tip.length > 0 ? '<span data-tip="true" style="line-height: 34px;"><i class="magicx-android-alert"></i><span style="text-align:left">'+tip.join('<br>')+'</span></span>' : '')+'\
						</p>'
				});
				
				if (minmax.length > 0)
					el += '<p data-notice>'+minmax.join(', ')+'</p>';
					
				el += '<input type="hidden" '+(data.required ? 'required' : '')+' data-format="json" data-min="'+data.values.min_qty+'" data-max="'+data.values.max_qty+'" class="magic-cart-param" name="'+data.id+'" value="'+data.value+'"/>\
					</div>';
				
				var new_op = $(el);
				
				var return_values = function () {
				
					var inp = new_op.find('input.magic-cart-param'),
						min = parseInt(inp.attr('data-min')),
						max = parseInt(inp.attr('data-max')),
						val = {}, 
						qty = 0;
						
					new_op.find('input[data-id]').each(function() {
						
						this.value = this.value !== '' && parseInt(this.value) > 0 ? parseInt(this.value) : 0;
						
						if (
							this.getAttribute('data-min') !== '' && 
							parseInt(this.getAttribute('data-min')) > parseInt(this.value)
						) this.value = this.getAttribute('data-min');
						
						if (
							this.getAttribute('data-max') !== '' && 
							parseInt(this.getAttribute('data-max')) < parseInt(this.value)
						) this.value = this.getAttribute('data-max');
						
						qty += parseInt(this.value);
						
						val[this.getAttribute('data-id')] = this.value;
						
					});
					
					if (!isNaN(min) && min > qty) {
						inp.val('').change();
						inp.after('<em class="magic-required-msg">{$magic->lang('Error: Invalid min total quantity')}</em>');
						return;
					};
					
					if (!isNaN(max) && max < qty) {
						inp.val('').change();
						inp.after('<em class="magic-required-msg">{$magic->lang('Error: Invalid max total quantity')}</em>');
						return;
					};
					
					inp.val(JSON.stringify(val)).change();
						
				};
				
				new_op.find('input[data-id]').on('change', return_values).on('focus', function() {
					$(this).select();
				});
				
				return_values();
				
				return new_op;
			
			};
			
			if (data.value === undefined || isNaN(parseInt(data.value)) )
				data.value = 1;
			else data.value = parseInt(data.value);
			
			var new_op = $('<div class="magic-cart-field-quantity">\
						<em data-action="minus"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" viewBox="0 0 491.858 491.858" xml:space="preserve" width="10px" height="10px"><path d="M465.167,211.613H240.21H26.69c-8.424,0-26.69,11.439-26.69,34.316s18.267,34.316,26.69,34.316h213.52h224.959    c8.421,0,26.689-11.439,26.689-34.316S473.59,211.613,465.167,211.613z" fill="#888"/></svg></em>\
						<em class="magic-cart-field-value" data-tip="true">\
							<input type="number" '+(data.required ? 'required' : '')+' data-min="'+data.values.min_qty+'" data-max="'+data.values.max_qty+'" class="magic-cart-param" name="'+data.id+'" value="'+(data.value !== '' ? data.value : 1)+'"/>\
							'+(minmax.length > 0 ? '<span>'+minmax.join(', ')+'</span>' : '')+'\
						</em>\
						<em data-action="plus"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http d://www.w3.org/1999/xlink" version="1.1" viewBox="0 0 491.86 491.86" xml:space="preserve" width="10px" height="10px"><path d="M465.167,211.614H280.245V26.691c0-8.424-11.439-26.69-34.316-26.69s-34.316,18.267-34.316,26.69v184.924H26.69    C18.267,211.614,0,223.053,0,245.929s18.267,34.316,26.69,34.316h184.924v184.924c0,8.422,11.438,26.69,34.316,26.69    s34.316-18.268,34.316-26.69V280.245H465.17c8.422,0,26.69-11.438,26.69-34.316S473.59,211.614,465.167,211.614z" fill="#888"/></svg></em>\
					</div>');
				
				new_op.find('input.magic-cart-param').on('blur', function (e){
						
					var val = parseInt(this.value),
						min = parseInt(this.getAttribute('data-min')),
						max = parseInt(this.getAttribute('data-max'));
					
					if (isNaN(val) || val === '' || val < 1)
						val = 1;
					
					if ( !isNaN(min) && min > val ) 
						val = min;
						
					if ( !isNaN(max) && max < val ) 
						val = max;
					
					$(this).val(val).trigger('change');
					
				}).trigger('blur');
				
				new_op.find('em[data-action]').on('click', function (){
					
					var action = $(this).data('action'),
						wrp = $(this).closest('.magic-cart-field-quantity'),
						inp = wrp.find('input.magic-cart-param'),
						min = parseInt(inp.attr('data-min')),
						max = parseInt(inp.attr('data-max'));
						val = parseInt(inp.val());

					switch (action) {
						case 'minus':
							val--;
							break;

						default:
							val++;
					}
					
					if (val < 1)
						val = 1;
					
					if ( !isNaN(min) && min > val ) 
						val = min;
						
					if ( !isNaN(max) && max < val ) 
						val = max;
						
					inp.val(val).trigger('change');
					
				});
			
			return new_op;
					
EOF;

	}
	
	public function color_options() {
		
		global $magic;
		
		return array(
			'cols' => array(
				array(
					'width' => '50%',
					'id' => 'title',
					'title' => $magic->lang('Color Title').'\
								<span class="tip">\
									<i class="fa fa-question-circle"></i>\
									<span>\
									'.$magic->lang('The title of color, it will display instead of hex code').'\
									</span>\
								</span>',
					'content' => '<input type="text" data-op-name="title" value="\'+magic.esc(option.title)+\'" />',
					'return' => '$(this).find(\'input[data-op-name="title"]\').val()'
				),
				array(
					'width' => '20%',
					'id' => 'value',
					'title' => $magic->lang('Color Value').'\
								<span class="tip">\
									<i class="fa fa-question-circle"></i>\
									<span>\
									'.$magic->lang('The color value, hex code or name of color').'\
									</span>\
								</span>',
					'content' => '<input type="text" readonly style="background:\'+magic.esc(option.value)+\';border:none;text-align:center;border-radius: 2px;color: \'+magic.invert_color(option.value)+\'" type="text" data-op-name="value" value="\'+magic.esc(option.value)+\'"/>',
					'return' => '$(this).find(\'input[data-op-name="value"]\').val()'
				),
				array(
					'width' => '20%',
					'id' => 'price',
					'title' => $magic->lang('Price').'\
								<span class="tip">\
									<i class="fa fa-question-circle"></i>\
									<span>\
									'.$magic->lang('The custom price + or - to the total when select this color').'\
									</span>\
								</span>',
					'content' => '<input type="text" data-op-name="price" value="\'+magic.esc(option.price)+\'" />',
					'return' => '$(this).find(\'input[data-op-name="price"]\').val()'
				),
				array(
					'width' => '5%',
					'id' => 'default',
					'title' => $magic->lang('Default'),
					'content' => '<center><input type="\'+(data.multiple ? \'checkbox\' : \'radio\')+\'" name="\'+random_id+\'" data-op-name="default" \'+(option.default ? \'checked\' : \'\')+\' /></center>',
					'return' => '$(this).find(\'input[data-op-name="default"]\').prop(\'checked\')'
				),
				array(
					'width' => '5%',
					'id' => '',
					'title' => '',
					'content' => '<i class="fa fa-times" data-func="delete"></i>'
				)
			),
			'extend' => array(
				'add' => $magic->lang('Add new color'),
				'clear' => $magic->lang('Clear all colors'),
				'trigger' => <<<EOF
					
					wrp.find('button[data-func="add-option"]').off('click').on('click', function(e) {
						
						e.data = triggerObjects.general_events;
						e.data.ex_return_colors = function(cw) {
							$('#magic-list-colors-body ul.colors-ul li[data-color]').each(function(){
								var color = this.getAttribute('data-color');
								if (
									$(this).find('input[type="checkbox"]').prop('checked') &&
									wrp.find('input[data-op-name="value"][value="'+color+'"]').length === 0
								) {
									add_option({
										value: color, 
										title: $(this).find('>span').text(), 
										price: ''
									});
								}
							});
								
							wrp.export_value();
							
						};
						
						triggerObjects.general_events.create_color(e);
						
						e.preventDefault();	
							
					});
EOF
			)
		);
		
	}
	
	public function quantity_options() {
		
		global $magic;
		
		return <<<EOF
				
			try {	
				if (typeof values === 'string')
					values = JSON.parse(values);
				else if (typeof values != 'object' || values === null)
					values = {};
			} catch (ex) { values = {}; };
			
			if (['standard', 'multiple', 'package'].indexOf(values.type) === -1)
				values.type = 'standard';
			
			if (values.multiple_options === undefined)
				values.multiple_options = [{title: 'S', price: '', min_qty: '', max_qty: ''}, {title: 'M', price: '', min_qty: '', max_qty: ''}, {title: 'XL', price: '', min_qty: '', max_qty: ''}];
			
			if (values.package_options === undefined)
				values.package_options = [{title: 'Package 1', value: '10', price: ''}, {title: 'Package 2', value: '50', price: '-1'}];
			
			var content = '<div class="magic-field-options-wrp rbd">\
					<p class="quantity-layout">\
						<label>{$magic->lang('Layout')}: </label>\
						<select data-name="layout">\
							<option value="standard">{$magic->lang('Standard')}</option>\
							<option '+(values.type == 'multiple' ? 'selected' : '')+' value="multiple">{$magic->lang('Multiple')}</option>\
							<option '+(values.type == 'package' ? 'selected' : '')+' value="package">{$magic->lang('Package')}</option>\
						</select>\
						<label>{$magic->lang('Min Quantity')}: </label>\
						<input type="text" data-name="min-qty" value="'+magic.esc(values.min_qty)+'" />\
						<label>{$magic->lang('Max Quantity')}: </label>\
						<input type="text" data-name="max-qty" value="'+magic.esc(values.max_qty)+'" />\
					</p>';
						
				content += '<table class="magic-field-options rtc multiple_options '+(values.type != 'multiple' ? 'hidden' : '')+'">\
					<thead>\
						<th width="30%">{$magic->lang('Title')}</th>\
						<th width="20%"> \
							{$magic->lang('Price')}\
							<span class="tip">\
								<i class="fa fa-question-circle"></i>\
								<span>\
								{$magic->lang('The custom price + or - for each quantity')}\
								</span>\
							</span>\
						</th>\
						<th width="20%"> \
							{$magic->lang('Min Qty')}\
						</th>\
						<th width="20%"> \
							{$magic->lang('Max Qty')}\
						</th>\
						<th width="10%"></th>\
					</thead>\
					<tbody>';
					
				if (typeof values == 'object' && values.multiple_options !== undefined && values.multiple_options.length > 0) {
					
					values.multiple_options.map(function(item) {
						content += '<tr>\
								<td width="30%"><input type="text" data-name="title" value="'+magic.esc(item.title)+'" /></td>\
								<td width="20%"><input type="text" data-name="price" value="'+magic.esc(item.price)+'" /></td>\
								<td width="20%"><input type="text" data-name="min-qty" value="'+magic.esc(item.min_qty)+'" /></td>\
								<td width="20%"><input type="text" data-name="max-qty" value="'+magic.esc(item.max_qty)+'" /></td>\
								<td width="10%"><i class="fa fa-times" data-func="delete"></i></td>\
							</tr>';
					});
				}
				
				content += '</tbody>\
						<tfoot>\
							<tr>\
								<td colspan="5" style="text-align:center;">\
									<button class="magic-button magic-button-primary" data-func="add-multiple">\
										<i class="fa fa-plus"></i> {$magic->lang('Add new quantity')}\
									</button> &nbsp; \
									<button class="magic-button" data-func="clear-options">\
										<i class="fa fa-eraser"></i> {$magic->lang('Clear all quantity')}\
									</button>\
								</td>\
							</tr>\
						</tfoot>\
					</table>';
					
				
				
				
				content += '<table class="magic-field-options rtc package_options '+(values.type != 'package' ? 'hidden' : '')+'">\
					<thead>\
						<th width="40%">{$magic->lang('Package Title')}</th>\
						<th width="20%">{$magic->lang('Quantity')}</th>\
						<th width="20%"> \
							{$magic->lang('Price')}\
							<span class="tip">\
								<i class="fa fa-question-circle"></i>\
								<span>\
								{$magic->lang('The custom price + or - for each quantity')}\
								</span>\
							</span>\
						</th>\
						<th width="10%"></th>\
					</thead>\
					<tbody>';
						
				if (typeof values == 'object' && values.package_options !== undefined && values.package_options.length > 0) {
					
					values.package_options.map(function(item) {
						content += '<tr>\
								<td width="50%"><input type="text" data-name="title" value="'+magic.esc(item.title)+'" /></td>\
								<td width="20%"><input type="text" data-name="value" value="'+magic.esc(item.value)+'" /></td>\
								<td width="20%"><input type="text" data-name="price" value="'+magic.esc(item.price)+'" /></td>\
								<td width="10%"><i class="fa fa-times" data-func="delete"></i></td>\
							</tr>';
					});
				}
				
				content += '</tbody>\
						<tfoot>\
							<tr>\
								<td colspan="4" style="text-align:center;">\
									<button class="magic-button magic-button-primary" data-func="add-package">\
										<i class="fa fa-plus"></i> {$magic->lang('Add new package')}\
									</button> &nbsp; \
									<button class="magic-button" data-func="clear-options">\
										<i class="fa fa-eraser"></i> {$magic->lang('Clear all packages')}\
									</button>\
								</td>\
							</tr>\
						</tfoot>\
					</table>';
			
			
			content += '<textarea data-name="values" class="hidden">'+(values !== undefined && values !== null ? JSON.stringify(values).replace(/\<\/textarea\>/g, '&#x3C;/textarea&#x3E;') : '')+'</textarea></div>';
					
			wrp.html(content);
			
			wrp.export_value = function() {
				var values = {
					type: wrp.find('select[data-name="layout"]').val(),
					min_qty: wrp.find('input[data-name="min-qty"]').val(),
					max_qty: wrp.find('input[data-name="max-qty"]').val(),
					multiple_options: [],
					package_options: []
				};
				wrp.find('table.magic-field-options.multiple_options tbody tr').each(function() {
					if ($(this).find('input[data-name="title"]').val() !== '') {
						values.multiple_options.push({
							value: magic.slugify($(this).find('input[data-name="title"]').val()),	
							title: $(this).find('input[data-name="title"]').val(),	
							price: $(this).find('input[data-name="price"]').val(),
							min_qty: $(this).find('input[data-name="min-qty"]').val(),
							max_qty: $(this).find('input[data-name="max-qty"]').val()
						});
					}
				});
				wrp.find('table.magic-field-options.package_options tbody tr').each(function() {
					if ($(this).find('input[data-name="title"]').val() !== '') {
						values.package_options.push({
							value: $(this).find('input[data-name="value"]').val(),
							title: $(this).find('input[data-name="title"]').val(),	
							price: $(this).find('input[data-name="price"]').val()
						});
					}
				});
				
				wrp.find('textarea[data-name="values"]').val(JSON.stringify(values)).trigger('change');
				
			};
			
			wrp.find('tbody input').on('change', wrp.export_value);
			
			if (typeof wrp.sortable == 'function') {
				wrp.find('table tbody').sortable({update: wrp.export_value});
			};
			
			trigger({
				
				el: wrp,
				
				events: {
					'select[data-name="layout"]:change': 'layout',
					'input[data-name="min-qty"]:change,input[data-name="max-qty"]:change': 'qty',
					'button[data-func="add-multiple"]': 'add_multiple',
					'button[data-func="add-package"]': 'add_package',
					'button[data-func="clear-options"]': 'clear_options',
					'table.magic-field-options tbody': 'func'
				},
				
				layout: function(e) {
					
					wrp.find('table.magic-field-options').addClass('hidden');
					
					if (this.value == 'multiple') {
						wrp.find('table.magic-field-options.multiple_options').removeClass('hidden');
					} else if (this.value == 'package') {
						wrp.find('table.magic-field-options.package_options').removeClass('hidden');
					}
					
					wrp.export_value();
					
					e.preventDefault();	
						
				},	
				
				qty: function(e) {
					
					wrp.export_value();
					
					e.preventDefault();	
					
				},
				
				add_multiple: function(e) {
						
					var row = $('<tr>\
							<td width="30%"><input type="text" data-name="title" value="" /></td>\
							<td width="20%"><input type="text" data-name="price" value="" /></td>\
							<td width="20%"><input type="text" data-name="min-qty" value="" /></td>\
							<td width="20%"><input type="text" data-name="max-qty" value="" /></td>\
							<td width="10%"><i class="fa fa-times" data-func="delete"></i></td>\
						</tr>');
					
					$(this).closest('table').find('tbody').append(row);
					
					row.find('input').on('change', wrp.export_value);
						
					wrp.export_value();
					
					e.preventDefault();	
						
				},
				
				add_package: function(e) {
						
					var row = $('<tr>\
							<td width="50%"><input type="text" data-name="title" value="" /></td>\
							<td width="20%"><input type="text" data-name="value" value="" /></td>\
							<td width="20%"><input type="text" data-name="price" value="" /></td>\
							<td width="10%"><i class="fa fa-times" data-func="delete"></i></td>\
						</tr>');
					
					$(this).closest('table').find('tbody').append(row);
					
					row.find('input').on('change', wrp.export_value);
						
					wrp.export_value();
					
					e.preventDefault();	
						
				},
				
				clear_options: function(e) {
					$(this).closest('table').find('tbody tr').remove();
					wrp.export_value();
					e.preventDefault();	
				},
				
				func: function(e) {
					if (
						e.target.getAttribute('data-func') == 'delete' ||
						e.target.getAttribute('data-color') == 'delete'
					) {
						$(e.target).closest('tr').remove();
						wrp.export_value();
						e.preventDefault();	
					}	
				}
			});
					
EOF;

	}
	
}