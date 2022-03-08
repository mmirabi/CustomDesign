<?php

	$section = 'font';
	$fields = $customdesign_admin->process_data(array(
		array(
			'type' => 'input',
			'name' => 'name',
			'label' => $customdesign->lang('Name'),
			'required' => true,
			'desc' => $customdesign->lang('The names must be latin letters'),
			'default' => 'Untitled'
		),
		array(
			'type' => 'input',
			'name' => 'name_desc',
			'label' => $customdesign->lang('Name Desciption'),
			'required' => true,
			'desc' => $customdesign->lang('Show on frontend(design editor), default will is name'),
			'default' => ''
		),
		array(
			'type' => 'upload',
			'name' => 'upload',
			'required' => true,
			'path' => 'fonts'.DS,
			'file' => 'font',
			'file_type' => 'woff2',
			'label' => $customdesign->lang('Upload Font'),
			'desc' => $customdesign->lang('You can convert your *.ttf to *.woff2 by a converter online tool').
					  ' <a href="https://font-converter.net/en" target="_blank"><strong>Font-Converter.net</strong></a>'
		),
		array(
			'type' => 'upload',
			'name' => 'upload_ttf',
			'path' => 'fonts'.DS,
			'file' => 'font',
			'file_type' => 'ttf',
			'label' => $customdesign->lang('PDF render'),
			'desc' => $customdesign->lang('Upload *.ttf file to render PDF (in case you want to export design to PDF for printing)')
		),
		array(
			'type' => 'toggle',
			'name' => 'active',
			'label' => $customdesign->lang('Active'),
			'default' => 'yes',
			'value' => null
		),
	), 'fonts');

?>

<div class="customdesign_wrapper" id="customdesign-<?php echo $section; ?>-page">
	<div class="customdesign_content">
		<?php
			$customdesign->views->detail_header(array(
				'add' => $customdesign->lang('Add new font'),
				'edit' => $fields[0]['value'],
				'page' => $section
			));
		?>
		<form action="<?php echo $customdesign->cfg->admin_url; ?>customdesign-page=<?php
			echo $section.(isset($_GET['callback']) ? '&callback='.$_GET['callback'] : '');
		?>" id="customdesign-clipart-form" method="post" class="customdesign_form" enctype="multipart/form-data">

			<?php $customdesign->views->tabs_render($fields); ?>

			<div class="customdesign_form_group customdesign_form_submit">
				<input type="submit" class="customdesign-button customdesign-button-primary" value="<?php echo $customdesign->lang('Save Font'); ?>"/>
				<input type="hidden" name="do" value="action" />
				<a class="customdesign_cancel" href="<?php echo $customdesign->cfg->admin_url;?>customdesign-page=<?php echo $section; ?>s">
					<?php echo $customdesign->lang('Cancel'); ?>
				</a>
				<input type="hidden" name="customdesign-section" value="<?php echo $section; ?>">
			</div>
		</form>
	</div>
</div>
