<?php

	global $magic;
	$section = 'category';
	$type = isset($_GET['type']) ? $_GET['type'] : '';
	
	$fields = $magic_admin->process_data(array(
		array(
			'type' => 'input',
			'name' => 'name',
			'label' => $magic->lang('Name'),
			'required' => true
		),
		array(
			'type' => 'parent',
			'cate_type' => $type,
			'name' => 'parent',
			'label' => $magic->lang('Parent'),
			'id' => isset($_GET['id'])? $_GET['id'] : 0
		),
		array(
			'type' => 'upload',
			'name' => 'upload',
			'path' => 'thumbnails'.DS,
			'thumbn' => 'thumbnail_url',
			'label' => $magic->lang('Thumbnail'),
			'desc' => $magic->lang('Supported files svg, png, jpg, jpeg. Max size 5MB')
		),
		array(
			'type' => 'input',
			'name' => 'order',
			'type_input' => 'number',
			'label' => $magic->lang('Order'),
			'default' => 0,
			'desc' => $magic->lang('Ordering of item with other.')
		),
		array(
			'type' => 'toggle',
			'name' => 'active',
			'label' => $magic->lang('Active'),
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

<div class="magic_wrapper">
	<div class="magic_content">
		<?php
			$magic->views->detail_header(array(
				'add' => $magic->lang('Add New Category'),
				'edit' => $fields[0]['value'],
				'page' => $section,
				'pages' => 'categories',
				'type' => $type
			));
		?>
		<form action="<?php echo $magic->cfg->admin_url; ?>magic-page=<?php
			echo $section.(isset($_GET['callback']) ? '&callback='.$_GET['callback'] : '');
		?>" id="magic-clipart-form" method="post" class="magic_form" enctype="multipart/form-data">

			<?php $magic->views->tabs_render($fields); ?>

			<div class="magic_form_group magic_form_submit">
				<input type="submit" class="magic-button magic-button-primary" value="<?php echo $magic->lang('Save Category'); ?>"/>
				<input type="hidden" name="do" value="action" />
				<a class="magic_cancel" href="<?php echo $magic->cfg->admin_url;?>magic-page=categories&type=<?php echo $type; ?>">
					<?php echo $magic->lang('Cancel'); ?>
				</a>
				<input type="hidden" name="magic-section" value="<?php echo $section; ?>">
			</div>
		</form>
	</div>
</div>
