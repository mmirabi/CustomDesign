<?php
	
	global $customdesign;
	
	$arg = array(

		'tabs' => array(

			'details:' . $customdesign->lang('Details') => array(
				array(
					'type' => 'input',
					'name' => 'name',
					'label' => $customdesign->lang('Name'),
					'required' => true,
					'default' => 'Untitled'
				),
				(
					$customdesign->connector->platform == 'php'? 
					array(
						'type' => 'input',
						'name' => 'price',
						'label' => $customdesign->lang('Price'),
						'default' => '0',
						'desc' => $customdesign->lang('Enter the base price for this product.')
					) : null
				),
				(
					$customdesign->connector->platform == 'php' ?
					array(	
						'type' => 'upload',
						'name' => 'thumbnail',
						'thumbn' => 'thumbnail_url',
						'path' => 'thumbnails'.DS,
						'label' => $customdesign->lang('Product thumbnail'),
						'desc' => $customdesign->lang('Supported files svg, png, jpg, jpeg. Max size 5MB')
					)
					:
					array(
						'type' => 'input',
						'name' => 'product',
						'label' => $customdesign->lang('CMS Product'),
						'default' => '0',
						'desc' => $customdesign->lang('This product will not be listed if this field value is zero. It will set automatically when you select this product base for a Woocommerce Product'),
						'readonly' => true
					)
				)
				,
				array(
					'type' => 'text',
					'name' => 'description',
					'label' => $customdesign->lang('Description')
				),
				array(
					'type' => 'toggle',
					'name' => 'active_description',
					'label' => $customdesign->lang('Active description'),
					'default' => 'no',
					'value' => null,
					'desc' => $customdesign->lang('Show description on editor design.')
				),
				array(
					'type' => 'categories',
					'cate_type' => 'products',
					'name' => 'categories',
					'label' => $customdesign->lang('Categories'),
					'id' => isset($_GET['id'])? $_GET['id'] : 0
				),
				array(
					'type' => 'printing',
					'name' => 'printings',
					'label' => $customdesign->lang('Printing Techniques'),
					'desc' => $customdesign->lang('Select Printing Techniques with price calculations for this product').'<br>'.$customdesign->lang('Drag to arrange items, the first one will be set as default').'. <br><a href="'.$customdesign->cfg->admin_url.'customdesign-page=printings" target=_blank>'.$customdesign->lang('You can manage all Printings here').'.</a>'
				),
				array(
					'type' => 'toggle',
					'name' => 'active',
					'label' => $customdesign->lang('Active'),
					'default' => 'yes',
					'value' => null,
					'desc' => $customdesign->lang('Deactivate does not affect the selected products. It will only not show in the switching products.')
				),
				array(
					'type' => 'input',
					'name' => 'order',
					'type_input' => 'number',
					'label' => $customdesign->lang('Order'),
					'default' => 0,
					'desc' => $customdesign->lang('Ordering of item with other.')
				),
			),

			'design:' . $customdesign->lang('Designs') => array(
				array(
					'type' => 'stages',
					'name' => 'stages'
				)
			),
			
			'variations:' . $customdesign->lang('Variations') => array(
				array(
					'type' => 'variations',
					'name' => 'variations'
				)
			),

			'attributes:' . $customdesign->lang('Attributes') => array(
				array(
					'type' => 'attributes',
					'name' => 'attributes'
				),
			)
		)
	);
	
	$fields = $customdesign_admin->process_data($arg, 'products');
	
?>

<div class="customdesign_wrapper" id="customdesign-product-page">
	<div class="customdesign_content">
		<?php

			$customdesign->views->detail_header(array(
				'add' => $customdesign->lang('Add New Product'),
				'edit' => $fields['tabs']['details:' . $customdesign->lang('Details')][0]['value'],
				'page' => 'product'
			));

		?>
		<form action="<?php
			echo $customdesign->cfg->admin_url;
		?>customdesign-page=product<?php
			if (isset($_GET['callback']))
				echo '&callback='.$_GET['callback'];
		?>" id="customdesign-product-form" method="POST" class="customdesign_form" enctype="multipart/form-data">

			<?php $customdesign->views->tabs_render($fields, 'products'); ?>

			<div class="customdesign_form_group" style="margin-top: 20px">
				<input type="submit" class="customdesign-button customdesign-button-primary" value="<?php echo $customdesign->lang('Save Product'); ?>"/>
				<input type="hidden" name="do" value="action" />
				<input type="hidden" name="customdesign-section" value="product">
			</div>
		</form>
	</div>
</div>
