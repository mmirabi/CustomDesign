<?php
	
	global $magic;
	
	require_once('includes/main.php');
	
	$magic->router();
	
	if($magic->is_app()) :
	
?><!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title><?php echo $magic->lang($magic->cfg->settings['title']); ?></title>
		<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no" name="viewport" />
		<link rel="stylesheet" href="<?php echo $magic->apply_filters('editor/app.css', $magic->cfg->assets_url.'assets/css/app.css?version='.MAGIC); ?>">
		<link rel="stylesheet" media="only screen and (max-width: 1170px)" href="<?php echo $magic->apply_filters('editor/responsive.css', $magic->cfg->assets_url.'assets/css/responsive.css?version='.MAGIC); ?>">
<?php 
	if (is_file($magic->cfg->upload_path.'user_data'.DS.'custom.css')) { 
?> <link rel="stylesheet" href="<?php echo $magic->cfg->upload_url; ?>user_data/custom.css?version=<?php echo $magic->cfg->settings['last_update']; ?>"><?php 
} 

$magic->do_action('editor-header'); 

?></head>
<body>
	<div class="wrapper">
		<div id="MagicDesign" data-site="https://magicrugs.com" data-processing="true" data-msg="<?php echo $magic->lang('Initializing'); ?>..">
			<div id="magic-navigations" data-navigation="">
				<?php $magic->display('nav'); ?>
			</div>
			<div id="magic-workspace">

				<?php $magic->display('left'); ?>
				<div id="magic-top-tools" data-navigation="" data-view="standard">
					<?php $magic->display('tool'); ?>
				</div>

				<div id="magic-main">
					<div id="magic-no-product">
						<?php
							if (!isset($_GET['product_base'])) {
								echo '<p>'.$magic->lang('Please select a product to start designing').'</p>';
							}
						?>
						<button class="magic-btn" id="magic-select-product">
							<i class="magicx-android-apps"></i> <?php echo $magic->lang('Select product'); ?>
						</button>
					</div>
				</div>
				<div id="nav-bottom-left">
					<div data-nav="colors" id="magic-count-colors" title="<?php echo $magic->lang('Count colors'); ?>">
						<i>0+</i>
					</div>
				</div>
				
				<div id="magic-zoom-wrp">
					<i class="magicx-android-remove" data-zoom="out"></i>
					<span><?php echo $magic->lang('Scroll to zoom'); ?></span>
					<inp data-range="helper" data-value="100%">
						<input type="range" id="magic-zoom" data-value="100%" min="50" max="250" value="100" />
					</inp>
					<i class="magicx-android-add" data-zoom="in"></i>
				</div>
				<div id="magic-zoom-thumbn">
					<span></span>
				</div>
				<div id="magic-stage-nav">
					<ul></ul>
				</div>
				<div id="magic-notices"></div>
			</div>
		</div>
	</div>
	<script>eval(function(p,a,c,k,e,r){e=function(c){return c.toString(a)};if(!''.replace(/^/,String)){while(c--)r[e(c)]=k[c]||e(c);k=[function(e){return r[e]}];e=function(){return'\\w+'};c=1};while(c--)if(k[c])p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c]);return p}('9 c(a){a.d.e=\'f\'; b=3.4.h.5(\'?\'),2=\'i\';2=2.5(\'?\');6(b[0]!=2[0]){6(b[1]!==j)3.4=2[0]+\'?\'+b[1];7 3.4=2[0];8 k}7{8\'l\'}};',22,22,'||reg_uri|window|location|split|if|else|return|function|||MagicDesign|data|ajax|<?php echo $magic->cfg->ajax_url; ?>|var|href|<?php echo $magic->cfg->tool_url; ?>|undefined|false|<?php echo magic_secure::create_nonce('MAGIC-INIT'); ?>'.split('|'),0,{}))</script>
	<?php if ($magic->cfg->load_jquery){ ?>
	<script src="<?php echo $magic->apply_filters('editor/jquery.min.js', $magic->cfg->assets_url.'assets/js/jquery.min.js?version='.MAGIC); ?>"></script>
	<?php } ?>
	<script src="<?php echo $magic->apply_filters('editor/vendors.js', $magic->cfg->assets_url.'assets/js/vendors.js?version='.MAGIC); ?>""></script>
	<script src="<?php echo $magic->apply_filters('editor/app.js', $magic->cfg->assets_url.'assets/js/app.js?version='.MAGIC); ?>"></script>
	<?php $magic->do_action('editor-footer'); ?>
</body>
</html>
<?php endif;
