<?php
	$title = "designs";
	$prefix = 'designs_';

	// Action Form
	if (isset($_POST['action_submit']) && !empty($_POST['action_submit'])) {

		$data_action = isset($_POST['action']) ? $_POST['action'] : '';
		$val = isset($_POST['id_action']) ? $_POST['id_action'] : '';
		$val = explode(',', $val);
		
		$customdesign_admin->check_caps('designs');
		
		foreach ($val as $value) {

			$dt = $customdesign_admin->get_row_id($value, $customdesign->db->prefix.'designs');
			switch ($data_action) {

				case 'active':
					$data = array(
						'active' => 1
					);
					$dt = $customdesign_admin->edit_row( $value, $data, 'customdesign_designs' );
					break;
				case 'deactive':
					$data = array(
						'active' => 0
					);
					$dt = $customdesign_admin->edit_row( $value, $data, 'customdesign_designs' );
					break;
				case 'delete':
					$tar_file = realpath($customdesign->cfg->upload_path).DS.'designs/';

					if (!empty($dt['upload'])) {
						if (file_exists($tar_file.$dt['upload'])) {
							unlink($tar_file.$dt['upload']);
						}
					}
					$customdesign_admin->delete_row($value, $customdesign->db->prefix.'designs');
					break;
				default:
					break;

			}

		}

	}

	// Search Form
	$data_search = '';
	if (isset($_POST['search_design']) && !empty($_POST['search_design'])) {

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
	$per_page = 5;
	if(isset($_SESSION[$prefix.'per_page']))
		$per_page = $_SESSION[$prefix.'per_page'];

	if (isset($_POST['per_page'])) {

		$data = isset($_POST['per_page']) ? $_POST['per_page'] : '';
		$_SESSION[$prefix.'per_page'] = $data;
		$per_page = $_SESSION[$prefix.'per_page'];

	}

    // Sort Form
	if (!empty($_POST['sortby'])) {

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
	$designs = $customdesign_admin->get_rows('designs', $search_filter, $orderby, $ordering, $per_page, $start);
	$total_record = $customdesign_admin->get_rows_total('designs');

    $config = array(
    	'current_page'  => $current_page,
		'total_record'  => $designs['total_count'],
		'total_page'    => $designs['total_page'],
 	    'limit'         => $per_page,
	    'link_full'     => $customdesign->cfg->admin_url.'customdesign-page=designs&tpage={page}',
	    'link_first'    => $customdesign->cfg->admin_url.'customdesign-page=designs',
	);

	$customdesign_pagination->init($config);

?>

<div class="customdesign_wrapper">

	<div class="customdesign_content">

		<div class="customdesign_header">
			<h2><?php echo $customdesign->lang('Designs'); ?></h2>
			<a href="<?php echo $customdesign->cfg->admin_url;?>customdesign-page=design" class="add-new customdesign-button"><?php echo $customdesign->lang('Add New Design'); ?></a>
			<?php
				$customdesign_page = isset($_GET['customdesign-page']) ? $_GET['customdesign-page'] : '';
				echo $customdesign_helper->breadcrumb($customdesign_page);
			?>
		</div>

	

		<div class="customdesign_option">
			<div class="left">
				<form action="<?php echo $customdesign->cfg->admin_url;?>customdesign-page=designs" method="post">
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
				<form action="<?php echo $customdesign->cfg->admin_url;?>customdesign-page=designs" method="post">
					<select name="per_page" class="art_per_page">
						<?php
							$per_pages = array('5', '10', '15', '20', '100');

							foreach($per_pages as $val) {

							    if($val == $per_page) {
							        echo '<option selected="selected">'.$val.'</option>';
							    } else {
							        echo '<option>'.$val.'</option>';
							    }

							}
						?>
					</select>
					<input  class="customdesign_submit" type="submit" name="submit" value="<?php echo $customdesign->lang('Per Page'); ?>">
					<?php $customdesign->securityFrom();?>
				</form>
				<form action="<?php echo $customdesign->cfg->admin_url;?>customdesign-page=designs" method="post">
					<select name="sort" class="art_per_page">
						<option value="name_asc" <?php if ($dt_order == 'name_asc' ) echo 'selected' ; ?> ><?php echo $customdesign->lang('Name'); ?> A-Z</option>
						<option value="name_desc" <?php if ($dt_order == 'name_desc' ) echo 'selected' ; ?> ><?php echo $customdesign->lang('Name'); ?> Z-A</option>
					</select>
					<input  class="customdesign_submit" type="submit" name="sortby" value="<?php echo $customdesign->lang('Sortby'); ?>">
					<?php $customdesign->securityFrom();?>
				</form>
			</div>
			<div class="right">
				<form action="<?php echo $customdesign->cfg->admin_url;?>customdesign-page=designs" method="post">
					<input type="text" name="search" class="search" placeholder="<?php echo $customdesign->lang('Search ...'); ?>" value="<?php if(isset($_SESSION[$prefix.'data_search'])) echo $_SESSION[$prefix.'data_search']; ?>">
					<input  class="customdesign_submit" type="submit" name="search_design" value="<?php echo $customdesign->lang('Search'); ?>">
					<?php $customdesign->securityFrom();?>

				</form>
			</div>
		</div>
		<?php if ( isset($designs['total_count']) && $designs['total_count'] > 0) { ?>
			<div class="customdesign_wrap_table">
				<table class="customdesign_table customdesign_designs">
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
							<th><?php echo $customdesign->lang('Sharing'); ?></th>
							<th><?php echo $customdesign->lang('Status'); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php

							if ( is_array($designs['rows']) && count($designs['rows']) > 0 ) {

								foreach ($designs['rows'] as $value) { ?>

									<tr>
										<td class="customdesign_check">
											<div class="customdesign_checkbox">
												<input type="checkbox" name="checked[]" class="action_check" value="<?php if(isset($value['id'])) echo $value['id']; ?>" class="action" id="<?php if(isset($value['id'])) echo $value['id']; ?>">
												<label for="<?php if(isset($value['id'])) echo $value['id']; ?>"><em class="check"></em></label>
											</div>
										</td>
										<td><a href="<?php echo $customdesign->cfg->admin_url;?>customdesign-page=design&id=<?php if(isset($value['id'])) echo $value['id']; ?>" class="name"><?php if(isset($value['name'])) echo $value['name']; ?></a></td>
										<td><?php if(isset($value['screenshot'])) echo $value['screenshot']; ?></td>
										<td>
											<?php
												if (isset($value['sharing'])) {
													if ($value['sharing'] == 1) {
														echo '<em class="pub">'.$customdesign->lang('sharing').'</em>';
													} else {
														echo '<em class="un pub">'.$customdesign->lang('not-sharing').'</em>';
													}
												}
											?>
										</td>
										<td>
											<?php
												if (isset($value['active'])) {
													if ($value['active'] == 1) {
														echo '<em class="pub">'.$customdesign->lang('active').'</em>';
													} else {
														echo '<em class="un pub">'.$customdesign->lang('deactive').'</em>';
													}
												}
											?>
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
						echo '<a href="'.$customdesign->cfg->admin_url.'customdesign-page=designs" class="btn-back"><i class="fa fa-reply" aria-hidden="true"></i>'.$customdesign->lang('Back To Lists').'</a>';
					}
					else
						echo '<p class="no-data">'.$customdesign->lang('No data. Please add design.').'</p>';
			}?>

	</div>

</div>
