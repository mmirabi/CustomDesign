<?php
	$title = "Edit Design";

	$arr = Array ("name");
	$design = $customdesign_admin->get_rows_custom($arr,'customdesign_designs');

	if (isset($_GET['id'])) {
		$data = $customdesign_admin->get_row_id($_GET['id'], 'customdesign_designs');
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
			$errors['name'] = $customdesign->lang('Please Insert Name.');
		} else {

			$data['name'] = trim($data['name']);
			if (is_array($design) && count($design) >0) {
				foreach ($design as $value) {
					if ($value['name'] == $data['name'] && $data['name'] != $data_name) {
						$errors['name'] = $customdesign->lang('The name provided already exists.');
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
				$id = $customdesign_admin->edit_row( $data_id, $data, 'customdesign_designs' );
			} else {
				$id =$customdesign_admin->add_row( $data, 'customdesign_designs' );
			}
			$customdesign_msg = array('status' => 'success');
			$customdesign->connector->set_session('customdesign_msg', $customdesign_msg);

		} else {

			$customdesign_msg = array('status' => 'error', 'errors' => $errors);
			$customdesign->connector->set_session('customdesign_msg', $customdesign_msg);
			if (!empty($data_id)) {
				$customdesign->redirect($customdesign->cfg->admin_url . "customdesign-page=design&id=".$data_id);
			} else {
				$customdesign->redirect($customdesign->cfg->admin_url . "customdesign-page=design");
			}
			exit;

		}

		if (isset($id) && $id == true ) {
			$customdesign->redirect($customdesign->cfg->admin_url . "customdesign-page=design&id=".$id);
			exit;
		}

	}

?>

<div class="customdesign_wrapper">
	<div class="customdesign_content">
		<div class="customdesign_header">
			<?php

				if (isset($_GET['id'])) {
					echo '<h2>'.$customdesign->lang('Edit Design').'</h2><a href="'.$customdesign->cfg->admin_url.'customdesign-page=design" class="add-new customdesign-button">'.$customdesign->lang('Add New Design').'</a>';
				} else {
					echo '<h2>'.$customdesign->lang('Add Design').'</h2>';
				}
				$customdesign_page = isset($_GET['customdesign-page']) ? $_GET['customdesign-page'] : '';
				echo $customdesign_helper->breadcrumb($customdesign_page); 

			?>
		</div>
		<?php 

			$customdesign_msg = $customdesign->connector->get_session('customdesign_msg');
			if (isset($customdesign_msg['status']) && $customdesign_msg['status'] == 'error') { ?>
				
				<div class="customdesign_message err">

					<?php foreach ($customdesign_msg['errors'] as $val) {
						echo '<em class="customdesign_err"><i class="fa fa-times"></i>  ' . $val . '</em>';
						$customdesign_msg = array('status' => '');
						$customdesign->connector->set_session('customdesign_msg', $customdesign_msg);
					} ?>

				</div>
				
			<?php }

			if (isset($customdesign_msg['status']) && $customdesign_msg['status'] == 'success') { ?>
				
				<div class="customdesign_message"> 
					<?php
						echo '<em class="customdesign_suc"><i class="fa fa-check"></i> '.$customdesign->lang('Your data has been successfully saved').'</em>';
						$customdesign_msg = array('status' => '');
						$customdesign->connector->set_session('customdesign_msg', $customdesign_msg);
					?>
				</div>

			<?php }

		?>
		<form action="<?php echo $customdesign->cfg->admin_url;?>customdesign-page=design" method="post" class="customdesign_form">
			<div class="customdesign_form_group">
				<span><?php echo $customdesign->lang('Name'); ?><em class="required">*</em></span>
				<div class="customdesign_form_content">
					<input type="text" name="name" value="<?php echo !empty($data['name']) ? $data['name'] : '' ?>">
					<input type="hidden" name="name_temp" value="<?php echo !empty($data['name']) ? $data['name'] : '' ?>">
				</div>
			</div>
			<div class="customdesign_form_group">
				<span><?php echo $customdesign->lang('Screenshot'); ?></span>
				<div class="customdesign_form_content">
					<textarea name="screenshot"><?php echo !empty($data['screenshot']) ? $data['screenshot'] : '' ?></textarea>
				</div>
			</div>
			<div class="customdesign_form_group">
				<span><?php echo $customdesign->lang('Sharing'); ?></span>
				<div class="customdesign_form_content">
					<div class="customdesign-toggle">
						<?php 
							$check = '';
							if (isset($data['sharing']) && $data['sharing'] == 1) {
								$check = 'checked';
							}
						?>
						<input type="checkbox" name="sharing" <?php echo $check; ?>>
						<span class="customdesign-toggle-label" data-on="Yes" data-off="No"></span>
						<span class="customdesign-toggle-handle"></span>
					</div>
				</div>
			</div>
			<div class="customdesign_form_group">
				<span><?php echo $customdesign->lang('Active'); ?></span>
				<div class="customdesign_form_content">
					<div class="customdesign-toggle">
						<?php 
							$check = '';
							if (isset($data['active']) && $data['active'] == 1) {
								$check = 'checked';
							}
						?>
						<input type="checkbox" name="active" <?php echo $check; ?>>
						<span class="customdesign-toggle-label" data-on="Yes" data-off="No"></span>
						<span class="customdesign-toggle-handle"></span>
					</div>
				</div>
			</div>
			<div class="customdesign_form_group">
				<input type="hidden" name="id" value="<?php echo !empty($data['id']) ? $data['id'] : '' ?>"/>
				<input type="submit" class="customdesign-button customdesign-button-primary" value="<?php echo $customdesign->lang('Save Design'); ?>"/>
				<input type="hidden" name="save_design" value="true">
			</div>
			<?php $customdesign->securityFrom();?>
		</form>
	</div>
</div>
