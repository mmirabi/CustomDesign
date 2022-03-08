<?php
	
	global $customdesign, $current_user;
	
	if(
		!defined('CUSTOMDESIGN') || 
		!$current_user ||
		(!$customdesign->caps('customdesign_access') && get_user_meta( $current_user->ID, 'dokan_enable_selling' , true ) != 'yes')
	) {
		header('HTTP/1.0 403 Forbidden');
		exit;
	}
	
	if (
		isset($_POST['clear_all_config'])
	) {
		global $wpdb;
		$varis = $wpdb->get_results("SELECT `ID` FROM `{$wpdb->prefix}posts` WHERE `post_parent`=".((int)$_POST['clear_all_config'])." AND `post_type` = 'product_variation' AND `post_status` = 'publish'");
		if (count($varis) > 0) {
			foreach ($varis as $vari) {
				update_post_meta($vari->ID, '_variation_customdesign', '');
			}
		}
		exit;
	}
	
	if (
		isset($_POST['data']) &&
		isset($_POST['apply_all_variations']) &&
		$_POST['apply_all_variations'] = 1
	) {
		global $wpdb;
		$varis = $wpdb->get_results("SELECT `ID` FROM `{$wpdb->prefix}posts` WHERE `post_parent`=".((int)$_GET['product_id'])." AND `post_type` = 'product_variation' AND `post_status` = 'publish'");
		if (count($varis) > 0) {
			foreach ($varis as $vari) {
				update_post_meta($vari->ID, '_variation_customdesign', $_POST['data']);
			}
		}
		exit;
	}
	
	global $customdesign;
	global $customdesign_admin;
	
	$customdesign->connector->platform = 'php';
	
	if (isset($_POST['data'])) {
		$data = json_decode(urldecode($_POST['data']), true);	
	} else {
		$data = array(
			'stages' => '',
			'printing' => ''
		);
	}
	
	$arg = array(
		array(
			'type' => 'stages',
			'name' => 'stages',
			'value' => isset($data['stages']) ? $data['stages'] : ''
		),
		array(
			'type' => 'printing',
			'name' => 'printings',
			'label' => $customdesign->lang('Printing Techniques'),
			'desc' => $customdesign->lang('Select Printing Techniques with price calculations for this product').'<br>'.$customdesign->lang('Drag to arrange items, the first one will be set as default'),
			'value' => isset($data['printing']) ? $data['printing'] : ''
		)
	);
	
	$fields = $arg;
	
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title><?php echo (isset($title) ? $title : 'MagicRugs Control Panel'); ?></title>
		<?php $customdesign->do_action('admin-header'); ?>
		<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,400i,500,700,900" rel="stylesheet">
		<link rel="stylesheet" href="<?php echo $customdesign->cfg->admin_assets_url;?>css/font-awesome.min.css?version=<?php echo CUSTOMDESIGN; ?>">
		<link rel="stylesheet" href="<?php echo $customdesign->cfg->admin_assets_url;?>css/admin.css?version=<?php echo CUSTOMDESIGN; ?>">
		<link rel="stylesheet" href="<?php echo $customdesign->cfg->admin_assets_url;?>css/responsive.css?version=<?php echo CUSTOMDESIGN; ?>">
		<link rel="stylesheet" href="<?php echo $customdesign->cfg->upload_url; ?>user_data/custom.css?version=<?php echo $customdesign->cfg->settings['last_update']; ?>">
		<link rel="stylesheet" href="<?php echo $customdesign->cfg->admin_assets_url; ?>css/iframe.css?version=<?php echo CUSTOMDESIGN; ?>" />
		<script src="<?php echo $customdesign->apply_filters('editor/jquery.min.js', $customdesign->cfg->assets_url.'assets/js/jquery.min.js?version='.CUSTOMDESIGN); ?>"></script>
		<?php $customdesign->do_action('editor-header'); ?>
</head>
<body class="CustomdesignDesign">
	<div class="customdesign_wrapper" id="customdesign-product-page" style="width: 100%; padding: 0px;">
		<div class="customdesign_content" style="width: 100%;padding: 34px 20px 14px;border: 2px solid #f1f1f1;">
			<div class="customdesign-variation-btns">
				<button class="customdesign-button" is="options-frame">
					<i class="fa fa-ellipsis-h"></i>
					<ul>
						<li data-frame-fn="copy"><?php echo $customdesign->lang('Copy this designs config'); ?></li>
						<li data-frame-fn="paste"><?php echo $customdesign->lang('Paste the copied config'); ?></li>
						<li data-frame-fn="apply"><?php echo $customdesign->lang('Apply this for all variations'); ?></li>
						<li data-frame-fn="remove" style="color:#E91E63;"><?php echo $customdesign->lang('Remove this MagicRugs config'); ?></li>
					</ul>
				</button>
				<button class="customdesign-button" data-frame-fn="close">
					<i class="fa fa-sort-up" data-frame-fn="close"></i>
				</button>
			</div>
			<?php $customdesign->views->tabs_render($fields, 'products'); ?>
		</div>
	</div>
<script>
	var CustomdesignDesign = {
		url : "<?php echo htmlspecialchars_decode($customdesign->cfg->url); ?>",
		admin_url : "<?php echo htmlspecialchars_decode($customdesign->cfg->admin_url); ?>",
		ajax : "<?php echo htmlspecialchars_decode($customdesign->cfg->admin_ajax_url); ?>",
		assets : "<?php echo $customdesign->cfg->assets_url; ?>",
		jquery : "<?php echo $customdesign->cfg->load_jquery; ?>",
		nonce : "<?php echo customdesign_secure::create_nonce('CUSTOMDESIGN_ADMIN'); ?>",
		filter_ajax: function(ops) {
			return ops;
		},
		js_lang : <?php echo json_encode($customdesign->cfg->js_lang); ?>
	};
</script>
<script src="<?php echo $customdesign->cfg->admin_assets_url;?>js/vendors.js?version=<?php echo CUSTOMDESIGN; ?>"></script>
<script src="<?php echo $customdesign->cfg->admin_assets_url;?>js/main.js?version=<?php echo CUSTOMDESIGN; ?>"></script>
<?php $customdesign->do_action('editor-footer'); ?>
<script type="text/javascript">
(function() {
	if($('body.CustomdesignDesign').width() <= 1000){
		$('body.CustomdesignDesign').css('overflow-y', 'scroll');
	}
	let fitIframe = () => {
		
			inp.val(
				encodeURIComponent(
					JSON.stringify({
						stages: enjson(customdesign.product.get_stages($('#customdesign-stages-wrp'))),
						printing: encodeURIComponent(JSON.stringify(customdesign.product.get_printing(wrp)))
					})
				)
			).change();
		
			if (window.frameElement && !window.frameElement.getAttribute('data-full')) {
				window.frameElement.style.height = document.body.scrollHeight+'px';
				window.frameElement.parentNode.removeAttribute('data-loading');
			};
		},
		wrp = $('#customdesign-product-page'),
		inp = window.parent.jQuery(window.parent.window['variable-customdesign-<?php echo $_GET['variation_id']; ?>']),
		btn = window.parent.jQuery('#customdesign-config-<?php echo $_GET['variation_id']; ?>');
		
	$(document).on('click', (e) => {
		
		if (e.target.getAttribute && e.target.getAttribute('data-frame-fn')) {
			
			switch (e.target.getAttribute('data-frame-fn')) {
				case 'close' : 
					fitIframe();
					btn.parent().removeClass('hasFrame');
					return window.frameElement.parentNode.removeChild(window.frameElement);
				break;
				case 'remove' : 
					if (confirm('<?php echo $customdesign->lang('Are you sure that you want to delete this config?'); ?>')) {
						inp.val('').change();
						btn.parent().attr('data-empty', 'true').removeClass('hasFrame');
						return window.frameElement.parentNode.removeChild(window.frameElement);
					} else return;
				break;
				case 'copy': 
					localStorage.setItem('CUSTOMDESIGN-VARIATION-COPY', 
						encodeURIComponent(
							JSON.stringify({
								stages: enjson(customdesign.product.get_stages($('#customdesign-stages-wrp'))),
								printing: encodeURIComponent(JSON.stringify(customdesign.product.get_printing(wrp)))
							})
						)
					);
					alert('<?php echo $customdesign->lang('Your design config has been copied!'); ?>');
				break;
				case 'paste': 
					if (!localStorage.getItem('CUSTOMDESIGN-VARIATION-COPY'))
						return alert('<?php echo $customdesign->lang('Error, You must copy one config before pasting'); ?>');
					
					inp.val(localStorage.getItem('CUSTOMDESIGN-VARIATION-COPY')).change();
					window.frameElement.parentNode.removeChild(window.frameElement);
					
					btn.parent().attr('data-empty', 'false').removeClass('hasFrame');

					inp.val(localStorage.getItem('CUSTOMDESIGN-VARIATION-COPY')).change();
					
				break;
				case 'apply': 
					if (confirm('<?php 
						echo $customdesign->lang('Are you sure that you want to apply this config to all other variations?'); 
					?>')) {
						
						let data = encodeURIComponent(
							JSON.stringify({
								stages: enjson(customdesign.product.get_stages($('#customdesign-stages-wrp'))),
								printing: encodeURIComponent(JSON.stringify(customdesign.product.get_printing(wrp)))
							})
						);
						
						window.parent.jQuery('textarea.customdesign-vari-inp').val(data);
						window.parent.jQuery('div.variable_customdesign_data').attr('data-empty', 'false');
						window.parent.jQuery('div.variable_customdesign_data iframe').each(function() {
							if (this !== window.frameElement) {
								$(this).parent().attr({'data-empty': 'false', 'is': 'nonempty'}).removeClass('hasFrame');
								$(this).remove();
							}
						});
						window.parent.jQuery('div#woocommerce-product-data').append(`<div class="UIloading blockUI blockOverlay" style="z-index: 1000; border: none; margin: 0px; padding: 0px; width: 100%; height: 100%; top: 0px; left: 0px; background: rgb(255, 255, 255); opacity: 0.6; cursor: wait; position: absolute;"></div>`);
						
						$.ajax({
							url: window.location.href,
							method: 'POST',
							data: {
								data	: data,
								apply_all_variations	: 1
							},
							success: (res) => {
								window.parent.jQuery('div#woocommerce-product-data div.UIloading').remove();
								window.parent.jQuery('div#variable_product_options div.toolbar button')
										.attr({'disabled': 'disabled'});
										
							}
						});
						
					}
				break;
			}
			
		};
		
		fitIframe();
		
		setTimeout(fitIframe, 1000);
		
	}).click();

})();
</script>
</body>
</html>