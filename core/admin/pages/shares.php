<?php

	$title = "Shares";
	$prefix = 'share_';

	// Action Form
	if (isset($_POST['action_submit']) && !empty($_POST['action_submit'])) {

		$data_action = isset($_POST['action']) ? $_POST['action'] : '';
		$val = isset($_POST['id_action']) ? $_POST['id_action'] : '';
		$id = isset($_POST['id']) ? $_POST['id'] : '';
		$val = explode(',', $val);

		if (!empty($id)) {
			$dt = $customdesign_admin->get_row_id($id, 'shares');
			$tar_file = $customdesign->cfg->upload_path.'shares/'.date('Y/m/', strtotime($dt['created'])).$dt['share_id'];
			if (!empty($dt['share_id'])) {
				if (file_exists($tar_file.'.jpg'))
					unlink($tar_file.'.jpg');
				if (file_exists($tar_file.'.lumi'))
					unlink($tar_file.'.lumi');
			}
			$customdesign_admin->delete_row($id, 'shares');
		}

		foreach ($val as $value) {

			$dt = $customdesign_admin->get_row_id($value, 'shares');
			switch ($data_action) {

				case 'active':
					$data = array(
						'active' => 1
					);
					$dt = $customdesign_admin->edit_row( $value, $data, 'shares' );
					break;
				case 'deactive':
					$data = array(
						'active' => 0
					);
					$dt = $customdesign_admin->edit_row( $value, $data, 'shares' );
					break;
				case 'delete':
					$tar_file = $customdesign->cfg->upload_path.'shares/'.date('Y/m/', strtotime($dt['created'])).$dt['share_id'];
					if (!empty($dt['share_id'])) {
						if (file_exists($tar_file.'.jpg'))
							unlink($tar_file.'.jpg');
						if (file_exists($tar_file.'.lumi'))
							unlink($tar_file.'.lumi');
					}
					$customdesign_admin->delete_row($value, 'shares');
					break;
				default:
					break;

			}

		}

	}

	// Search Form
	$data_search = '';
	if (isset($_POST['search_share']) && !empty($_POST['search_share'])) {

		$data_search = isset($_POST['search']) ? trim($_POST['search']) : '';

		if (empty($data_search)) {
			$errors = 'Please Insert Key Word';
			$_SESSION[$prefix.'data_search'] = '';
		} else {
			$_SESSION[$prefix.'data_search'] = 	$data_search;
		}

	}

	if (!empty($_SESSION[$prefix.'data_search'])) {
		$data_search = '%'.$_SESSION[$prefix.'data_search'].'%';
	}

	// Pagination
	$per_page = 20;
	if(isset($_SESSION[$prefix.'per_page']))
		$per_page = $_SESSION[$prefix.'per_page'];

	if (isset($_POST['per_page'])) {

		$data = isset($_POST['per_page']) ? $_POST['per_page'] : '';
	
		if ($data != 'none') {
			$_SESSION[$prefix.'per_page'] = $data;
			$per_page = $_SESSION[$prefix.'per_page'];
		} else {
			$_SESSION[$prefix.'per_page'] = 20;
			$per_page = $_SESSION[$prefix.'per_page'];
		}

	}

    // Sort Form
	if (!empty($_POST['sort'])) {

		$dt_sort = isset($_POST['sort']) ? $_POST['sort'] : '';
		$_SESSION[$prefix.'dt_order'] = $dt_sort;

		switch ($dt_sort) {

			case 'name_asc':
				$_SESSION[$prefix.'orderby'] = 'name';
				$_SESSION[$prefix.'ordering'] = 'asc';
				break;
			case 'name_desc':
				$_SESSION[$prefix.'orderby'] = 'name';
				$_SESSION[$prefix.'ordering'] = 'desc';
				break;
			default:
				break;

		}

	}

	$orderby  = (isset($_SESSION[$prefix.'orderby']) && !empty($_SESSION[$prefix.'orderby'])) ? $_SESSION[$prefix.'orderby'] : 'name';
	$ordering = (isset($_SESSION[$prefix.'ordering']) && !empty($_SESSION[$prefix.'ordering'])) ? $_SESSION[$prefix.'ordering'] : 'asc';
	$dt_order = isset($_SESSION[$prefix.'dt_order']) ? $_SESSION[$prefix.'dt_order'] : 'name_asc';

	// Get row pagination
    $current_page = isset($_GET['tpage']) ? $_GET['tpage'] : 1;
    $search_filter = array(
        'keyword' => $data_search,
        'fields' => 'name'
    );

    $start = ( $current_page - 1 ) *  $per_page;
	$shares = $customdesign_admin->get_rows('shares', $search_filter, $orderby, $ordering, $per_page, $start);
	$total_record = $customdesign_admin->get_rows_total('shares');

    $config = array(
    	'current_page'  => $current_page,
		'total_record'  => $shares['total_count'],
		'total_page'    => $shares['total_page'],
 	    'limit'         => $per_page,
	    'link_full'     => $customdesign->cfg->admin_url.'customdesign-page=shares&tpage={page}',
	    'link_first'    => $customdesign->cfg->admin_url.'customdesign-page=shares',
	);

	$customdesign_pagination->init($config);

?>

<div class="customdesign_wrapper">

	<div class="customdesign_content">

		<div class="customdesign_header">
			<h2><?php echo $customdesign->lang('shares'); ?></h2>
		</div>

		<?php if ( isset($shares['total_count']) && $shares['total_count'] > 0) { ?>

			<div class="customdesign_option">
				<div class="left">
					<form action="<?php echo $customdesign->cfg->admin_url;?>customdesign-page=shares" method="post">
						<select name="action" class="art_per_page">
							<option value="none"><?php echo $customdesign->lang('Bulk Actions'); ?></option>
							<option value="active"><?php echo $customdesign->lang('Active'); ?></option>
							<option value="deactive"><?php echo $customdesign->lang('Deactive'); ?></option>
							<option value="delete"><?php echo $customdesign->lang('Delete'); ?></option>
						</select>
						<input type="hidden" name="id_action" class="id_action">
						<input  class="customdesign_submit" type="submit" name="action_submit" value="<?php echo $customdesign->lang('Apply'); ?>">
						<?php $customdesign->securityFrom();?>
					</form>
					<form action="<?php echo $customdesign->cfg->admin_url;?>customdesign-page=shares" method="post">
						<select name="per_page" class="art_per_page" data-action="submit">
							<option value="none">-- <?php echo $customdesign->lang('Per page'); ?> --</option>
							<?php
								$per_pages = array('20', '50', '100', '200');

								foreach($per_pages as $val) {

								    if($val == $per_page) {
								        echo '<option selected="selected">'.$val.'</option>';
								    } else {
								        echo '<option>'.$val.'</option>';
								    }

								}
							?>
						</select>
						<?php $customdesign->securityFrom();?>
					</form>
					<form action="<?php echo $customdesign->cfg->admin_url;?>customdesign-page=shares" method="post">
						<select name="sort" class="art_per_page" data-action="submit">
							<option value="">-- <?php echo $customdesign->lang('Sort by'); ?> --</option>
							<option value="name_asc" <?php if ($dt_order == 'name_asc' ) echo 'selected' ; ?> ><?php echo $customdesign->lang('Name'); ?> A-Z</option>
							<option value="name_desc" <?php if ($dt_order == 'name_desc' ) echo 'selected' ; ?> ><?php echo $customdesign->lang('Name'); ?> Z-A</option>
						</select>
						<?php $customdesign->securityFrom();?>
					</form>
				</div>
				<div class="right">
					<form action="<?php echo $customdesign->cfg->admin_url;?>customdesign-page=shares" method="post">
						<input type="search" name="search" class="search" placeholder="<?php echo $customdesign->lang('Search ...'); ?>" value="<?php if(isset($_SESSION[$prefix.'data_search'])) echo $_SESSION[$prefix.'data_search']; ?>">
						<input  class="customdesign_submit" type="submit" name="search_share" value="<?php echo $customdesign->lang('Search'); ?>">
						<?php $customdesign->securityFrom();?>

					</form>
				</div>
			</div>
			<div class="customdesign_wrap_table">
				<table class="customdesign_table customdesign_shares">
					<thead>
						<tr>
							<th class="customdesign_check">
								<div class="customdesign_checkbox">
									<input type="checkbox" id="check_all">
									<label for="check_all"><em class="check"></em></label>
								</div>
							</th>
							<th><?php echo $customdesign->lang('Name'); ?></th>
							<th><?php echo $customdesign->lang('Screenshot'); ?></th>
							<th><?php echo $customdesign->lang('View'); ?></th>
							<th><?php echo $customdesign->lang('Status'); ?></th>
							<th><?php echo $customdesign->lang('Action'); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php

							if ( is_array($shares['rows']) && count($shares['rows']) > 0 ) {

								foreach ($shares['rows'] as $value) { ?>

									<tr>
										<td class="customdesign_check">
											<div class="customdesign_checkbox">
												<input type="checkbox" name="checked[]" class="action_check" value="<?php if(isset($value['id'])) echo $value['id']; ?>" class="action" id="<?php if(isset($value['id'])) echo $value['id']; ?>">
												<label for="<?php if(isset($value['id'])) echo $value['id']; ?>"><em class="check"></em></label>
											</div>
										</td>
										<td>
											<a href="<?php
												$link = $customdesign->cfg->tool_url.(strpos($customdesign->cfg->tool_url, '?') === false ? '?' : '&').'product_base='.$value['product'].(!empty($value['product_cms']) ? '&product_cms='.$value['product_cms'] : '').'&share='.$value['share_id'];
												echo str_replace('?&', '?', $link);
												
											?>" target="_blank" title="<?php echo $customdesign->lang('View this share design'); ?>">
												<?php if(isset($value['name'])) echo $value['name']; ?>
											</a>
										</td>
										<td><?php
											echo '<img src="'.$customdesign->cfg->upload_url.'shares/'.date('Y/m/', strtotime($value['created'])).$value['share_id'].'.jpg" height="150" />';
										?></td>
										<td><?php if(isset($value['view'])) echo $value['view']; ?></td>
										<td>
											<a href="#" class="customdesign_action" data-type="shares" data-action="switch_active" data-status="<?php echo (isset($value['active']) ? $value['active'] : '0'); ?>" data-id="<?php if(isset($value['id'])) echo $value['id'] ?>">
												<?php
													if (isset($value['active'])) {
														if ($value['active'] == 1) {
															echo '<em class="pub">'.$customdesign->lang('active').'</em>';
														} else {
															echo '<em class="un pub">'.$customdesign->lang('deactive').'</em>';
														}
													}
												?>
											</a>
										</td>
										<td>
											<a href="#" class="customdesign-item-action" data-item="<?php echo $value['id'];?>" data-func="delete"><?php echo $customdesign->lang('Delete'); ?></a>
										</td>
									</tr>

								<?php }

							}

						?>
					</tbody>
				</table>
			</div>
			<div class="customdesign_pagination"><?php echo $customdesign_pagination->pagination_html(); ?></div>

		<?php } else {
					if (isset($total_record) && $total_record > 0) {
						echo '<p class="no-data">'.$customdesign->lang('Apologies, but no results were found.').'</p>';
						$_SESSION[$prefix.'data_search'] = '';
						echo '<a href="'.$customdesign->cfg->admin_url.'customdesign-page=shares" class="btn-back"><i class="fa fa-reply" aria-hidden="true"></i>'.$customdesign->lang('Back To Lists').'</a>';
					}
					else
						echo '<p class="no-data">'.$customdesign->lang('No data. Please add share.').'</p>';
			}?>

	</div>

</div>
