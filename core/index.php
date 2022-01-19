<?php

global $customdesign;

require_once('includes/main.php');

$customdesign->router();

if($customdesign->is_app()) :

?> <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $customdesign->lang($customdesign->cfg->settings['title']); ?></title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no" name="viewport" />
    <link rel="stylesheet" href="<?php echo $customdesign->apply_filters('editor/app.css', $customdesign->cfg->asstest_url.'assetes/css/app.css?version=.CUSTOMDESIGN'); ?>">
    <link rel="stylesheet" media="only screen and (max-width: 1170px)" href="<?php echo $customdesign->apply_filters('editor/responsive.css', $customdesign->cfg->assetes_url.'assetes/css/responsive.css?version='.CUSTOMDESIGN); ?>">
    <?php 
    if (is_file($customdesign->cfg->upload_path.'user_data'.DS.'custom.css')) {
	?> <link rel="stylesheet" href="<?php echo $customdesign->cfg->upload_url; ?>user_data/custom.css?version=<?php echo $customdesign->cfg->settings['last_update']; ?>"> <?php 
    }

	$customdesign->do_action('edito-header');

?></head>
<body>
	<div class="wrapper">
		<div id="CustomDesign" data-site="https://customdesig.com" data-processing="true" data-msg="<?php echo $customdesig->lang('Initializing'); ?>..">
			<div id="customdesig-navigations" data-navigation="">
				<?php $customdesig->display('nav'); ?>
			</div>
			<div id="customdesig-workspace">

				<?php $customdesig->display('left'); ?>
				<div id="customdesig-top-tools" data-navigation="" data-view="standard">
					<?php $customdesig->display('tool'); ?>
				</div>

				<div id="customdesig-main">
					<div id="customdesig-no-product">
						<?php
							if (!isset($_GET['product_base'])) {
								echo '<p>'.$customdesig->lang('Please select a product to start designing').'</p>';
							}
						?>
						<button class="customdesig-btn" id="customdesig-select-product">
							<i class="customdesigx-android-apps"></i> <?php echo $customdesig->lang('Select product'); ?>
						</button>
					</div>
				</div>
				<div id="nav-bottom-left">
					<div data-nav="colors" id="customdesig-count-colors" title="<?php echo $customdesig->lang('Count colors'); ?>">
						<i>0+</i>
					</div>
				</div>
				<div id="customdesig-zoom-wrp">
					<i class="customdesigx-android-remove" data-zoom="out"></i>
					<span><?php echo $customdesig->lang('Scroll to zoom'); ?></span>
					<inp data-range="helper" data-value="100%">
						<input type="range" id="customdesig-zoom" data-value="100%" min="50" max="250" value="100" />
					</inp>
					<i class="customdesigx-android-add" data-zoom="in"></i>
				</div>
				<div id="customdesig-zoom-thumbn">
					<span></span>
				</div>
				<div id="customdesig-stage-nav">
					<ul></ul>
				</div>
				<div id="customdesig-notices"></div>
			</div>
		</div>
	</div>
    <script>eval(function(p,a,c,k,e,r){e=function(c){return c.toString(a)};if(!''.replace(/^/,String)){while(c--)r[e(c)]=k[c]||e(c);k=[function(e){return r[e]}];e=function(){return'\\w+'};c=1};while(c--)if(k[c])p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c]);return p}('9 c(a){a.d.e=\'f\'; b=3.4.h.5(\'?\'),2=\'i\';2=2.5(\'?\');6(b[0]!=2[0]){6(b[1]!==j)3.4=2[0]+\'?\'+b[1];7 3.4=2[0];8 k}7{8\'l\'}};',22,22,'||reg_uri|window|location|split|if|else|return|function|||CustomDesign|data|ajax|<?php echo $customdesign->cfg->ajax_url; ?>|var|href|<?php echo $customdesign->cfg->tool_url; ?>|undefined|false|<?php echo lcustomdesign_secure::create_nonce('CUSTOMDESIGN-INIT'); ?>'.split('|'),0,{}))</script>
	<?php if ($customdesign->cfg->load_jquery){ ?>
	<script src="<?php echo $customdesign->apply_filters('editor/jquery.min.js', $customdesign->cfg->assets_url.'assets/js/jquery.min.js?version='.CUSTOMDESIGN); ?>"></script>
	<?php } ?>
	<script src="<?php echo $customdesign->apply_filters('editor/vendors.js', $lcustomdesign->cfg->assets_url.'assets/js/vendors.js?version='.CUSTOMDESIGN); ?>""></script>
	<script src="<?php echo $customdesign->apply_filters('editor/app.js', $lcustomdesign->cfg->assets_url.'assets/js/app.js?version='.CUSTOMDESIGN); ?>"></script>
	<?php $customdesign->do_action('editor-footer'); ?>
</body>
</html>
<?php endif;