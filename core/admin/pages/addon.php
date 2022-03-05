<?php

	$section = 'addon';
	$name = isset($_GET['name']) ? $_GET['name'] : '';
	
	if (
		!isset($customdesign->addons->storage->{$name}) ||
		!method_exists($customdesign->addons->storage->{$name}, 'settings')
	) {
	?>
	<div class="customdesign_wrapper">
		<div class="customdesign_content">
			<div class="customdesign_header">
				<h2>
					<a href="<?php echo $customdesign->cfg->admin_url?>customdesign-page=addons" title="<?php echo $customdesign->lang('Back to Addons'); ?>">
						<?php echo $customdesign->lang('Addons'); ?>
					</a>
					<i class="fa fa-angle-right"></i>
					<?php echo str_replace(array('_', '-'), ' ', $name); ?>
				</h2>
			</div>
			<?php 
				if (!method_exists($customdesign->addons->storage->{$name}, 'help'))
					echo '<h3 class="no-available">'.$customdesign->lang('This addon has no options').'</h3>';
				else $customdesign->addons->storage->{$name}->help();
			?>
		</div>
	</div>
	<?php
		return;
	}
		
	$args = $customdesign->addons->storage->{$name}->settings();
	$fields = $customdesign_admin->process_settings_data($args);

?>

<div class="customdesign_wrapper" id="customdesign-<?php echo $section; ?>-page">
	<div class="customdesign_content">
		<div class="customdesign_header">
			<h2>
				<a href="<?php echo $customdesign->cfg->admin_url?>customdesign-page=addons" title="<?php echo $customdesign->lang('Back to Addons'); ?>">
					<?php echo $customdesign->lang('Addons'); ?>
				</a>
				<i class="fa fa-angle-right"></i>
				<?php echo str_replace(array('_', '-'), ' ', $name); ?>
			</h2>
		</div>
		<form action="<?php echo $customdesign->cfg->admin_url; ?>customdesign-page=addon&name=<?php echo $name; ?>" id="customdesign-clipart-form" method="post" class="customdesign_form" enctype="multipart/form-data">

			<?php 
				$customdesign->views->header_message();
				$customdesign->views->tabs_render($fields); 
			?>

			<div class="customdesign_form_group customdesign_form_submit">
				<input type="submit" class="customdesign-button customdesign-button-primary" value="<?php echo $customdesign->lang('Save Addon Settings'); ?>"/>
				<input type="hidden" name="do" value="action" />
				<a class="customdesign_cancel" href="<?php echo $customdesign->cfg->admin_url;?>customdesign-page=<?php echo $section; ?>s">
					<?php echo $customdesign->lang('Cancel'); ?>
				</a>
				<input type="hidden" name="customdesign-section" value="<?php echo $section; ?>">
				<input type="hidden" name="customdesign-redirect" value="<?php echo $customdesign->cfg->admin_url; ?>customdesign-page=addon&name=<?php echo $name; ?>">
			</div>
		</form>
		<?php
			if (method_exists($customdesign->addons->storage->{$name}, 'help'))
				$customdesign->addons->storage->{$name}->help();
		 ?>
	</div>
</div>
