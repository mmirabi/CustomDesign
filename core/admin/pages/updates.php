<?php
	global $customdesign;
	$checked = @json_decode($customdesign->get_option('last_check_update'));
?>

<div class="customdesign_wrapper">

	<div id="customdesign-updates">
		<h1><?php echo $customdesign->lang('MagicRugs Updates'); ?></h1>
		<?php $customdesign->views->header_message(); ?>
		<form action="" method="POST">
			<?php echo $customdesign->lang('Last checked on ').' '.(isset($checked->time) ? 
				'<span id="write-time-check"><script>var tm = new Date('.$checked->time.'000), mt = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"]; document.getElementById("write-time-check").innerHTML = tm.getHours()+"h:"+(tm.getMinutes()<10 ? "0"+tm.getMinutes() : tm.getMinutes())+" - "+tm.getDate()+" "+mt[tm.getMonth()]+" "+tm.getFullYear();</script></span>' 
				: '<b>Recently</b>'); ?>.
			&nbsp; 
			<button type="submit" class="customdesign_btn loaclik" data-func="check"><?php echo $customdesign->lang('Check again'); ?></button>
			<input type="hidden" name="do_action" value="check-update" />
		</form>
		<?php
			if (!empty($checked) && isset($checked->version) && version_compare(CUSTOMDESIGN, $checked->version, '<')) {
			?>
			<h3>
				<?php echo $customdesign->lang('An updated version of MagicRugs is available'); ?>. 
				<?php echo $customdesign->lang('New version').' '.$checked->version; ?>
			</h3>
			<div class="customdesign-update-notice">
				<b><?php echo $customdesign->lang('Important'); ?></b>: 
				<?php echo $customdesign->lang('before updating, please back up your database and files of MagicRugs'); ?>
			</div>
			<form action="" method="POST">
				<button class="customdesign_btn primary loaclik"><?php echo $customdesign->lang('Update Now'); ?></button> 
				&nbsp; 
				<a class="customdesign_btn" href="https://www.magicrugs.com/changelogs/<?php echo $customdesign->connector->platform; ?>?utm_source=client-site&utm_medium=text&utm_campaign=update-page&utm_term=links&utm_content=<?php echo $customdesign->connector->platform; ?>" target=_blank>
					<?php echo $customdesign->lang(' Changelogs'); ?>
				</a>
				<input type="hidden" name="do_action" value="do-update" />
			</form>
			<?php	
			} else {
			?>
			<h2><?php echo $customdesign->lang('Great! You have the latest version of MagicRugs'); ?>.</h2>
			<?php	
			}
		?>
	</div>

</div>
