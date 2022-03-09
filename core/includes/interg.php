<?php
	
function magic_cms_product_data_fields($ops, $js_cfg, $id) {
    
    global $magic;
    
    $product = isset($ops['magic_product_base']) ? $ops['magic_product_base'] : '';
    $design = isset($ops['magic_design_template']) ? $ops['magic_design_template'] : '';
    $customize = isset($ops['magic_customize']) ? $ops['magic_customize'] : '';
    $addcart = isset($ops['magic_disable_add_cart']) ? $ops['magic_disable_add_cart'] : '';

    ?>
	<link rel="stylesheet" href="<?php echo $magic->cfg->assets_url; ?>admin/assets/css/interg.css?version=<?php echo MAGIC; ?>" type="text/css" media="all" />
    <div id="magic_product_data" class="panel woocommerce_options_panel">
        <p class="form-field magic_customize_field options_group hidden" id="magic-enable-customize">
			<label for="magic_customize">
				<strong><?php echo $magic->lang('Hide cart button'); ?>:</strong>
			</label>
			<span class="magic-toggle">
				<input type="checkbox" name="magic_disable_add_cart"  <?php
				if ($addcart == 'yes')echo 'checked';
			?> id="magic_customize" value="yes" />
				<span class="magic-toggle-label" data-on="Yes" data-off="No"></span>
				<span class="magic-toggle-handle"></span>
			</span>
			<span style="float: left;margin-left: 10px;">
				<?php echo $magic->lang('Hide the Add To Cart button in product details page'); ?>
			</span>
		</p>
		<p class="form-field magic_customize_field options_group hidden" id="magic-enable-customize">
			<label for="magic_customize">
				<strong><?php echo $magic->lang('Allow customize'); ?>:</strong>
			</label>
			<span class="magic-toggle">
				<input type="checkbox" name="magic_customize"  <?php
				if ($customize != 'no')echo 'checked';
			?> id="magic_customize" value="yes" />
				<span class="magic-toggle-label" data-on="Yes" data-off="No"></span>
				<span class="magic-toggle-handle"></span>
			</span>
			<span style="float: left;margin-left: 10px;">
				<?php echo $magic->lang('Users can change or customize the design before checkout.'); ?>
			</span>
		</p>
        <div id="magic-product-base" class="options_group"></div>
        <p id="magic-seclect-base">
	        <a href="#" class="magic-button magic-button-primary magic-button-large" data-func="products">
		        <i class="fa fa-cubes"></i>
		        <?php echo $magic->lang('Select product base'); ?>
		    </a>
		    &nbsp;
		    <a href="#" title="<?php echo $magic->lang('Remove product base'); ?>" class="magic-button magic-button-link-delete magic-button-large hidden" data-func="remove-base-product">
		        <i class="fa fa-trash"></i>
		        <?php echo $magic->lang('Remove product'); ?>
		    </a>
        </p>
        <?php $magic->do_action( 'product-magic-option-tab' ); ?>
        <input type="hidden" value="<?php echo $product; ?>" name="magic_product_base" id="magic_product_base" />
        <input type="hidden" value="<?php echo $design; ?>" name="magic_design_template" id="magic_design_template" />
    </div>
<?php 
	
	$js_cfg = array_merge(array(
		'nonce_backend' => magic_secure::create_nonce('MAGIC-SECURITY-BACKEND'),
		'ajax_url' => $magic->cfg->ajax_url,
		'admin_ajax_url' => $magic->cfg->admin_ajax_url,
		'is_admin' => is_admin(),
		'admin_url' => $magic->cfg->admin_url,
		'assets_url' => $magic->cfg->assets_url,
		'upload_url' => $magic->cfg->upload_url,
		'inline_edit' => (isset($ops['inline_edit']) ? $ops['inline_edit'] : true),
		'current_product' => (isset($id) && !empty($id) ? $id : 0),
		'color' => explode(':', ($magic->cfg->settings['colors'] ? $magic->cfg->settings['colors'] : ''))[0],
		'_i42' => $magic->lang('No items found'),
    	'_i62' => $magic->lang('Products'),
    	'_i64' => $magic->lang('Select product'),
    	'_i63' => $magic->lang('Search product'),
    	'_i56' => $magic->lang('Categories'),
    	'_i57' => $magic->lang('All categories'),
    	'_i58' => $magic->lang('Select template'),
    	'_i59' => $magic->lang('Create new'),
    	'_i60' => $magic->lang('Stages'),
    	'_i61' => $magic->lang('Edit Product Base'),
		'_i65' => $magic->lang('Start Over'),
    	'_i66' => $magic->lang('Design templates'),
    	'_i67' => $magic->lang('Search design templates'),
    	'_i68' => $magic->lang('Load more'),
    	'_i69' => $magic->lang('Clear design template'),
    	'_i70' => $magic->lang('Clear'),
    	'_i71' => $magic->lang('You need to choose a product base to enable magicrugs Editor for this product.'),
    	'_i72' => $magic->lang('Download'),
    	'_i73' => $magic->lang('Download design template'),
    	'_front' => $magic->lang($magic->cfg->settings['label_stage_1']),
    	'_back' => $magic->lang($magic->cfg->settings['label_stage_2']),
    	'_left' => $magic->lang($magic->cfg->settings['label_stage_3']),
    	'_right' => $magic->lang($magic->cfg->settings['label_stage_4']),
	), $js_cfg);
	
	echo '<script type="text/javascript">';
	echo 'var magicjs='.json_encode($js_cfg).';';
	echo '</script>';
	echo '<script type="text/javascript" src="'.$magic->cfg->assets_url.'admin/assets/js/interg.js?version='.MAGIC.'"></script>';

}

