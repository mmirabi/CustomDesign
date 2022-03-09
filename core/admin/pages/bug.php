<?php

	global $magic;
	$section = 'bug';

	$fields = $magic_admin->process_data(array(
		array(
			'type' => 'text',
			'name' => 'content',
			'label' => $magic->lang('Content')
		),
		array(
			'type' => 'dropbox',
			'name' => 'status',
			'label' => $magic->lang('Status'),
			'options' => array(
				'new' => 'New',
				'pending' => 'Pending',
				'fixed' => 'Fixed',
			)
		),
	), 'bugs');
?>

<div class="magic_wrapper">
	<div class="magic_content">
		<?php
			$magic->views->detail_header(array(
				'add' => $magic->lang('Add new Bbug'),
				'edit' => '#'.isset($_GET['id']) ? intval($_GET['id']) : '',
				'page' => $section
			));
		?>
		<form action="<?php echo $magic->cfg->admin_url; ?>magic-page=<?php
			echo $section.(isset($_GET['callback']) ? '&callback='.$_GET['callback'] : '');
		?>" id="magic-clipart-form" method="post" class="magic_form" enctype="multipart/form-data">

			<?php $magic->views->tabs_render($fields); ?>

			<div class="magic_form_group magic_form_submit">
				<input type="submit" class="magic-button magic-button-primary" value="<?php echo $magic->lang('Save Bug'); ?>"/>
				<input type="hidden" name="do" value="action" />
				<a class="magic_cancel" href="<?php echo $magic->cfg->admin_url;?>magic-page=bugs">
					<?php echo $magic->lang('Cancel'); ?>
				</a>
				<input type="hidden" name="magic-section" value="<?php echo $section; ?>">
			</div>
		</form>
	</div>
</div>
