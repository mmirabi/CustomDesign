<?php
$items = $magic->addons->load_installed();
?>
<div class="magic_wrapper" id="magic-addons-page">
	<div class="magic_content">
		<div class="magic_header">
			<h2><?php echo $magic->lang('Addons'); ?></h2>
			<a href="#" class="add-new magic-button" onclick="document.querySelectorAll('.upload-addon-wrap')[0].style.display = 'inline-block';">
				<i class="fa fa-cloud-upload"></i>
				<?php echo $magic->lang('Upload a new addon'); ?>
			</a>
			<a href="<?php echo $magic->cfg->admin_url; ?>magic-page=explore-addons" class="add_new active">
				<i class="fa fa-th"></i>
				<?php echo $magic->lang('Explore all available addons'); ?>		
			</a>
		</div>
		<div class="upload-addon-wrap">
			<div class="upload-addon">
				<p class="install-help">
					<?php echo $magic->lang('If you have an addon in a .zip format, you may install it by uploading it here.'); ?>				
				</p>
				<form method="post" enctype="multipart/form-data" class="addon-upload-form" action="">
					<input type="file" name="addonzip" id="addonzip">
					<input type="hidden" name="action" value="upload">
					<input type="submit" name="install-magicaddon-submit" class="magic_submit" value="<?php echo $magic->lang('Install Now'); ?>">
				</form>
			</div>
		</div>
		<?php 
			$magic->views->header_message();
		?>
		<div class="magic_option">
			<div class="left">
				<form action="<?php echo $magic->cfg->admin_url; ?>magic-page=addons" method="post">
					<select name="action" class="art_per_page">
						<option value="none"><?php echo $magic->lang('Bulk Actions'); ?></option>
						<option value="active"><?php echo $magic->lang('Active'); ?></option>
						<option value="deactive"><?php echo $magic->lang('Deactive'); ?></option>
						<option value="delete"><?php echo $magic->lang('Delete'); ?></option>
					</select>
					<input type="hidden" name="id_action" class="id_action">
					<input type="submit" class="magic_submit" value="Apply">			
				</form>
			</div>
		</div>
		<div id="license_noticesModal" class="modal">
		  <div class="modal-content">
		    <span class="close">&times;</span>
		    <p>Enter your purchase code to activate the addon</p>
		    <div class="modal-footer">
			    <a id="link-addon-bundle" href="<?php echo $magic->cfg->admin_url; ?> ?page=magic&magic-page=license#magic-tab-addon-bundle" class="link-to-license">Enter your license now</a>
			    <a id="link-addon-printful" href="<?php echo $magic->cfg->admin_url; ?> ?page=magic&magic-page=license#magic-tab-addon-printful" class="link-to-license">Enter your license now</a>
			    <a id="link-addon-vendor" href="<?php echo $magic->cfg->admin_url; ?> ?page=magic&magic-page=license#magic-tab-addon-vendor" class="link-to-license">Enter your license now</a>
			</div>
		  </div>
		</div>
		<form action="" method="post" class="magic_form" enctype="multipart/form-data">
			<table class="magic_table magic_addons">
				<thead>
					<tr>
						<th class="magic_check">
							<div class="magic_checkbox">
								<input type="checkbox" id="check_all">
								<label for="check_all"><em class="check"></em></label>
							</div>
						</th>
						<th width="20%"><?php echo $magic->lang('Name'); ?></th>
						<th><?php echo $magic->lang('Description'); ?></th>
						<th><?php echo $magic->lang('Version'); ?></th>
						<th><?php echo $magic->lang('Compatible'); ?></th>
						<th><?php echo $magic->lang('Status'); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php
						if (count($items) > 0) {
							
							$actives = $magic->get_option( 'active_addons');
							
							if ($actives !== null && !empty($actives))
								$actives = (Array)@json_decode($actives);
							
							if (!is_array($actives))
								$actives = array();
								
							foreach ($items as $item) {
								$check_verify = $magic->addons->magic_check_verify_lincense($item['Slug']);
								echo '<tr>';
								echo '<td class="magic_check">'.
											'<div class="magic_checkbox">'.
												'<input type="checkbox" name="checked[]" class="action_check" value="'.$item['Slug'].'" id="lc-'.$item['Slug'].'">'.
												'<label for="lc-'.$item['Slug'].'"><em class="check"></em></label>'.
											'</div>'.
										'</td>';
								echo '<td data-slug="'.$item['Slug'].'" data-name="'.str_replace('"', '\"', $item['Name']).'">';
								
								if (isset($actives[$item['Slug']])) {
									echo '<strong>'.$item['Name'].'</strong><br><a href="'.$magic->cfg->admin_url.'magic-page=addon&name='.$item['Slug'].'">Addon settings</a>';
								} else {
									echo $item['Name'];
								}
								echo '</td>';
								echo '<td>'.$item['Description'].'</td>';
								if (version_compare($item['Compatible'], MAGIC, '>')) {
									echo '<td colspan="3">';
									echo '<span class="pub pen"><i class="fa fa-warning"></i> '.$magic->lang('Required MagicRugs version').' '.$item['Compatible'].'+</span>';
									echo '</td>';
								} else if (
									isset($item['Platform']) && 
									!empty($item['Platform']) && 
									strpos(strtolower($item['Platform']), $magic->connector->platform) === false
								) {
									echo '<td colspan="3">';
									echo '<span class="pub pen"><i class="fa fa-warning"></i> '.$magic->lang('Unsupported your platform').'</span><br><small>Only support '.$item['Platform'].'</small>';
									echo '</td>';
								} else {
									echo '<td>'.$item['Version'].'</td>';
									echo '<td>'.$item['Compatible'].'+</td>';
									echo '<td><a href="#" class="magic_action" data-type="addons" data-action="switch_active" data-status="'.(isset($actives[$item['Slug']]) ? $actives[$item['Slug']] : 0).'" data-id="'.$item['Slug'].'" check-license ="'.(isset($check_verify) ? (int)$check_verify : 0).'">';
									echo (
										isset($actives[$item['Slug']]) && $actives[$item['Slug']] == 1 ? 
										'<em class="pub">'.$magic->lang('Active').'</em>' : 
										'<em class="pub un">'.$magic->lang('Deactive').'</em>'
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
