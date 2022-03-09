<?php
	$title = "Tags list";
	$prefix = 'tags_';

	// Action Form
	$type = isset($_GET['type']) ? $_GET['type'] : 'cliparts';
	if (isset($_POST['action_submit']) && !empty($_POST['action_submit'])) {

		$arr = array("id","tag_id","item_id");
		$tag_ref = $magic_admin->get_rows_custom($arr, 'tags_reference', $orderby = 'id', $order='asc');
		$data_action = isset($_POST['action']) ? $_POST['action'] : '';
		$val = isset($_POST['id_action']) ? $_POST['id_action'] : '';
		$val = explode(',', $val);
		
		$magic_admin->check_caps('tags');
		
		foreach ($val as $value) {

			switch ($data_action) {

				case 'delete':

					foreach ($tag_ref as $vals) {
						if ($vals['tag_id'] == $value) {
							$data_tags = array();
							$item_type = $magic_admin->get_row_id($vals['item_id'], $type);
							$tag_name = $magic_admin->get_row_id($vals['tag_id'], 'tags');
							$data_tags['tags'] = str_replace( $tag_name['name'], ' ' , $item_type['tags'] );
							$data_tags['tags'] = str_replace( ', ,', ',' , $data_tags['tags'] );
							$data_tags['tags'] = str_replace( ', ', '' , $data_tags['tags'] );
							$data_tags['tags'] = str_replace( ' ,', '' , $data_tags['tags'] );
							trim($data_tags['tags'], ',');
							$magic_admin->edit_row($vals['item_id'],$data_tags,$type);
							$magic_admin->delete_row($vals['id'],'tags_reference');
						}
					}

					$magic_admin->delete_row($value, 'tags');

					break;
				default:
					break;

			}

		}

	}

	// Search Form
	$data_search = '';
	if (isset($_POST['search_tag']) && !empty($_POST['search_tag'])) {

		$data_search = isset($_POST['search']) ? trim($_POST['search']) : '';

		if (empty($data_search)) {
			$errors = 'Please Insert Key Word';
			$_SESSION[$prefix.$type.'data_search'] = '';
		} else {
			$_SESSION[$prefix.$type.'data_search'] = $data_search;
		}

	}

	if (!empty($_SESSION[$prefix.$type.'data_search'])) {
		$data_search = '%'.$_SESSION[$prefix.$type.'data_search'].'%';
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
			$_SESSION[$prefix.'per_page'] = 5;
			$per_page = $_SESSION[$prefix.'per_page'];
		}

	}

	// Sort Form
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
			default:
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
        'fields' => 'name,slug'
    );

    $start = ( $current_page - 1 ) *  $per_page;
	$tags = $magic_admin->get_rows('tags', $search_filter, $orderby, $ordering, $per_page, $start, null, $type);
    $total_record = $magic_admin->get_rows_total('tags', $type, 'type');

    $tags['total_page'] = ceil($tags['total_count'] / $per_page);
    $config = array(
    	'current_page'  => $current_page,
		'total_record'  => $tags['total_count'],
		'total_page'    => $tags['total_page'],
 	    'limit'         => $per_page,
	    'link_full'     => $magic->cfg->admin_url.'magic-page=tags&type='.$type.'&tpage={page}',
	    'link_first'    => $magic->cfg->admin_url.'magic-page=tags&type='.$type,
	);

	$magic_pagination->init($config);

?>

<div class="magic_wrapper">
	<div class="magic_content">
		<div class="magic_header">
			<h2><?php echo $magic->lang('Tags'); ?></h2>
			<a href="<?php echo $magic->cfg->admin_url;?>magic-page=tag&type=<?php echo $type; ?>" class="add-new magic-button"><?php echo $magic->lang('Add New Tag'); ?></a>
			<?php
				$magic_page = isset($_GET['magic-page']) ? $_GET['magic-page'] : '';
				$type = isset($_GET['type']) ? $_GET['type'] : '';
				echo $magic_helper->breadcrumb($magic_page,$type);
			?>
		</div>

	

		<div class="magic_option">
			<div class="left">
				<form action="<?php echo $magic->cfg->admin_url;?>magic-page=tags&type=<?php echo $type; ?>" method="post">
					<input type="hidden" name="id_action" class="id_action">
					<input type="hidden" name="action" value="delete" />
					<input  class="magic_submit" type="submit" name="action_submit" value="<?php echo $magic->lang('Delete'); ?>">
					<?php $magic->securityFrom();?>
				</form>
				<form action="<?php echo $magic->cfg->admin_url;?>magic-page=tags&type=<?php echo $type; ?>" method="post">
					<select name="per_page" class="art_per_page" data-action="submit">
						<option value="none">-- <?php echo $magic->lang('Per page'); ?> --</option>
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
					<?php $magic->securityFrom();?>
				</form>
				<form action="<?php echo $magic->cfg->admin_url;?>magic-page=tags&type=<?php echo $type; ?>" method="post">
					<select name="sort" class="art_per_page" data-action="submit">
						<option value="">-- <?php echo $magic->lang('Sort by'); ?> --</option>
						<option value="name_asc" <?php if ($dt_order == 'name_asc' ) echo 'selected' ; ?> ><?php echo $magic->lang('Name'); ?> A-Z</option>
						<option value="name_desc" <?php if ($dt_order == 'name_desc' ) echo 'selected' ; ?> ><?php echo $magic->lang('Name'); ?> Z-A</option>
					</select>
					<?php $magic->securityFrom();?>
				</form>
			</div>
			<div class="right">
				<form action="<?php echo $magic->cfg->admin_url;?>magic-page=tags&type=<?php echo $type; ?>" method="post">
					<input class="search" type="search" name="search" class="form-control form_search" placeholder="Search ..." value="<?php if(isset($_SESSION[$prefix.$type.'data_search'])) echo $_SESSION[$prefix.$type.'data_search']; ?>">
					<input class="magic_submit" type="submit" name="search_tag" value="<?php echo $magic->lang('Search'); ?>">
					<?php $magic->securityFrom();?>
				</form>
			</div>
		</div>
		
		<?php if ( isset($tags['total_count']) && $tags['total_count'] > 0) { ?>
			
			<div class="magic_wrap_table">
				<table class="magic_table">
					<thead>
						<tr>
							<th class="magic_check">
								<div class="magic_checkbox">
									<input type="checkbox" id="check_all">
									<label for="check_all"><em class="check"></em></label>
								</div>
							</th>
							<th><?php echo $magic->lang('Name'); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($tags['rows'] as $value) {?>
								<tr>
									<td class="magic_check">
										<div class="magic_checkbox">
											<input type="checkbox" name="checked[]" class="action_check" value="<?php echo $value['id']; ?>" class="action" id="<?php echo $value['id']; ?>">
											<label for="<?php echo $value['id']; ?>"><em class="check"></em></label>
										</div>
									</td>
									<td><a href="<?php echo $magic->cfg->admin_url;?>magic-page=tag&type=<?php echo $type; ?>&id=<?php if(isset($value['id'])) echo $value['id']; ?>" class="name"><?php if(isset($value['name'])) echo $value['name']; ?></a></td>
								</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
			<div class="magic_pagination"><?php echo $magic_pagination->pagination_html(); ?></div>

		<?php } else {
					if (isset($total_record) && $total_record > 0) {
						echo '<p class="no-data">'.$magic->lang('Apologies, but no results were found.').'</p>';
						$_SESSION[$prefix.$type.'data_search'] = '';
						echo '<a href="'.$magic->cfg->admin_url.'magic-page=tags&type='.$type.'" class="btn-back"><i class="fa fa-reply" aria-hidden="true"></i>'.$magic->lang('Back To Lists').'</a>';
					}
					else
						echo '<p class="no-data">'.$magic->lang('No data. Please add tag.').'</p>';
			}?>
	</div>
</div>
