<?php
	
	global $magic;

	$section = 'template';
	$id = isset($_GET['id']) ? $_GET['id'] : 0;
	$fields = $magic_admin->process_data(array(
		array(
			'type' => 'input',
			'name' => 'name',
			'label' => $magic->lang('Name'),
			'required' => true,
			'default' => 'Untitled'
		),
		array(
			'type' => 'input',
			'name' => 'price',
			'label' => $magic->lang('Price'),
			'default' => 0,
			'numberic' => 'float',
			'desc' => $magic->lang('Enter price for this template.')
		),
		array(
			'type' => 'categories',
			'cate_type' => 'templates',
			'name' => 'categories',
			'label' => $magic->lang('Categories'),
			'id' => $id,
			'db' => false
		),
		array(
			'type' => 'tags',
			'tag_type' => 'templates',
			'name' => 'tags',
			'label' => $magic->lang('Tags'),
			'id' => $id,
			'desc' => $magic->lang('Example: tag1, tag2, tag3 ...'),
		),
		array(
			'type' => 'upload',
			'file' => 'design',
			'name' => 'upload',
			'path' => 'templates'.DS.date('Y').DS.date('m').DS,
			'thumbn' => 'screenshot',
			'label' => $magic->lang('Upload template file'),
			'desc' => $magic->lang('Upload the exported file *.lumi from the MagicRugs Designer Tool. You can download the LUMI file via menu "File" > Save As File, or press Ctrl+Shift+S')
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
	), 'templates');

?>

<div class="magic_wrapper" id="magic-<?php echo $section; ?>-page">
	<div class="magic_content">
		<?php
			$magic->views->detail_header(array(
				'add' => $magic->lang('Add new template'),
				'edit' => $fields[0]['value'],
				'page' => $section
			));
		?>
		<form action="<?php echo $magic->cfg->admin_url; ?>magic-page=<?php
			echo $section.(isset($_GET['callback']) ? '&callback='.$_GET['callback'] : '');
		?>" id="magic-<?php echo $section; ?>-form" method="post" class="magic_form" enctype="multipart/form-data">

			<?php $magic->views->tabs_render($fields); ?>

			<div class="magic_form_group magic_form_submit">
				<input type="submit" class="magic-button magic-button-primary" value="<?php echo $magic->lang('Save Template'); ?>"/>
				<input type="hidden" name="do" value="action" />
				<a class="magic_cancel" href="<?php echo $magic->cfg->admin_url;?>magic-page=templates">
					<?php echo $magic->lang('Cancel'); ?>
				</a>
				<input type="hidden" name="magic-section" value="<?php echo $section; ?>">
			</div>
		</form>
	</div>
</div>
<script type="text/javascript">
	
	var magic_upload_url = '<?php echo $magic->cfg->upload_url; ?>',
		magic_assets_url = '<?php echo $magic->cfg->assets_url; ?>';
			
	document.magicconfig = {
		main: 'template'
	};
</script>
