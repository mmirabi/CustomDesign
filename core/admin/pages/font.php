<?php

	$section = 'font';
	$fields = $magic_admin->process_data(array(
		array(
			'type' => 'input',
			'name' => 'name',
			'label' => $magic->lang('Name'),
			'required' => true,
			'desc' => $magic->lang('The names must be latin letters'),
			'default' => 'Untitled'
		),
		array(
			'type' => 'input',
			'name' => 'name_desc',
			'label' => $magic->lang('Name Desciption'),
			'required' => true,
			'desc' => $magic->lang('Show on frontend(design editor), default will is name'),
			'default' => ''
		),
		array(
			'type' => 'upload',
			'name' => 'upload',
			'required' => true,
			'path' => 'fonts'.DS,
			'file' => 'font',
			'file_type' => 'woff2',
			'label' => $magic->lang('Upload Font'),
			'desc' => $magic->lang('You can convert your *.ttf to *.woff2 by a converter online tool').
					  ' <a href="https://font-converter.net/en" target="_blank"><strong>Font-Converter.net</strong></a>'
		),
		array(
			'type' => 'upload',
			'name' => 'upload_ttf',
			'path' => 'fonts'.DS,
			'file' => 'font',
			'file_type' => 'ttf',
			'label' => $magic->lang('PDF render'),
			'desc' => $magic->lang('Upload *.ttf file to render PDF (in case you want to export design to PDF for printing)')
		),
		array(
			'type' => 'toggle',
			'name' => 'active',
			'label' => $magic->lang('Active'),
			'default' => 'yes',
			'value' => null
		),
	), 'fonts');

?>

<div class="magic_wrapper" id="magic-<?php echo $section; ?>-page">
	<div class="magic_content">
		<?php
			$magic->views->detail_header(array(
				'add' => $magic->lang('Add new font'),
				'edit' => $fields[0]['value'],
				'page' => $section
			));
		?>
		<form action="<?php echo $magic->cfg->admin_url; ?>magic-page=<?php
			echo $section.(isset($_GET['callback']) ? '&callback='.$_GET['callback'] : '');
		?>" id="magic-clipart-form" method="post" class="magic_form" enctype="multipart/form-data">

			<?php $magic->views->tabs_render($fields); ?>

			<div class="magic_form_group magic_form_submit">
				<input type="submit" class="magic-button magic-button-primary" value="<?php echo $magic->lang('Save Font'); ?>"/>
				<input type="hidden" name="do" value="action" />
				<a class="magic_cancel" href="<?php echo $magic->cfg->admin_url;?>magic-page=<?php echo $section; ?>s">
					<?php echo $magic->lang('Cancel'); ?>
				</a>
				<input type="hidden" name="magic-section" value="<?php echo $section; ?>">
			</div>
		</form>
	</div>
</div>
