<?php
	$title = "Edit Design";

	$arr = Array ("name");
	$design = $magic_admin->get_rows_custom($arr,'magic_designs');

	if (isset($_GET['id'])) {
		$data = $magic_admin->get_row_id($_GET['id'], 'magic_designs');
	}

	if (!empty($_POST['save_design'])) {

		$data = array();
		$data_id = isset($_POST['id']) ? trim($_POST['id']) : '';
		$data['name'] = isset($_POST['name']) ? trim($_POST['name']) : '';
		$data['screenshot'] = isset($_POST['screenshot']) ? trim($_POST['screenshot']) : '';
		$data['sharing'] = isset($_POST['sharing']) ? $_POST['sharing'] : '';
		$data['active'] = isset($_POST['active']) ? $_POST['active'] : '';
		$data_name = isset($_POST['name_temp']) ? $_POST['name_temp'] : '';
		$errors = array();

		if (empty($data['name'])) {
			$errors['name'] = $magic->lang('Please Insert Name.');
		} else {

			$data['name'] = trim($data['name']);
			if (is_array($design) && count($design) >0) {
				foreach ($design as $value) {
					if ($value['name'] == $data['name'] && $data['name'] != $data_name) {
						$errors['name'] = $magic->lang('The name provided already exists.');
					}
				}
			}
			
		}

		if (!empty($data['sharing'])) {
			$data['sharing'] = 1;
		} else {
			$data['sharing'] = 0;
		}

		if (!empty($data['active'])) {
			$data['active'] = 1;
		} else {
			$data['active'] = 0;
		}

		$data['updated'] = date("Y-m-d").' '.date("H:i:s");
		
		if (count($errors) == 0) {

			if (!empty($data_id)) {
				$id = $magic_admin->edit_row( $data_id, $data, 'magic_designs' );
			} else {
				$id =$magic_admin->add_row( $data, 'magic_designs' );
			}
			$magic_msg = array('status' => 'success');
			$magic->connector->set_session('magic_msg', $magic_msg);

		} else {

			$magic_msg = array('status' => 'error', 'errors' => $errors);
			$magic->connector->set_session('magic_msg', $magic_msg);
			if (!empty($data_id)) {
				$magic->redirect($magic->cfg->admin_url . "magic-page=design&id=".$data_id);
			} else {
				$magic->redirect($magic->cfg->admin_url . "magic-page=design");
			}
			exit;

		}

		if (isset($id) && $id == true ) {
			$magic->redirect($magic->cfg->admin_url . "magic-page=design&id=".$id);
			exit;
		}

	}

?>

<div class="magic_wrapper">
	<div class="magic_content">
		<div class="magic_header">
			<?php

				if (isset($_GET['id'])) {
					echo '<h2>'.$magic->lang('Edit Design').'</h2><a href="'.$magic->cfg->admin_url.'magic-page=design" class="add-new magic-button">'.$magic->lang('Add New Design').'</a>';
				} else {
					echo '<h2>'.$magic->lang('Add Design').'</h2>';
				}
				$magic_page = isset($_GET['magic-page']) ? $_GET['magic-page'] : '';
				echo $magic_helper->breadcrumb($magic_page); 

			?>
		</div>
		<?php 

			$magic_msg = $magic->connector->get_session('magic_msg');
			if (isset($magic_msg['status']) && $magic_msg['status'] == 'error') { ?>
				
				<div class="magic_message err">

					<?php foreach ($magic_msg['errors'] as $val) {
						echo '<em class="magic_err"><i class="fa fa-times"></i>  ' . $val . '</em>';
						$magic_msg = array('status' => '');
						$magic->connector->set_session('magic_msg', $magic_msg);
					} ?>

				</div>
				
			<?php }

			if (isset($magic_msg['status']) && $magic_msg['status'] == 'success') { ?>
				
				<div class="magic_message"> 
					<?php
						echo '<em class="magic_suc"><i class="fa fa-check"></i> '.$magic->lang('Your data has been successfully saved').'</em>';
						$magic_msg = array('status' => '');
						$magic->connector->set_session('magic_msg', $magic_msg);
					?>
				</div>

			<?php }

		?>
		<form action="<?php echo $magic->cfg->admin_url;?>magic-page=design" method="post" class="magic_form">
			<div class="magic_form_group">
				<span><?php echo $magic->lang('Name'); ?><em class="required">*</em></span>
				<div class="magic_form_content">
					<input type="text" name="name" value="<?php echo !empty($data['name']) ? $data['name'] : '' ?>">
					<input type="hidden" name="name_temp" value="<?php echo !empty($data['name']) ? $data['name'] : '' ?>">
				</div>
			</div>
			<div class="magic_form_group">
				<span><?php echo $magic->lang('Screenshot'); ?></span>
				<div class="magic_form_content">
					<textarea name="screenshot"><?php echo !empty($data['screenshot']) ? $data['screenshot'] : '' ?></textarea>
				</div>
			</div>
			<div class="magic_form_group">
				<span><?php echo $magic->lang('Sharing'); ?></span>
				<div class="magic_form_content">
					<div class="magic-toggle">
						<?php 
							$check = '';
							if (isset($data['sharing']) && $data['sharing'] == 1) {
								$check = 'checked';
							}
						?>
						<input type="checkbox" name="sharing" <?php echo $check; ?>>
						<span class="magic-toggle-label" data-on="Yes" data-off="No"></span>
						<span class="magic-toggle-handle"></span>
					</div>
				</div>
			</div>
			<div class="magic_form_group">
				<span><?php echo $magic->lang('Active'); ?></span>
				<div class="magic_form_content">
					<div class="magic-toggle">
						<?php 
							$check = '';
							if (isset($data['active']) && $data['active'] == 1) {
								$check = 'checked';
							}
						?>
						<input type="checkbox" name="active" <?php echo $check; ?>>
						<span class="magic-toggle-label" data-on="Yes" data-off="No"></span>
						<span class="magic-toggle-handle"></span>
					</div>
				</div>
			</div>
			<div class="magic_form_group">
				<input type="hidden" name="id" value="<?php echo !empty($data['id']) ? $data['id'] : '' ?>"/>
				<input type="submit" class="magic-button magic-button-primary" value="<?php echo $magic->lang('Save Design'); ?>"/>
				<input type="hidden" name="save_design" value="true">
			</div>
			<?php $magic->securityFrom();?>
		</form>
	</div>
</div>
