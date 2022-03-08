<?php
	global $customdesign;

	$section = 'shape';
	$fields = $customdesign_admin->process_data(array(
		array(
			'type' => 'input',
			'name' => 'name',
			'label' => $customdesign->lang('Name'),
			'required' => true
		),
		array(
			'type' => 'shape',
			'name' => 'content',
			'label' => $customdesign->lang('Content'),
			'desc' => $customdesign->lang('Only accept SVG under plain text')
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
	), 'shapes');

?>

<div class="customdesign_wrapper" id="customdesign-<?php echo $section; ?>-page">
	<div class="customdesign_content">
		<?php
			$customdesign->views->detail_header(array(
				'add' => $customdesign->lang('Add new shape'),
				'edit' => $fields[0]['value'],
				'page' => $section
			));
		?>
		<form action="<?php echo $customdesign->cfg->admin_url; ?>customdesign-page=<?php
			echo $section.(isset($_GET['callback']) ? '&callback='.$_GET['callback'] : '');
		?>" id="customdesign-clipart-form" method="post" class="customdesign_form" enctype="multipart/form-data">

			<?php $customdesign->views->tabs_render($fields); ?>

			<div class="customdesign_form_group customdesign_form_submit">
				<input type="submit" class="customdesign-button customdesign-button-primary" value="<?php echo $customdesign->lang('Save Shape'); ?>"/>
				<input type="hidden" name="do" value="action" />
				<a class="customdesign_cancel" href="<?php echo $customdesign->cfg->admin_url;?>customdesign-page=<?php echo $section; ?>s">
					<?php echo $customdesign->lang('Cancel'); ?>
				</a>
				<input type="hidden" name="customdesign-section" value="<?php echo $section; ?>">
			</div>
		</form>
	</div>
</div>
