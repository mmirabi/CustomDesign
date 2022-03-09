<?php
	global $magic;
	$checked = @json_decode($magic->get_option('last_check_update'));
?>

<div class="magic_wrapper">

	<div id="magic-updates">
		<h1><?php echo $magic->lang('MagicRugs Updates'); ?></h1>
		<?php $magic->views->header_message(); ?>
		<form action="" method="POST">
			<?php echo $magic->lang('Last checked on ').' '.(isset($checked->time) ? 
				'<span id="write-time-check"><script>var tm = new Date('.$checked->time.'000), mt = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"]; document.getElementById("write-time-check").innerHTML = tm.getHours()+"h:"+(tm.getMinutes()<10 ? "0"+tm.getMinutes() : tm.getMinutes())+" - "+tm.getDate()+" "+mt[tm.getMonth()]+" "+tm.getFullYear();</script></span>' 
				: '<b>Recently</b>'); ?>.
			&nbsp; 
			<button type="submit" class="magic_btn loaclik" data-func="check"><?php echo $magic->lang('Check again'); ?></button>
			<input type="hidden" name="do_action" value="check-update" />
		</form>
		<?php
			if (!empty($checked) && isset($checked->version) && version_compare(MAGIC, $checked->version, '<')) {
			?>
			<h3>
				<?php echo $magic->lang('An updated version of MagicRugs is available'); ?>. 
				<?php echo $magic->lang('New version').' '.$checked->version; ?>
			</h3>
			<div class="magic-update-notice">
				<b><?php echo $magic->lang('Important'); ?></b>: 
				<?php echo $magic->lang('before updating, please back up your database and files of MagicRugs'); ?>
			</div>
			<form action="" method="POST">
				<button class="magic_btn primary loaclik"><?php echo $magic->lang('Update Now'); ?></button> 
				&nbsp; 
				<a class="magic_btn" href="https://www.magicrugs.com/changelogs/<?php echo $magic->connector->platform; ?>?utm_source=client-site&utm_medium=text&utm_campaign=update-page&utm_term=links&utm_content=<?php echo $magic->connector->platform; ?>" target=_blank>
					<?php echo $magic->lang(' Changelogs'); ?>
				</a>
				<input type="hidden" name="do_action" value="do-update" />
			</form>
			<?php	
			} else {
			?>
			<h2><?php echo $magic->lang('Great! You have the latest version of MagicRugs'); ?>.</h2>
			<?php	
			}
		?>
	</div>

</div>
