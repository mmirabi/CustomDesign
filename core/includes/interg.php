<?php
	
function customdesign_cms_product_data_fields($ops, $js_cfg, $id) {
    
    global $customdesign;
    
    $product = isset($ops['customdesign_product_base']) ? $ops['customdesign_product_base'] : '';
    $design = isset($ops['customdesign_design_template']) ? $ops['customdesign_design_template'] : '';
    $customize = isset($ops['customdesign_customize']) ? $ops['customdesign_customize'] : '';
    $addcart = isset($ops['customdesign_disable_add_cart']) ? $ops['customdesign_disable_add_cart'] : '';

    ?>
	<link rel="stylesheet" href="<?php echo $customdesign->cfg->assets_url; ?>admin/assets/css/interg.css?version=<?php echo CUSTOMDESIGN; ?>" type="text/css" media="all" />
    <div id="customdesign_product_data" class="panel woocommerce_options_panel">
        <p class="form-field customdesign_customize_field options_group hidden" id="customdesign-enable-customize">
			<label for="customdesign_customize">
				<strong><?php echo $customdesign->lang('Hide cart button'); ?>:</strong>
			</label>
			<span class="customdesign-toggle">
				<input type="checkbox" name="customdesign_disable_add_cart"  <?php
				if ($addcart == 'yes')echo 'checked';
			?> id="customdesign_customize" value="yes" />
				<span class="customdesign-toggle-label" data-on="Yes" data-off="No"></span>
				<span class="customdesign-toggle-handle"></span>
			</span>
			<span style="float: left;margin-left: 10px;">
				<?php echo $customdesign->lang('Hide the Add To Cart button in product details page'); ?>
			</span>
		</p>
		<p class="form-field customdesign_customize_field options_group hidden" id="customdesign-enable-customize">
			<label for="customdesign_customize">
				<strong><?php echo $customdesign->lang('Allow customize'); ?>:</strong>
			</label>
			<span class="customdesign-toggle">
				<input type="checkbox" name="customdesign_customize"  <?php
				if ($customize != 'no')echo 'checked';
			?> id="customdesign_customize" value="yes" />
				<span class="customdesign-toggle-label" data-on="Yes" data-off="No"></span>
				<span class="customdesign-toggle-handle"></span>
			</span>
			<span style="float: left;margin-left: 10px;">
				<?php echo $customdesign->lang('Users can change or customize the design before checkout.'); ?>
			</span>
		</p>
        <div id="customdesign-product-base" class="options_group"></div>
        <p id="customdesign-seclect-base">
	        <a href="#" class="customdesign-button customdesign-button-primary customdesign-button-large" data-func="products">
		        <i class="fa fa-cubes"></i>
		        <?php echo $customdesign->lang('Select product base'); ?>
		    </a>
		    &nbsp;
		    <a href="#" title="<?php echo $customdesign->lang('Remove product base'); ?>" class="customdesign-button customdesign-button-link-delete customdesign-button-large hidden" data-func="remove-base-product">
		        <i class="fa fa-trash"></i>
		        <?php echo $customdesign->lang('Remove product'); ?>
		    </a>
        </p>
        <?php $customdesign->do_action( 'product-customdesign-option-tab' ); ?>
        <input type="hidden" value="<?php echo $product; ?>" name="customdesign_product_base" id="customdesign_product_base" />
        <input type="hidden" value="<?php echo $design; ?>" name="customdesign_design_template" id="customdesign_design_template" />
    </div>
<?php 
	
	$js_cfg = array_merge(array(
		'nonce_backend' => customdesign_secure::create_nonce('CUSTOMDESIGN-SECURITY-BACKEND'),
		'ajax_url' => $customdesign->cfg->ajax_url,
		'admin_ajax_url' => $customdesign->cfg->admin_ajax_url,
		'is_admin' => is_admin(),
		'admin_url' => $customdesign->cfg->admin_url,
		'assets_url' => $customdesign->cfg->assets_url,
		'upload_url' => $customdesign->cfg->upload_url,
		'inline_edit' => (isset($ops['inline_edit']) ? $ops['inline_edit'] : true),
		'current_product' => (isset($id) && !empty($id) ? $id : 0),
		'color' => explode(':', ($customdesign->cfg->settings['colors'] ? $customdesign->cfg->settings['colors'] : ''))[0],
		'_i42' => $customdesign->lang('No items found'),
    	'_i62' => $customdesign->lang('Products'),
    	'_i64' => $customdesign->lang('Select product'),
    	'_i63' => $customdesign->lang('Search product'),
    	'_i56' => $customdesign->lang('Categories'),
    	'_i57' => $customdesign->lang('All categories'),
    	'_i58' => $customdesign->lang('Select template'),
    	'_i59' => $customdesign->lang('Create new'),
    	'_i60' => $customdesign->lang('Stages'),
    	'_i61' => $customdesign->lang('Edit Product Base'),
		'_i65' => $customdesign->lang('Start Over'),
    	'_i66' => $customdesign->lang('Design templates'),
    	'_i67' => $customdesign->lang('Search design templates'),
    	'_i68' => $customdesign->lang('Load more'),
    	'_i69' => $customdesign->lang('Clear design template'),
    	'_i70' => $customdesign->lang('Clear'),
    	'_i71' => $customdesign->lang('You need to choose a product base to enable magicrugs Editor for this product.'),
    	'_i72' => $customdesign->lang('Download'),
    	'_i73' => $customdesign->lang('Download design template'),
    	'_front' => $customdesign->lang($customdesign->cfg->settings['label_stage_1']),
    	'_back' => $customdesign->lang($customdesign->cfg->settings['label_stage_2']),
    	'_left' => $customdesign->lang($customdesign->cfg->settings['label_stage_3']),
    	'_right' => $customdesign->lang($customdesign->cfg->settings['label_stage_4']),
	), $js_cfg);
	
	echo '<script type="text/javascript">';
	echo 'var customdesignjs='.json_encode($js_cfg).';';
	echo '</script>';
	echo '<script type="text/javascript" src="'.$customdesign->cfg->assets_url.'admin/assets/js/interg.js?version='.CUSTOMDESIGN.'"></script>';

}

