<?php
	global $magic;

	$key = $magic->get_option('purchase_key');
	$key_valid = ($key === null || empty($key) || strlen($key) != 36 || count(explode('-', $key)) != 5) ? false : true;

	$key_addon_bundle = $magic->get_option('purchase_key_addon_bundle');
	$key_valid_addon_bundle = ($key_addon_bundle === null || empty($key_addon_bundle) || strlen($key_addon_bundle) != 36 || count(explode('-', $key_addon_bundle)) != 5) ? false : true;

	$key_addon_vendor = $magic->get_option('purchase_key_addon_vendor');
	$key_valid_addon_vendor = ($key_addon_vendor === null || empty($key_addon_vendor) || strlen($key_addon_vendor) != 36 || count(explode('-', $key_addon_vendor)) != 5) ? false : true;

	$key_addon_printful = $magic->get_option('purchase_key_addon_printful');
	$key_valid_addon_printful = ($key_addon_printful === null || empty($key_addon_printful) || strlen($key_addon_printful) != 36 || count(explode('-', $key_addon_printful)) != 5) ? false : true;
?>

<style type="text/css">
	ul.magic_tab_nav_remake{
		margin-left: 0px !important;
	}
	ul.magic_tab_nav_remake li{
		list-style-type: none;
	}
	ul.magic_tab_nav_remake li a{
		text-decoration: none;
	}
	.mb0{
		margin: 15px 0px !important;
		display: inline-block;
	    float: left;
	    width: 100%;
	}
</style>
<div class="magic_wrapper">

	<div id="magic-license">
		<h1>
			<?php echo $magic->lang('License verification'); ?>
		</h1>
		<?php if ($key_valid): ?>
			<div class="magic-update-notice">
				<?php echo $magic->lang('You must verify your purchase code before updating and access to all features'); ?>.	
			</div>
		<?php endif ?>

		<?php $magic->views->header_message(); ?>

		<div class="magic_tabs_wrapper magic_form_settings" data-id="license-verification">
			<ul class="magic_tab_nav_remake">
				<li class="active"><a href="#magic-tab-license-plugin">License verification</a></li>
				<li><a href="#magic-tab-addon-bundle">License addon bundle</a></li>
				<?php if ($magic->connector->platform == 'woocommerce'): ?>
				<li><a href="#magic-tab-addon-vendor">License addon vendor</a></li>
				<?php endif; ?>
				<?php if ($magic->connector->platform == 'woocommerce'): ?>
				<li><a href="#magic-tab-addon-printful">License addon printful</a></li>
				<?php endif; ?>
			</ul>
			<div class="magic_tabs">
				<div class="magic_tab_content active" id="magic-tab-license-plugin" >

					<?php if ($key_valid): ?>
						<div class="magic-update-notice success">
							<?php echo $magic->lang('Your license has been verified, now your MagicRugs will be updated automatically and have access to all features'); ?>.
						</div>
					<?php endif; ?>
					<form action="" method="POST" id="magic-license-form">
						<?php if ($key_valid) { ?>
						<input type="password" name="key" readonly size="58" value="<?php echo $key; ?>" placeholder="<?php echo $magic->lang('Enter your purchase code'); ?>" />
						<input type="hidden" name="do_action" value="revoke-license" />
						<button type="submit" class="magic_btn danger">
							<?php echo $magic->lang('Revoke this license'); ?>
						</button>
						<script type="text/javascript">
							jQuery('#magic-license-form').on('submit', function(e) {
								if (!confirm("<?php echo $magic->lang('Are you sure? After revoking the license you can use it to verify another domain but you will not be able to use it to verify this domain again'); ?>.")) {
									e.preventDefault();
								} else {
									jQuery('#magic-license-form button.magic_btn').html('<i style="font-size: 16px;" class="fa fa-circle-o-notch fa-spin fa-fw"></i> please wait..');
								}
							});
						</script>
						<?php } else { ?>
						<input type="password" name="key" size="58" value="<?php echo $key; ?>" placeholder="<?php echo $magic->lang('Enter your purchase code'); ?>" />
						<input type="hidden" name="do_action" value="verify-license" />
						<button type="submit" class="magic_btn primary loaclik">
							<?php echo $magic->lang('Verify Now'); ?>
						</button>
						&nbsp; 
						<a class="magic_btn" href="https://www.magicrugs.com/pricing/?utm_source=client-site&utm_medium=text&utm_campaign=license-page&utm_term=links&utm_content=<?php echo $magic->connector->platform; ?>" target=_blank>
							<?php echo $magic->lang('Buy a license'); ?>
						</a>
						<?php } ?>
					</form>

				</div>
				<div class="magic_tab_content" id="magic-tab-addon-bundle" >
					
					<?php if ($key_valid_addon_bundle): ?>
						<div class="magic-update-notice success">
							<?php echo $magic->lang('Your license has been verified, now your MagicRugs will be updated automatically and have access to all features'); ?>.
						</div>
					<?php endif; ?>
					<form action="" method="POST" id="magic-license-form-addon-bundle">
						<?php if ($key_valid_addon_bundle) { ?>
						<input type="password" name="key" readonly size="58" value="<?php echo $key_addon_bundle; ?>" placeholder="<?php echo $magic->lang('Enter your purchase code'); ?>" />
						<input type="hidden" name="do_action" value="revoke-license-addon-bundle" />
						<button type="submit" class="magic_btn danger">
							<?php echo $magic->lang('Revoke this license'); ?>
						</button>
						<script type="text/javascript">
							jQuery('#magic-license-form-addon-bundle').on('submit', function(e) {
								if (!confirm("<?php echo $magic->lang('Are you sure? After revoking the license you can use it to verify another domain but you will not be able to use it to verify this domain again'); ?>.")) {
									e.preventDefault();
								} else {
									jQuery('#magic-license-form-addon-bundle button.magic_btn').html('<i style="font-size: 16px;" class="fa fa-circle-o-notch fa-spin fa-fw"></i> please wait..');
								}
							});
						</script>
						<?php } else { ?>
						<input type="password" name="key" size="58" value="<?php echo $key_addon_bundle; ?>" placeholder="<?php echo $magic->lang('Enter your purchase code'); ?>" />
						<input type="hidden" name="do_action" value="verify-license-addon-bundle" />
						<button type="submit" class="magic_btn primary loaclik">
							<?php echo $magic->lang('Verify Now'); ?>
						</button>
						&nbsp; 
						<a class="magic_btn" href="https://codecanyon.net/item/addons-bundle-for-magic-product-designer/25824664" target=_blank>
							<?php echo $magic->lang('Buy a license'); ?>
						</a>
						<?php } ?>
					</form>

				</div>
				<?php if ($magic->connector->platform == 'woocommerce'): ?>
				<div class="magic_tab_content" id="magic-tab-addon-vendor" >
					
					<?php if ($key_valid_addon_vendor): ?>
						<div class="magic-update-notice success">
							<?php echo $magic->lang('Your license has been verified, now your MagicRugs will be updated automatically and have access to all features'); ?>.
						</div>
					<?php endif; ?>
					<form action="" method="POST" id="magic-license-form-addon-vendor">
						<?php if ($key_valid_addon_vendor) { ?>
						<input type="password" name="key" readonly size="58" value="<?php echo $key_addon_vendor; ?>" placeholder="<?php echo $magic->lang('Enter your purchase code'); ?>" />
						<input type="hidden" name="do_action" value="revoke-license-addon-vendor" />
						<button type="submit" class="magic_btn danger">
							<?php echo $magic->lang('Revoke this license'); ?>
						</button>
						<script type="text/javascript">
							jQuery('#magic-license-form-addon-vendor').on('submit', function(e) {
								if (!confirm("<?php echo $magic->lang('Are you sure? After revoking the license you can use it to verify another domain but you will not be able to use it to verify this domain again'); ?>.")) {
									e.preventDefault();
								} else {
									jQuery('#magic-license-form-addon-vendor button.magic_btn').html('<i style="font-size: 16px;" class="fa fa-circle-o-notch fa-spin fa-fw"></i> please wait..');
								}
							});
						</script>
						<?php } else { ?>
						<input type="password" name="key" size="58" value="<?php echo $key_addon_vendor; ?>" placeholder="<?php echo $magic->lang('Enter your purchase code'); ?>" />
						<input type="hidden" name="do_action" value="verify-license-addon-vendor" />
						<button type="submit" class="magic_btn primary loaclik">
							<?php echo $magic->lang('Verify Now'); ?>
						</button>
						&nbsp; 
						<a class="magic_btn" href="https://codecanyon.net/item/vendors-design-launcher-addon-for-magic-product-designer/24082588" target=_blank>
							<?php echo $magic->lang('Buy a license'); ?>
						</a>
						<?php } ?>
					</form>
				</div>
				<?php endif; ?>

				<?php if ($magic->connector->platform == 'woocommerce'): ?>
				<div class="magic_tab_content" id="magic-tab-addon-printful" >
					
					<?php if ($key_valid_addon_printful): ?>
						<div class="magic-update-notice success">
							<?php echo $magic->lang('Your license has been verified, now your MagicRugs will be updated automatically and have access to all features'); ?>.
						</div>
					<?php endif; ?>
					<form action="" method="POST" id="magic-license-form-addon-printful">
						<?php if ($key_valid_addon_printful) { ?>
						<input type="password" name="key" readonly size="58" value="<?php echo $key_addon_printful; ?>" placeholder="<?php echo $magic->lang('Enter your purchase code'); ?>" />
						<input type="hidden" name="do_action" value="revoke-license-addon-printful" />
						<button type="submit" class="magic_btn danger">
							<?php echo $magic->lang('Revoke this license'); ?>
						</button>
						<script type="text/javascript">
							jQuery('#magic-license-form-addon-printful').on('submit', function(e) {
								if (!confirm("<?php echo $magic->lang('Are you sure? After revoking the license you can use it to verify another domain but you will not be able to use it to verify this domain again'); ?>.")) {
									e.preventDefault();
								} else {
									jQuery('#magic-license-form-addon-printful button.magic_btn').html('<i style="font-size: 16px;" class="fa fa-circle-o-notch fa-spin fa-fw"></i> please wait..');
								}
							});
						</script>
						<?php } else { ?>
						<input type="password" name="key" size="58" value="<?php echo $key_addon_printful; ?>" placeholder="<?php echo $magic->lang('Enter your purchase code'); ?>" />
						<input type="hidden" name="do_action" value="verify-license-addon-printful" />
						<button type="submit" class="magic_btn primary loaclik">
							<?php echo $magic->lang('Verify Now'); ?>
						</button>
						&nbsp; 
						<a class="magic_btn" href="https://codecanyon.net/item/vendors-design-launcher-addon-for-magic-product-designer/24082588" target=_blank>
							<?php echo $magic->lang('Buy a license'); ?>
						</a>
						<?php } ?>
					</form>
				</div>
				<?php endif; ?>
			</div>
		</div>

		<h3 class="mb0"><?php echo $magic->lang('More details'); ?></h3>
		<ul>
			<li><?php echo $magic->lang('The license key is the purchase code which was created at Envato after purchasing the product'); ?>.</li>
			<li><?php echo $magic->lang('You can not use a license for more than one domain, but you can revoke it from an unused domain to verify the new domain'); ?>.</li>
			<li><?php echo $magic->lang('Once you have revoked your license at a domain, you will not be able to use it to verify that domain again'); ?>.</li>
			<li><?php echo $magic->lang('Each license can only be verified up to 3 times, including your localhost and excluding subdomains or subfolders'); ?>.</li>
			<li>
				<a href="https://help.market.envato.com/hc/en-us/articles/202822600-Where-Is-My-Purchase-Code" target=_blank><?php echo $magic->lang('How to find the purchase code'); ?>?</a> 
				<?php echo $magic->lang('If you do not have a license yet'); ?> 
				<a href="https://www.magicrugs.com/pricing/?utm_source=client-site&utm_medium=text&utm_campaign=license-page&utm_term=links&utm_content=<?php echo $magic->connector->platform; ?>" target=_blank><?php echo $magic->lang(' get a purchase code'); ?>.</a>
			</li>
		</ul>

	</div>

</div>
<style type="text/css">
	
/* Tab style */
.magic_tabs_wrapper {
    float: left;
    width: 100%;
}

.magic_tab_nav_remake {
    float: left;
    width: 100%;
}

.magic_tab_nav_remake li {
    float: left;
}

html body .magic_wrapper .magic_tab_nav_remake li a {
    display: inline-block;
    font-weight: 500;
    color: #54575a !important;
    padding: 10px 20px;
    background: #f3f3f3;
    letter-spacing: 0.3px;
    margin-right: -1px;
    border: 1px solid #c7c7c7;
    position: relative;
    z-index: 11;
    white-space: nowrap;
    user-select: none;
    -webkit-user-select: none;
}
html body .magic_wrapper .magic_tab_nav_remake li:not([data-add]) a i{
    display: inline-block;
    padding: 0px;
    width: 0px;
    margin: 0px;
}
html body .magic_wrapper .magic_tab_nav_remake li:not([data-add]) a>i:before{
    display: none;
}
html body .magic_wrapper .magic_tab_nav_remake li a>i:hover:before{
    color: #000 !important;
}
html body .magic_wrapper .magic_tab_nav_remake li.active a>i{
    width: auto;
    position: relative;
    bottom: -2px;
    right: 3px;
}
html body .magic_wrapper .magic_tab_nav_remake li:not([data-add]) a>i:after{
    position: absolute;
    content: "";
    top: 0px;
    left: 0px;
    width: 100%;
    height: 101%;
    z-index: 1;
}
html body .magic_wrapper .magic_tab_nav_remake li.active:not([data-add]) a>i:after{
    z-index: -1;
}
html body .magic_wrapper .magic_tab_nav_remake li.active a>i:before{
    display: inline-block;
    color: #969696;
    transition: all ease 250ms;
    bottom: -2px;
    position: relative;
}
.magic_content .magic_tab_nav_remake li a:hover {
    background: #fff;
    text-decoration: none;
    opacity: 1 !important;
}
html body .magic_wrapper .magic_tab_nav_remake li[data-add] a>i{
    display: inline-block;
    margin: 0;
    font-size: 14px !important;
    height: 16px;
}
html body .magic_wrapper .magic_tab_nav_remake li.active a {
    background: #fff;
    color: #393749;
    border-bottom-color: #fff;
}
html body .magic_wrapper .magic_tab_nav_remake li a text{
    padding: 3px 5px;
    border: 1px dashed transparent;
    position: relative;
    top: 0px;
    transition: all ease 100ms;
    min-height: 23px;
}
html body .magic_wrapper .magic_tab_nav_remake li.active a text{
    cursor: text;
}
.magic-stages-wrp .magic_tab_nav_remake li.active a text:after{
    content: "\f040";
    padding: 0 5px;
    color: #cccccc;
    float: right;
    font: normal normal normal 14px/1 FontAwesome;
    font-size: 12px;
    text-rendering: auto;
    -webkit-font-smoothing: antialiased;
    margin-top: 4px;
    cursor: pointer;
    transition: color ease 250ms;
}
.magic-stages-wrp .magic_tab_nav_remake li.active a text:hover:after{
    color: #54575a;
}
html body .magic_wrapper .magic_tab_nav_remake li a span{
    margin-top: -10px;
    margin-bottom: -10px;
}
html body .magic_wrapper .magic_tab_nav_remake li a img{
    height: 30px;
    display: inline-block;
    border-radius: 2px;
    transition: opacity ease 250ms;
}
html body .magic_wrapper .magic_tab_nav_remake li.active a img:hover{
    opacity: 0.5;
}
html body .magic_wrapper .magic_tab_nav_remake li a span+i:before{
    display: none !important; 
}
.magic_tabs {
    float: left;
    width: 100%;
    border: 1px solid #c7c7c7;
    padding: 20px;
    margin-top: -1px;
}

.magic_tab_content.active {
    display: block;
}
#magic-tab-design h3 {
    font-weight: 400;
    font-size: 22px;
}
.magic_tab_content {
    float: left;
    width: 100%;
    display: none;
    -webkit-animation: fadeEffect 0.4s;
    animation: fadeEffect 0.4s;
}
.magic_tab_content div[data-view="table"] {
    overflow: auto;
    max-height: 400px;
}
.magic_content div[data-view="table"] table tbody td:first-child{
    width: 80px;
}
#magic-popup, .magic-popup {
    position: fixed;
    top: 0px;
    left: 0px;
    height: 100vh;
    width: 100vw;
    text-align: center;
    background: rgba(0, 0, 0, 0.69);
    display: none;
    z-index: 1000000000000;
}

.magic-popup-content {
    width: 1080px;
    max-width: 80%;
    height: 80vh;
    margin: 0 auto 0;
    background: #fff;
    position: relative;
    z-index: 1;
    border-radius: 4px;
    overflow: hidden;
    top: calc(10vh - 15px);
}

.magic-popup-content.magic-multi-cliparts {
    width: 60%;
}

.magic-multi-cliparts .magic_form_group > span{
    width: 140px;
}
.magic-multi-cliparts .magic_form_group .magic_form_content{
    width: calc(100% - 140px);
    max-width: 100%;
    text-align: left;
}
.magic-multi-cliparts .magic_form_group input[type="text"]{
    max-width: 100%;
}
</style>

<script type="text/javascript">
$(document).ready(function(){
	var urlPara = window.location.href;
	if(urlPara.indexOf('#') != -1){
		var para = returnPara(urlPara);
		console.log(para);
		para = para.substring(1, para.length);

		$('ul.magic_tab_nav_remake li').removeClass('active');
		$('div.magic_tab_content').removeClass('active');

		$('ul.magic_tab_nav_remake li a[href="#'+para+'"]').parent().addClass('active');
		$('div.magic_tab_content[id="'+para+'"]').addClass('active');
	}

	function returnPara(url = ''){
		return url.match(/#.+$/g)[0];
	}

	$('ul.magic_tab_nav_remake a').click(function(){
		var active = $(this).attr('href').substring(1, $(this).attr('href').length);
		$('ul.magic_tab_nav_remake li').removeClass('active');
		$('div.magic_tab_content').removeClass('active');

		$(this).parent().addClass('active');
		$('div.magic_tab_content[id="'+active+'"]').addClass('active');
	});
});
</script>