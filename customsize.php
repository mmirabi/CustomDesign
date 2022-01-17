<?php
/* 
Plugin Name: Custom Size
Plugin URI: https://rugcustom.com/
Descripstion: Custom Size, Price, Product time formula.
Author: Mehdi Mirabi
Version: 1.0.0
Author URI: https://mehdimirabi.com
*/

if(!defined('DS')) {
    if(DIRECTORY_SEPARTOR == "\\"){
        // windows type
        define('DS', "/" );
    } else {
        // linux type
        define('DS', DIRECTORY_SEPARTOR );
    }
}
if(!defined('CUSTOMSIZE_WOO')) {
    define('CUSTOMSIZE_WOO', '1.0.0' );
}
if(!defined( 'CUSTOMSIZE_FILE' )) {
    define('CUSTOMSIZE_FILE', ___FILE__ );
    define('CUSTOMSIZE_PLUGIN_BASENAME', plugin_basename(CUSTOMSIZE_FILE));
}
function customsize_lang() {
    global $customsize;
    return isset($customsize) ? esc_html($customsize->lang($s)) : $s;
}

calss customsize_woocommerce {
     
    public $url;

    public $admin_url;

    public $path;

    public $app_path;

    public $upload_url;

    public $upload_path;
}