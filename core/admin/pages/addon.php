<?php

	$section = 'addon';
	$name = isset($_GET['name']) ? $_GET['name'] : '';
	
	if (
		!isset($magic->addons->storage->{$name}) ||
		!method_exists($magic->addons->storage->{$name}, 'settings')
	) {
	?>
	<div class="magic_wrapper">
		<div class="magic_content">
			<div class="magic_header">
				<h2>
					<a href="<?php echo $magic->cfg->admin_url?>magic-page=addons" title="<?php echo $magic->lang('Back to Addons'); ?>">
						<?php echo $magic->lang('Addons'); ?>
					</a>
					<i class="fa fa-angle-right"></i>
					<?php echo str_replace(array('_', '-'), ' ', $name); ?>
				</h2>
			</div>
			<?php 
				if (!method_exists($magic->addons->storage->{$name}, 'help'))
					echo '<h3 class="no-available">'.$magic->lang('This addon has no options').'</h3>';
				else $magic->addons->storage->{$name}->help();
			?>
		</div>
	</div>
	<?php
		return;
	}
		
	$args = $magic->addons->storage->{$name}->settings();
	$fields = $magic_admin->process_settings_data($args);

?>

<div class="magic_wrapper" id="magic-<?php echo $section; ?>-page">
	<div class="magic_content">
		<div class="magic_header">
			<h2>
				<a href="<?php echo $magic->cfg->admin_url?>magic-page=addons" title="<?php echo $magic->lang('Back to Addons'); ?>">
					<?php echo $magic->lang('Addons'); ?>
				</a>
				<i class="fa fa-angle-right"></i>
				<?php echo str_replace(array('_', '-'), ' ', $name); ?>
			</h2>
		</div>
		<form action="<?php echo $magic->cfg->admin_url; ?>magic-page=addon&name=<?php echo $name; ?>" id="magic-clipart-form" method="post" class="magic_form" enctype="multipart/form-data">

			<?php 
				$magic->views->header_message();
				$magic->views->tabs_render($fields); 
			?>

			<div class="magic_form_group magic_form_submit">
				<input type="submit" class="magic-button magic-button-primary" value="<?php echo $magic->lang('Save Addon Settings'); ?>"/>
				<input type="hidden" name="do" value="action" />
				<a class="magic_cancel" href="<?php echo $magic->cfg->admin_url;?>magic-page=<?php echo $section; ?>s">
					<?php echo $magic->lang('Cancel'); ?>
				</a>
				<input type="hidden" name="magic-section" value="<?php echo $section; ?>">
				<input type="hidden" name="magic-redirect" value="<?php echo $magic->cfg->admin_url; ?>magic-page=addon&name=<?php echo $name; ?>">
			</div>
		</form>
		<?php
			if (method_exists($magic->addons->storage->{$name}, 'help'))
				$magic->addons->storage->{$name}->help();
		 ?>
	</div>
</div>
