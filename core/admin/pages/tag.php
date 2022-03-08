<?php
	global $customdesign;

	$section = 'tag';
	$type = isset($_GET['type']) ? $_GET['type'] : '';
	$fields = $customdesign_admin->process_data(array(
		array(
			'type' => 'input',
			'name' => 'name',
			'label' => $customdesign->lang('Name'),
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

<div class="customdesign_wrapper" id="customdesign-<?php echo $section; ?>-page">
	<div class="customdesign_content">
		<?php
			$customdesign->views->detail_header(array(
				'add' => $customdesign->lang('Add New Tag'),
				'edit' => $customdesign->lang('Edit Tag'),
				'page' => $section,
				'type' => $type
			));
		?>
		<form action="<?php echo $customdesign->cfg->admin_url; ?>customdesign-page=<?php
			echo $section.(isset($_GET['callback']) ? '&callback='.$_GET['callback'] : '');
		?>" id="customdesign-clipart-form" method="post" class="customdesign_form" enctype="multipart/form-data">

			<?php $customdesign->views->tabs_render($fields); ?>

			<div class="customdesign_form_group customdesign_form_submit">
				<input type="submit" class="customdesign-button customdesign-button-primary" value="<?php echo $customdesign->lang('Save Tag'); ?>"/>
				<input type="hidden" name="do" value="action" />
				<a class="customdesign_cancel" href="<?php echo $customdesign->cfg->admin_url;?>customdesign-page=<?php echo $section; ?>s&type=<?php echo $type; ?>">
					<?php echo $customdesign->lang('Cancel'); ?>
				</a>
				<input type="hidden" name="do" value="action">
				<input type="hidden" name="customdesign-section" value="<?php echo $section; ?>">
			</div>
		</form>
	</div>
</div>
