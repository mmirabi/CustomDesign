<?php

	$title = "Categories list";
	$prefix = 'categories_';
	
	// Search Form
	$type = isset($_GET['type']) ? $_GET['type'] : 'cliparts';
	$data_search = '';
	if (isset($_POST['search_cate']) && !empty($_POST['search_cate'])) {

		$data_search = isset($_POST['search']) ? trim($_POST['search']) : '';

		if (empty($data_search)) {
			$_SESSION[$prefix.$type.'data_search'] = '';
		} else {
			$_SESSION[$prefix.$type.'data_search'] = $data_search;
		}

	}

	if (!empty($_SESSION[$prefix.$type.'data_search'])) {
		$data_search = '%'.$_SESSION[$prefix.$type.'data_search'].'%';
	}

	// Action Form
	if (isset($_POST['action_submit']) && !empty($_POST['action_submit'])) {

		$data_action = isset($_POST['action']) ? $_POST['action'] : '';
		$val = isset($_POST['id_action']) ? $_POST['id_action'] : '';
		$val = explode(',', $val);
		
		$customdesign_admin->check_caps('categories');
		
		foreach ($val as $value) {

			switch ($data_action) {

				case 'active':
					$data = array(
						'active' => 1
					);
					$dt = $customdesign_admin->edit_row( $value, $data, 'categories' );
					break;
				case 'deactive':
					$data = array(
						'active' => 0
					);
					$dt = $customdesign_admin->edit_row( $value, $data, 'categories' );
					break;
				case 'delete':

					$dt = $customdesign_admin->get_row_id($value, 'categories');
					$arr = array("id", "parent");
					$dts = $customdesign_admin->get_rows_custom($arr, 'categories');
					$arr = array("id","category_id");
					$cate_reference = $customdesign_admin->get_rows_custom($arr, 'categories_reference', $orderby = 'id', $order='asc');

					foreach ($cate_reference as $vals) {
						if ($vals['category_id'] == $value) {
							$customdesign_admin->delete_row($vals['id'], 'categories_reference');
						}
					}

					foreach ($dts as $val) {

						if ($val['parent'] == $dt['id']) {
							$val['parent'] = $dt['parent'];
							$customdesign_admin->edit_row($val['id'], $val, 'categories');
						}

					}

					$tar_file = realpath($customdesign->cfg->upload_path).DS;
					if (!empty($dt['upload'])) {
						if (file_exists($tar_file.$dt['upload'])) {
							unlink($tar_file.$dt['upload']);
							unlink(str_replace(array($customdesign->cfg->upload_url, '/'), array($customdesign->cfg->upload_path, TS), $dt['thumbnail_url']));
						}
					}

					$customdesign_admin->delete_row($value, 'categories');

					break;
				default:
					break;

			}

		}

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

	// Sortby
	if (!empty($_POST['sort'])) {

		$dt_sort = isset($_POST['sort']) ? $_POST['sort'] : '';
		$_SESSION[$prefix.$type.'dt_order'] = $dt_sort;

		switch ($dt_sort) {

			case 'name_asc':
				$_SESSION[$prefix.$type.'orderby'] = 'name';
				$_SESSION[$prefix.$type.'ordering'] = 'asc';
				break;
			case 'name_desc':
				$_SESSION[$prefix.$type.'orderby'] = 'name';
				$_SESSION[$prefix.$type.'ordering'] = 'desc';
				break;

		}

	}

	$orderby  = (isset($_SESSION[$prefix.$type.'orderby']) && !empty($_SESSION[$prefix.$type.'orderby'])) ? $_SESSION[$prefix.$type.'orderby'] : 'name';
	$ordering = (isset($_SESSION[$prefix.$type.'ordering']) && !empty($_SESSION[$prefix.$type.'ordering'])) ? $_SESSION[$prefix.$type.'ordering'] : 'asc';
	$dt_order = isset($_SESSION[$prefix.$type.'dt_order']) ? $_SESSION[$prefix.$type.'dt_order'] : 'name_asc';

	// Get row pagination
    $current_page = isset($_GET['tpage']) ? $_GET['tpage'] : 1;
    $search_filter = array(
        'keyword' => $data_search,
        'fields' => 'name'
    );

    $default_filter = array(
    	'type' => $type,
    );

    $start = ( $current_page - 1 ) * $per_page;
	$cate = $customdesign_admin->get_rows('categories', $search_filter, $orderby, $ordering, null, null, null, $type);
	$total_record = $customdesign_admin->get_rows_total('categories', $type, 'type');
    $cate['total_page'] = ceil($cate['total_count'] / $per_page);

    $config = array(
    	'current_page'  => $current_page,
		'total_record'  => $cate['total_count'],
		'total_page'    => $cate['total_page'],
 	    'limit'         => $per_page,
	    'link_full'     => $customdesign->cfg->admin_url.'customdesign-page=categories&type='.$type.'&tpage={page}',
	    'link_first'    => $customdesign->cfg->admin_url.'customdesign-page=categories&type='.$type,
	);

	$customdesign_pagination->init($config);

?>

<div class="customdesign_wrapper">
	<div class="customdesign_content">

		<div class="customdesign_header">
			<h2><?php echo $customdesign->lang('Categories'); ?></h2>
			<a href="<?php echo $customdesign->cfg->admin_url;?>customdesign-page=category&type=<?php echo $type; ?>" class="add-new customdesign-button">
				<i class="fa fa-plus"></i> 
				<?php echo $customdesign->lang('Add new category'); ?>
			</a>
			<?php
				$customdesign_page = isset($_GET['customdesign-page']) ? $_GET['customdesign-page'] : '';
				$type = isset($_GET['type']) ? $_GET['type'] : '';
				echo $customdesign_helper->breadcrumb($customdesign_page,$type);
			?>
		</div>
		<div class="customdesign_option">
			<div class="left">
				<form action="<?php echo $customdesign->cfg->admin_url;?>customdesign-page=categories&type=<?php echo $type ?>" method="post">
					<select name="action" class="art_per_page">
						<option value="none"><?php echo $customdesign->lang('Bulk Actions'); ?></option>
						<option value="active"><?php echo $customdesign->lang('Active'); ?></option>
						<option value="deactive"><?php echo $customdesign->lang('Deactive'); ?></option>
						<option value="delete"><?php echo $customdesign->lang('Delete'); ?></option>
					</select>
					<input type="hidden" name="id_action" class="id_action">
					<input type="hidden" name="do" value="action" />
					<input type="submit" class="customdesign_submit" name="action_submit" value="<?php echo $customdesign->lang('Apply'); ?>" />
					<?php $customdesign->securityFrom();?>
				</form>
				<form class="less" action="<?php echo $customdesign->cfg->admin_url;?>customdesign-page=categories&type=<?php echo $type ?>" method="post">
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
				<form class="less" action="<?php echo $customdesign->cfg->admin_url;?>customdesign-page=categories&type=<?php echo $type ?>" method="post">
					<select name="sort" class="art_per_page" data-action="submit">
						<option value="">-- <?php echo $customdesign->lang('Sort by'); ?> --</option>
						<option value="name_asc" <?php if ($dt_order == 'name_asc' ) echo 'selected' ; ?> ><?php echo $customdesign->lang('Name'); ?> A-Z</option>
						<option value="name_desc" <?php if ($dt_order == 'name_desc' ) echo 'selected' ; ?> ><?php echo $customdesign->lang('Name'); ?> Z-A</option>
					</select>
					<?php $customdesign->securityFrom();?>
				</form>
			</div>
			<div class="right">
				<form action="<?php echo $customdesign->cfg->admin_url;?>customdesign-page=categories&type=<?php echo $type ?>" method="post">
					<input class="search" type="search" name="search" class="form-control form_search" placeholder="Search ..." value="<?php if(isset($_SESSION[$prefix.$type.'data_search'])) echo $_SESSION[$prefix.$type.'data_search']; ?>">
					<input class="customdesign_submit" type="submit" name="search_cate" value="<?php echo $customdesign->lang('Search'); ?>">
					<?php $customdesign->securityFrom();?>
				</form>
			</div>
		</div>
		<?php if ( isset($cate['total_count']) && $cate['total_count'] > 0) { ?>
			<div class="customdesign_wrap_table">
				<table class="customdesign_table customdesign_categories">
					<thead>
						<tr>
							<th class="customdesign_check">
								<div class="customdesign_checkbox">
									<input type="checkbox" id="check_all">
									<label for="check_all"><em class="check"></em></label>
								</div>
							</th>
							<th width="40%"><?php echo $customdesign->lang('Name'); ?></th>
							<th><?php echo $customdesign->lang('Thumbnail'); ?></th>
							<th><?php echo $customdesign->lang('Status'); ?></th>
							<th><?php echo $customdesign->lang('Ordering'); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php

							if (empty($data_search)) {

								$cate = $customdesign_admin->get_categories_parent($cate['rows']);
								$start = ($current_page - 1) * $per_page;

								for ($i = $start; $i < $start + $per_page; $i++) {
									if(!isset($cate[$i]))
										break; ?>

									<tr>
										<td class="customdesign_check">
											<div class="customdesign_checkbox">
												<input type="checkbox" name="checked[]" class="action_check" value="<?php if(isset($cate[$i]['id'])) echo $cate[$i]['id']; ?>" class="action" id="<?php if(isset($cate[$i]['id'])) echo $cate[$i]['id']; ?>">
												<label for="<?php if(isset($cate[$i]['id'])) echo $cate[$i]['id']; ?>"><em class="check"></em></label>
											</div>
										</td>
										<td class="customdesign-resource-title">
											<a href="<?php echo $customdesign->cfg->admin_url;?>customdesign-page=category&type=<?php echo $type; ?>&id=<?php if(isset($cate[$i]['id'])) echo $cate[$i]['id']; ?>" class="name"><?php if(isset($cate[$i]['name'])) echo str_repeat('&mdash;', $cate[$i]['lv']).$cate[$i]['name']; ?></a>
											<span> - #<?php echo $cate[$i]['id'] ?></span>
										</td>
										<td>
										<?php
											if (isset($cate[$i]['thumbnail_url']) && !empty($cate[$i]['thumbnail_url'])) {
												echo '<img class="customdesign-thumbn" src="'.$cate[$i]['thumbnail_url'].'">' ;
											}
										?>
										</td>
										<td>
											<a href="#" class="customdesign_action" data-type="categories" data-action="switch_active" data-status="<?php echo (isset($cate[$i]['active']) ? $cate[$i]['active'] : '0'); ?>" data-id="<?php if(isset($cate[$i]['id'])) echo $cate[$i]['id'] ?>">
												<?php
													if (isset($cate[$i]['active'])) {
														if ($cate[$i]['active'] == 1) {
															echo '<em class="pub">'.$customdesign->lang('active').'</em>';
														} else {
															echo '<em class="un pub">'.$customdesign->lang('deactive').'</em>';
														}
													}
												?>
											</a>
										</td>
										<td width="1%"><?php echo $cate[$i]['order']; ?></td>
									</tr>

								<?php }

							} else {
								
								foreach ($cate['rows'] as $value) { ?>
									<tr>
										<td>
											<div class="customdesign_checkbox">
												<input type="checkbox" name="checked[]" class="action_check" value="<?php if(isset($value['id'])) echo $value['id']; ?>" class="action" id="<?php if(isset($value['id'])) echo $value['id']; ?>">
												<label for="<?php if(isset($value['id'])) echo $value['id']; ?>"><em class="check"></em></label>
											</div>
										</td>
										<td><a href="<?php echo $customdesign->cfg->admin_url;?>customdesign-page=category&id=<?php if(isset($value['id'])) echo $value['id']; ?>&type=<?php echo $type?>" class="name"><?php if(isset($value['name'])) echo $value['name']; ?></a></td>
										<td>
										<?php
											if (isset($value['thumbnail_url']) && !empty($value['thumbnail_url'])) {
												echo '<img src="'.$value['thumbnail_url'].'">' ;
											}
										?>
										</td>
										<td>
											<a href="#" class="customdesign_action" data-type="categories" data-action="switch_active" data-status="<?php echo (isset($value['active']) ? $value['active'] : '0'); ?>" data-id="<?php if(isset($value['id'])) echo $value['id'] ?>">
												<?php
													if (isset($value['active'])) {
														if ($value['active'] == 1)
															echo '<em class="pub">'.$customdesign->lang('active').'</em>';
														else
															echo '<em class="un pub">'.$customdesign->lang('deactive').'</em>';
													}
												?>
											</a>
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
						$type = isset($_GET['type']) ? $_GET['type'] : '$type';
						$_SESSION[$prefix.$type.'data_search'] = '';
						echo '<a href="'.$customdesign->cfg->admin_url.'customdesign-page=categories&type='.$type.'" class="btn-back"><i class="fa fa-reply" aria-hidden="true"></i>'.$customdesign->lang('Back To Lists').'</a>';
					}
					else
						echo '<p class="no-data">'.$customdesign->lang('No data. Please add category.').'</p>';
			} ?>

	</div>
</div>
