<?php
	global $customdesign;
?><script>
	var CustomdesignDesign = {
		url : "<?php echo htmlspecialchars_decode($customdesign->cfg->url); ?>",
		admin_url : "<?php echo htmlspecialchars_decode($customdesign->cfg->admin_url); ?>",
		ajax : "<?php echo htmlspecialchars_decode($customdesign->cfg->admin_ajax_url); ?>",
		assets : "<?php echo $customdesign->cfg->assets_url; ?>",
		jquery : "<?php echo $customdesign->cfg->load_jquery; ?>",
		nonce : "<?php echo customdesign_secure::create_nonce('CUSTOMDESIGN_ADMIN') ?>",
		filter_ajax: function(ops) {
			return ops;
		},
		js_lang : <?php echo json_encode($customdesign->cfg->js_lang); ?>,
	};
</script>
<script src="<?php echo $customdesign->cfg->admin_assets_url;?>js/vendors.js?version=<?php echo CUSTOMDESIGN; ?>"></script>
<script src="<?php echo $customdesign->cfg->admin_assets_url;?>js/tag-it.min.js?version=<?php echo CUSTOMDESIGN; ?>"></script>
<script src="<?php echo $customdesign->cfg->admin_assets_url;?>js/main.js?version=<?php echo CUSTOMDESIGN; ?>"></script>
<?php
	
	$customdesign->do_action('editor-footer');
	
	if ($customdesign->connector->platform == 'php') {
		echo '</body></html>';
	}
?>
