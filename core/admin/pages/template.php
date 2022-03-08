<?php
	
	global $customdesign;

	$section = 'template';
	$id = isset($_GET['id']) ? $_GET['id'] : 0;
	$fields = $customdesign_admin->process_data(array(
		array(
			'type' => 'input',
			'name' => 'name',
			'label' => $customdesign->lang('Name'),
			'required' => true,
			'default' => 'Untitled'
		),
		array(
			'type' => 'input',
			'name' => 'price',
			'label' => $customdesign->lang('Price'),
			'default' => 0,
			'numberic' => 'float',
			'desc' => $customdesign->lang('Enter price for this template.')
		),
		array(
			'type' => 'categories',
			'cate_type' => 'templates',
			'name' => 'categories',
			'label' => $customdesign->lang('Categories'),
			'id' => $id,
			'db' => false
		),
		array(
			'type' => 'tags',
			'tag_type' => 'templates',
			'name' => 'tags',
			'label' => $customdesign->lang('Tags'),
			'id' => $id,
			'desc' => $customdesign->lang('Example: tag1, tag2, tag3 ...'),
		),
		array(
			'type' => 'upload',
			'file' => 'design',
			'name' => 'upload',
			'path' => 'templates'.DS.date('Y').DS.date('m').DS,
			'thumbn' => 'screenshot',
			'label' => $customdesign->lang('Upload template file'),
			'desc' => $customdesign->lang('Upload the exported file *.lumi from the MagicRugs Designer Tool. You can download the LUMI file via menu "File" > Save As File, or press Ctrl+Shift+S')
		),
		array(
			'type' => 'toggle',
			'name' => 'featured',
			'label' => $customdesign->lang('Featured'),
			'default' => 'no',
			'value' => null
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
			'name' => 'order',
			'type_input' => 'number',
			'label' => $customdesign->lang('Order'),
			'default' => 0,
			'desc' => $customdesign->lang('Ordering of item with other.')
		),
	), 'templates');

?>

<div class="customdesign_wrapper" id="customdesign-<?php echo $section; ?>-page">
	<div class="customdesign_content">
		<?php
			$customdesign->views->detail_header(array(
				'add' => $customdesign->lang('Add new template'),
				'edit' => $fields[0]['value'],
				'page' => $section
			));
		?>
		<form action="<?php echo $customdesign->cfg->admin_url; ?>customdesign-page=<?php
			echo $section.(isset($_GET['callback']) ? '&callback='.$_GET['callback'] : '');
		?>" id="customdesign-<?php echo $section; ?>-form" method="post" class="customdesign_form" enctype="multipart/form-data">

			<?php $customdesign->views->tabs_render($fields); ?>

			<div class="customdesign_form_group customdesign_form_submit">
				<input type="submit" class="customdesign-button customdesign-button-primary" value="<?php echo $customdesign->lang('Save Template'); ?>"/>
				<input type="hidden" name="do" value="action" />
				<a class="customdesign_cancel" href="<?php echo $customdesign->cfg->admin_url;?>customdesign-page=templates">
					<?php echo $customdesign->lang('Cancel'); ?>
				</a>
				<input type="hidden" name="customdesign-section" value="<?php echo $section; ?>">
			</div>
		</form>
	</div>
</div>
<script type="text/javascript">
	
	var customdesign_upload_url = '<?php echo $customdesign->cfg->upload_url; ?>',
		customdesign_assets_url = '<?php echo $customdesign->cfg->assets_url; ?>';
			
	document.customdesignconfig = {
		main: 'template'
	};
</script>
