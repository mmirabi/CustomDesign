<?php
/*
Plugin Name: Magic Pro - Rugs Designer Tool
Plugin URI: https://www.magicrugs.com/
Description: The professional solution for designing & printing online
Author: Mehdi Mirabi
Version: 2.0
Author URI: http://mehdimirabi.com/
*/

if(!defined('DS')) {
	if(DIRECTORY_SEPARATOR == "\\"){
		// window type
		define('DS', "/" ); 
	} else {
		// linux type
		define('DS', DIRECTORY_SEPARATOR );
	}
}
if(!defined('MAGIC_WOO')) {
	define('MAGIC_WOO', '2.0.0' );
}
if ( ! defined( 'MAGIC_FILE' ) ) {
	define('MAGIC_FILE', __FILE__ );
	define('MAGIC_PLUGIN_BASENAME', plugin_basename(MAGIC_FILE));
}	

function magic_lang($s) {
	global $magic;
	return isset($magic) ? esc_html($magic->lang($s)) : $s;
}

class magic_woocommerce {
	    
    public $url;
    
    public $admin_url;
    
    public $path;
    
    public $app_path;
    
    public $upload_url;
    
    public $upload_path;
    
    public $assets_url;
	
    public $checkout_url;
    
    public $admin_assets_url;
    
    public $ajax_url;
    
    public $product_id;

    public $prefix;
	
	private $connector_file = 'woo_connector.php';

    public function __construct() {
        
        global $wpdb;
			
        $this->prefix = 'magic_';
		
		$this->url = site_url('/?magic=design');
		$this->tool_url = site_url('/?magic=design');
		
        $this->admin_url = admin_url('admin.php?page=magic');
        
        $this->path = dirname(__FILE__).DS;
        
        $this->app_path = $this->path . 'core'.DS;
        
        $this->upload_path = WP_CONTENT_DIR.DS.'uploads'.DS.'magic_data'.DS;
        
        $this->upload_url = content_url('uploads/magic_data/');
        
        $this->assets_url = plugin_dir_url(__FILE__) . 'core/';
        
        $this->admin_assets_url = plugin_dir_url(__FILE__) . 'core/admin/assets/';
        
        $this->ajax_url =  site_url('/?magic=ajax');
        
        $this->admin_ajax_url =  admin_url('?magic=ajax');
		
        $this->checkout_url =  site_url('/?magic=cart');

        define('MAGIC_PATH', $this->path . 'core'.DS);
        
        define('MAGIC_ADMIN_PATH', $this->path . 'core'.DS.'admin'.DS);

        register_activation_hook(__FILE__, array($this, 'activation'), 10);
        
		add_action( 'activated_plugin', array($this, 'activation_redirect'), 10 );

        //process ajax magic
		
        add_action( 'wp_loaded', array(&$this, 'loaded'), 10);
        add_action( 'init', array(&$this, 'init'), 4);
        add_action( 'template_redirect', array(&$this, 'page_display'), 10);
		
		if (is_admin()) {

	        // create tab custom field in add min product detail
	
	        add_filter('woocommerce_product_data_tabs', array(&$this, 'woo_add_tab_attr'));
	
	        add_filter('woocommerce_product_data_panels', array(&$this, 'woo_add_product_data_fields'));
	
	        add_action('woocommerce_process_product_meta', array(&$this, 'woo_process_product_meta_fields_save'));
			
			//admin hooks

	        add_action( 'admin_menu', array(&$this, 'menu_page') );
			 
	        add_action( 'woocommerce_after_order_itemmeta', array(&$this, 'woo_admin_after_order_itemmeta'), 999, 3 );
	        add_action( 'woocommerce_before_order_itemmeta', array(&$this, 'woo_admin_before_order_itemmeta'), 999, 3 );
			 
			if (isset($_GET['page']) && $_GET['page'] == 'magic'){
				add_action( 'wp_print_scripts', array(&$this, 'wpdocs_dequeue_script'), 100 );
			}
			
			add_action( 'admin_footer', array(&$this, 'admin_footer') );    	
	        
			add_action( 'admin_head', array(&$this, 'hide_wp_update_notice'), 1 );
			add_action( 'in_plugin_update_message-' .MAGIC_PLUGIN_BASENAME, array( &$this, 'update_message' ) );
	        add_filter( 'plugin_action_links_' . MAGIC_PLUGIN_BASENAME, array( &$this, 'plugin_action_links' ) );
	        add_filter( 'plugin_row_meta', array( &$this, 'plugin_row_meta' ), 10, 2 );
			add_filter( 'submenu_file', array( &$this, 'submenu_file'));
	        add_filter( 'woocommerce_order_item_get_quantity', array(&$this, 'woo_order_item_get_quantity' ), 10, 2 );
			add_filter( 'manage_edit-shop_order_columns', array(&$this, 'woo_magic_order_column'), 10, 1 );
			add_action( 'manage_shop_order_posts_custom_column', array(&$this, 'woo_magic_column_content') );
	        
	        add_action( 'admin_notices', array(&$this, 'admin_notices') );

	        if ($wpdb->get_var("SHOW TABLES LIKE 'magic_settings'") == 'magic_settings') {

		        $magic_update_core = $wpdb->get_results("SELECT `value` from `magic_settings` WHERE `key`='last_check_update'"); 
		        if (count($magic_update_core) == 1) {
		        	$this->update_core = @json_decode($magic_update_core[0]->value);
			    }
				
				$current = get_site_transient( 'update_plugins' );
				
				if (
					isset($this->update_core) && 
					version_compare(MAGIC_WOO, $this->update_core->version, '<') && 
					(
						!isset($current->response[MAGIC_PLUGIN_BASENAME]) ||
						$this->update_core->version > $current->response[MAGIC_PLUGIN_BASENAME]->new_version
					)
				) {
					$current->response[MAGIC_PLUGIN_BASENAME] = (Object)array(
						'package' => 'private',
						'new_version' => $this->update_core->version,
						'slug' => 'magic-hook-sfm'
					);
					set_site_transient('update_plugins', $current);
				}else if (
					isset($current) && 
					isset($current->response[MAGIC_PLUGIN_BASENAME]) &&
					MAGIC_WOO >= $current->response[MAGIC_PLUGIN_BASENAME]->new_version
				) {
					unset($current->response[MAGIC_PLUGIN_BASENAME]);
					set_site_transient('update_plugins', $current);
				}
			}
			
			$role = get_role('administrator');
			
			$role->add_cap('magic_access');
			$role->add_cap('magic_can_upload');
			
			$role->add_cap('magic_read_dashboard');
			$role->add_cap('magic_read_settings');
			$role->add_cap('magic_read_products');
			$role->add_cap('magic_read_cliparts');
			$role->add_cap('magic_read_templates');
			$role->add_cap('magic_read_orders');
			$role->add_cap('magic_read_shapes');
			$role->add_cap('magic_read_printings');
			$role->add_cap('magic_read_fonts');
			$role->add_cap('magic_read_shares');
			$role->add_cap('magic_read_bugs');
			$role->add_cap('magic_read_languages');
			$role->add_cap('magic_read_addons');
			
			$role->add_cap('magic_edit_settings');
			$role->add_cap('magic_edit_products');
			$role->add_cap('magic_edit_cliparts');
			$role->add_cap('magic_edit_templates');
			$role->add_cap('magic_edit_orders');
			$role->add_cap('magic_edit_shapes');
			$role->add_cap('magic_edit_printings');
			$role->add_cap('magic_edit_fonts');
			$role->add_cap('magic_edit_shares');
			$role->add_cap('magic_edit_languages');
			$role->add_cap('magic_edit_categories');
			$role->add_cap('magic_edit_tags');
			$role->add_cap('magic_edit_bugs');
			$role->add_cap('magic_edit_addons');
			$role->add_cap('magic_edit_distresss');
			   
		} else {
			// Add MagicRugs design to variations on add to cart form
			add_filter( 'woocommerce_available_variation', array(&$this, 'frontstore_variation'), 999, 3);
			
		}
		// Adds body classes
		add_filter( 'body_class', array( $this, 'magic_body_class' ), 999 );

		//enqueue style for frontend
		add_action( 'wp_enqueue_scripts', array(&$this, 'frontend_scripts'), 999);
		
        // render data in page cart

        add_filter('woocommerce_cart_shipping_packages', array(&$this, 'shipping_packages'), 999, 2);
        add_filter('woocommerce_get_item_data', array(&$this, 'woo_render_meta'), 999, 2);
        
		
		add_filter('woocommerce_cart_item_name', array(&$this, 'woo_cart_edit_design_btn'), 10, 2);
		add_filter('woocommerce_cart_item_thumbnail', array(&$this, 'woo_cart_design_thumbnails'), 10, 3);
		
		// add meta data attr cart to order
		if ( version_compare( get_option( 'woocommerce_version' ), '3.0', '<' ) ) 
			add_action('woocommerce_add_order_item_meta', array(&$this, 'woo_add_order_item_meta'), 1, 3);	
		else
			add_action('woocommerce_checkout_create_order_line_item',array(&$this, 'woo_checkout_create_order_line_item'), 20, 4);
		
		//remove cart item
		add_action('woocommerce_cart_item_removed', array(&$this, 'woo_cart_item_removed'), 1, 2);
		
        // save data to table product order
        add_action('woocommerce_new_order', array(&$this, 'woo_order_finish'), 20, 3);
		add_action('woocommerce_thankyou', array(&$this, 'woo_thank_you'), 20, 3);
		add_filter('woocommerce_loop_add_to_cart_link', array(&$this, 'woo_customize_link_list'), 999, 2);
		
        add_action( 'woocommerce_product_thumbnails', array(&$this, 'woo_add_template_thumbs' ), 30);
		
		//remove Order again button
		add_action( 'woocommerce_order_details_before_order_table', array(&$this, 'woo_order_details_before_order_table' ), 30);
		
		// Add custom price for items
        add_action('woocommerce_before_calculate_totals', array(&$this, 'woo_calculate_price'), 10, 1);
		
		// Add reorder button
		// add_filter( 'woocommerce_my_account_my_orders_actions', array(&$this, 'my_orders_actions'), 999, 2);
		
		/*cart display*/
        add_action( 'woocommerce_cart_item_quantity', array(&$this, 'woo_cart_item_quantity' ), 30, 3);
        add_action( 'woocommerce_checkout_cart_item_quantity', array(&$this, 'woo_checkout_cart_item_quantity' ), 30, 3);
        add_action( 'woocommerce_order_item_quantity_html', array(&$this, 'woo_order_item_quantity_html' ), 30, 3);
        // add_action( 'woocommerce_order_item_meta_start', array(&$this, 'woo_order_item_meta_start' ), 30, 3);
		
        add_filter( 'woocommerce_email_order_item_quantity', array(&$this, 'woo_email_order_item_quantity' ), 30, 2);
		
        add_filter( 'woocommerce_get_price_html', array(&$this, 'woo_product_get_price_html' ), 999, 2);
        //Was updated by update quantity of woo, so do not need to fake the price
        //add_filter( 'woocommerce_cart_item_price', array(&$this, 'woocommerce_cart_item_price' ), 999, 3);
        add_filter( 'woocommerce_widget_cart_item_quantity', array(&$this, 'woo_widget_cart_item_quantity' ), 999, 3);
		
		add_action( 'woocommerce_email_order_details', array(&$this, 'email_customer_designs' ), 11, 4 );
		add_action( 'woocommerce_order_details_after_order_table', array(&$this, 'myaccount_customer_designs' ), 10, 1 );
		
		add_action( 'woocommerce_after_add_to_cart_button', array(&$this, 'customize_button' ), 10, 2 );
		//hook delete order
		
        add_filter( 'before_delete_post', array(&$this, 'woo_remove_order' ), 999, 2);
		add_filter( 'display_post_states', array(&$this, 'add_display_post_states' ), 10, 2 );
		
		add_action( 'woocommerce_product_after_variable_attributes', array(&$this, 'add_variable_attributes' ), 10, 3 );
		add_action( 'woocommerce_save_product_variation', array(&$this, 'save_variable_attributes' ), 10, 2 );

		// admin notice
		add_action( 'admin_notices', array($this, 'magic_admin_notices') );
		
		if (
			!isset($_COOKIE['MAGICSESSID']) || 
			empty($_COOKIE['MAGICSESSID']) || 
			$_COOKIE['MAGICSESSID'] === null
		) {
			$sessid = strtoupper(substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 20));
			@setcookie('MAGICSESSID', $sessid, time() + (86400 * 30), '/');
			$_COOKIE['MAGICSESSID'] = $sessid;
		}
		
    }
	
    public function activation() {
	    
        global $wpdb;
		
		$upload_path = WP_CONTENT_DIR.DS.'uploads'.DS;
		
		if ( !is_dir($upload_path) )
			wp_mkdir_p($upload_path);
		
		if ( !is_dir($this->upload_path) )
			wp_mkdir_p($this->upload_path);
		
		$design_editor = $wpdb->get_row( "SELECT post_name FROM {$wpdb->prefix}posts WHERE post_name = 'design-editor'", 'ARRAY_A' );
		
		if ( null === $design_editor ) {

			$current_user = wp_get_current_user();
			
			$page = array(
				'post_title'  => esc_html('Design Editor'),
				'post_status' => 'publish',
				'post_author' => $current_user->ID,
				'post_type'   => 'page',
				'post_content'   => 'This is MagicRugs design page. Go to MagicRugs > Settings > Shop to change other page when you need.'
			);
			
			$page_id = wp_insert_post( $page );
			update_option('magic_editor_page', $page_id);
			
		}
			
		return true;
		
    }  
    
    public function activation_redirect($plugin) {
	    
	    if( $plugin == plugin_basename( __FILE__ ) ) {
		    
		    global $wpdb;
		
			if ($wpdb->get_var("SHOW TABLES LIKE 'magic_settings'") != 'magic_settings') {
				
				$templine = '';
				$sql_file = $this->path .'woo'.DS.'sample'. DS . 'database.sql';
				
				$handle = @fopen( $sql_file, 'r' );
				$lines = @fread( $handle, @filesize($sql_file) );
	
				$lines = explode("\n", $lines);
				
				foreach ($lines as $line) {
					$s1 = substr($line, 0, 2);
					if ($s1 != '--' && $line !== '') {
						
						$templine .= $line;
						
						$line = trim($line);
						$s2 = substr($line, -1, 1);
						
						if ($s2 == ';')
						{
							$sql = $templine;
							$wpdb->query( $sql, false );
							$templine = '';
						}
					}
				}
				
				@fclose($handle);
				
			}
		    
		    return; 
		    
		    
			$setup = get_option('magic_setup', false);
			
			if ($setup != 'done') {
				exit( wp_redirect( admin_url( 'admin.php?page=magic-setup' ) ) );
			}
		}
		
    }

    public function magic_admin_notices() {
		
		global $magic;

		$key = $magic->get_option('purchase_key');
		$key_valid = ($key === null || empty($key) || strlen($key) != 36 || count(explode('-', $key)) != 5) ? false : true;

// 		if(!$key_valid){
// 			echo '<div class="wp-notice error" style="margin: 15px 0"><p>'.$magic->lang('You must verify your purchase code of MagicRugs Product Designer to access to all features').'. <a href="'.admin_url('?page=magic&magic-page=license').'">'.$magic->lang('Enter your license now').' &rarr;</a></p></div>';
// 		}

		$addon_list = $magic->addons->addon_installed_list();
		$actives = $magic->get_option('active_addons');
		if ($actives !== null && !empty($actives))
			$actives = (Array)@json_decode($actives);

		if( isset($addon_list) && !empty($addon_list) && count($addon_list) > 0 
			&& (
				(isset($addon_list['assign']) && isset($actives['assign']))
				|| (isset($addon_list['display_template_clipart']) && isset($actives['display_template_clipart']))
				|| (isset($addon_list['dropbox_sync']) && isset($actives['dropbox_sync']))
				|| (isset($addon_list['mydesigns']) && isset($actives['mydesigns']))
				|| (isset($addon_list['distress']) && isset($actives['distress']))
			)
		){

			$key_addon_bundle = $magic->get_option('purchase_key_addon_bundle');
			$key_valid_addon_bundle = ($key_addon_bundle === null || empty($key_addon_bundle) || strlen($key_addon_bundle) != 36 || count(explode('-', $key_addon_bundle)) != 5) ? false : true;

			if (!$key_valid_addon_bundle) {
				echo '<div class="wp-notice error" style="margin: 15px 0"><p>'.$magic->lang('You must verify your purchase code for addon bundle to access to all features').'. <a href="'.admin_url('?page=magic&magic-page=license#magic-tab-addon-bundle').'">'.$magic->lang('Enter your license now').'</a></p></div>';
			}

		}

		if(isset($addon_list) && !empty($addon_list) && count($addon_list) > 0 && isset($addon_list['vendors']) && isset($actives['vendors']) ){
			// exist addon vendor
			$key_addon_vendor = $magic->get_option('purchase_key_addon_vendor');
			$key_valid_addon_vendor = ($key_addon_vendor === null || empty($key_addon_vendor) || strlen($key_addon_vendor) != 36 || count(explode('-', $key_addon_vendor)) != 5) ? false : true;

			if (!$key_valid_addon_vendor) {
				echo '<div class="wp-notice error" style="margin: 15px 0"><p>'.$magic->lang('You must verify your purchase code for addon vendor to access to all features').'. <a href="'.admin_url('?page=magic&magic-page=license').'">'.$magic->lang('Enter your license now').'</a></p></div>';
			}
		}

		if(isset($addon_list) && !empty($addon_list) && count($addon_list) > 0 && isset($addon_list['printful']) && isset($actives['printful'])){
			// exist addon vendor
			$key_addon_printful = $magic->get_option('purchase_key_addon_printful');
			$key_valid_addon_printful = ($key_addon_printful === null || empty($key_addon_printful) || strlen($key_addon_printful) != 36 || count(explode('-', $key_addon_printful)) != 5) ? false : true;

			if (!$key_valid_addon_printful) {
				echo '<div class="wp-notice error" style="margin: 15px 0"><p>'.$magic->lang('You must verify your purchase code for addon printful to access to all features').'. <a href="'.admin_url('?page=magic&magic-page=license').'">'.$magic->lang('Enter your license now').'</a></p></div>';
			}
		}
	}
    
    public function render() {
	    
		show_admin_bar(false);
        //require bridge for frontend
        require_once($this->path . $this->connector_file);
        
        $editor_index = apply_filters('magic_editor_index', $this->path . 'core'. DS . 'index.php');
        
        //require cutomize index
        require_once($editor_index);
        
    }
	
	public function woo_remove_order($order_id) {
		
		global $post_type, $magic;

	    if($post_type !== 'shop_order') {
	        return;
	    }
	    
		$magic->lib->delete_order_products($order_id);
	}
	
	public function init() {
		
		$editor_page = get_option('magic_editor_page', 0);
		
		if ($editor_page > 0) {
			$url = esc_url(get_page_link($editor_page));
			$this->url = (strpos($url, '?') === false)? $url . '?': $url;
			$this->tool_url = $this->url;
		}
		
		$this->load_core();
		
		/*if (is_admin()) {
			if (isset($_GET['page']) && $_GET['page'] == 'magic-setup') {
				include $this->path.'woo'.DS.'setup.php';
				exit;
			}
		}*/
			
	}
	
	public function page_display() {
			
		global $wp_query, $magic, $post;
		
		$editor = get_option('magic_editor_page', 0);
		$in_iframe = $magic->get_option('editor_iframe', 0);
		$iframe_width = $magic->get_option('editor_iframe_width', '100%');
		$iframe_height = $magic->get_option('editor_iframe_height', '80vh');
		
		$id = get_queried_object_id();
		
		if ($editor > 0){
				
			if (
				(
					isset($_GET['page_id']) &&
					!empty($_GET['page_id']) &&
					$editor == $_GET['page_id']
				) ||
				(
					isset($_GET['product_base']) &&
					!empty($_GET['product_cms'])
				) ||
				(
					isset($_GET['product_base']) &&
					!empty($_GET['order_print'])
				) ||
				$editor == $id
			){
				
				if ($in_iframe == 1 && !isset($_GET['magic_iframe']) && !isset($_GET['pdf_download'])) {
					remove_all_filters('the_content');
					$link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')  ? "https" : "http"; 
					$link .= "://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
					if(strpos($_SERVER['REQUEST_URI'], '?') !== FALSE){
						$link .= '&';
					} else {
						$link .= '?';
					}
					$link .='magic_iframe=true';
					if($post != null){
						$post->post_content = '<iframe style="border:none;width: '.$iframe_width.';height: '.$iframe_height.';" src="'.esc_url($link).'"></iframe><script>if (top.location.href !== window.location.href)top.location.href=window.location.href;</script>';
					}
				} else {
					$this->render();
					exit;
				}
			}
		}
	}
	
    public function loaded() {
	    
		global $post, $magic;
		
		$route = isset($_GET['magic']) && !empty($_GET['magic']) ? $_GET['magic'] : null;
		
        if ($route) {
			switch ($route) {
				case 'design':
					@ob_end_clean();
					$this->render();
					exit;
				break;	
				case 'ajax':
				case 'cart':
					@ob_end_clean();
					$magic->router($route);
				break;	
				default:break;
			}
			exit;
		}
        
    }
	
	public function admin_notices() {
		
		return;
		
		if (isset($_GET['magic-hide-notice']) && $_GET['magic-hide-notice'] == 'setup') {
			update_option('magic_setup', 'done');
		} else {
		
			$setup = get_option('magic_setup', false);
			$current = get_option( 'active_plugins', array() );
			if ($setup != 'done') {
			?>
			<div id="message" class="updated">
				<p>
					<strong><?php _e('Welcome to RugCustom', 'magic'); ?></strong> &#8211; 
					<?php _e('You&lsquo;re almost ready, Please create a Woo Product and link to a MagicRugs Product Base to start designing.', 'magic'); ?>
				</p>
				<?php if (!in_array('woocommerce'.DS.'woocommerce.php', $current)) { ?>
				<p style="background: #f4433629;padding: 10px;">
					<?php _e('You need to install and activate the Woocommerce plugin so that MagicRugs can work', 'magic'); ?> 
					<a href="<?php echo admin_url('plugins.php'); ?>"><?php _e('Go to plugins', 'magic'); ?> &rarr;</a>
				</p>
				<?php } ?>
				<p class="submit">
					<a href="<?php echo esc_url( admin_url( 'admin.php?page=magic-setup' ) ); ?>" class="button-primary">
						<?php _e('Run the Setup Wizard', 'magic'); ?>
					</a> &nbsp; 
					<a class="button-secondary skip" href="<?php echo esc_url(add_query_arg( 'magic-hide-notice', 'setup' )); ?>">
						<?php _e('Skip setup', 'magic'); ?>
					</a>
				</p>
			</div>
			<?php	
			}
		}
		
	}
	
	public function woo_order_item_get_quantity($qty, $item){

		$item_data = $item->get_data();
		
		$magic_data = array();
		
		if (count($item_data['meta_data']) > 0) {
			
			$is_magic = false;
			
			foreach ($item_data['meta_data'] as $meta_data) {
				if ($meta_data->key == 'magic_data') {
					$is_magic = true;
					break;
				}
			}
			
			if ($is_magic) {
				
				$product_id = $item->get_product_id();
				$order_id = $item->get_order_id();
				
				global $magic;
				
				$items = $magic->lib->get_order_products($order_id);
				
				if (count($items) > 0) {
					foreach ($items as $order_item) {
						if ($product_id == $order_item['product_id'])
							return $order_item['qty'];
					}
				}
			}
			
		}
		
		return $qty;
		
	}
	
	public function woo_magic_order_column($columns) {
		$newCols = array();
        
        $count = 0;
        foreach($columns as $index => $detail){
            if($count == 2){
                $newCols['type'] = 'Custom design';
            }
            $newCols[$index] = $detail;
            $count++;
        }
        return $newCols;

	    // return array_slice($columns, 0, 3, true) + 
			  //  array('type' => 'Custom design') + 
			  //  array_slice($columns, $position, count($columns) - 1, true);
			   
	}
	
	public function woo_magic_column_content($column) {
		
	    global $post, $wpdb;
	
	    if ( 'type' === $column ) {
			$is_magic = $wpdb->get_results('SELECT `id` FROM `magic_order_products` WHERE `order_id`='.$post->ID);
	        if (count($is_magic) === 0) {
		    	echo '';
		    } else {
			    echo '<a href="'.(esc_url( admin_url( 'post.php?post='.$post->ID) ) ).'&action=edit">&#9733;</a>';
			}    
	        
	    }
	}
	
	public function woo_admin_before_order_itemmeta($item_id, $item, $product) {
		
		global $magic_printings, $magic;
		
		if( !isset($magic_printings) ) {
			$magic_printings = $magic->lib->get_prints();
		}
		
	}
	
	public function woo_order_details_before_order_table($order) {
		
		global $wpdb;

        $table_name 	= $this->prefix."order_products";
		$order_id 		= $order->get_id();
		$count_order 	= $wpdb->get_var( " SELECT COUNT( * ) FROM $table_name WHERE order_id = $order_id" );

		if ($count_order > 0)
			remove_action( 'woocommerce_order_details_after_order_table', 'woocommerce_order_again_button' );
			
	}

	public function woo_admin_after_order_itemmeta($item_id, $item, $product) {
		
		if ($product === null || empty($product))
			return;
		
		global $magic, $post;
		
		$item_data = $item->get_data();
        if(!$item->meta_exists('magic_data')){
            return;
        };

       
		$data = array(
			"product_cms" => $product->get_ID(),
			"cart_id" => '',
			"product_base" => '',
			"template" => '',
			"order_id" => $post->ID,
			"item_id" => $item_id
		);
		$cart_id = '';


		if (count($item_data['meta_data']) > 0) {
			foreach ($item_data['meta_data'] as $meta_data) {
				if ($meta_data->key == 'magic_data') {
					$data['cart_id'] = $meta_data->value['cart_id'];
					break;
				}
			}
		}
		
		$data['product_base'] = get_post_meta($data['product_cms'], 'magic_product_base', true );
		
		if (empty($data['cart_id'])) {
	        $data['template'] = get_post_meta($data['product_cms'], 'magic_design_template', true );	
		}

		// $product = wc_get_product( 7878 );
		// var_dump($product->is_type( 'variable' ));
		$id_parent = 0;
		$is_variation = false;
		if($product->get_parent_id() != null && intval($product->get_parent_id()) != 0){
			$id_parent = $product->get_parent_id();
			$product_parent = wc_get_product( $id_parent );
			$is_variation = $product_parent->is_type( 'variable' );
		}
		if (
			empty($data['cart_id']) 
			&& $id_parent != 0
			&& $is_variation == true
		) {
	        $data['template'] = get_post_meta($data['product_cms'], '_variation_magic', true );
	        $data['product_base'] = 'variable:'.$product->get_id();	
		}

		if (count($item_data['meta_data']) > 0) {
			foreach ($item_data['meta_data'] as $meta_data) {
				if ($meta_data->key == 'magic_data' && $data['product_base'] == '' && isset($meta_data->value['id']) && strpos($meta_data->value['id'], 'variable') !== false ) {
					$data['product_base'] = $meta_data->value['id'];
					break;
				}
			}
		}

		$magic->views->order_designs($data);
		
	}
    
    public function menu_page() {
        
        global $wpdb;
        
        $title = 'MagicRugs';
        
        if (
        	isset($this->update_core) && 
        	version_compare(MAGIC_WOO, $this->update_core->version, '<')
        )
        	$title .= ' <span class="update-plugins"><span class="plugin-count">1</span></span>';
        
        $title .= '<style type="text/css">#toplevel_page_magic img{height: 20px;box-sizing: content-box;margin-top: -3px;}</style>';
        
        add_menu_page( 
            	__( 'MagicRugs', 'magic' ),
                $title,
                'magic_access',
                'magic',
                array($this, 'admin_page'),
                $this->assets_url . 'assets/images/icon.png',
            90
        );
        
        add_submenu_page( 
        	'magic', 
        	'MagicRugs'.(!empty($_GET['magic-page']) ? ' '. ucfirst($_GET['magic-page']) : ''), 
        	__( 'Dashboard', 'magic' ),
        	'magic_access', 
        	'magic'
        );
        
        add_submenu_page( 
        	'magic', 
        	__( 'Orders', 'magic' ), 
        	__( 'Orders', 'magic' ),
        	'magic_access', 
        	'admin.php?page=magic&magic-page=orders'
        );
        
        add_submenu_page( 
        	'magic', 
        	__( 'Addons', 'magic' ), 
        	__( 'Addons', 'magic' ),
        	'magic_access', 
        	'admin.php?page=magic&magic-page=explore-addons'
        );
        
        add_submenu_page( 
        	'magic', 
        	__( 'Help', 'magic' ), 
        	__( 'Help', 'magic' ),
        	'magic_access', 
        	'https://MagicRugs.com'
        );
        
        add_submenu_page( 
        	'magic', 
        	__( 'Settings', 'magic' ), 
        	__( 'Settings', 'magic' ),
        	'magic_access', 
        	'admin.php?page=magic&magic-page=settings'
        );
        
    }
	
    public function admin_page() {
		
		if (!defined('MAGIC_ADMIN'))
			define('MAGIC_ADMIN', true);
		
		global $magic;
		
		if (!$magic->dbready) {
			echo '<br><div class="notice error"><p>MagicRugs Database is not ready! Try to deactive MagicRugs plugin and reactive it again. <a href="'.admin_url('plugins.php').'">Plugins Page</a></p></div>';
			return;
		}
			
        require_once($this->path . 'core'.DS . 'admin' .DS .'index.php');
        
    }

    public function woo_add_tab_attr( $product_data_tabs ) {
	    
        global $post;
		$product = wc_get_product( $post->ID );

		$product_data_tabs['magic'] = array(
			'label' => __( 'MagicRugs Configuration', 'magic' ),
			'target' => 'magic_product_data'
		);
		
        return $product_data_tabs;
    }
	
	public function woo_customize_link_list($html){
		
		global $product, $wpdb, $magic;
		
		$config = get_option('magic_config', array());
		
		if	(isset($config['btn_list']) && !$config['btn_list']) 
			return $html;
		if($product == null){
			return $html;
		}
		$pid = $product->get_id();
		
		$product_base = get_post_meta($pid, 'magic_product_base', true);
		$disable_add_cart = get_post_meta($pid, 'magic_disable_add_cart', true);
		$magic_customize = get_post_meta($pid, 'magic_customize', true);
		$price = $product->get_price();
		
		if (empty($price)) {
			$disable_add_cart = 'res';
		}
		
		if(
			!empty($product_base) &&
			$magic_customize == 'yes'
		){
			
			$link_design = str_replace('?&', '?', $this->tool_url . '&product_base='.$product_base.'&product_cms=' . $pid );
			$link_design = apply_filters( 'magic_customize_link', $link_design );
			
			$html = ($disable_add_cart == 'yes' ? '' : $html);
			$html .= '<a class="magic-button magic-list-button" href="' . esc_url($link_design ). '">' . 
						(isset($config['btn_text'])? $config['btn_text'] : __('Customize', 'magic')) .
					 '</a>' ;
		}
		
		return $html;
	}
	
    // add element html to tab custom product
    public function woo_add_product_data_fields() {
        
		$screen = get_current_screen();
		
		if (
			$screen->parent_file == 'edit.php?post_type=product' || 
			$screen->post_type == 'product'
		) {
			
			global $magic;
			global $wpdb;
			
	    	$id = get_the_ID();
	    	$ops = array();
	    	$js_cfg = array();
			
	        $ops['magic_product_base'] = get_post_meta($id, 'magic_product_base', true );
	        $ops['magic_design_template'] = get_post_meta($id, 'magic_design_template', true );
	        $ops['magic_customize'] = get_post_meta($id, 'magic_customize', true );
	        $ops['magic_disable_add_cart'] = get_post_meta($id, 'magic_disable_add_cart', true );
				
        	if (!empty($ops['magic_product_base'])) {
	        	
	        	$query = "SELECT `name`,`stages`,`attributes` FROM `{$magic->db->prefix}products` WHERE `id`={$ops['magic_product_base']}";
	        	$data = $wpdb->get_results($query);
	        	
	        	if (isset($data[0]) && isset($data[0]->stages)) {
		        	
		        	$color = $magic->lib->get_color($data[0]->attributes);
		        	
		        	$js_cfg['current_data'] = array(
						'id' => $ops['magic_product_base'],
						'name' => $data[0]->name,
						'color' => $color,
						'stages' => $data[0]->stages,
						'attributes' => $data[0]->attributes,
					);
					
					$stage = $magic->lib->dejson($data[0]->stages);
					
					if (isset($stage) && isset($stage->front) && isset($stage->front->label) && !empty($stage->front->label))
						$js_cfg['_front'] = rawurldecode($stage->front->label);
					if (isset($stage) && isset($stage->back) && isset($stage->back->label) && !empty($stage->back->label))
						$js_cfg['_back'] = rawurldecode($stage->back->label);
					if (isset($stage) && isset($stage->left) && isset($stage->left->label) && !empty($stage->left->label))
						$js_cfg['_left'] = rawurldecode($stage->left->label);
					if (isset($stage) && isset($stage->right) && isset($stage->right->label) && !empty($stage->right->label))
						$js_cfg['_right'] = rawurldecode($stage->right->label);
	        	}
        	}
			
			if (!empty($ops['magic_design_template'])) {
	        	
	        	$designs = json_decode(rawurldecode($ops['magic_design_template']));
	        	
	        	foreach($designs as $s => $d) {
		        	
		        	if (!isset($d->id))
		        		continue; 
		        		
		        	$data = $wpdb->get_results("SELECT `name`,`screenshot` FROM `{$magic->db->prefix}templates` WHERE `id`=".$d->id);
		        	if (isset($data[0]))
			        	$designs->{$s}->screenshot = $data[0]->screenshot;
			        else unset($designs->{$s});
			        
	        	}
	        	
	        	$js_cfg['current_design'] = $designs;
	        	
        	}
        	
			magic_cms_product_data_fields($ops, $js_cfg, $id);
			echo '<script type="text/javascript" src="'.$magic->cfg->assets_url.'admin/assets/js/woo_product.js?version='.MAGIC.'"></script>';
		
		}
		
    }

	// save value element data tabs

    public function woo_process_product_meta_fields_save($post_id) {
	  	
	    global $wpdb;
	    
	    $product_base = isset($_POST['magic_product_base']) ? $_POST['magic_product_base'] : '';
	    $design_template = isset($_POST['magic_design_template']) ? $_POST['magic_design_template'] : '';
	    $magic_customize = isset($_POST['magic_customize']) ? $_POST['magic_customize'] : 'no';
	    $addcart = isset($_POST['magic_disable_add_cart']) ? $_POST['magic_disable_add_cart'] : 'no';

        update_post_meta($post_id, 'magic_disable_add_cart', $addcart);
        update_post_meta($post_id, 'magic_customize', $magic_customize);
        update_post_meta($post_id, 'magic_product_base', $product_base);
        update_post_meta($post_id, 'magic_design_template', $design_template);
        
        if($product_base == ''){
        	$wpdb->query("UPDATE `{$this->prefix}products` SET `product` = 0 WHERE `product` = $post_id");
        }
		
        if (!empty($product_base) && $magic_customize == 'yes') {
	        $check = $wpdb->get_results("SELECT `product` FROM `{$this->prefix}products` WHERE `id` = $product_base", OBJECT);
	        if (isset($check[0])) {
				$wpdb->query("UPDATE `{$this->prefix}products` SET `product` = 0 WHERE `product` = $post_id");
		        $wpdb->query("UPDATE `{$this->prefix}products` SET `product` = $post_id WHERE `id` = $product_base");
	        }
        }
        
    }

	public function admin_footer() {
		echo '<script type="text/javascript">jQuery(\'a[href="https://MagicRugs.com"]\').attr({target: \'_blank\'})</script>';	
	}

	/** Frontend**/

	// Add body class for magic
	public function magic_body_class($classes){
		if(is_singular( 'product' )){
			$classes[] = 'magic-theme-' . get_option( 'template' );
		}
		return $classes;
	}

	public function frontend_scripts() {
		
		wp_register_script('magic-frontend', plugin_dir_url(__FILE__) . 'woo/assets/js/frontend.js', array('jquery'), MAGIC_WOO, true);
		
		wp_register_style('magic-style', plugin_dir_url(__FILE__).'woo/assets/css/frontend.css', false, MAGIC_WOO);
		
		wp_enqueue_style('magic-style');
		wp_enqueue_script('magic-frontend');
		
	}

    //Render attributes from magic
    public function woo_render_meta( $cart_data, $cart_item = null ){
	    
		// get data in cart
		global $magic;
		
        $custom_items = array();

        if( !empty( $cart_data ) )  $custom_items = $cart_data;	
		
		if(
			function_exists( 'is_cart' ) 
			&& is_cart() 
			&& isset( $cart_item[ 'magic_data' ] )
		){
			
			$cart_item_data = $magic->lib->get_cart_data( $cart_item['magic_data'] );
			if ( is_array($cart_item_data ) ){
				
				foreach ( $cart_item_data['attributes'] as $aid => $attr ) {
					
					if (isset($attr['value']) ) {
						
						$val = $attr['value'];
						
						if (
							($attr['type'] == 'color' || 
							$attr['type'] == 'product_color') &&
							is_array($attr['values']) &&
							is_array($attr['values']['options'])
						) {
							foreach ($attr['values']['options'] as $v) {
								if (trim($val) == trim($v['value'])) {
									$val = '<span style="background-color: '.$v['value'].';padding: 1px 3px;" title="'.$v['value'].'">'.$v['title'].'</span>';
								}
							}
						} else if ($attr['type'] == 'quantity') {
							
							if ( is_array(@json_decode($val, true)) ) {
								$val = @json_decode($val, true);
								foreach ($val as $k => $v) {
									if($v == 0){
										unset($val[$k]);
										continue;
									}
									$val[$k] = '<p><strong>'.$k.':</strong>'.$v.'</p>';
								}
								$val = implode('', array_values($val));
							} else $val = $attr['value'];
						} else if(
							is_array($attr['values']) &&
							isset($attr['values']['options']) &&
							is_array($attr['values']['options'])
						){
							foreach ($attr['values']['options'] as $v) {
								if (trim($val) == trim($v['value'])) {
									$val = $v['title'];
								}
							}		
						}
						
						$custom_items[] = array( 
							"name" => $attr['name'], 
							"value" => $val
						);
					}
					
				}
			}
			
		}
        return $custom_items;
    }
	
	//design thumbnails in cart page
	public function woo_cart_design_thumbnails($product_image, $cart_item, $cart_item_key) {
		
		global $magic, $magic_cart_thumbnails;
		
		$design_thumb = '';
		
		if (
			function_exists('is_cart') && 
			is_cart() && 
			isset($cart_item['magic_data'])
		) {
			
			$cart_item_data = $magic->lib->get_cart_data( $cart_item['magic_data'] );
			$color = $magic->lib->get_color($cart_item_data['attributes']);
			
			if(
				isset($cart_item_data['screenshots']) 
				&& is_array($cart_item_data['screenshots'])
			){
				$allowed_tags = wp_kses_allowed_html( 'post' );
				$uniq = uniqid();
				$magic_cart_thumbnails[$uniq] = array();
				$design_thumb = '<div class="magic-cart-thumbnails magic-cart-thumbnails-'.$uniq.'">';
				foreach ($cart_item_data['screenshots'] as $screenshot) {
					$design_thumb .= '<img style="background:'.$color.';padding: 0px;" class="magic-cart-thumbnail" src="'.$magic->cfg->upload_url.$screenshot.'" />';
				}
				$design_thumb .= '</div>';
			}
		}
		
		if (intval($magic->cfg->settings['show_only_design']) == 1 && function_exists('is_cart') && is_cart() && isset($cart_item['magic_data']) ) {
			$product_image = '';
		}

		return $product_image.$design_thumb;
	}
	
    //Add custom price to product cms
    public function woo_calculate_price($cart_object) {

		global $wpdb, $magic;
		
        if( !WC()->session->__isset( "reload_checkout" )) {
            $woo_ver = WC()->version;

            foreach ($cart_object->cart_contents as $key => $value) {
				if( isset($value['magic_data']) ){

					$cart_item_data = $magic->lib->get_cart_data( $value['magic_data'] );

					$magic_price = (
						isset($cart_item_data['price']) && 
						isset($cart_item_data['price']['total'])
					) ? floatVal($cart_item_data['price']['total']) : 0;

					if(isset($cart_item_data['options']) && isset($cart_item_data['attributes'])){
						// fix bug package option price
						$arrOption = (array)$cart_item_data['options'];
						$arrAttribute = (array)$cart_item_data['attributes'];

						foreach ($arrOption as $indexListChoice => $valueListChoice) {
							foreach ($arrAttribute as $keyListOption => $valueListOption) {
								$arrValueListOption = (array)$valueListOption;
								$packOption_arr = array();
								if(isset($arrValueListOption['values'])){
									$packOption_arr = (array)$arrValueListOption['values'];
								}
								if( 
									$indexListChoice == $arrValueListOption['id'] 
									&& $arrValueListOption['type'] == 'quantity' 
									&& isset($arrValueListOption['values']) 
									&& isset($packOption_arr['package_options']) 
								){
									foreach ($packOption_arr['package_options'] as $keyPackageOption => $valuePackageOption) {
										$arrValuePackageOption = (array)$valuePackageOption;
										if( $valueListChoice == $arrValuePackageOption['value']){
											$magic_price += (doubleval($arrValuePackageOption['value']) * doubleval($arrValuePackageOption['price']));
										}
									}
								}
							}
						}
					}

					// // variable product calc price
					// if(strpos($cart_item_data['id'], 'variable') !== false){
					// 	$product_id = intval(preg_replace('/[^0-9]+/mi', '', $cart_item_data['id']));
					// 	$product = wc_get_product( $product_id );
					// 	$price = floatval($product->get_price());
					// 	$magic_qty = isset($cart_item_data['qty']) ? intval($cart_item_data['qty']) : 1;
					// 	$magic_price = $price * $magic_qty;
					// }

					// variable product change name 
					// if(strpos($cart_item_data['id'], 'variable') !== false){
					// 	$product_base_id = intval(preg_replace('/[^0-9]+/mi', '', $cart_item_data['product_cms']));
					// 	$cart_item_data['product_name'] = get_the_title($product_base_id);

					// 	$product_id = intval(preg_replace('/[^0-9]+/mi', '', $cart_item_data['id']));
					// 	$product = wc_get_product( $product_id );
					// 	$productAttribute = $product->get_variation_attributes();
					// 	if($productAttribute != NULL && count($productAttribute) >= 1){
					// 		$newname = ' - ';
					// 		foreach ($productAttribute as $index => $detailAttribute) {
					// 			$newname .= $detailAttribute.', ';
					// 		}
					// 		$newname = substr($newname, 0, -2);
					// 		$value['magic_data']['product_name'] .= $newname;
					// 	}
						
					// 	if ( version_compare( $woo_ver, '3.0', '<' ) ) {
				    //         $cart_object->cart_contents[$key]['data']->name = $value['magic_data']['product_name']; // Before WC 3.0
				    //     } else {	
					// 		$cart_object->cart_contents[$key]['data']->name = $value['magic_data']['product_name']; // Before WC 3.0
				    //         $cart_object->cart_contents[$key]['data']->set_name($value['magic_data']['product_name']); // WC 3.0+
				    //     }
					// }

					// if(strpos($cart_item_data['id'], 'variable') !== false && isset($cart_item_data['options']) && isset($cart_item_data['attributes']) ){
					// 	$product_id = intval(preg_replace('/[^0-9]+/mi', '', $cart_item_data['id']));
					// 	$product = wc_get_product( $product_id );
					// 	$price = floatval($product->get_price());

					// 	// fix bug package option price
					// 	$arrOption = (array)$cart_item_data['options'];
					// 	$arrAttribute = (array)$cart_item_data['attributes'];

					// 	foreach ($arrOption as $indexListChoice => $valueListChoice) {
					// 		foreach ($arrAttribute as $keyListOption => $valueListOption) {

					// 			$arrValueListOption = (array)$valueListOption;
					// 			if(isset($arrValueListOption['values'])){
					// 				$packOption_arr = (array)$arrValueListOption['values'];
					// 			}
					// 			if( 
					// 				$indexListChoice == $arrValueListOption['id'] 
					// 				&& $arrValueListOption['type'] == 'quantity' 
					// 				&& isset($arrValueListOption['values']) 
					// 				&& isset($packOption_arr['package_options']) 
					// 			){
					// 				foreach ($packOption_arr['package_options'] as $keyPackageOption => $valuePackageOption) {
					// 					$arrValuePackageOption = (array)$valuePackageOption;
					// 					if( $valueListChoice == $arrValuePackageOption['value']){
					// 						$magic_price = (doubleval($arrValuePackageOption['value']) * $price);
					// 					}
					// 				}
					// 			}

					// 			// fix price with quantity attribute product variable (clip art orr template get price error so commented)
					// 			// if(
					// 			// 	$indexListChoice == $arrValueListOption['id'] 
					// 			// 	&& $arrValueListOption['type'] == 'quantity' 
					// 			// 	&& isset($arrValueListOption['value']) 
					// 			// 	&& !isset($arrValueListOption['values']) 
					// 			// 	&& !isset($packOption_arr['package_options']) 
					// 			// ){
					// 			// 	$magic_price = (doubleval($arrValueListOption['value']) * $price);
					// 			// }
					// 		}
					// 	}
					// }

					$magic_price = $magic->apply_filters('add-custom-price-limuse-data', $magic_price, $cart_item_data);
					
					$magic_qty = isset($cart_item_data['qty']) ? intval($cart_item_data['qty']) : 1;
					
					if ( version_compare( $woo_ver, '3.0', '<' ) ) {
			            $cart_object->cart_contents[$key]['data']->price = $magic_price/$magic_qty; // Before WC 3.0
			        } else {
						$cart_object->cart_contents[$key]['data']->price = $magic_price/$magic_qty; // Before WC 3.0
			            $cart_object->cart_contents[$key]['data']->set_price( $magic_price/$magic_qty ); // WC 3.0+
			        }
					
					$cart_object->cart_contents[$key]['quantity'] = $magic_qty;
				
				} else {
					
					$product_id = $value['product_id'];
					$product_base_id = $this->get_base_id($product_id);

					if ($product_base_id != null) {
						
						$is_product_base = $magic->lib->get_product($product_base_id);
						
						if ($is_product_base != null) {
							
							$cms_template = get_post_meta($product_id, 'magic_design_template', true );
							$product = wc_get_product($product_id);
							$template_price = 0;
							$template_stages = array();
							
							if (
								isset($cms_template) && 
								!empty($cms_template) && 
								$cms_template != '%7B%7D'
							) {
								
								$cms_template = json_decode(urldecode($cms_template), true);
								$templates = array();
								
								foreach ($cms_template as $s => $stage){
									$template_stages[$s] = $stage['id'];
									
									if(!in_array($stage['id'], $templates)){
										$templates[] = $stage['id'];
										$template = $magic->lib->get_template($stage['id']);
										$template_price += ($template['price'] > 0)? $template['price'] : 0;
									}
								}
								
								$price = $product->get_price();
								$total_price = 0;
								
								if ( version_compare( $woo_ver, '3.0', '<' ) ) {
						            $total_price = $cart_object->cart_contents[$key]['data']->price = $price + $template_price; // Before WC 3.0
						        } else {
						            $cart_object->cart_contents[$key]['data']->set_price( $price + $template_price ); // WC 3.0+
									$total_price = $price + $template_price;
						        }
								
								if(!isset($value['magic_incart'])){
									//push item to magic_cart
									$data = array(
										'product_id' => $product_base_id,
										'product_cms' => $product_id,
										'product_name' => $product->get_name(),
										'template' => $magic->lib->enjson($template_stages),
										'price' => array(
								            'total' => $total_price,
								            'attr' => 0,
								            'printing' => 0,
								            'resource' => 0,
								            'base' => $total_price
								        ),
									);
									
									$item = $magic->lib->cart_item_from_template($data, null);
									
									if(is_array($item)){
										$item['incart'] = true;
										$magic->lib->add_item_cart($item);
										$cart_object->cart_contents[$key]['magic_incart'] = true;
									}
									
								}
								
							}
							
						}
					}

					// variation product template
					if(isset($value['variation_id']) && intval($value['variation_id']) != 0 && isset($value['variation']) && !empty($value['variation']) && $product_base_id == null ){
						
						$product_id = intval($value['variation_id']);
						$product_base_id = 'variable:'.$product_id;
						$cms_template = get_post_meta($product_id, '_variation_magic', true );
						$product = wc_get_product($product_id);
						$template_price = 0;
						$template_stages = array();
						
						if (
							isset($cms_template) && 
							!empty($cms_template) && 
							$cms_template != '%7B%7D'
						) {
							
							$cms_template = json_decode(urldecode($cms_template), true);
							$templates = array();
							if(isset($cms_template['stages']) && gettype($cms_template['stages']) == 'string'){
								$cms_template = json_decode(urldecode(base64_decode($cms_template['stages'])), true);
								foreach ($cms_template as $s => $stage){
									if( isset($stage['template']['id']) ){
										$template_stages[$s] = intval($stage['template']['id']);
										if(!in_array($stage['template']['id'], $templates)){
											$templates[] = intval($stage['template']['id']);
											$template = $magic->lib->get_template(intval($stage['template']['id']));
											$template_price += ($template['price'] > 0)? $template['price'] : 0;
										}
									}
								}
								
								$price = $product->get_price();
								$total_price = 0;
								
								if ( version_compare( $woo_ver, '3.0', '<' ) ) {
						            $total_price = $cart_object->cart_contents[$key]['data']->price = $price + $template_price; // Before WC 3.0
						        } else {
						            $cart_object->cart_contents[$key]['data']->set_price( $price + $template_price ); // WC 3.0+
									$total_price = $price + $template_price;
						        }
								
								if(!isset($value['magic_incart'])){
									//push item to magic_cart
									$data = array(
										'product_id' => $product_base_id,
										'product_cms' => $value['product_id'],
										'product_name' => $product->get_name(),
										'template' => $magic->lib->enjson($template_stages),
										'price' => array(
								            'total' => $total_price,
								            'attr' => 0,
								            'printing' => 0,
								            'resource' => 0,
								            'base' => $total_price
								        ),
									);
									
									$item = $magic->lib->cart_item_from_template($data, null);
									
									if(is_array($item)){
										$item['incart'] = true;
										$magic->lib->add_item_cart($item);
										$cart_object->cart_contents[$key]['magic_incart'] = true;
									}
									
								}
							}
						}
					}

				}
                
            }
            
        }

    }
    // Add value custom field to order 
    public function woo_checkout_create_order_line_item($item, $cart_item_key, $values, $order) {
		if( isset( $values['magic_data'] ) )
			$item->update_meta_data( "magic_data", $values['magic_data'] );
	}

	// Add value custom field to order before WC 3.0
    public function woo_add_order_item_meta($item_id, $values, $cart_item_key ) {
        if( isset( $values['magic_data'] ) )
			wc_add_order_item_meta( $item_id, "magic_data", $values['magic_data'] );
    }
    
    // save data to table order_products
    public function woo_order_finish ($order_id) {

        global $wpdb, $magic;

        if(is_null(WC()->cart) && !isset($cart['msg'])){
        	return;
		}

        $table_name =  $this->prefix."order_products";
        
		$count_order = $wpdb->get_var( " SELECT COUNT( * ) FROM $table_name WHERE order_id = $order_id" );

		$log = 'MagicRugs Trace Error ID#' . $order_id.' '.date ("Y-m-d H:i:s");

		if ($count_order > 0) {
			//$magic->logger->log( '[FAIL] '.$log.' - order_id exist)');
			//header('HTTP/1.1 401 '.'Error: order_id #'.$order_id.' was exist)', true, 401);
			//return;
		}
		
		$cart_data = array('items' => array());
		
		if(is_null(WC()->cart) && isset($cart['msg'])){
			$msg = magic_lang('Sorry, something went wrong when we processed your order. Please contact the administrator')
				   .'.<br><br><em>'.$log.' -  "'.$cart['msg'].'"</em>';
			
			header('HTTP/1.1 401 '.$msg, true, 401);
			exit;
		}

		$getCart = WC()->cart->get_cart();
		if($getCart == NULL){
			$getCart = array();
		}
		if(empty($getCart)){
			$getCart = array();
		}
		foreach( $getCart as $cart_item_key => $item ){
			if( 
				isset($item['magic_data'])
			) { 
				$cart_data['items'][$item['magic_data']['cart_id']] = $item['magic_data'];
			}
		}
		// echo "<pre>"
		// print_r($cart_data);
		// die();
		$cart = $magic->lib->store_cart($order_id, $cart_data);
		
		if ($cart !== true && $cart['error'] == 1) {
			
			$magic->logger->log( '[FAIL] '.$log.' - '.$cart['msg']);
			
			wp_delete_post($order_id, true);
			$wpdb->delete( $table_name, array( 'order_id' => $order_id ) );
			
			$msg = magic_lang('Sorry, something went wrong when we processed your order. Please contact the administrator')
				   .'.<br><br><em>'.$log.' -  "'.$cart['msg'].'"</em>';
			
			header('HTTP/1.1 401 '.$msg, true, 401);
			exit;
			
		}
		
		// // hash : b450dbe41097246dbfd0d37f0b54034e
		// $order_product = new WC_Order($order_id);
		// $order_key = $order_product->order_key;

		// $order_received_url = wc_get_endpoint_url( 'order-received', $order_id, wc_get_checkout_url() );
		// $order_received_url = add_query_arg( 'key', $order_key, $order_received_url );

		// echo json_encode(array('result' => 'success', 'redirect' => $order_received_url));
		// wp_die();
    }
	
	public function woo_thank_you() {
		echo "<script>localStorage.setItem('MAGIC-CART-DATA', '');</script>";
	}
	
    // Get product have product base
    public function woo_products_assigned() {

        global $wpdb;
        $list_product = array();
        $sql_id_product_design_base = "SELECT meta_value FROM " .  $wpdb->prefix . "postmeta WHERE " . $wpdb->prefix . "postmeta.meta_key = 'magic_product_base'";

        $list_id_product = $wpdb->get_results( $sql_id_product_design_base, ARRAY_A );


        if( count($list_id_product) > 0 ){
            $list_id_meta_product = array();

            foreach ($list_id_product as $key_meta_product => $meta_product){
                foreach ($meta_product as $key_meta_product_key => $meta_product_value ){
                    if( $meta_product_value == '' || $meta_product_value == '0' || $meta_product_value == 0 ){
                        unset($list_id_product[$key_meta_product]);
                    }else{
                        array_push($list_id_meta_product, $meta_product_value);
                    }
                }
            }

            $list_item_id_product = array_unique($list_id_meta_product);

            $arr_product_ID = implode(',', $list_item_id_product);

            $sql = "
                  SELECT * FROM " . $wpdb->prefix . "posts  INNER JOIN " . $wpdb->prefix . "postmeta
                  ON ( " . $wpdb->prefix . "posts.ID = " . $wpdb->prefix . "postmeta.post_id )
                  WHERE ( " . $wpdb->prefix . "postmeta.meta_key = 'magic_product_base' AND " . $wpdb->prefix . "postmeta.meta_value IN ($arr_product_ID ))              
                  AND " . $wpdb->prefix . "posts.post_type = 'product' AND (( " .$wpdb->prefix . "posts.post_status = 'publish'))
                  GROUP BY " . $wpdb->prefix . "posts.ID ORDER BY " . $wpdb->prefix . "posts.post_date DESC
              ";

            $list_product = $wpdb->get_results( $sql, ARRAY_A);

        }

        return $list_product;
    }
	
	//get products woo
    public function woo_products() {
        global $wpdb;

        $sql_product = "
                  SELECT " . $wpdb->prefix . "posts.ID, " . $wpdb->prefix . "posts.post_title , ". $wpdb->prefix . "postmeta.meta_value  FROM " . $wpdb->prefix . "posts  INNER JOIN " . $wpdb->prefix . "postmeta
                  ON ( " . $wpdb->prefix . "posts.ID = " . $wpdb->prefix . "postmeta.post_id ) WHERE " . $wpdb->prefix . "postmeta.meta_key = '_regular_price' "
        ;

        $list_product_woocomerce = $wpdb->get_results( $sql_product, ARRAY_A );

        return $list_product_woocomerce ;

    }

	//load core magic
	public function load_core() {
		
		require_once($this->path . $this->connector_file);
        require_once($this->app_path.'includes'.DS.'main.php');
        
	}
    
    public function get_product() {
        
        global $product;
        
        
        if ($this->product_id != null && function_exists('wc_get_product')) {

            $product = $this->product = wc_get_product($this->product_id);
            
            if ($this->product != null) 
                return $this->product;
            
        }
        return null;
    }
	
	//edti design button in cart page
	public function woo_cart_edit_design_btn ($product_name, $cart_item) {
		
		global $magic;
		
		if(
			function_exists('is_cart') 
			&& is_cart() 
			&& isset ($cart_item['magic_data'])
		){
				
			$is_query = explode('?', $this->tool_url);
			$cart_id = $cart_item['magic_data'][ 'cart_id' ];
			$cart_item_data = $magic->lib->get_cart_data( $cart_item['magic_data'] );
			$url = $this->tool_url.
					((isset($is_query[1]) && !empty($is_query[1]))? '&' : '').
					'product_base='.$cart_item_data['product_id'].
					'&product_cms='.$cart_item_data['product_cms'].
					'&cart='.$cart_id;

			if(strpos($cart_item_data['id'], 'variable') !== false){
				$product_base_id = intval(preg_replace('/[^0-9]+/mi', '', $cart_item_data['product_cms']));
				$cart_item_data['product_name'] = get_the_title($product_base_id);

				$product_id = intval(preg_replace('/[^0-9]+/mi', '', $cart_item_data['id']));
				$product = wc_get_product( $product_id );
				$productAttribute = $product->get_variation_attributes();

				if($productAttribute != NULL && count($productAttribute) >= 1){
					$newname = ' - ';
					foreach ($productAttribute as $index => $detailAttribute) {
						$newname .= $detailAttribute.', ';
					}
					$newname = substr($newname, 0, -2);
					$cart_item_data['product_name'] .= $newname;
				}
			}

			return $cart_item_data['product_name'] . 
					'<div class="magic-edit-design-wrp">'.
						'<a id="'.$cart_id.'" class="magic-edit-design button" href="'.$url.'">'.
							__('Edit Design', 'magic').
						'</a>'.
					'</div>';
		
		} else return $product_name;
		
	}
	
	//change quantity column in cart page
	public function woo_cart_item_quantity($product_quantity, $cart_item_key = null, $cart_item = null) {
		
		global $magic;
		
		if( isset($cart_item['magic_data']) ){
			
			$cart_item_data = $magic->lib->get_cart_data( $cart_item['magic_data'] );
			
			if( 
				isset($cart_item_data['qtys']) && 
				count($cart_item_data['qtys']) > 0
			){
				
				$product_quantity = array();

				foreach ($cart_item_data['qtys'] as $key => $val) {
					$product_quantity[] = $key .' - '.$val['qty'];
				}
				
				return implode('<br/>', $product_quantity);
				
			}else $product_quantity = $cart_item_data['qty'];
		}
		
		return $product_quantity;
	}
	
	//change quantity column in checkout page
	public function woo_checkout_cart_item_quantity($str, $cart_item, $cart_item_key) {
		
		global $magic;
		
		$cart_item_data = isset( $cart_item['magic_data'] ) ? $magic->lib->get_cart_data( $cart_item['magic_data'] ) : array();
		
		return isset($cart_item['magic_data']) ? ' <strong class="product-quantity">' . sprintf( '&times; %s', $cart_item_data['qty'] ) . '</strong>': $str;
		
	}
	
	//change quantity column in order page
	public function woo_order_item_quantity_html( $str, $item ){
		
		global $magic;
		
		$custom_field = wc_get_order_item_meta( $item->get_id(), 'magic_data', true );
		
		$cart_item_data = $magic->lib->get_cart_data( $custom_field );

		if( is_array( $cart_item_data ) 
			&& isset( $cart_item_data[ 'qty' ] ) 
		){
			return ' <strong class="product-quantity">' . sprintf( '&times; %s', $cart_item_data['qty'] ) . '</strong>';
		}
		
		return $str;
		
	}
	
	public function woo_email_order_item_quantity( $qty, $item ) {
		
		$product = $item->get_product();
		
		if ( is_object( $product ) ) {
			
			$product_id = $item->get_product_id();
			$order_id = $item->get_order_id();
			
			global $magic;
			
			$items = $magic->lib->get_order_products( $order_id );
			
			if( count($items) > 0 ):
				foreach ($items as $order_item) {
					// hash : 09199e1fe4d7d285194da94841dc2d27
					if( $product_id == $order_item['product_id'] && $qty == $order_item['qty'] ) {
						 return $order_item['qty'];
					 }
				}
			endif;
		}
		
		return $qty;
	}
	
	public function woo_order_item_meta_start( $item_id, $item, $order) {
		unset( $item['magic_data'] );
	}
		
	public function email_customer_designs( $order, $sent_to_admin = false, $plain_text = false ,$email = '') {
		
		if ( ! is_a( $order, 'WC_Order' ) || $plain_text) {
			return;
		}
		
		global $magic, $magic_printings;
		
		if (!isset($magic_printings))
			$magic_printings = $magic->lib->get_prints();
		
		if (
			isset($magic->cfg->settings['email_design']) && 
			$magic->cfg->settings['email_design'] == 1 
		) {
			
			$order_id 	= $order->get_id();
			
			$order_status = $order->get_status();
			
			if ( 
				$order_status == 'completed' ||
				$sent_to_admin === true
			) {
				
				$items = $magic->lib->get_order_products($order_id);
				
				if( count($items) > 0 ) :
						
				?>
					<h2>Custom designs</h2>
					<div style="margin-bottom: 40px;">
					<table class="td" cellspacing="0" cellpadding="6" style="width: 100%; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;" border="1">
						<thead>
							<tr>
							<th class="td" scope="col">Product</th>
								<th class="td" scope="col">Quantity</th>
								<th class="td" scope="col">Price</th>
							</tr>
						</thead>
						<tbody>
					<?php
						
						foreach ($items as $item) {
							
							$data = $magic->lib->dejson($item['data']);
							
							$is_query = explode('?', $magic->cfg->tool_url);
								
							$url = $magic->cfg->tool_url.(isset($is_query[1])? '&':'?');
							$url .= 'product_base='.$item['product_base'];
							$url .= (($item['custom'] == 1)? '&design_print='.str_replace('.lumi', '', $item['design']) : '');
							$url .= '&order_print='.$order_id . '&product_cms='.$item['product_id'];
							$url = str_replace('?&', '?', $url);
							
							$url = apply_filters('magic_email_customer_download_link', $url, $item);
							
							?>
							<tr class="order_item">
								<td class="td" scope="col">
									<?php echo esc_html($item['product_name']); ?>
								</td>
								<td class="td" scope="col">
									<?php echo esc_html($item['qty']); ?>
								</td>
								<td class="td" scope="col">
									<?php echo wc_price($item['product_price']); ?>
								</td>
							</tr>
							<?php
								if (isset($data->attributes)) {
									
									foreach ($data->attributes as $i => $attr) {
										
										if (isset($attr->value)) {
											
											$val_display = '';
											
											if (
												$attr->type == 'color' || 
												$attr->type == 'product_color'
											) {
												$val = trim($attr->value);
												$lab = $attr->value;
												if (
													is_object($attr->values) && 
													is_array($attr->values->options)
												) {
													foreach ($attr->values->options as $op) {
														if ($op->value == $val)
															$lab = $op->title;
													}
												}
												$val_display .= '<span title="'.htmlentities($attr->value).'" style="background:'.$attr->value.';padding: 3px 8px;border-radius: 12px;">'.htmlentities($lab).'</span>';
											
											} else if($attr->type == 'quantity') {
												
												$val = @json_decode($attr->value);
												
												if (
													isset($attr->values) &&
													is_object($attr->values) &&
													isset($attr->values->type) &&
													$attr->values->type == 'multiple'
												) {
													foreach ($attr->values->multiple_options as $op) {
														if (
															is_object($val) &&
															isset($val->{$op->value})
														) 
															$val_display .= '<span>'.$op->title.': '.$val->{$op->value}.'</span> ';
													}
												} else $val_display .= '<span>'.$attr->value.'</span>';
												
											} else if (
												is_object($attr->values) && 
												isset($attr->values->options) &&
												is_array($attr->values->options)
											) {
												
												$val = explode("\n", $attr->value);
												
												foreach ($attr->values->options as $op) {
													if (in_array($op->value, $val))
														$val_display .= '<span>'.$op->title.'</span> ';
												}
												
											} else $val_display .= '<span>'.$attr->value.'</span>';
											
											echo '<tr class="order_item">'.
														'<td class="td" scope="col">'.
														'<span style="font-weight:500;">'.$attr->name.':</span>'.
													 '</td>'.
													 '<td class="td" scope="col" colspan="2">'.
													 	$val_display.
													'</td>'.
												'</tr>';
										}
									}
																			
									
									
									if (
										isset($data->variation) && 
										!empty($data->variation)
									) {
										echo '<tr class="order_item">'.
												'<td scope="col" class="td">'.
													'<span style="font-weight:500;">Variation:</span>'.
												 '</td>'.
												 '<td class="td" colspan="2">#'.$data->variation.'</td>'.
											'</tr>';
									}
									
									if (
										isset($data->printing) && 
										!empty($data->printing) && 
										is_array($magic_printings) &&
										$data->printing !== 0
									) {
										foreach ($magic_printings as $pmethod) {
											if ($pmethod['id'] == $data->printing) {
												echo '<tr class="order_item">'.
														'<td scope="col" class="td">'.
															'<span style="font-weight:500;">Printing:</span>'.
														 '</td>'.
														 '<td class="td" colspan="2">'.$pmethod['title'].'</td>'.
													'</tr>';
											}
										}
									}
									
								}
							?>
							<tr class="order_item">
								<td class="td" scope="col" colspan="3">
								<?php
								
									$data = array(
										"product_cms" => $item['product_id'],
										"cart_id" => $item['cart_id'],
										"product_base" => $item['product_base'],
										"template" => '',
										"order_id" => $item['order_id'],
										"item_id" => ''
									);

									$magic->views->order_designs($data, false);
									
								?>
								</td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
				<?php
						
				endif;
			
			}
			
		}
		
	}
	
	public function myaccount_customer_designs($order) {
		
		if ( ! is_a( $order, 'WC_Order' ) ) {
			return;
		}
		
		global $magic;
		
		if( isset($magic->cfg->settings['email_design']) && $magic->cfg->settings['email_design'] == 1 ) {
			
			$order_id 	= $order->get_id();
			
			$order_status = $order->get_status();
			
			if( $order_status == 'completed' ) {
				$items = $magic->lib->get_order_products($order_id);

				?>
				<h2><?php echo magic_lang("Your Designs:");?></h2>
				<div style="margin-bottom: 40px;">
				<table class="woocommerce-table woocommerce-table--order-details shop_table order_details">
					<thead>
						<tr>
							<th><?php _e( 'Product', 'woocommerce' ); ?></th>
							<th><?php _e( 'View Design', 'woocommerce' ); ?></th>
						</tr>
					</thead>
					<tbody>
				<?php
				
				foreach ($items as $order_item) {
					$is_query = explode('?', $magic->cfg->tool_url);
						
					$url = $magic->cfg->tool_url.(isset($is_query[1])? '&':'?');
					$url .= 'product_base='.$order_item['product_base'];
					$url .= (($order_item['custom'] == 1)? '&design_print='.str_replace('.lumi', '', $order_item['design']) : '');
					$url .= '&order_print='.$order_id . '&product_cms='.$order_item['product_id'];
								
					$url = str_replace('?&', '?', $url);
					
					?>
					<tr class="woocommerce-table__line-item order_item">
						<td class="woocommerce-table__product-name product-name"><?php echo esc_html($order_item['product_name']);?></td>
						<td class="woocommerce-table__product-name product-link"><?php 
							echo apply_filters( 'magic_order_download_link', '<a href="' . $url . '" target="_blank" class="magic-view-design">' . magic_lang('View Design') . '</a>', $order_item ); 
						?></td>
					</tr>
					<?php
				}

					?>
						</tbody>
					</table>
				</div>
				<?php

			}
		}
		
	}
	
	public function woo_cart_item_removed($cart_key, $cart) {
		
		global $magic;
		
		foreach ($cart->removed_cart_contents as $key => $cart_item){
			if (isset($cart_item['magic_data'])){
				$magic->lib->remove_cart_item( $cart_item['magic_data']['cart_id'], $cart_item['magic_data'] );
			}
		}
		
	}
	
	//add template thumbnail to product image
	public function woo_add_template_thumbs() {
		
		global $product,  $wpdb, $magic;
		
        $product_id = $product->get_id();

        $product_have_design = $this->has_template($product_id);
		
		if( is_array($product_have_design)){
			$template = $magic->lib->get_template($product_have_design['meta_value']);
			if(is_array($template)){
				
				$attributes = array(
					'title'                   => $template['name'],
					'data-caption'            => $template['name'],
					'data-src'                => $template['screenshot'],
					'data-large_image'        => $template['screenshot']
				);
				$html  = '<div data-thumb="' . esc_url($template['screenshot']) . '" class="woocommerce-product-gallery__image"><a href="' . esc_url( $template['screenshot'] ) . '">';
				$html .= '<img src="'.esc_url($template['screenshot']).'" '.implode(' ', $attributes).'/>';
				$html .= '</a></div>';
				echo $html;
			}
			
        }
	}
	
	//check product as design?
	public function has_template($product_id) {
		
		global $wpdb, $magic;
		
		$cms_product = $wpdb->get_results("SELECT * FROM `{$wpdb->prefix}posts` WHERE `id`=".$product_id);
		$cms_template = get_post_meta($product_id, 'magic_design_template', true );
		if (!isset($cms_product[0]))
			return false;
		
		if (isset($cms_template) && !empty($cms_template) && $cms_template != '%7B%7D') {
			return true;
		}
		return false;
	}
	
	public function get_base_id($product_id) {
		
		global $wpdb;
		
		$sql_design = "
					SELECT pm.* FROM " . $wpdb->prefix . "posts as posts INNER JOIN " . $wpdb->prefix . "postmeta as pm  
				  ON ( pm.post_id = " . $product_id . " AND posts.ID = " . $product_id . ") 
				  WHERE  pm.meta_key = 'magic_product_base' AND  pm.meta_value > 0
				  AND posts.post_type = 'product' AND  posts.post_status = 'publish'
			  ";
		
		$product_have_design = $wpdb->get_results( $sql_design, ARRAY_A);
		
		if(count($product_have_design)>0)
			return $product_have_design[0]['meta_value'];
		return null;
	}
	
	public function woo_product_get_price_html($price, $product) {
		
		global $wpdb, $magic;
		
		$cms_template = get_post_meta($product->get_id(), 'magic_design_template', true );
		
		$template_price = 0;
		
		if (
			isset($cms_template) 
			&& !empty($cms_template) 
			&& $cms_template != '%7B%7D'
		) {
			$cms_template = json_decode(urldecode($cms_template), true);
			$templates = array();
			foreach($cms_template as $stage){
				if(isset($stage['id']) && !in_array($stage['id'], $templates)){
					$templates[] = $stage['id'];
					$template = $magic->lib->get_template($stage['id']);
					$template_price += ($template['price'] > 0)? $template['price'] : 0;
				}
			}
			if (!is_numeric($template_price))
				$template_price = 0;
			
			$pprice = $product->get_price();
			if (!is_numeric($pprice)){
				$pprice = 0;
			}
			$sale_product = '';
			$new_price = $pprice + $template_price;
			if($product->get_sale_price()){
				return wc_format_sale_price($product->get_regular_price(), ($pprice + $template_price) ).' '.$product->get_price_suffix();
			}
			if(get_option('woocommerce_calc_taxes') == 'yes' && get_option('woocommerce_price_display_suffix') != ''){
				return wc_price($pprice + $template_price).' '.$product->get_price_suffix();
			}
			return wc_price($pprice + $template_price);
		}
		
		return $price;
		
	}
	
	public function woocommerce_cart_item_price($price, $cart_item, $cart_item_key) {
		
		$product_quantity = $cart_item['quantity'];
		
		global $magic;
		
		if( isset($cart_item['magic_data']) ){
			
			$cart_item_data = $magic->lib->get_cart_data( $cart_item['magic_data'] );
			
			if( 
				isset($cart_item_data['qtys']) && 
				count($cart_item_data['qtys']) > 0
			){
				
				$product_quantity = 0;

				foreach ($cart_item_data['qtys'] as $key => $val) {
					$product_quantity += (Int)$val['qty'];
				}
				
			}else $product_quantity = $cart_item_data['qty'];
			
			return wc_price($cart_item['data']->price);
		}
		
		return $price;
			
	}
	
	public function woo_widget_cart_item_quantity($html, $cart_item, $cart_item_key) {
		
		if (isset($cart_item['magic_data'])) {
			foreach ($cart_item['magic_data']['attributes'] as $id => $attr) {
				if ($attr->type == 'quantity' && isset($cart_item['magic_data']['options']->{$id})) {
					$total = $cart_item['magic_data']['price']['total'];
					$qty = @json_decode($cart_item['magic_data']['options']->{$id}, true);
					if (json_last_error() === 0 && is_array($qty)) {
						$qty = array_sum($qty);
					} else $qty = (Int)$cart_item['magic_data']['options']->{$id};
					$html = '<span class="quantity">' . sprintf( '%s &times; %s', $qty, wc_price($total/$qty) ) . '</span>';
				}
			}
			
		}
		
		return $html;
		
	}
	
	public function hide_wp_update_notice() {
	   remove_action( 'admin_notices', 'update_nag', 3 );
	} 
	         
	public function wpdocs_dequeue_script() {
		
	    global $wp_scripts;
	    $wp_scripts->queue = array('hoverIntent', 'common', 'admin-bar', 'heartbeat', 'wp-auth-check');
	    
	}

	public function add_display_post_states($post_states, $post){
		
		global $wpdb;
		
		$editor_page = get_option('magic_editor_page', 0);

		if ( $editor_page == $post->ID ) {
			$post_states['magic_design_page'] = __( 'Design Editor Page', 'magic' );
		}
		if($post->post_type == 'product'){
			$product_id = $post->ID;
			$sql_design = "
						SELECT pm.*, pm.meta_value as base_id  FROM " . $wpdb->prefix . "posts as posts INNER JOIN " . $wpdb->prefix . "postmeta as pm  
	                  ON ( pm.post_id = " . $product_id . " AND posts.ID = " . $product_id . ") 
	                  WHERE  pm.meta_key = 'magic_product_base' AND  pm.meta_value > 0
	                  AND posts.post_type = 'product' AND  posts.post_status = 'publish'
	              ";
	        $product_have_design = $wpdb->get_results( $sql_design, ARRAY_A);
			if(!count($product_have_design)) return $post_states;
			$post_states['magic_assigned_base'] = __( 'Assigned MagicRugs Product', 'magic' ).' #'.$product_have_design[0]['base_id'];
		}
		return $post_states;
	}
	
	public  function add_variable_attributes( $loop, $variation_data, $variation ) {
		
		global $magic, $post;
		
	?>
	<div>
		<p class="form-field variable_description0_field form-row form-row-full" style="margin-bottom:0px;">
			<label>MagicRugs configuration</label>
			<textarea style="display: none;" class="short magic-vari-inp" style="" name="variable_magic[<?php echo $loop; ?>]" id="variable-magic-<?php echo $variation->ID; ?>" placeholder="" rows="2" cols="20"><?php 
				if (isset($variation_data['_variation_magic'])) {
					echo str_replace(array('<textarea', '</textarea>'), array('&lt;textarea', '&lt;/textarea&gt;'), $variation_data['_variation_magic'][0]); 
				}
			?></textarea> 
		</p>
		<div class="variable_magic_data" data-empty="<?php
					echo (
						isset($variation_data['_variation_magic']) && 
						!empty($variation_data['_variation_magic'][0])
					) ? 'false' : 'true';
			?>" data-id="<?php echo $variation->ID; ?>">
			<button class="button" data-magic-frame="<?php 
				echo $magic->cfg->ajax_url;	
			?>&action=product_variation&product_id=<?php echo $post->ID; ?>&variation_id=<?php echo $variation->ID; ?>" id="magic-config-<?php echo $variation->ID; ?>">
				<i class="fa fa-cog"></i> 
				<text is="nonempty"><?php echo $magic->lang('Open MagicRugs Configuration'); ?></text>
				<text is="empty"><?php echo $magic->lang('Setup new MagicRugs Designer'); ?></text>
			</button>
			<button class="button secondary button-link-delete" is="nonempty" data-magic-frame="clear">
				<i class="fa fa-trash"></i>  <?php echo $magic->lang('Clear this config'); ?>
			</button>
			<button class="button secondary" is="empty" data-magic-frame="list">
				<i class="fa fa-th"></i>  <?php echo $magic->lang('Select an exist config'); ?>
			</button>
			<button class="button secondary" is="empty" data-magic-frame="paste">
				<i class="fa fa-paste"></i>  <?php echo $magic->lang('Paste copied config'); ?>
			</button>
		</div>
	</div>	
	<?php
	}
	
	public  function save_variable_attributes( $variation_id, $i ) {
		if (
			isset( $_POST['variable_magic']) && 
			isset( $_POST['variable_magic'][ $i ] )
		) {
			$variation_id = absint($_POST['variable_post_id'][$i]);
			update_post_meta($variation_id, '_variation_magic', $_POST['variable_magic'][$i]);			
		}
	}
	
	public function plugin_action_links( $links ) {
		
		$action_links = array(
			'settings' => '<a href="' . admin_url( 'admin.php?page=magic' ) . '" aria-label="' . esc_attr__( 'Go to MagicRugs settings', 'woocommerce' ) . '">' . esc_html__( 'Settings', 'magic' ) . '</a>',
		);

		return array_merge( $action_links, $links );
	}
	
	public function plugin_row_meta($links, $file) {
		
		if (MAGIC_PLUGIN_BASENAME == $file) {
			
			$row_meta = array(
				'docs' => '<a href="' . esc_url( 'https://MagicRugs.com/?utm_source=client-site&utm_medium=plugin-meta&utm_campaign=links&utm_term=meta&utm_content=woocommerce' ) . '" target=_blank aria-label="' . esc_attr__( 'View MagicRugs ', 'magic' ) . '">' . esc_html__( 'Documentation', 'magic' ) . '</a>',
				'blog' => '<a href="' . esc_url( 'https://MagicRugs.com/?utm_source=client-site&utm_medium=plugin-meta&utm_campaign=links&utm_term=meta&utm_content=woocommerce' ) . '" target=_blank aria-label="' . esc_attr__( 'View MagicRugs ', 'magic' ) . '">' . esc_html__( 'Blog', 'magic' ) . '</a>',
				'support' => '<a href="' . esc_url( 'https://MagicRugs.com/?utm_source=client-site&utm_medium=plugin-meta&utm_campaign=links&utm_term=meta&utm_content=woocommerce' ) . '" target=_blank aria-label="' . esc_attr__( 'customer support', 'magic' ) . '">' . esc_html__( 'Support', 'magic' ) . '</a>'
			);

			return array_merge( $links, $row_meta );
		}

		return (array) $links;
	}
	
	public function submenu_file( $submenu_file ) {
		
		$p = isset($_GET['page']) ? $_GET['page'] : '';
		$lp = isset($_GET['magic-page']) ? $_GET['magic-page'] : '';
		
		if ($p == 'magic' && ($lp == 'addons' || $lp == 'explore-addons')) 
			return 'admin.php?page=magic&magic-page=explore-addons';
		
		if ($p == 'magic' && $lp == 'settings') 
			return 'admin.php?page=magic&magic-page=settings';
			
		if ($p == 'magic' && $lp == 'orders') 
			return 'admin.php?page=magic&magic-page=orders';
		
		return $submenu_file;
		
	}
	
	public function update_message($response){
		
		?><script>document.querySelectorAll("#magic-hook-sfm-update .update-message.notice p")[0].innerHTML = '<?php echo esc_html__('There is a new version of MagicRugs - Product Designer Tool'); ?>. <a href="https://www.MagicRugs.com/changelogs/woocommerce/?utm_source=client-site&utm_medium=text&utm_campaign=update-page&utm_term=links&utm_content=woocommerce" target=_blank" target=_blank>View version <?php echo esc_html($response['new_version']); ?> details</a> or <a href="<?php echo admin_url( 'admin.php?page=magic&magic-page=updates' ); ?>">update now</a>.';</script><?php
	}
	
	public function my_orders_actions($actions, $order) {
		
		global $magic, $wpdb;

		
		$is_magic = $wpdb->get_results('SELECT `id` FROM `magic_order_products` WHERE `order_id`='.$order->get_id());
        if (count($is_magic) !== 0) {
	    	$actions['reorder']   = array(
				'url'  => $magic->cfg->tool_url.'reorder='.$order->get_id(),
				'name' => __( 'Reorder', 'woocommerce' ),
			);
	    }
		
		return $actions;
		
	}
	
	public function frontstore_variation($data, $claz, $vari) {
		
		$magic_data = get_post_meta($data['variation_id'], '_variation_magic', true);
		$data['magic'] = isset($magic_data) && !empty($magic_data) ? $data['variation_id'] : 0;
		
		return $data;
		
	}
	
	public function customize_button() {
		
		global $product, $wpdb, $magic;
		
		$config = get_option('magic_config', array());		
		
		if(
			(isset($config['btn_page']) && !$config['btn_page']) ||
			!method_exists($product, 'get_id')
		) return;
		
		$product_id 	= $product->get_id();
			
		$product_base = get_post_meta($product_id, 'magic_product_base', true);
		$magic_customize = get_post_meta($product_id, 'magic_customize', true);
		$disable_cartbtn = get_post_meta($product_id, 'magic_disable_add_cart', true);

		if (
			(empty($product_base) && $product->is_type( 'simple' )) || 
			$magic_customize != 'yes' ||
			(!$product->is_type( 'variable' ) && !$product->is_type( 'simple' ))
		) {
			return;
		}
		
		if ($product->is_type( 'variable' )) {
			$product_base = 'variable';	
		}
		
		$text 			= isset($config['btn_text'])? $config['btn_text'] : __('Customize', 'magic');
		$link_design	= str_replace('?&', '?', $this->tool_url . '&product_base='.$product_base.'&product_cms='.$product_id);
		
		do_action( 'magic_before_customize_button' );

		$disable_variation = '';
		if ($product->is_type( 'variable' )) {
           
			$disable_variation = 'disabled';	
		}

		$class_magic = apply_filters('magic_button_customize', 'magic-customize-button button alt '.$disable_variation.' single_add_to_cart_button');
		$link_design = apply_filters( 'magic_customize_link', $link_design );
		?>
		<a name="customize" id="magic-customize-button" class="<?php echo $class_magic; ?>" href="<?php echo esc_url($link_design ); ?>" data-href="<?php echo esc_url($link_design ); ?>">
			<?php echo esc_html($text); ?>
		</a>
		<script>
			(function($) {
				<?php  if ($disable_cartbtn == 'yes') { ?>
				$('#magic-customize-button').closest('form').find('button.single_add_to_cart_button').remove();
				<?php } ?>
				<?php if($product->is_type( 'variable' )): ?>
					$('#magic-customize-button').click(function(e){
					var goto = true;
					$('table.variations tr select').each(function(index, value){
						if($(this).val() == '' || $(this).val() == 'null' || $(this).val() == ' ' || $(this).val() == null || $(this).val() == undefined || $(this).val() == 'undefined' ){
							goto = false;
						}
					});

					if(goto == false){
						e.preventDefault();
						alert('Please select some product options before adding this product to customize.');
					}
				})
				<?php endif; ?>
				$('form.variations_form')/*.on('show_variation', function (e) {
					
				})*/.on('hide_variation', function (e) {
					setTimeout(() => {
						let form 		= e.data.variationForm,
							attributes  = form.getChosenAttributes(),
							url = new URL($('#magic-customize-button').attr('href'));
						if (attributes.data != undefined){
							let attr_filter = Object.keys(attributes.data).map(function(key, index) {
								url.searchParams.delete(key,'');
							});
							$('#magic-customize-button').attr('href', decodeURIComponent(url));
						}
						$('#magic-customize-button').addClass('disabled');
					}, 1);	
				}).on('found_variation', function (e, vari) {
					setTimeout(() => {
						let lm = vari.magic,
							hrf = $('#magic-customize-button').attr('data-href').replace('product_base=variable', 'product_base=variable:'+lm)+'&quantity='+$(this).find('input[name="quantity"]').val();
						$('#magic-customize-button').attr({
							'href': lm !== '' && lm !== 0 ? hrf : "javascript:alert('This variant has not been configured with Rug Custom<br> You can use CustomSize variation for full access')",
						}).removeAttr('disabled').removeClass('disabled');
						if(vari.is_in_stock == false){
							$('#magic-customize-button').addClass('disabled');
                            $("#magic-customize-button").removeAttr("href");
                        }else{
							let form 		= e.data.variationForm,
								attributes  = form.getChosenAttributes(),
								url = new URL($('#magic-customize-button').attr('href'));
							if ( attributes.count && attributes.count === attributes.chosenCount ){
								let attr_filter = Object.keys(attributes.data).map(function(key, index) {
									url.searchParams.append(key,attributes.data[key]);
								});
								$('#magic-customize-button').attr('href', decodeURIComponent(url));
							}
						}
						// If not setup MagicRugs for this variation ==> disable customize button
						if (lm === '' || lm === 0) {
							$('#magic-customize-button').attr({'disabled': 'disabled'}).addClass('disabled');
						}
					}, 1);
				}).find('input[name="quantity"]').on('change', function() {
					if (!$('#magic-customize-button').hasClass('disabled')) {
						let hrf = $('#magic-customize-button').attr('href');
						hrf = hrf.replace(/&quantity=[\d]*/g, '&quantity='+this.value);
						$('#magic-customize-button').attr('href', hrf);
					}
				});
				
			})(jQuery);
		</script>
		<?php
		
		do_action( 'magic_after_customize_button' );

	}
	
	public function shipping_packages($package) {
		
		global $magic;
		
		foreach ( $package[0]['contents'] as $item_id => $values ) {
			if( isset($values['magic_data']) ){
				$cart_item_data = isset( $values['magic_data'] ) ? $magic->lib->get_cart_data( $values['magic_data'] ) : array();
				$package[0]['contents'][$item_id]['quantity'] = $cart_item_data['qty'];
			}
		}
		
		return $package;
	}

}

if (class_exists('WOOCS')) {
    global $WOOCS;
    if ($WOOCS->is_multiple_allowed) {
        $currrent = $WOOCS->current_currency;
        if ($currrent != $WOOCS->default_currency) {
            $currencies = $WOOCS->get_currencies();
            $rate = $currencies[$currrent]['rate'];
            $price = $price / $rate;
        }
    }
}

global $magic_woo;

$magic_woo = new magic_woocommerce();
