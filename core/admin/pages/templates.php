<?php
	$title = "templates";
	$prefix = 'templates_';
	$currency = isset($magic->cfg->settings['currency']) ? $magic->cfg->settings['currency'] : '';

	// Action Form
	if (isset($_POST['action_submit']) && !empty($_POST['action_submit'])) {

		$data_action = isset($_POST['action']) ? $_POST['action'] : '';
		$val = isset($_POST['id_action']) ? $_POST['id_action'] : '';
		$val = explode(',', $val);
		
		$magic_admin->check_caps('templates');

		foreach ($val as $value) {

			$dt = $magic_admin->get_row_id($value, 'templates');
			
			switch ($data_action) {

				case 'active':
					$data = array(
						'active' => 1
					);
					$dt = $magic_admin->edit_row( $value, $data, 'templates' );
					break;
				case 'deactive':
					$data = array(
						'active' => 0
					);
					$dt = $magic_admin->edit_row( $value, $data, 'templates' );
					break;
				case 'delete':

					$arr = array("id","item_id");
					$cate_reference = $magic_admin->get_rows_custom($arr, 'categories_reference', $orderby = 'id', $order='asc');

					foreach ($cate_reference as $vals) {
						if ($vals['item_id'] == $value) {
							$magic_admin->delete_row($vals['id'], 'categories_reference');
						}
					}

					$arr = array("id","item_id");
					$tag_reference = $magic_admin->get_rows_custom($arr, 'tags_reference', $orderby = 'id', $order='asc');

					foreach ($tag_reference as $vals) {
						if ($vals['item_id'] == $value) {
							$magic_admin->delete_row($vals['id'], 'tags_reference');
						}
					}

					$tar_file = realpath($magic->cfg->upload_path).DS;
					if (!empty($dt['upload'])) {
						if (file_exists($tar_file.$dt['upload'])) {
							@unlink($tar_file.$dt['upload']);
							@unlink(str_replace(array($magic->cfg->upload_url, '/'), array($magic->cfg->upload_path, DS), $dt['screenshot']));
						}
					}
					
					$magic_admin->delete_row($value, 'templates');

					break;
				default:
					break;

			}

		}

	}

	// Search Form
	$data_search = '';
	if (isset($_POST['search_template']) && !empty($_POST['search_template'])) {
		
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
	
	if (isset($_POST['categories'])) {
		$_SESSION[$prefix.'category'] = $_POST['categories'];
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
	
	// Process Featured
	if (isset($_POST['featured_status']) && isset($_POST['featured_id'])) {

		$data = array();
		if ($_POST['featured_status'] == 'unfeatured') {
			$data['featured'] = 0;
		} else {
			$data['featured'] = 1;
		}
		$magic_admin->edit_row( $_POST['featured_id'], $data, 'templates' );

	}
	
	$default_filter = array();
	
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
			case 'created_asc':
				$_SESSION[$prefix.'orderby'] = 'created';
				$_SESSION[$prefix.'ordering'] = 'asc';
				break;
			case 'created_desc':
				$_SESSION[$prefix.'orderby'] = 'created';
				$_SESSION[$prefix.'ordering'] = 'desc';
				break;
			case 'featured':
			case 'active':
			case 'deactive':
				$_SESSION[$prefix.'orderby'] = '';
				$_SESSION[$prefix.'ordering'] = '';
				break;
			default:
				break;

		}

	}
	
	$orderby  = (isset($_SESSION[$prefix.'orderby']) && !empty($_SESSION[$prefix.'orderby'])) ? $_SESSION[$prefix.'orderby'] : 'created';
	$ordering = (isset($_SESSION[$prefix.'ordering']) && !empty($_SESSION[$prefix.'ordering'])) ? $_SESSION[$prefix.'ordering'] : 'desc';
	$dt_order = isset($_SESSION[$prefix.'dt_order']) ? $_SESSION[$prefix.'dt_order'] : 'created_desc';
	$dt_category = isset($_SESSION[$prefix.'category']) ? $_SESSION[$prefix.'category'] : '';
	
	// Get row pagination
    $current_page = isset($_GET['tpage']) ? $_GET['tpage'] : 1;

    $where = array("tmpl.author = '{$magic->vendor_id}'");

    if (!empty($data_search))
	    array_push($where, "(tmpl.name LIKE '$data_search' OR tmpl.tags LIKE '$data_search')");
    if (!empty($dt_category))
	    array_push($where, "cate.category_id = '$dt_category'");
	if ($dt_order == 'featured')
		array_push($where, "tmpl.featured = '1'");
	else if ($dt_order == 'active')
		array_push($where, "tmpl.active = '1'");
	else if ($dt_order == 'deactive')
		array_push($where, "tmpl.active <> '1'");
	
    $select = "SELECT SQL_CALC_FOUND_ROWS tmpl.* FROM {$magic->db->prefix}templates tmpl ";

    $query = array(
		($dt_category !== '') ? "LEFT JOIN {$magic->db->prefix}categories_reference cate ON cate.item_id = tmpl.id" : '',
		count($where) > 0 ? "WHERE ".implode(' AND ', $where) : "",
		"GROUP BY tmpl.id"
    );
    
    $start = ( $current_page - 1 ) *  $per_page;
    array_push($query, "ORDER BY ".$orderby." ".$ordering);
	array_push($query, "LIMIT ".$start.",".$per_page);
	
	$templates = $magic->db->rawQuery($select.implode(' ', $query));
	$total = $magic->db->rawQuery("SELECT FOUND_ROWS() AS count");
        
    if (count($total) > 0 && isset($total[0]['count'])) {
		$total = $total[0]['count'];
	} else $total = 0;
    
    $config = array(
    	'current_page'  => $current_page,
		'total_record'  => $total,
		'total_page'    => ceil($total/$per_page),
 	    'limit'         => $per_page,
	    'link_full'     => $magic->cfg->admin_url.'magic-page=templates&tpage={page}',
	    'link_first'    => $magic->cfg->admin_url.'magic-page=templates',
	);

	$magic_pagination->init($config);
	
?>

<div class="magic_wrapper">

	<div class="magic_content">

		<div class="magic_header">
			<h2><?php echo $magic->lang('Design templates'); ?></h2>
			<a href="<?php echo $magic->cfg->admin_url;?>magic-page=template" class="add-new magic-button">
				<i class="fa fa-plus"></i> 
				<?php echo $magic->lang('Add new template'); ?></a>
			<?php
				$magic_page = isset($_GET['magic-page']) ? $_GET['magic-page'] : '';
				echo $magic_helper->breadcrumb($magic_page);
			?>
		</div>

			<div class="magic_option">
				<div class="left">
					<form action="<?php echo $magic->cfg->admin_url;?>magic-page=templates" method="post">
						<select name="action" class="art_per_page">
							<option value="none"><?php echo $magic->lang('Bulk Actions'); ?></option>
							<option value="active"><?php echo $magic->lang('Active'); ?></option>
							<option value="deactive"><?php echo $magic->lang('Deactive'); ?></option>
							<option value="delete"><?php echo $magic->lang('Delete'); ?></option>
						</select>
						<input type="hidden" name="id_action" class="id_action">
						<input  class="magic_submit" type="submit" name="action_submit" value="<?php echo $magic->lang('Apply'); ?>">
						<?php $magic->securityFrom();?>
					</form>
					<form action="<?php echo $magic->cfg->admin_url;?>magic-page=templates" method="post" class="less">
						<select name="per_page" data-action="submit" class="art_per_page">
							<option value="none">-- <?php echo $magic->lang('Per page'); ?> --</option>
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
						<?php $magic->securityFrom();?>
					</form>
					<form action="<?php echo $magic->cfg->admin_url;?>magic-page=templates" method="post" class="less">
						<select name="sort" data-action="submit" class="art_per_page">
							<option value="created_desc">-- <?php echo $magic->lang('Sort by'); ?> --</option>
							<option value="featured" <?php if ($dt_order == 'featured' ) echo 'selected' ; ?> ><?php echo $magic->lang('Featured only'); ?> </option>
							<option value="active" <?php if ($dt_order == 'active' ) echo 'selected' ; ?> ><?php echo $magic->lang('Active only'); ?> </option>
							<option value="deactive" <?php if ($dt_order == 'deactive' ) echo 'selected' ; ?> ><?php echo $magic->lang('Deactive only'); ?> </option>
							<option value="name_asc" <?php if ($dt_order == 'name_asc' ) echo 'selected' ; ?> ><?php echo $magic->lang('Name'); ?> A->Z</option>
							<option value="name_desc" <?php if ($dt_order == 'name_desc' ) echo 'selected' ; ?> ><?php echo $magic->lang('Name'); ?> Z->A</option>
							<option value="created_asc" <?php if ($dt_order == 'created_asc' ) echo 'selected' ; ?> ><?php echo $magic->lang('Created date'); ?> &uarr;</option>
							<option value="created_desc" <?php if ($dt_order == 'created_desc' ) echo 'selected' ; ?> ><?php echo $magic->lang('Created date'); ?> &darr;</option>
						</select>
						<?php $magic->securityFrom();?>
					</form>
					<form action="<?php echo $magic->cfg->admin_url;?>magic-page=templates" method="post" class="less">
						<select name="categories" class="art_per_page" data-action="submit" style="width:150px">
							<option value="">-- <?php echo $magic->lang('Categories'); ?> --</option>
							<?php
								$cates = $magic_admin->get_categories('templates');
								foreach ($cates as $cate) {
									echo '<option '.(
										$dt_category==$cate['id'] ? 
										'selected' : 
										''
									);
									echo ' value="'.$cate['id'].'">'.str_repeat('&mdash;', $cate['lv']).' '.$cate['name'].'</option>';
								}
							?>
						</select>
						<input type="hidden" name="do" value="categroies" />
						<?php $magic->securityFrom();?>
					</form>
				</div>
				<div class="right">
					<form action="<?php echo $magic->cfg->admin_url;?>magic-page=templates" method="post">
						<input type="search" name="search" class="search" placeholder="<?php echo $magic->lang('Search ...'); ?>" value="<?php if(isset($_SESSION[$prefix.'data_search'])) echo $_SESSION[$prefix.'data_search']; ?>">
						<input  class="magic_submit" type="submit" name="search_template" value="<?php echo $magic->lang('Search'); ?>">
						<?php $magic->securityFrom();?>

					</form>
				</div>
			</div>
			
		<?php if (count($templates) > 0) { ?>
		
			<div class="magic_wrap_table">
				<table class="magic_table magic_templates">
					<thead>
						<tr>
							<th class="magic_check">
								<div class="magic_checkbox">
									<input type="checkbox" id="check_all">
									<label for="check_all"><em class="check"></em></label>
								</div>
							</th>
							<th><?php echo $magic->lang('Name'); ?></th>
							<th><?php echo $magic->lang('Price').' ('.$currency.')'; ?></th>
							<th><?php echo $magic->lang('Screenshot'); ?></th>
							<th><?php echo $magic->lang('Categories'); ?></th>
							<th><?php echo $magic->lang('Tags'); ?></th>
							<th><?php echo $magic->lang('Featured'); ?></th>
							<th><?php echo $magic->lang('Status'); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php

							if ( is_array($templates) && count($templates) > 0 ) {

								foreach ($templates as $value) { ?>

									<tr>
										<td class="magic_check">
											<div class="magic_checkbox">
												<input type="checkbox" name="checked[]" class="action_check" value="<?php if(isset($value['id'])) echo $value['id']; ?>" class="action" id="<?php if(isset($value['id'])) echo $value['id']; ?>">
												<label for="<?php if(isset($value['id'])) echo $value['id']; ?>"><em class="check"></em></label>
											</div>
										</td>
										<td class="magic-resource-title">
											<a href="<?php echo $magic->cfg->admin_url;?>magic-page=template&id=<?php if(isset($value['id'])) echo $value['id']; ?>" class="name"><?php if(isset($value['name'])) echo $value['name']; ?></a>
											<span> - #<?php echo $value['id'] ?></span>
										</td>
										<td style="position:relative;"><input type="number" class="magic_set_price" data-type="templates" data-id="<?php if(isset($value['id'])) echo $value['id']; ?>" value="<?php if(isset($value['price'])) echo $value['price']; ?>"></td>
										<td><?php if(isset($value['screenshot'])) echo '<img height="120" src="'.$value['screenshot'].'" />'; ?></td>
										<td>
											<?php
												$value['id'] = isset($value['id']) ? $value['id'] : '';
												$dt = $magic_admin->get_category_item($value['id'], 'templates');
												$dt_name = array();

												foreach ($dt as $val) {
													$dt_name[] = $val['name'];
												}
												echo implode(', ', $dt_name);
											?>
										</td>
										<td style="width:20%; position:relative;">
											<?php
												$value['id'] = isset($value['id']) ? $value['id'] : '';
												$dt = $magic_admin->get_tag_item($value['id'], 'templates');
												$dt_name = array();
												foreach ($dt as $val) {
													$dt_name[] = $val['name'];
												}
											?>
											<input name="tags" class="tagsfield" value="<?php echo implode(',', $dt_name); ?>" data-id="<?php echo $value['id']; ?>" data-type="templates">
										</td>
										<td class="magic_featured">
											<a href="#" class="magic_action" data-type="templates" data-action="switch_feature" data-status="<?php echo (isset($value['featured']) ? $value['featured'] : '0'); ?>" data-id="<?php if(isset($value['id'])) echo $value['id'] ?>">
												<?php
													if (isset($value['featured']) && $value['featured'] == 1)
														echo '<i class="fa fa-star"></i>';
													else echo '<i class="none fa fa-star-o"></i>';
												?>
											</a>
										</td>
										<td>
											<a href="#" class="magic_action" data-type="templates" data-action="switch_active" data-status="<?php echo (isset($value['active']) ? $value['active'] : '0'); ?>" data-id="<?php if(isset($value['id'])) echo $value['id'] ?>">
												<?php
													if (isset($value['active'])) {
														if ($value['active'] == 1) {
															echo '<em class="pub">'.$magic->lang('active').'</em>';
														} else {
															echo '<em class="un pub">'.$magic->lang('deactive').'</em>';
														}
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
			<div class="magic_pagination"><?php echo $magic_pagination->pagination_html(); ?></div>

		<?php } else {
					if (isset($total_record[0]['total']) && $total_record[0]['total'] > 0) {
						echo '<p class="no-data">'.$magic->lang('Apologies, but no results were found.').'</p>';
						$_SESSION[$prefix.'data_search'] = '';
						echo '<a href="'.$magic->cfg->admin_url.'magic-page=templates" class="btn-back"><i class="fa fa-reply" aria-hidden="true"></i>'.$magic->lang('Back To Lists').'</a>';
					}
					else echo '<p class="no-data">'.$magic->lang('No data. Please add template.').'</p>';
			}?>

	</div>

</div>
<script type="text/javascript"><?php

	$tags = $magic_admin->get_rows_custom(array ("id", "name", "slug", "type"),'tags');

	// Autocomplete Tag
	function js_str($s) {
	    return '"' . addcslashes($s, "\0..\37\"\\") . '"';
	}

	function js_array($array) {
	    $temp = array_map('js_str', $array);
	    return '[' . implode(',', $temp) . ']';
	}

	if (isset($tags) && count($tags) > 0) {
		$values = array();
		foreach ($tags as $value) {

			if ($value['type'] == 'templates')
				$values[] = $value['name'];

		}
		echo 'var magic_sampleTags = ', js_array($values), ';';
	} else {
		echo 'var magic_sampleTags = "";';
	}
?></script>
