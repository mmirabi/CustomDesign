<?php

	$title = "Bugs";
	$prefix = 'bugs_';

	// Action Form
	if (isset($_POST['action_submit']) && !empty($_POST['action_submit'])) {

		$data_action = isset($_POST['action']) ? $_POST['action'] : '';
		$val = isset($_POST['id_action']) ? $_POST['id_action'] : '';
		$val = explode(',', $val);
		
		$customdesign_admin->check_caps('bugs');
		
		foreach ($val as $value) {

			$dt = $customdesign_admin->get_row_id($value, 'bugs');
			switch ($data_action) {

				case 'delete':
					$customdesign_admin->delete_row($value, 'bugs');
					break;
				default:
					break;

			}

		}

	}

	// Search Form
	$data_search = '';
	if (isset($_POST['search_bug']) && !empty($_POST['search_bug'])) {

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

			case 'created_asc':
				$_SESSION[$prefix.'orderby'] = 'created';
				$_SESSION[$prefix.'ordering'] = 'asc';
				break;
			case 'created_desc':
				$_SESSION[$prefix.'orderby'] = 'created';
				$_SESSION[$prefix.'ordering'] = 'desc';
				break;
			default:
				break;

		}

	}

	$orderby  = (isset($_SESSION[$prefix.'orderby']) && !empty($_SESSION[$prefix.'orderby'])) ? $_SESSION[$prefix.'orderby'] : 'created';
	$ordering = (isset($_SESSION[$prefix.'ordering']) && !empty($_SESSION[$prefix.'ordering'])) ? $_SESSION[$prefix.'ordering'] : 'asc';
	$dt_order = isset($_SESSION[$prefix.'dt_order']) ? $_SESSION[$prefix.'dt_order'] : 'created_asc';

	// Get row pagination
    $current_page = isset($_GET['tpage']) ? $_GET['tpage'] : 1;
    $search_filter = array(
        'keyword' => $data_search,
        'fields' => 'content,status'
    );

    $start = ( $current_page - 1 ) *  $per_page;
	$bugs = $customdesign_admin->get_rows('bugs', $search_filter, $orderby, $ordering, $per_page, $start);
	$total_record = $customdesign_admin->get_rows_total('bugs');

    $config = array(
    	'current_page'  => $current_page,
		'total_record'  => $bugs['total_count'],
		'total_page'    => $bugs['total_page'],
 	    'limit'         => $per_page,
	    'link_full'     => $customdesign->cfg->admin_url.'customdesign-page=bugs&tpage={page}',
	    'link_first'    => $customdesign->cfg->admin_url.'customdesign-page=bugs',
	);

	$customdesign_pagination->init($config);

?>

<div class="customdesign_wrapper">

	<div class="customdesign_content">

		<div class="customdesign_header">
			<h2><?php echo $customdesign->lang('bugs'); ?></h2>
			<a href="<?php echo $customdesign->cfg->admin_url;?>customdesign-page=bug" class="add-new customdesign-button">
				<i class="fa fa-plus"></i> 
				<?php echo $customdesign->lang('Add new bug'); ?>
			</a>
			<?php
				$customdesign_page = isset($_GET['customdesign-page']) ? $_GET['customdesign-page'] : '';
				echo $customdesign_helper->breadcrumb($customdesign_page);
			?>
		</div>

		<div class="customdesign_option">
			<div class="left">
				<form action="<?php echo $customdesign->cfg->admin_url;?>customdesign-page=bugs" method="post">
					<input type="hidden" name="id_action" class="id_action">
					<input type="hidden" name="action" value="delete" />
					<input  class="customdesign_submit" type="submit" name="action_submit" value="<?php echo $customdesign->lang('Delete'); ?>">
					<?php $customdesign->securityFrom();?>
				</form>
				<form action="<?php echo $customdesign->cfg->admin_url;?>customdesign-page=bugs" method="post">
					<select name="per_page" class="art_per_page" data-action="submit">
						<option value="none">-- <?php echo $customdesign->lang('Per page'); ?> --</option>
						<?php
							$per_pages = array('10', '25', '50', '100');

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
				<form action="<?php echo $customdesign->cfg->admin_url;?>customdesign-page=bugs" method="post">
					<select name="sort" class="art_per_page" data-action="submit">
						<option value="">-- <?php echo $customdesign->lang('Sort by'); ?> --</option>
						<option value="created_asc" <?php if ($dt_order == 'created_asc' ) echo 'selected' ; ?> ><?php echo $customdesign->lang('Created date'); ?> &uarr;</option>
						<option value="created_desc" <?php if ($dt_order == 'created_desc' ) echo 'selected' ; ?> ><?php echo $customdesign->lang('Created date'); ?> &darr;</option>
						<option value="upadted_asc" <?php if ($dt_order == 'upadted_asc' ) echo 'selected' ; ?> ><?php echo $customdesign->lang('Upadted date'); ?> &uarr;</option>
						<option value="upadted_desc" <?php if ($dt_order == 'upadted_desc' ) echo 'selected' ; ?> ><?php echo $customdesign->lang('Upadted date'); ?> &darr;</option>
					</select>
					<?php $customdesign->securityFrom();?>
				</form>
			</div>
			<div class="right">
				<form action="<?php echo $customdesign->cfg->admin_url;?>customdesign-page=bugs" method="post">
					<input type="search" name="search" class="search" placeholder="<?php echo $customdesign->lang('Search ...'); ?>" value="<?php if(isset($_SESSION[$prefix.'data_search'])) echo $_SESSION[$prefix.'data_search']; ?>">
					<input  class="customdesign_submit" type="submit" name="search_bug" value="<?php echo $customdesign->lang('Search'); ?>">
					<?php $customdesign->securityFrom();?>

				</form>
			</div>
		</div>
		<?php if ( isset($bugs['total_count']) && $bugs['total_count'] > 0) { ?>
			<div class="customdesign_wrap_table">
				<table class="customdesign_table customdesign_bugs">
					<thead>
						<tr>
							<th class="customdesign_check">
								<div class="customdesign_checkbox">
									<input type="checkbox" id="check_all">
									<label for="check_all"><em class="check"></em></label>
								</div>
							</th>
							<th><?php echo $customdesign->lang('Content'); ?></th>
							<th><?php echo $customdesign->lang('Report to Customdesign'); ?></th>
							<th><?php echo $customdesign->lang('Status'); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php

							if ( is_array($bugs['rows']) && count($bugs['rows']) > 0 ) {

								foreach ($bugs['rows'] as $value) { ?>

									<tr>
										<td class="customdesign_check">
											<div class="customdesign_checkbox">
												<input type="checkbox" name="checked[]" class="action_check" value="<?php if(isset($value['id'])) echo $value['id']; ?>" class="action" id="<?php if(isset($value['id'])) echo $value['id']; ?>">
												<label for="<?php if(isset($value['id'])) echo $value['id']; ?>"><em class="check"></em></label>
											</div>
										</td>
										<td>
											<a href="<?php echo $customdesign->cfg->admin_url;?>customdesign-page=bug&id=<?php if(isset($value['id'])) echo $value['id'] ?>" class="name"><?php 
												if(isset($value['content'])) 
													echo substr($value['content'], 0, 50); 
												?>
											</a>
										</td>
										<td><?php 
											if($value['customdesign'] != 1) {
												echo '<a href="#report-bug" data-id="'.$value['id'].'" title="'.$customdesign->lang('Report this bug to MagicRugs.com').'" class="send_customdesign">'.$customdesign->lang('Send now').'</a>';
											}else echo $customdesign->lang('Sent!');
										?></td>
										<td>
											<?php
												if (isset($value['status'])) {
													if ($value['status'] == 'new')
														echo '<em class="new pub">'.$customdesign->lang('new').'</em>';
													if ($value['status'] == 'pending')
														echo '<em class="pen pub">'.$customdesign->lang('pending').'</em>';
													if ($value['status'] == 'fixed')
														echo '<em class="pub">'.$customdesign->lang('fixed').'</em>';
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
						echo '<a href="'.$customdesign->cfg->admin_url.'customdesign-page=bugs" class="btn-back"><i class="fa fa-reply" aria-hidden="true"></i>'.$customdesign->lang('Back To Lists').'</a>';
					}
					else
						echo '<p class="no-data">'.$customdesign->lang('No data. Please add bug.').'</p>';
			}?>

	</div>

</div>
