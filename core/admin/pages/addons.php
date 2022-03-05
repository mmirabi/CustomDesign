<?php
$items = $customdesign->addons->load_installed();
?>
<div class="customdesign_wrapper" id="customdesign-addons-page">
	<div class="customdesign_content">
		<div class="customdesign_header">
			<h2><?php echo $customdesign->lang('Addons'); ?></h2>
			<a href="#" class="add-new customdesign-button" onclick="document.querySelectorAll('.upload-addon-wrap')[0].style.display = 'inline-block';">
				<i class="fa fa-cloud-upload"></i>
				<?php echo $customdesign->lang('Upload a new addon'); ?>
			</a>
			<a href="<?php echo $customdesign->cfg->admin_url; ?>customdesign-page=explore-addons" class="add_new active">
				<i class="fa fa-th"></i>
				<?php echo $customdesign->lang('Explore all available addons'); ?>		
			</a>
		</div>
		<div class="upload-addon-wrap">
			<div class="upload-addon">
				<p class="install-help">
					<?php echo $customdesign->lang('If you have an addon in a .zip format, you may install it by uploading it here.'); ?>				
				</p>
				<form method="post" enctype="multipart/form-data" class="addon-upload-form" action="">
					<input type="file" name="addonzip" id="addonzip">
					<input type="hidden" name="action" value="upload">
					<input type="submit" name="install-customdesignaddon-submit" class="customdesign_submit" value="<?php echo $customdesign->lang('Install Now'); ?>">
				</form>
			</div>
		</div>
		<?php 
			$customdesign->views->header_message();
		?>
		<div class="customdesign_option">
			<div class="left">
				<form action="<?php echo $customdesign->cfg->admin_url; ?>customdesign-page=addons" method="post">
					<select name="action" class="art_per_page">
						<option value="none"><?php echo $customdesign->lang('Bulk Actions'); ?></option>
						<option value="active"><?php echo $customdesign->lang('Active'); ?></option>
						<option value="deactive"><?php echo $customdesign->lang('Deactive'); ?></option>
						<option value="delete"><?php echo $customdesign->lang('Delete'); ?></option>
					</select>
					<input type="hidden" name="id_action" class="id_action">
					<input type="submit" class="customdesign_submit" value="Apply">			
				</form>
			</div>
		</div>
		<div id="license_noticesModal" class="modal">
		  <div class="modal-content">
		    <span class="close">&times;</span>
		    <p>Enter your purchase code to activate the addon</p>
		    <div class="modal-footer">
			    <a id="link-addon-bundle" href="<?php echo $customdesign->cfg->admin_url; ?> ?page=customdesign&customdesign-page=license#customdesign-tab-addon-bundle" class="link-to-license">Enter your license now</a>
			    <a id="link-addon-printful" href="<?php echo $customdesign->cfg->admin_url; ?> ?page=customdesign&customdesign-page=license#customdesign-tab-addon-printful" class="link-to-license">Enter your license now</a>
			    <a id="link-addon-vendor" href="<?php echo $customdesign->cfg->admin_url; ?> ?page=customdesign&customdesign-page=license#customdesign-tab-addon-vendor" class="link-to-license">Enter your license now</a>
			</div>
		  </div>
		</div>
		<form action="" method="post" class="customdesign_form" enctype="multipart/form-data">
			<table class="customdesign_table customdesign_addons">
				<thead>
					<tr>
						<th class="customdesign_check">
							<div class="customdesign_checkbox">
								<input type="checkbox" id="check_all">
								<label for="check_all"><em class="check"></em></label>
							</div>
						</th>
						<th width="20%"><?php echo $customdesign->lang('Name'); ?></th>
						<th><?php echo $customdesign->lang('Description'); ?></th>
						<th><?php echo $customdesign->lang('Version'); ?></th>
						<th><?php echo $customdesign->lang('Compatible'); ?></th>
						<th><?php echo $customdesign->lang('Status'); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php
						if (count($items) > 0) {
							
							$actives = $customdesign->get_option( 'active_addons');
							
							if ($actives !== null && !empty($actives))
								$actives = (Array)@json_decode($actives);
							
							if (!is_array($actives))
								$actives = array();
								
							foreach ($items as $item) {
								$check_verify = $customdesign->addons->customdesign_check_verify_lincense($item['Slug']);
								echo '<tr>';
								echo '<td class="customdesign_check">'.
											'<div class="customdesign_checkbox">'.
												'<input type="checkbox" name="checked[]" class="action_check" value="'.$item['Slug'].'" id="lc-'.$item['Slug'].'">'.
												'<label for="lc-'.$item['Slug'].'"><em class="check"></em></label>'.
											'</div>'.
										'</td>';
								echo '<td data-slug="'.$item['Slug'].'" data-name="'.str_replace('"', '\"', $item['Name']).'">';
								
								if (isset($actives[$item['Slug']])) {
									echo '<strong>'.$item['Name'].'</strong><br><a href="'.$customdesign->cfg->admin_url.'customdesign-page=addon&name='.$item['Slug'].'">Addon settings</a>';
								} else {
									echo $item['Name'];
								}
								echo '</td>';
								echo '<td>'.$item['Description'].'</td>';
								if (version_compare($item['Compatible'], CUSTOMDESIGN, '>')) {
									echo '<td colspan="3">';
									echo '<span class="pub pen"><i class="fa fa-warning"></i> '.$customdesign->lang('Required MagicRugs version').' '.$item['Compatible'].'+</span>';
									echo '</td>';
								} else if (
									isset($item['Platform']) && 
									!empty($item['Platform']) && 
									strpos(strtolower($item['Platform']), $customdesign->connector->platform) === false
								) {
									echo '<td colspan="3">';
									echo '<span class="pub pen"><i class="fa fa-warning"></i> '.$customdesign->lang('Unsupported your platform').'</span><br><small>Only support '.$item['Platform'].'</small>';
									echo '</td>';
								} else {
									echo '<td>'.$item['Version'].'</td>';
									echo '<td>'.$item['Compatible'].'+</td>';
									echo '<td><a href="#" class="customdesign_action" data-type="addons" data-action="switch_active" data-status="'.(isset($actives[$item['Slug']]) ? $actives[$item['Slug']] : 0).'" data-id="'.$item['Slug'].'" check-license ="'.(isset($check_verify) ? (int)$check_verify : 0).'">';
									echo (
										isset($actives[$item['Slug']]) && $actives[$item['Slug']] == 1 ? 
										'<em class="pub">'.$customdesign->lang('Active').'</em>' : 
										'<em class="pub un">'.$customdesign->lang('Deactive').'</em>'
									);
									echo '</a></td>';
								}
								echo '</tr>';
							}
						} else {
							echo '<tr><td colspan="6">No items found</td></tr>';
						}
					?>
				</tbody>
			</table>
		</form>
	</div>
</div>
<script>
	let modal = $("#license_noticesModal");
	let btn = $(".myBtn");
	let span = $(".close")[0];

	span.addEventListener("click", function(event) {
	 	modal.css('display', 'none');
		$(".link-to-license").css('display', 'none');
	});
	window.addEventListener("click", function(event) {
	 	if (event.target.id == 'license_noticesModal') {
	    	modal.css('display', 'none');
	    	$(".link-to-license").css('display', 'none');
		}
	});
</script>
