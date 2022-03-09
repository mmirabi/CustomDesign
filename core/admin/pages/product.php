<?php
	
	global $magic;
	
	$arg = array(

		'tabs' => array(

			'details:' . $magic->lang('Details') => array(
				array(
					'type' => 'input',
					'name' => 'name',
					'label' => $magic->lang('Name'),
					'required' => true,
					'default' => 'Untitled'
				),
				(
					$magic->connector->platform == 'php'? 
					array(
						'type' => 'input',
						'name' => 'price',
						'label' => $magic->lang('Price'),
						'default' => '0',
						'desc' => $magic->lang('Enter the base price for this product.')
					) : null
				),
				(
					$magic->connector->platform == 'php' ?
					array(	
						'type' => 'upload',
						'name' => 'thumbnail',
						'thumbn' => 'thumbnail_url',
						'path' => 'thumbnails'.DS,
						'label' => $magic->lang('Product thumbnail'),
						'desc' => $magic->lang('Supported files svg, png, jpg, jpeg. Max size 5MB')
					)
					:
					array(
						'type' => 'input',
						'name' => 'product',
						'label' => $magic->lang('CMS Product'),
						'default' => '0',
						'desc' => $magic->lang('This product will not be listed if this field value is zero. It will set automatically when you select this product base for a Woocommerce Product'),
						'readonly' => true
					)
				)
				,
				array(
					'type' => 'text',
					'name' => 'description',
					'label' => $magic->lang('Description')
				),
				array(
					'type' => 'toggle',
					'name' => 'active_description',
					'label' => $magic->lang('Active description'),
					'default' => 'no',
					'value' => null,
					'desc' => $magic->lang('Show description on editor design.')
				),
				array(
					'type' => 'categories',
					'cate_type' => 'products',
					'name' => 'categories',
					'label' => $magic->lang('Categories'),
					'id' => isset($_GET['id'])? $_GET['id'] : 0
				),
				array(
					'type' => 'printing',
					'name' => 'printings',
					'label' => $magic->lang('Printing Techniques'),
					'desc' => $magic->lang('Select Printing Techniques with price calculations for this product').'<br>'.$magic->lang('Drag to arrange items, the first one will be set as default').'. <br><a href="'.$magic->cfg->admin_url.'magic-page=printings" target=_blank>'.$magic->lang('You can manage all Printings here').'.</a>'
				),
				array(
					'type' => 'toggle',
					'name' => 'active',
					'label' => $magic->lang('Active'),
					'default' => 'yes',
					'value' => null,
					'desc' => $magic->lang('Deactivate does not affect the selected products. It will only not show in the switching products.')
				),
				array(
					'type' => 'input',
					'name' => 'order',
					'type_input' => 'number',
					'label' => $magic->lang('Order'),
					'default' => 0,
					'desc' => $magic->lang('Ordering of item with other.')
				),
			),

			'design:' . $magic->lang('Designs') => array(
				array(
					'type' => 'stages',
					'name' => 'stages'
				)
			),
			
			'variations:' . $magic->lang('Variations') => array(
				array(
					'type' => 'variations',
					'name' => 'variations'
				)
			),

			'attributes:' . $magic->lang('Attributes') => array(
				array(
					'type' => 'attributes',
					'name' => 'attributes'
				),
			)
		)
	);
	
	$fields = $magic_admin->process_data($arg, 'products');
	
?>

<div class="magic_wrapper" id="magic-product-page">
	<div class="magic_content">
		<?php

			$magic->views->detail_header(array(
				'add' => $magic->lang('Add New Product'),
				'edit' => $fields['tabs']['details:' . $magic->lang('Details')][0]['value'],
				'page' => 'product'
			));

		?>
		<form action="<?php
			echo $magic->cfg->admin_url;
		?>magic-page=product<?php
			if (isset($_GET['callback']))
				echo '&callback='.$_GET['callback'];
		?>" id="magic-product-form" method="POST" class="magic_form" enctype="multipart/form-data">

			<?php $magic->views->tabs_render($fields, 'products'); ?>

			<div class="magic_form_group" style="margin-top: 20px">
				<input type="submit" class="magic-button magic-button-primary" value="<?php echo $magic->lang('Save Product'); ?>"/>
				<input type="hidden" name="do" value="action" />
				<input type="hidden" name="magic-section" value="product">
			</div>
		</form>
	</div>
</div>
