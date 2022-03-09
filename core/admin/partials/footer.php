<?php
	global $magic;
?><script>
	var MagicDesign = {
		url : "<?php echo htmlspecialchars_decode($magic->cfg->url); ?>",
		admin_url : "<?php echo htmlspecialchars_decode($magic->cfg->admin_url); ?>",
		ajax : "<?php echo htmlspecialchars_decode($magic->cfg->admin_ajax_url); ?>",
		assets : "<?php echo $magic->cfg->assets_url; ?>",
		jquery : "<?php echo $magic->cfg->load_jquery; ?>",
		nonce : "<?php echo magic_secure::create_nonce('MAGIC_ADMIN') ?>",
		filter_ajax: function(ops) {
			return ops;
		},
		js_lang : <?php echo json_encode($magic->cfg->js_lang); ?>,
	};
</script>
<script src="<?php echo $magic->cfg->admin_assets_url;?>js/vendors.js?version=<?php echo MAGIC; ?>"></script>
<script src="<?php echo $magic->cfg->admin_assets_url;?>js/tag-it.min.js?version=<?php echo MAGIC; ?>"></script>
<script src="<?php echo $magic->cfg->admin_assets_url;?>js/main.js?version=<?php echo MAGIC; ?>"></script>
<?php
	
	$magic->do_action('editor-footer');
	
	if ($magic->connector->platform == 'php') {
		echo '</body></html>';
	}
?>
