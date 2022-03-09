<?php
	global $magic;

	$section = 'clipart';
	$fields = $magic_admin->process_data(array(
		array(
			'type' => 'input',
			'name' => 'name',
			'label' => $magic->lang('Name'),
			'required' => true,
			'default' => 'Untitled'
		),
		array(
			'type' => 'categories',
			'cate_type' => 'cliparts',
			'name' => 'categories',
			'label' => $magic->lang('Categories'),
			'id' => isset($_GET['id'])? $_GET['id'] : 0,
			'db' => false
		),
		array(
			'type' => 'tags',
			'tag_type' => 'cliparts',
			'name' => 'tags',
			'label' => $magic->lang('Tags'),
			'id' => isset($_GET['id'])? $_GET['id'] : 0,
			'desc' => $magic->lang('Example: tag1, tag2, tag3 ...'),
		),
		array(
			'type' => 'upload',
			'name' => 'upload',
			'path' => 'cliparts'.DS.date('Y').DS.date('m').DS,
			'thumbn' => 'thumbnail_url',
			'label' => $magic->lang('Upload design file'),
			'desc' => $magic->lang('Supported files svg, png, jpg, jpeg. Max size 5MB')
		),
		array(
			'type' => 'input',
			'name' => 'price',
			'label' => $magic->lang('Price'),
			'default' => 0
		),
		array(
			'type' => 'toggle',
			'name' => 'featured',
			'label' => $magic->lang('Featured'),
			'default' => 'no',
			'value' => null
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
			'name' => 'order',
			'type_input' => 'number',
			'label' => $magic->lang('Order'),
			'default' => 0,
			'desc' => $magic->lang('Ordering of item with other.')
		),
	), 'cliparts');

?>

<div class="magic_wrapper" id="magic-<?php echo $section; ?>-page">
	<div class="magic_content">
		<?php
			$magic->views->detail_header(array(
				'add' => $magic->lang('Add new clipart'),
				'edit' => $fields[0]['value'],
				'page' => $section
			));
		?>
		<form action="<?php echo $magic->cfg->admin_url; ?>magic-page=<?php
			echo $section.(isset($_GET['callback']) ? '&callback='.$_GET['callback'] : '');
		?>" id="magic-clipart-form" method="post" class="magic_form" enctype="multipart/form-data">

			<?php $magic->views->tabs_render($fields); ?>

			<div class="magic_form_group magic_form_submit">
				<input type="submit" class="magic-button magic-button-primary" value="<?php echo $magic->lang('Save Clipart'); ?>"/>
				<input type="hidden" name="do" value="action" />
				<a class="magic_cancel" href="<?php echo $magic->cfg->admin_url;?>magic-page=cliparts">
					<?php echo $magic->lang('Cancel'); ?>
				</a>
				<input type="hidden" name="magic-section" value="<?php echo $section; ?>">
			</div>
		</form>
	</div>
</div>
