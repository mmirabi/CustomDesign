<?php
	global $magic;

	$section = 'shape';
	$fields = $magic_admin->process_data(array(
		array(
			'type' => 'input',
			'name' => 'name',
			'label' => $magic->lang('Name'),
			'required' => true
		),
		array(
			'type' => 'shape',
			'name' => 'content',
			'label' => $magic->lang('Content'),
			'desc' => $magic->lang('Only accept SVG under plain text')
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
	), 'shapes');

?>

<div class="magic_wrapper" id="magic-<?php echo $section; ?>-page">
	<div class="magic_content">
		<?php
			$magic->views->detail_header(array(
				'add' => $magic->lang('Add new shape'),
				'edit' => $fields[0]['value'],
				'page' => $section
			));
		?>
		<form action="<?php echo $magic->cfg->admin_url; ?>magic-page=<?php
			echo $section.(isset($_GET['callback']) ? '&callback='.$_GET['callback'] : '');
		?>" id="magic-clipart-form" method="post" class="magic_form" enctype="multipart/form-data">

			<?php $magic->views->tabs_render($fields); ?>

			<div class="magic_form_group magic_form_submit">
				<input type="submit" class="magic-button magic-button-primary" value="<?php echo $magic->lang('Save Shape'); ?>"/>
				<input type="hidden" name="do" value="action" />
				<a class="magic_cancel" href="<?php echo $magic->cfg->admin_url;?>magic-page=<?php echo $section; ?>s">
					<?php echo $magic->lang('Cancel'); ?>
				</a>
				<input type="hidden" name="magic-section" value="<?php echo $section; ?>">
			</div>
		</form>
	</div>
</div>
