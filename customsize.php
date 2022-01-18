<?php
/*
Plugin Name: Customdesign - Rug Designer Tool
Plugin URI: https://www.rugscustom.com/
Description: The professional solution for designing & printing online
Author: MehdiMirabi
Version: 1.0.0
Author URI: http://mehdimnirabi.com/
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
if(!defined('CUSTOMDESIGN_WOO')) {
	define('CUSTOMDESIGN_WOO', '1.0.0' );
}
if ( ! defined( 'CUSTOMDESIGN_FILE' ) ) {
	define('CUSTOMDESIGN_FILE', __FILE__ );
	define('CUSTOMDESIGN_PLUGIN_BASENAME', plugin_basename(CUSTOMDESIGN_FILE));
}	

function customdesign_lang($s) {
	global $customdesign;
	return isset($customdesign) ? esc_html($customdesign->lang($s)) : $s;
}

class customdesign_woocommerce {
	    
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
			
        $this->prefix = 'customdesign_';
		
		$this->url = site_url('/?customdesign=design');
		$this->tool_url = site_url('/?customdesign=design');
		
        $this->admin_url = admin_url('admin.php?page=customdesign');
        
        $this->path = dirname(__FILE__).DS;
        
        $this->app_path = $this->path . 'core'.DS;
        
        $this->upload_path = WP_CONTENT_DIR.DS.'uploads'.DS.'customdesign_data'.DS;
        
        $this->upload_url = content_url('uploads/customdesign_data/');
        
        $this->assets_url = plugin_dir_url(__FILE__) . 'core/';
        
        $this->admin_assets_url = plugin_dir_url(__FILE__) . 'core/admin/assets/';
        
        $this->ajax_url =  site_url('/?customdesign=ajax');
        
        $this->admin_ajax_url =  admin_url('?customdesign=ajax');
		
        $this->checkout_url =  site_url('/?customdesign=cart');

        define('CUSTOMDESIGN_PATH', $this->path . 'core'.DS);
        
        define('CUSTOMDESIGN_ADMIN_PATH', $this->path . 'core'.DS.'admin'.DS);

        register_activation_hook(__FILE__, array($this, 'activation'), 10);
        
		add_action( 'activated_plugin', array($this, 'activation_redirect'), 10 );

        //process ajax customdesign
		
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
			 
			if (isset($_GET['page']) && $_GET['page'] == 'customdesign'){
				add_action( 'wp_print_scripts', array(&$this, 'wpdocs_dequeue_script'), 100 );
			}
			
			add_action( 'admin_footer', array(&$this, 'admin_footer') );    	
	        
			add_action( 'admin_head', array(&$this, 'hide_wp_update_notice'), 1 );
			add_action( 'in_plugin_update_message-' .CUSTOMDESIGN_PLUGIN_BASENAME, array( &$this, 'update_message' ) );
	        add_filter( 'plugin_action_links_' . CUSTOMDESIGN_PLUGIN_BASENAME, array( &$this, 'plugin_action_links' ) );
	        add_filter( 'plugin_row_meta', array( &$this, 'plugin_row_meta' ), 10, 2 );
			add_filter( 'submenu_file', array( &$this, 'submenu_file'));
	        add_filter( 'woocommerce_order_item_get_quantity', array(&$this, 'woo_order_item_get_quantity' ), 10, 2 );
			add_filter( 'manage_edit-shop_order_columns', array(&$this, 'woo_customdesign_order_column'), 10, 1 );
			add_action( 'manage_shop_order_posts_custom_column', array(&$this, 'woo_customdesign_column_content') );
	        
	        add_action( 'admin_notices', array(&$this, 'admin_notices') );

	        if ($wpdb->get_var("SHOW TABLES LIKE 'customdesign_settings'") == 'customdesign_settings') {

		        $customdesign_update_core = $wpdb->get_results("SELECT `value` from `customdesign_settings` WHERE `key`='last_check_update'"); 
		        if (count($customdesign_update_core) == 1) {
		        	$this->update_core = @json_decode($customdesign_update_core[0]->value);
			    }
				
				$current = get_site_transient( 'update_plugins' );
				
				if (
					isset($this->update_core) && 
					version_compare(CUSTOMDESIGN_WOO, $this->update_core->version, '<') && 
					(
						!isset($current->response[CUSTOMDESIGN_PLUGIN_BASENAME]) ||
						$this->update_core->version > $current->response[CUSTOMDESIGN_PLUGIN_BASENAME]->new_version
					)
				) {
					$current->response[CUSTOMDESIGN_PLUGIN_BASENAME] = (Object)array(
						'package' => 'private',
						'new_version' => $this->update_core->version,
						'slug' => 'customdesign-hook-sfm'
					);
					set_site_transient('update_plugins', $current);
				}else if (
					isset($current) && 
					isset($current->response[CUSTOMDESIGN_PLUGIN_BASENAME]) &&
					CUSTOMDESIGN_WOO >= $current->response[CUSTOMDESIGN_PLUGIN_BASENAME]->new_version
				) {
					unset($current->response[CUSTOMDESIGN_PLUGIN_BASENAME]);
					set_site_transient('update_plugins', $current);
				}
			}
			
			$role = get_role('administrator');
			
			$role->add_cap('customdesign_access');
			$role->add_cap('customdesign_can_upload');
			
			$role->add_cap('customdesign_read_dashboard');
			$role->add_cap('customdesign_read_settings');
			$role->add_cap('customdesign_read_products');
			$role->add_cap('customdesign_read_cliparts');
			$role->add_cap('customdesign_read_templates');
			$role->add_cap('customdesign_read_orders');
			$role->add_cap('customdesign_read_shapes');
			$role->add_cap('customdesign_read_printings');
			$role->add_cap('customdesign_read_fonts');
			$role->add_cap('customdesign_read_shares');
			$role->add_cap('customdesign_read_bugs');
			$role->add_cap('customdesign_read_languages');
			$role->add_cap('customdesign_read_addons');
			
			$role->add_cap('customdesign_edit_settings');
			$role->add_cap('customdesign_edit_products');
			$role->add_cap('customdesign_edit_cliparts');
			$role->add_cap('customdesign_edit_templates');
			$role->add_cap('customdesign_edit_orders');
			$role->add_cap('customdesign_edit_shapes');
			$role->add_cap('customdesign_edit_printings');
			$role->add_cap('customdesign_edit_fonts');
			$role->add_cap('customdesign_edit_shares');
			$role->add_cap('customdesign_edit_languages');
			$role->add_cap('customdesign_edit_categories');
			$role->add_cap('customdesign_edit_tags');
			$role->add_cap('customdesign_edit_bugs');
			$role->add_cap('customdesign_edit_addons');
			$role->add_cap('customdesign_edit_distresss');
			   
		} else {
			// Add customdesign design to variations on add to cart form
			add_filter( 'woocommerce_available_variation', array(&$this, 'frontstore_variation'), 999, 3);
			
		}
		
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
		add_action( 'admin_notices', array($this, 'customdesign_admin_notices') );
		
		if (
			!isset($_COOKIE['CUSTOMDESIGNSESSID']) || 
			empty($_COOKIE['CUSTOMDESIGNSESSID']) || 
			$_COOKIE['CUSTOMDESIGNSESSID'] === null
		) {
			$sessid = strtoupper(substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 20));
			@setcookie('CUSTOMDESIGNSESSID', $sessid, time() + (86400 * 30), '/');
			$_COOKIE['CUSTOMDESIGNSESSID'] = $sessid;
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
				'post_content'   => 'This is customdesign design page. Go to customdesign > Settings > Shop to change other page when you need.'
			);
			
			$page_id = wp_insert_post( $page );
			update_option('customdesign_editor_page', $page_id);
			
		}
			
		return true;
		
    }  
    
    public function activation_redirect($plugin) {
	    
	    if( $plugin == plugin_basename( __FILE__ ) ) {
		    
		    global $wpdb;
		
			if ($wpdb->get_var("SHOW TABLES LIKE 'customdesign_settings'") != 'customdesign_settings') {
				
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
		    
		    
			$setup = get_option('customdesign_setup', false);
			
			if ($setup != 'done') {
				exit( wp_redirect( admin_url( 'admin.php?page=customdesign-setup' ) ) );
			}
		}
		
    }

    public function customdesign_admin_notices() {
		
		global $customdesign;

		$addon_list = $customdesign->addons->addon_installed_list();

		if( isset($addon_list) && !empty($addon_list) && count($addon_list) > 0 
			&& (
				isset($addon_list['assign']) 
				|| isset($addon_list['display_template_clipart']) 
				|| isset($addon_list['dropbox_sync']) 
				|| isset($addon_list['mydesigns']) 
				|| isset($addon_list['distress']) 
			)
		){

			$key_addon_bundle = $customdesign->get_option('purchase_key_addon_bundle');
			$key_valid_addon_bundle = ($key_addon_bundle === null || empty($key_addon_bundle) || strlen($key_addon_bundle) != 36 || count(explode('-', $key_addon_bundle)) != 5) ? false : true;

			if (!$key_valid_addon_bundle) {
				echo '<div class="wp-notice error" style="margin: 15px 0"><p>'.$customdesign->lang('You must verify your purchase code for addon bundle to access to all features').'. <a href="'.admin_url('?page=customdesign&customdesign-page=license').'">'.$customdesign->lang('Enter your license now').'</a></p></div>';
			}

		}

		if(isset($addon_list) && !empty($addon_list) && count($addon_list) > 0 && isset($addon_list['vendors'])){
			// exist addon vendor
			$key_addon_vendor = $customdesign->get_option('purchase_key_addon_vendor');
			$key_valid_addon_vendor = ($key_addon_vendor === null || empty($key_addon_vendor) || strlen($key_addon_vendor) != 36 || count(explode('-', $key_addon_vendor)) != 5) ? false : true;

			if (!$key_valid_addon_vendor) {
				echo '<div class="wp-notice error" style="margin: 15px 0"><p>'.$customdesign->lang('You must verify your purchase code for addon vendor to access to all features').'. <a href="'.admin_url('?page=customdesign&customdesign-page=license').'">'.$customdesign->lang('Enter your license now').'</a></p></div>';
			}
		}

		if(isset($addon_list) && !empty($addon_list) && count($addon_list) > 0 && isset($addon_list['printful'])){
			// exist addon vendor
			$key_addon_printful = $customdesign->get_option('purchase_key_addon_printful');
			$key_valid_addon_printful = ($key_addon_printful === null || empty($key_addon_printful) || strlen($key_addon_printful) != 36 || count(explode('-', $key_addon_printful)) != 5) ? false : true;

			if (!$key_valid_addon_printful) {
				echo '<div class="wp-notice error" style="margin: 15px 0"><p>'.$customdesign->lang('You must verify your purchase code for addon printful to access to all features').'. <a href="'.admin_url('?page=customdesign&customdesign-page=license').'">'.$customdesign->lang('Enter your license now').'</a></p></div>';
			}
		}
	}
    
    public function render() {
	    
		show_admin_bar(false);
        //require bridge for frontend
        require_once($this->path . $this->connector_file);
        
        $editor_index = apply_filters('customdesign_editor_index', $this->path . 'core'. DS . 'index.php');
        
        //require cutomize index
        require_once($editor_index);
        
    }
	
	public function woo_remove_order($order_id) {
		
		global $post_type, $customdesign;

	    if($post_type !== 'shop_order') {
	        return;
	    }
	    
		$customdesign->lib->delete_order_products($order_id);
	}
	
	public function init() {
		
		$editor_page = get_option('customdesign_editor_page', 0);
		
		if ($editor_page > 0) {
			$url = esc_url(get_page_link($editor_page));
			$this->url = (strpos($url, '?') === false)? $url . '?': $url;
			$this->tool_url = $this->url;
		}
		
		$this->load_core();
		
		/*if (is_admin()) {
			if (isset($_GET['page']) && $_GET['page'] == 'customdesign-setup') {
				include $this->path.'woo'.DS.'setup.php';
				exit;
			}
		}*/
			
	}
	
	public function page_display() {
			
		global $wp_query, $customdesign, $post;
		
		$editor = get_option('customdesign_editor_page', 0);
		$in_iframe = $customdesign->get_option('editor_iframe', 0);
		$iframe_width = $customdesign->get_option('editor_iframe_width', '100%');
		$iframe_height = $customdesign->get_option('editor_iframe_height', '80vh');
		
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
				
				if ($in_iframe == 1 && !isset($_GET['customdesign_iframe']) && !isset($_GET['pdf_download'])) {
					remove_all_filters('the_content');
					$link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')  ? "https" : "http"; 
					$link .= "://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
					if(strpos($_SERVER['REQUEST_URI'], '?') !== FALSE){
						$link .= '&';
					} else {
						$link .= '?';
					}
					$link .='customdesign_iframe=true';
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
	    
		global $post, $customdesign;
		
		$route = isset($_GET['customdesign']) && !empty($_GET['customdesign']) ? $_GET['customdesign'] : null;
		
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
					$customdesign->router($route);
				break;	
				default:break;
			}
			exit;
		}
        
    }
	
	public function admin_notices() {
		
		return;
		
		if (isset($_GET['customdesign-hide-notice']) && $_GET['customdesign-hide-notice'] == 'setup') {
			update_option('customdesign_setup', 'done');
		} else {
		
			$setup = get_option('customdesign_setup', false);
			$current = get_option( 'active_plugins', array() );
			if ($setup != 'done') {
			?>
			<div id="message" class="updated">
				<p>
					<strong><?php _e('Welcome to customdesign', 'customdesign'); ?></strong> &#8211; 
					<?php _e('You&lsquo;re almost ready, Please create a Woo Product and link to a customdesign Product Base to start designing.', 'customdesign'); ?>
				</p>
				<?php if (!in_array('woocommerce'.DS.'woocommerce.php', $current)) { ?>
				<p style="background: #f4433629;padding: 10px;">
					<?php _e('You need to install and activate the Woocommerce plugin so that customdesign can work', 'customdesign'); ?> 
					<a href="<?php echo admin_url('plugins.php'); ?>"><?php _e('Go to plugins', 'customdesign'); ?> &rarr;</a>
				</p>
				<?php } ?>
				<p class="submit">
					<a href="<?php echo esc_url( admin_url( 'admin.php?page=customdesign-setup' ) ); ?>" class="button-primary">
						<?php _e('Run the Setup Wizard', 'customdesign'); ?>
					</a> &nbsp; 
					<a class="button-secondary skip" href="<?php echo esc_url(add_query_arg( 'customdesign-hide-notice', 'setup' )); ?>">
						<?php _e('Skip setup', 'customdesign'); ?>
					</a>
				</p>
			</div>
			<?php	
			}
		}
		
	}
	
	public function woo_order_item_get_quantity($qty, $item){

		$item_data = $item->get_data();
		
		$customdesign_data = array();
		
		if (count($item_data['meta_data']) > 0) {
			
			$is_customdesign = false;
			
			foreach ($item_data['meta_data'] as $meta_data) {
				if ($meta_data->key == 'customdesign_data') {
					$is_customdesign = true;
					break;
				}
			}
			
			if ($is_customdesign) {
				
				$product_id = $item->get_product_id();
				$order_id = $item->get_order_id();
				
				global $customdesign;
				
				$items = $customdesign->lib->get_order_products($order_id);
				
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
	
	public function woo_customdesign_order_column($columns) {
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
	
	public function woo_customdesign_column_content($column) {
		
	    global $post, $wpdb;
	
	    if ( 'type' === $column ) {
			$is_customdesign = $wpdb->get_results('SELECT `id` FROM `customdesign_order_products` WHERE `order_id`='.$post->ID);
	        if (count($is_customdesign) === 0) {
		    	echo '';
		    } else {
			    echo '<a href="'.(esc_url( admin_url( 'post.php?post='.$post->ID) ) ).'&action=edit">&#9733;</a>';
			}    
	        
	    }
	}
	
	public function woo_admin_before_order_itemmeta($item_id, $item, $product) {
		
		global $customdesign_printings, $customdesign;
		
		if( !isset($customdesign_printings) ) {
			$customdesign_printings = $customdesign->lib->get_prints();
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
		
		global $customdesign, $post;
		
		$item_data = $item->get_data();
        if(!$item->meta_exists('customdesign_data')){
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
				if ($meta_data->key == 'customdesign_data') {
					$data['cart_id'] = $meta_data->value['cart_id'];
					break;
				}
			}
		}
		
		$data['product_base'] = get_post_meta($data['product_cms'], 'customdesign_product_base', true );
		
		if (empty($data['cart_id'])) {
	        $data['template'] = get_post_meta($data['product_cms'], 'customdesign_design_template', true );	
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
	        $data['template'] = get_post_meta($data['product_cms'], '_variation_customdesign', true );
	        $data['product_base'] = 'variable:'.$product->get_id();	
		}

		if (count($item_data['meta_data']) > 0) {
			foreach ($item_data['meta_data'] as $meta_data) {
				if ($meta_data->key == 'customdesign_data' && $data['product_base'] == '' && isset($meta_data->value['id']) && strpos($meta_data->value['id'], 'variable') !== false ) {
					$data['product_base'] = $meta_data->value['id'];
					break;
				}
			}
		}

		$customdesign->views->order_designs($data);
		
	}
    
    public function menu_page() {
        
        global $wpdb;
        
        $title = 'customdesign';
        
        if (
        	isset($this->update_core) && 
        	version_compare(CUSTOMDESIGN_WOO, $this->update_core->version, '<')
        )
        	$title .= ' <span class="update-plugins"><span class="plugin-count">1</span></span>';
        
        $title .= '<style type="text/css">#toplevel_page_customdesign img{height: 20px;box-sizing: content-box;margin-top: -3px;}</style>';
        
        add_menu_page( 
            	__( 'customdesign', 'customdesign' ),
                $title,
                'customdesign_access',
                'customdesign',
                array($this, 'admin_page'),
                $this->assets_url . 'assets/images/icon.png',
            90
        );
        
        add_submenu_page( 
        	'customdesign', 
        	'customdesign'.(!empty($_GET['customdesign-page']) ? ' '. ucfirst($_GET['customdesign-page']) : ''), 
        	__( 'Dashboard', 'customdesign' ),
        	'customdesign_access', 
        	'customdesign'
        );
        
        add_submenu_page( 
        	'customdesign', 
        	__( 'Orders', 'customdesign' ), 
        	__( 'Orders', 'customdesign' ),
        	'customdesign_access', 
        	'admin.php?page=customdesign&customdesign-page=orders'
        );
        
        add_submenu_page( 
        	'customdesign', 
        	__( 'Addons', 'customdesign' ), 
        	__( 'Addons', 'customdesign' ),
        	'customdesign_access', 
        	'admin.php?page=customdesign&customdesign-page=explore-addons'
        );
        
        add_submenu_page( 
        	'customdesign', 
        	__( 'Help', 'customdesign' ), 
        	__( 'Help', 'customdesign' ),
        	'customdesign_access', 
        	'https://help.customdesign.com'
        );
        
        add_submenu_page( 
        	'customdesign', 
        	__( 'Settings', 'customdesign' ), 
        	__( 'Settings', 'customdesign' ),
        	'customdesign_access', 
        	'admin.php?page=customdesign&customdesign-page=settings'
        );
        
    }
	
    public function admin_page() {
		
		if (!defined('CUSTOMDESIGN_ADMIN'))
			define('CUSTOMDESIGN_ADMIN', true);
		
		global $customdesign;
		
		if (!$customdesign->dbready) {
			echo '<br><div class="notice error"><p>customdesign Database is not ready! Try to deactive customdesign plugin and reactive it again. <a href="'.admin_url('plugins.php').'">Plugins Page</a></p></div>';
			return;
		}
			
        require_once($this->path . 'core'.DS . 'admin' .DS .'index.php');
        
    }

    public function woo_add_tab_attr( $product_data_tabs ) {
	    
        global $post;
		$product = wc_get_product( $post->ID );

		$product_data_tabs['customdesign'] = array(
			'label' => __( 'customdesign Configuration', 'customdesign' ),
			'target' => 'customdesign_product_data'
		);
		
        return $product_data_tabs;
    }
	
	public function woo_customize_link_list($html){
		
		global $product, $wpdb, $customdesign;
		
		$config = get_option('customdesign_config', array());
		
		if	(isset($config['btn_list']) && !$config['btn_list']) 
			return $html;
		if($product == null){
			return $html;
		}
		$pid = $product->get_id();
		
		$product_base = get_post_meta($pid, 'customdesign_product_base', true);
		$disable_add_cart = get_post_meta($pid, 'customdesign_disable_add_cart', true);
		$customdesign_customize = get_post_meta($pid, 'customdesign_customize', true);
		$price = $product->get_price();
		
		if (empty($price)) {
			$disable_add_cart = 'res';
		}
		
		if(
			!empty($product_base) &&
			$customdesign_customize == 'yes'
		){
			
			$link_design = str_replace('?&', '?', $this->tool_url . '&product_base='.$product_base.'&product_cms=' . $pid );
			$link_design = apply_filters( 'customdesign_customize_link', $link_design );
			
			$html = ($disable_add_cart == 'yes' ? '' : $html);
			$html .= '<a class="customdesign-button customdesign-list-button" href="' . esc_url($link_design ). '">' . 
						(isset($config['btn_text'])? $config['btn_text'] : __('Customize', 'customdesign')) .
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
			
			global $customdesign;
			global $wpdb;
			
	    	$id = get_the_ID();
	    	$ops = array();
	    	$js_cfg = array();
			
	        $ops['customdesign_product_base'] = get_post_meta($id, 'customdesign_product_base', true );
	        $ops['customdesign_design_template'] = get_post_meta($id, 'customdesign_design_template', true );
	        $ops['customdesign_customize'] = get_post_meta($id, 'customdesign_customize', true );
	        $ops['customdesign_disable_add_cart'] = get_post_meta($id, 'customdesign_disable_add_cart', true );
				
        	if (!empty($ops['customdesign_product_base'])) {
	        	
	        	$query = "SELECT `name`,`stages`,`attributes` FROM `{$customdesign->db->prefix}products` WHERE `id`={$ops['customdesign_product_base']}";
	        	$data = $wpdb->get_results($query);
	        	
	        	if (isset($data[0]) && isset($data[0]->stages)) {
		        	
		        	$color = $customdesign->lib->get_color($data[0]->attributes);
		        	
		        	$js_cfg['current_data'] = array(
						'id' => $ops['customdesign_product_base'],
						'name' => $data[0]->name,
						'color' => $color,
						'stages' => $data[0]->stages,
						'attributes' => $data[0]->attributes,
					);
					
					$stage = $customdesign->lib->dejson($data[0]->stages);
					
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
			
			if (!empty($ops['customdesign_design_template'])) {
	        	
	        	$designs = json_decode(rawurldecode($ops['customdesign_design_template']));
	        	
	        	foreach($designs as $s => $d) {
		        	
		        	if (!isset($d->id))
		        		continue; 
		        		
		        	$data = $wpdb->get_results("SELECT `name`,`screenshot` FROM `{$customdesign->db->prefix}templates` WHERE `id`=".$d->id);
		        	if (isset($data[0]))
			        	$designs->{$s}->screenshot = $data[0]->screenshot;
			        else unset($designs->{$s});
			        
	        	}
	        	
	        	$js_cfg['current_design'] = $designs;
	        	
        	}
        	
			customdesign_cms_product_data_fields($ops, $js_cfg, $id);
			echo '<script type="text/javascript" src="'.$customdesign->cfg->assets_url.'admin/assets/js/woo_product.js?version='.CUSTOMDESIGN.'"></script>';
		
		}
		
    }

	// save value element data tabs

    public function woo_process_product_meta_fields_save($post_id) {
	  	
	    global $wpdb;
	    
	    $product_base = isset($_POST['customdesign_product_base']) ? $_POST['customdesign_product_base'] : '';
	    $design_template = isset($_POST['customdesign_design_template']) ? $_POST['customdesign_design_template'] : '';
	    $customdesign_customize = isset($_POST['customdesign_customize']) ? $_POST['customdesign_customize'] : 'no';
	    $addcart = isset($_POST['customdesign_disable_add_cart']) ? $_POST['customdesign_disable_add_cart'] : 'no';

        update_post_meta($post_id, 'customdesign_disable_add_cart', $addcart);
        update_post_meta($post_id, 'customdesign_customize', $customdesign_customize);
        update_post_meta($post_id, 'customdesign_product_base', $product_base);
        update_post_meta($post_id, 'customdesign_design_template', $design_template);
        
        if($product_base == ''){
        	$wpdb->query("UPDATE `{$this->prefix}products` SET `product` = 0 WHERE `product` = $post_id");
        }
		
        if (!empty($product_base) && $customdesign_customize == 'yes') {
	        $check = $wpdb->get_results("SELECT `product` FROM `{$this->prefix}products` WHERE `id` = $product_base", OBJECT);
	        if (isset($check[0])) {
				$wpdb->query("UPDATE `{$this->prefix}products` SET `product` = 0 WHERE `product` = $post_id");
		        $wpdb->query("UPDATE `{$this->prefix}products` SET `product` = $post_id WHERE `id` = $product_base");
	        }
        }
        
    }

	public function admin_footer() {
		echo '<script type="text/javascript">jQuery(\'a[href="https://help.customdesign.com"]\').attr({target: \'_blank\'})</script>';	
	}

	/** Frontend**/
	
	public function frontend_scripts() {
		
		wp_register_script('customdesign-frontend', plugin_dir_url(__FILE__) . 'woo/assets/js/frontend.js', array('jquery'), customdesign_WOO, true);
		
		wp_register_style('customdesign-style', plugin_dir_url(__FILE__).'woo/assets/css/frontend.css', false, CUSTOMDESIGN_WOO);
		
		wp_enqueue_style('customdesign-style');
		wp_enqueue_script('customdesign-frontend');
		
	}

    //Render attributes from customdesign
    public function woo_render_meta( $cart_data, $cart_item = null ){
	    
		// get data in cart
		global $customdesign;
		
        $custom_items = array();

        if( !empty( $cart_data ) )  $custom_items = $cart_data;	
		
		if(
			function_exists( 'is_cart' ) 
			&& is_cart() 
			&& isset( $cart_item[ 'customdesign_data' ] )
		){
			
			$cart_item_data = $customdesign->lib->get_cart_data( $cart_item['customdesign_data'] );
	
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
		
		global $customdesign, $customdesign_cart_thumbnails;
		
		$design_thumb = '';
		
		if (
			function_exists('is_cart') && 
			is_cart() && 
			isset($cart_item['customdesign_data'])
		) {
			
			$cart_item_data = $customdesign->lib->get_cart_data( $cart_item['customdesign_data'] );
			$color = $customdesign->lib->get_color($cart_item_data['attributes']);
			
			if(
				isset($cart_item_data['screenshots']) 
				&& is_array($cart_item_data['screenshots'])
			){
				$allowed_tags = wp_kses_allowed_html( 'post' );
				$uniq = uniqid();
				$customdesign_cart_thumbnails[$uniq] = array();
				$design_thumb = '<div class="customdesign-cart-thumbnails customdesign-cart-thumbnails-'.$uniq.'">';
				foreach ($cart_item_data['screenshots'] as $screenshot) {
					$design_thumb .= '<img style="background:'.$color.';padding: 0px;" class="customdesign-cart-thumbnail" src="'.$customdesign->cfg->upload_url.$screenshot.'" />';
				}
				$design_thumb .= '</div>';
			}
		}
		
		if (intval($customdesign->cfg->settings['show_only_design']) == 1 && function_exists('is_cart') && is_cart() && isset($cart_item['customdesign_data']) ) {
			$product_image = '';
		}

		return $product_image.$design_thumb;
		
	}
	
    //Add custom price to product cms
    public function woo_calculate_price($cart_object) {

		global $wpdb, $customdesign;
		
        if( !WC()->session->__isset( "reload_checkout" )) {
            $woo_ver = WC()->version;

            foreach ($cart_object->cart_contents as $key => $value) {
				if( isset($value['customdesign_data']) ){

					$cart_item_data = $customdesign->lib->get_cart_data( $value['customdesign_data'] );

					$customdesign_price = (
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
											$customdesign_price += (doubleval($arrValuePackageOption['value']) * doubleval($arrValuePackageOption['price']));
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
					// 	$customdesign_qty = isset($cart_item_data['qty']) ? intval($cart_item_data['qty']) : 1;
					// 	$customdesign_price = $price * $customdesign_qty;
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
					// 		$value['customdesign_data']['product_name'] .= $newname;
					// 	}
						
					// 	if ( version_compare( $woo_ver, '3.0', '<' ) ) {
				    //         $cart_object->cart_contents[$key]['data']->name = $value['customdesign_data']['product_name']; // Before WC 3.0
				    //     } else {	
					// 		$cart_object->cart_contents[$key]['data']->name = $value['customdesign_data']['product_name']; // Before WC 3.0
				    //         $cart_object->cart_contents[$key]['data']->set_name($value['customdesign_data']['product_name']); // WC 3.0+
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
					// 						$customdesign_price = (doubleval($arrValuePackageOption['value']) * $price);
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
					// 			// 	$customdesign_price = (doubleval($arrValueListOption['value']) * $price);
					// 			// }
					// 		}
					// 	}
					// }

					$customdesign_price = $customdesign->apply_filters('add-custom-price-limuse-data', $customdesign_price, $cart_item_data);
					
					$customdesign_qty = isset($cart_item_data['qty']) ? intval($cart_item_data['qty']) : 1;
					
					if ( version_compare( $woo_ver, '3.0', '<' ) ) {
			            $cart_object->cart_contents[$key]['data']->price = $customdesign_price/$customdesign_qty; // Before WC 3.0
			        } else {
						$cart_object->cart_contents[$key]['data']->price = $customdesign_price/$customdesign_qty; // Before WC 3.0
			            $cart_object->cart_contents[$key]['data']->set_price( $customdesign_price/$customdesign_qty ); // WC 3.0+
			        }
					
					$cart_object->cart_contents[$key]['quantity'] = $customdesign_qty;
				
				} else {
					
					$product_id = $value['product_id'];
					$product_base_id = $this->get_base_id($product_id);

					if ($product_base_id != null) {
						
						$is_product_base = $customdesign->lib->get_product($product_base_id);
						
						if ($is_product_base != null) {
							
							$cms_template = get_post_meta($product_id, 'customdesign_design_template', true );
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
										$template = $customdesign->lib->get_template($stage['id']);
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
								
								if(!isset($value['customdesign_incart'])){
									//push item to customdesign_cart
									$data = array(
										'product_id' => $product_base_id,
										'product_cms' => $product_id,
										'product_name' => $product->get_name(),
										'template' => $customdesign->lib->enjson($template_stages),
										'price' => array(
								            'total' => $total_price,
								            'attr' => 0,
								            'printing' => 0,
								            'resource' => 0,
								            'base' => $total_price
								        ),
									);
									
									$item = $customdesign->lib->cart_item_from_template($data, null);
									
									if(is_array($item)){
										$item['incart'] = true;
										$customdesign->lib->add_item_cart($item);
										$cart_object->cart_contents[$key]['customdesign_incart'] = true;
									}
									
								}
								
							}
							
						}
					}

					// variation product template
					if(isset($value['variation_id']) && intval($value['variation_id']) != 0 && isset($value['variation']) && !empty($value['variation']) && $product_base_id == null ){
						
						$product_id = intval($value['variation_id']);
						$product_base_id = 'variable:'.$product_id;
						$cms_template = get_post_meta($product_id, '_variation_customdesign', true );
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
											$template = $customdesign->lib->get_template(intval($stage['template']['id']));
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
								
								if(!isset($value['customdesign_incart'])){
									//push item to customdesign_cart
									$data = array(
										'product_id' => $product_base_id,
										'product_cms' => $value['product_id'],
										'product_name' => $product->get_name(),
										'template' => $customdesign->lib->enjson($template_stages),
										'price' => array(
								            'total' => $total_price,
								            'attr' => 0,
								            'printing' => 0,
								            'resource' => 0,
								            'base' => $total_price
								        ),
									);
									
									$item = $customdesign->lib->cart_item_from_template($data, null);
									
									if(is_array($item)){
										$item['incart'] = true;
										$customdesign->lib->add_item_cart($item);
										$cart_object->cart_contents[$key]['customdesign_incart'] = true;
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
		if( isset( $values['customdesign_data'] ) )
			$item->update_meta_data( "customdesign_data", $values['customdesign_data'] );
	}

	// Add value custom field to order before WC 3.0
    public function woo_add_order_item_meta($item_id, $values, $cart_item_key ) {
        if( isset( $values['customdesign_data'] ) )
			wc_add_order_item_meta( $item_id, "customdesign_data", $values['customdesign_data'] );
    }
    
    // save data to table order_products
    public function woo_order_finish ($order_id) {

        global $wpdb, $customdesign;

        if(is_null(WC()->cart) && !isset($cart['msg'])){
        	return;
		}

        $table_name =  $this->prefix."order_products";
        
		$count_order = $wpdb->get_var( " SELECT COUNT( * ) FROM $table_name WHERE order_id = $order_id" );

		$log = 'customdesign Trace Error ID#' . $order_id.' '.date ("Y-m-d H:i:s");

		if ($count_order > 0) {
			//$customdesign->logger->log( '[FAIL] '.$log.' - order_id exist)');
			//header('HTTP/1.1 401 '.'Error: order_id #'.$order_id.' was exist)', true, 401);
			//return;
		}
		
		$cart_data = array('items' => array());
		
		if(is_null(WC()->cart) && isset($cart['msg'])){
			$msg = customdesign_lang('Sorry, something went wrong when we processed your order. Please contact the administrator')
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
				isset($item['customdesign_data'])
			) { 
				$cart_data['items'][$item['customdesign_data']['cart_id']] = $item['customdesign_data'];
			}
		}
		
		$cart = $customdesign->lib->store_cart($order_id, $cart_data);
		
		if ($cart !== true && $cart['error'] == 1) {
			
			$customdesign->logger->log( '[FAIL] '.$log.' - '.$cart['msg']);
			
			wp_delete_post($order_id, true);
			$wpdb->delete( $table_name, array( 'order_id' => $order_id ) );
			
			$msg = customdesign_lang('Sorry, something went wrong when we processed your order. Please contact the administrator')
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
		echo "<script>localStorage.setItem('CUSTOMDESIGN-CART-DATA', '');</script>";
	}
	
    // Get product have product base
    public function woo_products_assigned() {

        global $wpdb;
        $list_product = array();
        $sql_id_product_design_base = "SELECT meta_value FROM " .  $wpdb->prefix . "postmeta WHERE " . $wpdb->prefix . "postmeta.meta_key = 'customdesign_product_base'";

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
                  WHERE ( " . $wpdb->prefix . "postmeta.meta_key = 'customdesign_product_base' AND " . $wpdb->prefix . "postmeta.meta_value IN ($arr_product_ID ))              
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

	//load core customdesign
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
		
		global $customdesign;
		
		if(
			function_exists('is_cart') 
			&& is_cart() 
			&& isset ($cart_item['customdesign_data'])
		){
				
			$is_query = explode('?', $this->tool_url);
			$cart_id = $cart_item['customdesign_data'][ 'cart_id' ];
			$cart_item_data = $customdesign->lib->get_cart_data( $cart_item['customdesign_data'] );
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
					'<div class="customdesign-edit-design-wrp">'.
						'<a id="'.$cart_id.'" class="customdesign-edit-design button" href="'.$url.'">'.
							__('Edit Design', 'customdesign').
						'</a>'.
					'</div>';
		
		} else return $product_name;
		
	}
	
	//change quantity column in cart page
	public function woo_cart_item_quantity($product_quantity, $cart_item_key = null, $cart_item = null) {
		
		global $customdesign;
		
		if( isset($cart_item['customdesign_data']) ){
			
			$cart_item_data = $customdesign->lib->get_cart_data( $cart_item['customdesign_data'] );
			
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
		
		global $customdesign;
		
		$cart_item_data = isset( $cart_item['customdesign_data'] ) ? $customdesign->lib->get_cart_data( $cart_item['customdesign_data'] ) : array();
		
		return isset($cart_item['customdesign_data']) ? ' <strong class="product-quantity">' . sprintf( '&times; %s', $cart_item_data['qty'] ) . '</strong>': $str;
		
	}
	
	//change quantity column in order page
	public function woo_order_item_quantity_html( $str, $item ){
		
		global $customdesign;
		
		$custom_field = wc_get_order_item_meta( $item->get_id(), 'customdesign_data', true );
		
		$cart_item_data = $customdesign->lib->get_cart_data( $custom_field );

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
			
			global $customdesign;
			
			$items = $customdesign->lib->get_order_products( $order_id );
			
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
		unset( $item['customdesign_data'] );
	}
		
	public function email_customer_designs( $order, $sent_to_admin = false, $plain_text = false ) {
		
		if ( ! is_a( $order, 'WC_Order' ) || $plain_text) {
			return;
		}
		
		global $customdesign, $customdesign_printings;
		
		if (!isset($customdesign_printings))
			$customdesign_printings = $customdesign->lib->get_prints();
		
		if (
			isset($customdesign->cfg->settings['email_design']) && 
			$customdesign->cfg->settings['email_design'] == 1 
		) {
			
			$order_id 	= $order->get_id();
			
			$order_status = $order->get_status();
			
			if ( 
				$order_status == 'completed' ||
				$sent_to_admin === true
			) {
				
				$items = $customdesign->lib->get_order_products($order_id);
				
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
							
							$data = $customdesign->lib->dejson($item['data']);
							
							$is_query = explode('?', $customdesign->cfg->tool_url);
								
							$url = $customdesign->cfg->tool_url.(isset($is_query[1])? '&':'?');
							$url .= 'product_base='.$item['product_base'];
							$url .= (($item['custom'] == 1)? '&design_print='.str_replace('.lumi', '', $item['design']) : '');
							$url .= '&order_print='.$order_id . '&product_cms='.$item['product_id'];
							$url = str_replace('?&', '?', $url);
							
							$url = apply_filters('customdesign_email_customer_download_link', $url, $item);
							
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
										is_array($customdesign_printings) &&
										$data->printing !== 0
									) {
										foreach ($customdesign_printings as $pmethod) {
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
									
									$customdesign->views->order_designs($data, false);
									
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
		
		global $customdesign;
		
		if( isset($customdesign->cfg->settings['email_design']) && $customdesign->cfg->settings['email_design'] == 1 ) {
			
			$order_id 	= $order->get_id();
			
			$order_status = $order->get_status();
			
			if( $order_status == 'completed' ) {
				$items = $customdesign->lib->get_order_products($order_id);

				?>
				<h2><?php echo customdesign_lang("Your Designs:");?></h2>
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
					$is_query = explode('?', $customdesign->cfg->tool_url);
						
					$url = $customdesign->cfg->tool_url.(isset($is_query[1])? '&':'?');
					$url .= 'product_base='.$order_item['product_base'];
					$url .= (($order_item['custom'] == 1)? '&design_print='.str_replace('.lumi', '', $order_item['design']) : '');
					$url .= '&order_print='.$order_id . '&product_cms='.$order_item['product_id'];
								
					$url = str_replace('?&', '?', $url);
					
					?>
					<tr class="woocommerce-table__line-item order_item">
						<td class="woocommerce-table__product-name product-name"><?php echo esc_html($order_item['product_name']);?></td>
						<td class="woocommerce-table__product-name product-link"><?php 
							echo apply_filters( 'customdesign_order_download_link', '<a href="' . $url . '" target="_blank" class="customdesign-view-design">' . customdesign_lang('View Design') . '</a>', $order_item ); 
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
		
		global $customdesign;
		
		foreach ($cart->removed_cart_contents as $key => $cart_item){
			if (isset($cart_item['customdesign_data'])){
				$customdesign->lib->remove_cart_item( $cart_item['customdesign_data']['cart_id'], $cart_item['customdesign_data'] );
			}
		}
		
	}
	
	//add template thumbnail to product image
	public function woo_add_template_thumbs() {
		
		global $product,  $wpdb, $customdesign;
		
        $product_id = $product->get_id();

        $product_have_design = $this->has_template($product_id);
		
		if( is_array($product_have_design)){
			$template = $customdesign->lib->get_template($product_have_design['meta_value']);
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
		
		global $wpdb, $customdesign;
		
		$cms_product = $wpdb->get_results("SELECT * FROM `{$wpdb->prefix}posts` WHERE `id`=".$product_id);
		$cms_template = get_post_meta($product_id, 'customdesign_design_template', true );
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
				  WHERE  pm.meta_key = 'customdesign_product_base' AND  pm.meta_value > 0
				  AND posts.post_type = 'product' AND  posts.post_status = 'publish'
			  ";
		
		$product_have_design = $wpdb->get_results( $sql_design, ARRAY_A);
		
		if(count($product_have_design)>0)
			return $product_have_design[0]['meta_value'];
		return null;
	}
	
	public function woo_product_get_price_html($price, $product) {
		
		global $wpdb, $customdesign;
		
		$cms_template = get_post_meta($product->get_id(), 'customdesign_design_template', true );
		
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
					$template = $customdesign->lib->get_template($stage['id']);
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
		
		global $customdesign;
		
		if( isset($cart_item['customdesign_data']) ){
			
			$cart_item_data = $customdesign->lib->get_cart_data( $cart_item['customdesign_data'] );
			
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
		
		if (isset($cart_item['customdesign_data'])) {
			foreach ($cart_item['customdesign_data']['attributes'] as $id => $attr) {
				if ($attr->type == 'quantity' && isset($cart_item['customdesign_data']['options']->{$id})) {
					$total = $cart_item['customdesign_data']['price']['total'];
					$qty = @json_decode($cart_item['customdesign_data']['options']->{$id}, true);
					if (json_last_error() === 0 && is_array($qty)) {
						$qty = array_sum($qty);
					} else $qty = (Int)$cart_item['customdesign_data']['options']->{$id};
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
		
		$editor_page = get_option('customdesign_editor_page', 0);

		if ( $editor_page == $post->ID ) {
			$post_states['customdesign_design_page'] = __( 'Design Editor Page', 'customdesign' );
		}
		if($post->post_type == 'product'){
			$product_id = $post->ID;
			$sql_design = "
						SELECT pm.*, pm.meta_value as base_id  FROM " . $wpdb->prefix . "posts as posts INNER JOIN " . $wpdb->prefix . "postmeta as pm  
	                  ON ( pm.post_id = " . $product_id . " AND posts.ID = " . $product_id . ") 
	                  WHERE  pm.meta_key = 'customdesign_product_base' AND  pm.meta_value > 0
	                  AND posts.post_type = 'product' AND  posts.post_status = 'publish'
	              ";
	        $product_have_design = $wpdb->get_results( $sql_design, ARRAY_A);
			if(!count($product_have_design)) return $post_states;
			$post_states['customdesign_assigned_base'] = __( 'Assigned customdesign Product', 'customdesign' ).' #'.$product_have_design[0]['base_id'];
		}
		return $post_states;
	}
	
	public  function add_variable_attributes( $loop, $variation_data, $variation ) {
		
		global $customdesign, $post;
		
	?>
	<div>
		<p class="form-field variable_description0_field form-row form-row-full" style="margin-bottom:0px;">
			<label>customdesign configuration</label>
			<textarea style="display: none;" class="short customdesign-vari-inp" style="" name="variable_customdesign[<?php echo $loop; ?>]" id="variable-customdesign-<?php echo $variation->ID; ?>" placeholder="" rows="2" cols="20"><?php 
				if (isset($variation_data['_variation_customdesign'])) {
					echo str_replace(array('<textarea', '</textarea>'), array('&lt;textarea', '&lt;/textarea&gt;'), $variation_data['_variation_customdesign'][0]); 
				}
			?></textarea> 
		</p>
		<div class="variable_customdesign_data" data-empty="<?php
					echo (
						isset($variation_data['_variation_customdesign']) && 
						!empty($variation_data['_variation_customdesign'][0])
					) ? 'false' : 'true';
			?>" data-id="<?php echo $variation->ID; ?>">
			<button class="button" data-customdesign-frame="<?php 
				echo $customdesign->cfg->ajax_url;	
			?>&action=product_variation&product_id=<?php echo $post->ID; ?>&variation_id=<?php echo $variation->ID; ?>" id="customdesign-config-<?php echo $variation->ID; ?>">
				<i class="fa fa-cog"></i> 
				<text is="nonempty"><?php echo $customdesign->lang('Open customdesign Configuration'); ?></text>
				<text is="empty"><?php echo $customdesign->lang('Setup new customdesign Designer'); ?></text>
			</button>
			<button class="button secondary button-link-delete" is="nonempty" data-customdesign-frame="clear">
				<i class="fa fa-trash"></i>  <?php echo $customdesign->lang('Clear this config'); ?>
			</button>
			<button class="button secondary" is="empty" data-customdesign-frame="list">
				<i class="fa fa-th"></i>  <?php echo $customdesign->lang('Select an exist config'); ?>
			</button>
			<button class="button secondary" is="empty" data-customdesign-frame="paste">
				<i class="fa fa-paste"></i>  <?php echo $customdesign->lang('Paste copied config'); ?>
			</button>
		</div>
	</div>	
	<?php
	}
	
	public  function save_variable_attributes( $variation_id, $i ) {
		if (
			isset( $_POST['variable_customdesign']) && 
			isset( $_POST['variable_customdesign'][ $i ] )
		) {
			$variation_id = absint($_POST['variable_post_id'][$i]);
			update_post_meta($variation_id, '_variation_customdesign', $_POST['variable_customdesign'][$i]);			
		}
	}
	
	public function plugin_action_links( $links ) {
		
		$action_links = array(
			'settings' => '<a href="' . admin_url( 'admin.php?page=customdesign' ) . '" aria-label="' . esc_attr__( 'Go to customdesign settings', 'woocommerce' ) . '">' . esc_html__( 'Settings', 'customdesign' ) . '</a>',
		);

		return array_merge( $action_links, $links );
	}
	
	public function plugin_row_meta($links, $file) {
		
		if (CUSTOMDESIGN_PLUGIN_BASENAME == $file) {
			
			$row_meta = array(
				'docs' => '<a href="' . esc_url( '#' ) . '" target=_blank aria-label="' . esc_attr__( 'View customdesign docs', 'customdesign' ) . '">' . esc_html__( 'Documentation', 'customdesign' ) . '</a>',
				'blog' => '<a href="' . esc_url( '#' ) . '" target=_blank aria-label="' . esc_attr__( 'View customdesign docs', 'customdesign' ) . '">' . esc_html__( 'customdesign Blog', 'customdesign' ) . '</a>',
				'support' => '<a href="' . esc_url( '#' ) . '" target=_blank aria-label="' . esc_attr__( 'Visit premium customer support', 'customdesign' ) . '">' . esc_html__( 'Premium support', 'customdesign' ) . '</a>'
			);

			return array_merge( $links, $row_meta );
		}

		return (array) $links;
	}
	
	public function submenu_file( $submenu_file ) {
		
		$p = isset($_GET['page']) ? $_GET['page'] : '';
		$lp = isset($_GET['customdesign-page']) ? $_GET['customdesign-page'] : '';
		
		if ($p == 'customdesign' && ($lp == 'addons' || $lp == 'explore-addons')) 
			return 'admin.php?page=customdesign&customdesign-page=explore-addons';
		
		if ($p == 'customdesign' && $lp == 'settings') 
			return 'admin.php?page=customdesign&customdesign-page=settings';
			
		if ($p == 'customdesign' && $lp == 'orders') 
			return 'admin.php?page=customdesign&customdesign-page=orders';
		
		return $submenu_file;
		
	}
	
	public function update_message($response){
		
		?><script>document.querySelectorAll("#customdesign-hook-sfm-update .update-message.notice p")[0].innerHTML = '<?php echo esc_html__('There is a new version of CustomRugs - Rugs Designer Tool'); ?>. <a href="https://www.customdesign.com/changelogs/woocommerce/?utm_source=client-site&utm_medium=text&utm_campaign=update-page&utm_term=links&utm_content=woocommerce" target=_blank" target=_blank>View version <?php echo esc_html($response['new_version']); ?> details</a> or <a href="<?php echo admin_url( 'admin.php?page=customdesign&customdesign-page=updates' ); ?>">update now</a>.';</script><?php
	}
	
	public function my_orders_actions($actions, $order) {
		
		global $customdesign, $wpdb;

		
		$is_customdesign = $wpdb->get_results('SELECT `id` FROM `customdesign_order_products` WHERE `order_id`='.$order->get_id());
        if (count($is_customdesign) !== 0) {
	    	$actions['reorder']   = array(
				'url'  => $customdesign->cfg->tool_url.'reorder='.$order->get_id(),
				'name' => __( 'Reorder', 'woocommerce' ),
			);
	    }
		
		return $actions;
		
	}
	
	public function frontstore_variation($data, $claz, $vari) {
		
		$customdesign_data = get_post_meta($data['variation_id'], '_variation_customdesign', true);
		$data['customdesign'] = isset($customdesign_data) && !empty($customdesign_data) ? $data['variation_id'] : 0;
		
		return $data;
		
	}
	
	public function customize_button() {
		
		global $product, $wpdb, $customdesign;
		
		$config = get_option('customdesign_config', array());		
		
		if(
			(isset($config['btn_page']) && !$config['btn_page']) ||
			!method_exists($product, 'get_id')
		) return;
		
		$product_id 	= $product->get_id();
	
		$product_base = get_post_meta($product_id, 'customdesign_product_base', true);
		$customdesign_customize = get_post_meta($product_id, 'customdesign_customize', true);
		$disable_cartbtn = get_post_meta($product_id, 'customdesign_disable_add_cart', true);

		if (
			(empty($product_base) && $product->is_type( 'simple' )) || 
			$customdesign_customize != 'yes' ||
			(!$product->is_type( 'variable' ) && !$product->is_type( 'simple' ))
		) {
			return;
		}
		
		if ($product->is_type( 'variable' )) {
			$product_base = 'variable';	
		}
		
		$text 			= isset($config['btn_text'])? $config['btn_text'] : __('Customize', 'customdesign');
		$link_design	= str_replace('?&', '?', $this->tool_url . '&product_base='.$product_base.'&product_cms='.$product_id);
		
		do_action( 'customdesign_before_customize_button' );

		$disable_variation = '';
		if ($product->is_type( 'variable' )) {
           
			$disable_variation = 'disabled';	
		}

		$class_customdesign = apply_filters('customdesign_button_customize', 'customdesign-customize-button button alt '.$disable_variation.' single_add_to_cart_button_fixed');
		$link_design = apply_filters( 'customdesign_customize_link', $link_design );
 
		?>
		<a name="customize" id="customdesign-customize-button" class="<?php echo $class_customdesign; ?>" href="<?php echo esc_url($link_design ); ?>" data-href="<?php echo esc_url($link_design ); ?>">
			<?php echo esc_html($text); ?>
		</a>
		<script>
			(function($) {
				<?php  if ($disable_cartbtn == 'yes') { ?>
				$('#customdesign-customize-button').closest('form').find('button.single_add_to_cart_button').remove();
				<?php } ?>
				<?php if($product->is_type( 'variable' )): ?>
					$('#customdesign-customize-button').click(function(e){
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
					
				}).on('hide_variation', function (e) {
					
				})*/.on('found_variation', function (e, vari) {
					setTimeout(() => {
						let lm = vari.customdesign,
							hrf = $('#customdesign-customize-button').attr('data-href').replace('product_base=variable', 'product_base=variable:'+lm)+'&quantity='+$(this).find('input[name="quantity"]').val();
						console.log(vari);
						$('#customdesign-customize-button').attr({
							'href': lm !== '' && lm !== 0 ? hrf : "javascript:alert('This variant has not been configured with customdesign')",
						}).removeAttr('disabled').removeClass('disabled');
						if(vari.is_in_stock == false){
							$('#customdesign-customize-button').addClass('disabled');
                            $("#customdesign-customize-button").removeAttr("href");

                        }
						// If not setup customdesign for this variation ==> disable customize button
						if (lm === '' || lm === 0) {
							$('#customdesign-customize-button').attr({'disabled': 'disabled'}).addClass('disabled');
						}
					}, 1);
				}).find('input[name="quantity"]').on('change', function() {
					if (!$('#customdesign-customize-button').hasClass('disabled')) {
						let hrf = $('#customdesign-customize-button').attr('href');
						hrf = hrf.replace(/&quantity=[\d]*/g, '&quantity='+this.value);
						$('#customdesign-customize-button').attr('href', hrf);
					}
				});
				
			})(jQuery);
		</script>
		<?php
		
		do_action( 'customdesign_after_customize_button' );

	}
	
	public function shipping_packages($package) {
		
		global $customdesign;
		
		foreach ( $package[0]['contents'] as $item_id => $values ) {
			if( isset($values['customdesign_data']) ){
				$cart_item_data = isset( $values['customdesign_data'] ) ? $customdesign->lib->get_cart_data( $values['customdesign_data'] ) : array();
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

global $customdesign_woo;

$customdesign_woo = new customdesign_woocommerce();
