<?php
	global $magic;

	$section = 'tag';
	$type = isset($_GET['type']) ? $_GET['type'] : '';
	$fields = $magic_admin->process_data(array(
		array(
			'type' => 'input',
			'name' => 'name',
			'label' => $magic->lang('Name'),
			'required' => true
		),
		array(
			'type' => 'input',
			'type_input' => 'hidden',
			'name' => 'type',
			'default' => $type,
		)
	), 'tags');

?>

<div class="magic_wrapper" id="magic-<?php echo $section; ?>-page">
	<div class="magic_content">
		<?php
			$magic->views->detail_header(array(
				'add' => $magic->lang('Add New Tag'),
				'edit' => $magic->lang('Edit Tag'),
				'page' => $section,
				'type' => $type
			));
		?>
		<form action="<?php echo $magic->cfg->admin_url; ?>magic-page=<?php
			echo $section.(isset($_GET['callback']) ? '&callback='.$_GET['callback'] : '');
		?>" id="magic-clipart-form" method="post" class="magic_form" enctype="multipart/form-data">

			<?php $magic->views->tabs_render($fields); ?>

			<div class="magic_form_group magic_form_submit">
				<input type="submit" class="magic-button magic-button-primary" value="<?php echo $magic->lang('Save Tag'); ?>"/>
				<input type="hidden" name="do" value="action" />
				<a class="magic_cancel" href="<?php echo $magic->cfg->admin_url;?>magic-page=<?php echo $section; ?>s&type=<?php echo $type; ?>">
					<?php echo $magic->lang('Cancel'); ?>
				</a>
				<input type="hidden" name="do" value="action">
				<input type="hidden" name="magic-section" value="<?php echo $section; ?>">
			</div>
		</form>
	</div>
</div>
