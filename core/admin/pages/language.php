<?php

	$section = 'language';

	$langs = $magic->get_langs();
	$lang_map = $magic->langs();

	$options = array();

	foreach ($langs as $lang) {
		if (!isset($options[$lang]) && isset($lang_map[$lang]))
			$options[$lang] = $lang_map[$lang];
	}

	$fields = $magic_admin->process_data(array(
		array(
			'type' => 'input',
			'name' => 'text',
			'label' => $magic->lang('Translate Text'),
			'required' => true
		),
		array(
			'type' => 'input',
			'name' => 'original_text',
			'label' => $magic->lang('Original text'),
			'required' => true
		),
		array(
			'type' => 'dropbox',
			'options' => $options,
			'name' => 'lang',
			'label' => $magic->lang('Language'),
		),
	), 'languages');

?>

<div class="magic_wrapper" id="magic-<?php echo $section; ?>-page">
	<div class="magic_content">
		<?php
			$magic->views->detail_header(array(
				'add' => $magic->lang('Add translate text'),
				'edit' => $magic->lang('Edit translate text'),
				'page' => $section
			));
		?>
		<form action="<?php echo $magic->cfg->admin_url; ?>magic-page=<?php
			echo $section.(isset($_GET['callback']) ? '&callback='.$_GET['callback'] : '');
		?>" id="magic-clipart-form" method="post" class="magic_form" enctype="multipart/form-data">

			<?php $magic->views->tabs_render($fields); ?>

			<div class="magic_form_group magic_form_submit">
				<input type="submit" class="magic-button magic-button-primary" value="<?php echo $magic->lang('Save Translate Text'); ?>"/>
				<input type="hidden" name="do" value="action" />
				<a class="magic_cancel" href="<?php echo $magic->cfg->admin_url;?>magic-page=<?php echo $section; ?>s">
					<?php echo $magic->lang('Cancel'); ?>
				</a>
				<input type="hidden" name="magic-section" value="<?php echo $section; ?>">
			</div>
		</form>
	</div>
</div>

<?php

	return;
	$title = "Edit translate text";

	if (isset($_GET['id'])) {
		$data = $magic_admin->get_row_id($_GET['id'], 'magic_languages');
	}


	$langs = $magic->get_langs();
	$lang_map = $magic->langs();

	if (!empty($_POST['save_language'])) {

		$data = array();
		$data_id = isset($_POST['id']) ? trim($_POST['id']) : '';
		$data['text'] = isset($_POST['text']) ? trim($_POST['text']) : '';
		$data['original_text'] = isset($_POST['original_text']) ? trim($_POST['original_text']) : '';
		$data['lang'] = isset($_POST['lang']) ? trim($_POST['lang']) : '';
		$data_name = isset($_POST['name_temp']) ? $_POST['name_temp'] : '';
		$errors = array();

		if (empty($data['lang'])) {
			$errors['lang'] = $magic->lang('Please select language.');
		}else if (empty($data['text'])) {
			$errors['text'] = $magic->lang('Please insert translate text.');
		}else if (empty($data['original_text'])) {
			$errors['original_text'] = $magic->lang('Please insert original text.');
		}else{
			$check_exist = $magic->db->rawQuery("SELECT `id` FROM `{$magic->db->prefix}languages` WHERE `author`='{$magic->vendor_id}' AND `lang` = '".$data['lang']."' AND `original_text` = '".$data['original_text']."'");
			if (count($check_exist) > 0) {
				$errors['original_text'] = $magic->lang('The original text provided already exists.');
			}

		}

		if (!empty($data_id)) {
			$data['updated'] = date("Y-m-d").' '.date("H:i:s");
		} else {
			$data['created'] = date("Y-m-d").' '.date("H:i:s");
		}

		if (count($errors) == 0) {

			if (!empty($data_id)) {
				$id = $magic_admin->edit_row( $data_id, $data, 'magic_languages' );
			} else {
				$id = $magic_admin->add_row( $data, 'magic_languages' );
			}
			$magic_msg = array('status' => 'success');
			$magic->connector->set_session('magic_msg', $magic_msg);

		} else {

			$magic_msg = array('status' => 'error', 'errors' => $errors);
			$magic->connector->set_session('magic_msg', $magic_msg);
			if (!empty($data_id)) {
				$magic->redirect($magic->cfg->admin_url . "magic-page=language&id=".$data_id);
			} else {
				$magic->redirect($magic->cfg->admin_url . "magic-page=language");
			}
			exit;

		}

		if (isset($id) && $id == true ) {
			$magic->redirect($magic->cfg->admin_url . "magic-page=language&id=".$id);
			exit;
		}

	}else if (count($langs) !== 0) {
		$errors['text'] = $magic->lang('No language added, Please add new language before adding translate text').
		' &nbsp; <a href="'.$magic->cfg->admin_url .'magic-page=languages">'.$magic->lang('Languages').' <i class="fa fa-arrow-circle-right"></i></a>';
		$magic_msg = array('status' => 'error', 'errors' => $errors);
		$magic->connector->set_session('magic_msg', $magic_msg);
	}

?>

<div class="magic_wrapper">
	<div class="magic_content">
		<div class="magic_header">
			<?php

				if (!empty($data['id'])) {
					echo '<h2>'.$magic->lang('Edit Translate Text').'</h2><a href="'.$magic->cfg->admin_url.'magic-page=language" class="add-new magic-button">'.$magic->lang('Add New Language').'</a>';
				} else {
					echo '<h2>'.$magic->lang('Add Translate Text').'</h2>';
				}
				$magic_page = isset($_GET['magic-page']) ? $_GET['magic-page'] : '';
				echo $magic_helper->breadcrumb($magic_page);

			?>
		</div>
		<?php

			$magic_msg = $magic->connector->get_session('magic_msg');
			if (isset($magic_msg) && $magic_msg['status'] == 'error') { ?>

				<div class="magic_message err">

					<?php foreach ($magic_msg['errors'] as $val) {
						echo '<em class="magic_err"><i class="fa fa-times"></i>  ' . $val . '</em>';
						$magic_msg = array('status' => '');
						$magic->connector->set_session('magic_msg', $magic_msg);
					} ?>

				</div>

			<?php }

			if (isset($magic_msg) && $magic_msg['status'] == 'success') { ?>

				<div class="magic_message">
					<?php
						echo '<em class="magic_suc"><i class="fa fa-check"></i> '.$magic->lang('Your data has been successfully saved').'</em>';
						$magic_msg = array('status' => '');
						$magic->connector->set_session('magic_msg', $magic_msg);
					?>
				</div>

			<?php }

		?>
		<form action="<?php echo $magic->cfg->admin_url;?>magic-page=language" method="post" class="magic_form">
			<div class="magic_form_group">
				<span><?php echo $magic->lang('Translate Text'); ?><em class="required">*</em></span>
				<div class="magic_form_content">
					<input type="text" name="text" value="<?php echo !empty($data['text']) ? $data['text'] : '' ?>">
					<input type="hidden" name="name_temp" value="<?php echo !empty($data['text']) ? $data['text'] : '' ?>">
				</div>
			</div>
			<div class="magic_form_group">
				<span><?php echo $magic->lang('Original text'); ?><em class="required">*</em></span>
				<div class="magic_form_content">
					<input type="text" name="original_text" value="<?php echo !empty($data['original_text']) ? $data['original_text'] : '' ?>">
				</div>
			</div>
			<div class="magic_form_group">
				<span><?php echo $magic->lang('Language'); ?></span>
				<div class="magic_form_content">
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
			<div class="magic_form_group magic_form_submit">
				<input type="hidden" name="id" value="<?php echo !empty($data['id']) ? $data['id'] : '' ?>"/>
				<input type="submit" class="magic-button magic-button-primary" value="<?php echo $magic->lang('Save Language'); ?>"/>
				<input type="hidden" name="save_language" value="true">
				<a class="magic_cancel" href="<?php echo $magic->cfg->admin_url;?>magic-page=languages">
					<?php echo $magic->lang('Cancel'); ?>
				</a>
			</div>
			<?php $magic->securityFrom();?>
		</form>
	</div>
</div>
