<?php

	global $customdesign;
	$section = 'category';
	$type = isset($_GET['type']) ? $_GET['type'] : '';
	
	$fields = $customdesign_admin->process_data(array(
		array(
			'type' => 'input',
			'name' => 'name',
			'label' => $customdesign->lang('Name'),
			'required' => true
		),
		array(
			'type' => 'parent',
			'cate_type' => $type,
			'name' => 'parent',
			'label' => $customdesign->lang('Parent'),
			'id' => isset($_GET['id'])? $_GET['id'] : 0
		),
		array(
			'type' => 'upload',
			'name' => 'upload',
			'path' => 'thumbnails'.DS,
			'thumbn' => 'thumbnail_url',
			'label' => $customdesign->lang('Thumbnail'),
			'desc' => $customdesign->lang('Supported files svg, png, jpg, jpeg. Max size 5MB')
		),
		array(
			'type' => 'input',
			'name' => 'order',
			'type_input' => 'number',
			'label' => $customdesign->lang('Order'),
			'default' => 0,
			'desc' => $customdesign->lang('Ordering of item with other.')
		),
		array(
			'type' => 'toggle',
			'name' => 'active',
			'label' => $customdesign->lang('Active'),
			'default' => 'yes',
			'value' => null
		),
		array(
			'type' => 'input',
			'type_input' => 'hidden',
			'name' => 'type',
			'default' => $type,
		)
	), 'categories');

?>

<div class="customdesign_wrapper">
	<div class="customdesign_content">
		<?php
			$customdesign->views->detail_header(array(
				'add' => $customdesign->lang('Add New Category'),
				'edit' => $fields[0]['value'],
				'page' => $section,
				'pages' => 'categories',
				'type' => $type
			));
		?>
		<form action="<?php echo $customdesign->cfg->admin_url; ?>customdesign-page=<?php
			echo $section.(isset($_GET['callback']) ? '&callback='.$_GET['callback'] : '');
		?>" id="customdesign-clipart-form" method="post" class="customdesign_form" enctype="multipart/form-data">

			<?php $customdesign->views->tabs_render($fields); ?>

			<div class="customdesign_form_group customdesign_form_submit">
				<input type="submit" class="customdesign-button customdesign-button-primary" value="<?php echo $customdesign->lang('Save Category'); ?>"/>
				<input type="hidden" name="do" value="action" />
				<a class="customdesign_cancel" href="<?php echo $customdesign->cfg->admin_url;?>customdesign-page=categories&type=<?php echo $type; ?>">
					<?php echo $customdesign->lang('Cancel'); ?>
				</a>
				<input type="hidden" name="customdesign-section" value="<?php echo $section; ?>">
			</div>
		</form>
	</div>
</div>
