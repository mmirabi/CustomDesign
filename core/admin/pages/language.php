<?php

	$section = 'language';

	$langs = $customdesign->get_langs();
	$lang_map = $customdesign->langs();

	$options = array();

	foreach ($langs as $lang) {
		if (!isset($options[$lang]) && isset($lang_map[$lang]))
			$options[$lang] = $lang_map[$lang];
	}

	$fields = $customdesign_admin->process_data(array(
		array(
			'type' => 'input',
			'name' => 'text',
			'label' => $customdesign->lang('Translate Text'),
			'required' => true
		),
		array(
			'type' => 'input',
			'name' => 'original_text',
			'label' => $customdesign->lang('Original text'),
			'required' => true
		),
		array(
			'type' => 'dropbox',
			'options' => $options,
			'name' => 'lang',
			'label' => $customdesign->lang('Language'),
		),
	), 'languages');

?>

<div class="customdesign_wrapper" id="customdesign-<?php echo $section; ?>-page">
	<div class="customdesign_content">
		<?php
			$customdesign->views->detail_header(array(
				'add' => $customdesign->lang('Add translate text'),
				'edit' => $customdesign->lang('Edit translate text'),
				'page' => $section
			));
		?>
		<form action="<?php echo $customdesign->cfg->admin_url; ?>customdesign-page=<?php
			echo $section.(isset($_GET['callback']) ? '&callback='.$_GET['callback'] : '');
		?>" id="customdesign-clipart-form" method="post" class="customdesign_form" enctype="multipart/form-data">

			<?php $customdesign->views->tabs_render($fields); ?>

			<div class="customdesign_form_group customdesign_form_submit">
				<input type="submit" class="customdesign-button customdesign-button-primary" value="<?php echo $customdesign->lang('Save Translate Text'); ?>"/>
				<input type="hidden" name="do" value="action" />
				<a class="customdesign_cancel" href="<?php echo $customdesign->cfg->admin_url;?>customdesign-page=<?php echo $section; ?>s">
					<?php echo $customdesign->lang('Cancel'); ?>
				</a>
				<input type="hidden" name="customdesign-section" value="<?php echo $section; ?>">
			</div>
		</form>
	</div>
</div>

<?php

	return;
	$title = "Edit translate text";

	if (isset($_GET['id'])) {
		$data = $customdesign_admin->get_row_id($_GET['id'], 'customdesign_languages');
	}


	$langs = $customdesign->get_langs();
	$lang_map = $customdesign->langs();

	if (!empty($_POST['save_language'])) {

		$data = array();
		$data_id = isset($_POST['id']) ? trim($_POST['id']) : '';
		$data['text'] = isset($_POST['text']) ? trim($_POST['text']) : '';
		$data['original_text'] = isset($_POST['original_text']) ? trim($_POST['original_text']) : '';
		$data['lang'] = isset($_POST['lang']) ? trim($_POST['lang']) : '';
		$data_name = isset($_POST['name_temp']) ? $_POST['name_temp'] : '';
		$errors = array();

		if (empty($data['lang'])) {
			$errors['lang'] = $customdesign->lang('Please select language.');
		}else if (empty($data['text'])) {
			$errors['text'] = $customdesign->lang('Please insert translate text.');
		}else if (empty($data['original_text'])) {
			$errors['original_text'] = $customdesign->lang('Please insert original text.');
		}else{
			$check_exist = $customdesign->db->rawQuery("SELECT `id` FROM `{$customdesign->db->prefix}languages` WHERE `author`='{$customdesign->vendor_id}' AND `lang` = '".$data['lang']."' AND `original_text` = '".$data['original_text']."'");
			if (count($check_exist) > 0) {
				$errors['original_text'] = $customdesign->lang('The original text provided already exists.');
			}

		}

		if (!empty($data_id)) {
			$data['updated'] = date("Y-m-d").' '.date("H:i:s");
		} else {
			$data['created'] = date("Y-m-d").' '.date("H:i:s");
		}

		if (count($errors) == 0) {

			if (!empty($data_id)) {
				$id = $customdesign_admin->edit_row( $data_id, $data, 'customdesign_languages' );
			} else {
				$id = $customdesign_admin->add_row( $data, 'customdesign_languages' );
			}
			$customdesign_msg = array('status' => 'success');
			$customdesign->connector->set_session('customdesign_msg', $customdesign_msg);

		} else {

			$customdesign_msg = array('status' => 'error', 'errors' => $errors);
			$customdesign->connector->set_session('customdesign_msg', $customdesign_msg);
			if (!empty($data_id)) {
				$customdesign->redirect($customdesign->cfg->admin_url . "customdesign-page=language&id=".$data_id);
			} else {
				$customdesign->redirect($customdesign->cfg->admin_url . "customdesign-page=language");
			}
			exit;

		}

		if (isset($id) && $id == true ) {
			$customdesign->redirect($customdesign->cfg->admin_url . "customdesign-page=language&id=".$id);
			exit;
		}

	}else if (count($langs) !== 0) {
		$errors['text'] = $customdesign->lang('No language added, Please add new language before adding translate text').
		' &nbsp; <a href="'.$customdesign->cfg->admin_url .'customdesign-page=languages">'.$customdesign->lang('Languages').' <i class="fa fa-arrow-circle-right"></i></a>';
		$customdesign_msg = array('status' => 'error', 'errors' => $errors);
		$customdesign->connector->set_session('customdesign_msg', $customdesign_msg);
	}

?>

<div class="customdesign_wrapper">
	<div class="customdesign_content">
		<div class="customdesign_header">
			<?php

				if (!empty($data['id'])) {
					echo '<h2>'.$customdesign->lang('Edit Translate Text').'</h2><a href="'.$customdesign->cfg->admin_url.'customdesign-page=language" class="add-new customdesign-button">'.$customdesign->lang('Add New Language').'</a>';
				} else {
					echo '<h2>'.$customdesign->lang('Add Translate Text').'</h2>';
				}
				$customdesign_page = isset($_GET['customdesign-page']) ? $_GET['customdesign-page'] : '';
				echo $customdesign_helper->breadcrumb($customdesign_page);

			?>
		</div>
		<?php

			$customdesign_msg = $customdesign->connector->get_session('customdesign_msg');
			if (isset($customdesign_msg) && $customdesign_msg['status'] == 'error') { ?>

				<div class="customdesign_message err">

					<?php foreach ($customdesign_msg['errors'] as $val) {
						echo '<em class="customdesign_err"><i class="fa fa-times"></i>  ' . $val . '</em>';
						$customdesign_msg = array('status' => '');
						$customdesign->connector->set_session('customdesign_msg', $customdesign_msg);
					} ?>

				</div>

			<?php }

			if (isset($customdesign_msg) && $customdesign_msg['status'] == 'success') { ?>

				<div class="customdesign_message">
					<?php
						echo '<em class="customdesign_suc"><i class="fa fa-check"></i> '.$customdesign->lang('Your data has been successfully saved').'</em>';
						$customdesign_msg = array('status' => '');
						$customdesign->connector->set_session('customdesign_msg', $customdesign_msg);
					?>
				</div>

			<?php }

		?>
		<form action="<?php echo $customdesign->cfg->admin_url;?>customdesign-page=language" method="post" class="customdesign_form">
			<div class="customdesign_form_group">
				<span><?php echo $customdesign->lang('Translate Text'); ?><em class="required">*</em></span>
				<div class="customdesign_form_content">
					<input type="text" name="text" value="<?php echo !empty($data['text']) ? $data['text'] : '' ?>">
					<input type="hidden" name="name_temp" value="<?php echo !empty($data['text']) ? $data['text'] : '' ?>">
				</div>
			</div>
			<div class="customdesign_form_group">
				<span><?php echo $customdesign->lang('Original text'); ?><em class="required">*</em></span>
				<div class="customdesign_form_content">
					<input type="text" name="original_text" value="<?php echo !empty($data['original_text']) ? $data['original_text'] : '' ?>">
				</div>
			</div>
			<div class="customdesign_form_group">
				<span><?php echo $customdesign->lang('Language'); ?></span>
				<div class="customdesign_form_content">
					<select name="lang">
						<?php
							foreach ($langs as $lang) {
								echo '<option value="'.$lang.'"'.(
									(isset($data['lang']) && $data['lang'] == $lang) ? ' selected' : ''
								).'>'.$lang_map[$lang].' - '.strtoupper($lang).'</option>';
							}
						?>
					</select>
				</div>
			</div>
			<div class="customdesign_form_group customdesign_form_submit">
				<input type="hidden" name="id" value="<?php echo !empty($data['id']) ? $data['id'] : '' ?>"/>
				<input type="submit" class="customdesign-button customdesign-button-primary" value="<?php echo $customdesign->lang('Save Language'); ?>"/>
				<input type="hidden" name="save_language" value="true">
				<a class="customdesign_cancel" href="<?php echo $customdesign->cfg->admin_url;?>customdesign-page=languages">
					<?php echo $customdesign->lang('Cancel'); ?>
				</a>
			</div>
			<?php $customdesign->securityFrom();?>
		</form>
	</div>
</div>
