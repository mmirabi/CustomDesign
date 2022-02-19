<?php
//defines

if (!defined('TS'))
	define('TS', DIRECTORY_SEPARATOR);

if (!defined('CUSTOMDESIGN_ADMIN_PATH'))
    define('CUSTOMDESIGN_ADMIN_PATH', dirname(__FILE__));

if (!defined('CUSTOMDESIGN_ADMIN'))
    define('CUSTOMDESIGN_ADMIN', true);

date_default_timezone_set('UTC');

class customdesign_router {
	
	protected $_action;
	protected $_load_assets;
	protected $_asset_uri;
	protected $_allow = false;
	protected $_is_ajax = false;
	protected $_customdesign = false;
	protected $_cfg = false;
	protected $_admin_path;
	
	public $menus;
	public $check_update;
	
	public function __construct($customdesign_page = '', $load_assets = true) {

        global $customdesign;
        $this->_customdesign = $customdesign;
        $this->_admin_path = $customdesign->cfg->root_path.'admin'.DS;
		
		$this->check_update = @json_decode($customdesign->get_option('last_check_update'));
		$this->menus =  $customdesign->apply_filters('admin_menus', array(
			'dashboard' => array(
				'title' => $customdesign->lang('Dashboard'),
				'icon'  => '<i class="fa fa-home"></i>',
				'link'   => $customdesign->cfg->admin_url.'customdesign-page=dashboard',
				'child'	=> array(
					'dashboard' => array(
						'title' => $customdesign->lang('Home'),
						'link'   => $customdesign->cfg->admin_url.'customdesign-page=dashboard',
					),
					'updates' => array(
						'title' => $customdesign->lang('Updates').(!empty($this->check_update) && isset($this->check_update->version) && version_compare(CUSTOMDESIGN, $this->check_update->version, '<') ? ' <span class="update-notice">1</span>' : ''),
						'link'   => $customdesign->cfg->admin_url.'customdesign-page=updates',
					),
					'license' => array(
						'title' => $customdesign->lang('License'),
						'link'   => $customdesign->cfg->admin_url.'customdesign-page=license',
					),
					'system' => array(
						'title' => $customdesign->lang('Status'),
						'link'   => $customdesign->cfg->admin_url.'customdesign-page=system',
					)
				),
				'capability' => 'customdesign_read_dashboard'
			),
			'products' => array(
				'title' => $customdesign->lang('Products Base'),
				'icon'  => '<i class="fa fa-cube"></i>',
				'child' => array(
					'products'   => array(
						'type'   => '',
						'title'  => $customdesign->lang('All Products Base'),
						'link'   => $customdesign->cfg->admin_url.'customdesign-page=products',
						'hidden' => false,
					),
					'product' => array(
						'type'   => '',
						'title'  => $customdesign->lang('Add New Product Base'),
						'link'   => $customdesign->cfg->admin_url.'customdesign-page=product',
						'hidden' => false,
					),
					'categories' => array(
						'type'   => 'products',
						'title'  => $customdesign->lang('Product Categories'),
						'link'   => $customdesign->cfg->admin_url.'customdesign-page=categories&type=products',
						'hidden' => false,
					),
					'category' => array(
						'type'   => 'products',
						'title'  => $customdesign->lang('Add New Category'),
						'link'   => $customdesign->cfg->admin_url.'customdesign-page=category&type=products',
						'hidden' => true,
					),
				),
				'capability' => 'customdesign_read_products'
			),
			'templates' => array(
				'title' => $customdesign->lang('Design Templates'),
				'icon'  => '<i class="fa fa-paper-plane-o"></i>',
				'child' => array(
					'templates'   => array(
						'type'   => '',
						'title'  => $customdesign->lang('All Templates'),
						'link'   => $customdesign->cfg->admin_url.'customdesign-page=templates',
						'hidden' => false,
					),
					'template' => array(
						'type'   => '',
						'title'  => $customdesign->lang('Add New Template'),
						'link'   => $customdesign->cfg->admin_url.'customdesign-page=template',
						'hidden' => false,
					),
					'categories' => array(
						'type'   => 'templates',
						'title'  => $customdesign->lang('Categories'),
						'link'   => $customdesign->cfg->admin_url.'customdesign-page=categories&type=templates',
						'hidden' => false,
					),
					'category' => array(
						'type'   => 'templates',
						'title'  => $customdesign->lang('Add New Category'),
						'link'   => $customdesign->cfg->admin_url.'customdesign-page=category&type=templates',
						'hidden' => true,
					),
					'tags' => array(
						'type'   => 'templates',
						'title'  => $customdesign->lang('Tags'),
						'link'   => $customdesign->cfg->admin_url.'customdesign-page=tags&type=templates',
						'hidden' => false,
					),
					'tag' => array(
						'type'   => 'templates',
						'title'  => $customdesign->lang('Add New Tag'),
						'link'   => $customdesign->cfg->admin_url.'customdesign-page=tag&type=templates',
						'hidden' => true,
					),
				),
				'capability' => 'customdesign_read_templates'
			),
			'cliparts' => array(
				'title' => $customdesign->lang('Cliparts'),
				'icon'  => '<i class="fa fa-file-image-o"></i>',
				'child' => array(
					'cliparts'   => array(
						'type'   => '',
						'title'  => $customdesign->lang('All Cliparts'),
						'link'   => $customdesign->cfg->admin_url.'customdesign-page=cliparts',
						'hidden' => false,
					),
					'clipart' => array(
						'type'   => '',
						'title'  => $customdesign->lang('Add New Clipart'),
						'link'   => $customdesign->cfg->admin_url.'customdesign-page=clipart',
						'hidden' => false,
					),
					'categories' => array(
						'type'   => 'cliparts',
						'title'  => $customdesign->lang('Categories'),
						'link'   => $customdesign->cfg->admin_url.'customdesign-page=categories&type=cliparts',
						'hidden' => false,
					),
					'category' => array(
						'type'   => 'cliparts',
						'title'  => $customdesign->lang('Add New Category'),
						'link'   => $customdesign->cfg->admin_url.'customdesign-page=category&type=cliparts',
						'hidden' => true,
					),
					'tags' => array(
						'type'   => 'cliparts',
						'title'  => $customdesign->lang('Tags'),
						'link'   => $customdesign->cfg->admin_url.'customdesign-page=tags&type=cliparts',
						'hidden' => false,
					),
					'tag' => array(
						'type'   => 'cliparts',
						'title'  => $customdesign->lang('Add New Tag'),
						'link'   => $customdesign->cfg->admin_url.'customdesign-page=tag&type=cliparts',
						'hidden' => true,
					),
				),
				'capability' => 'customdesign_read_cliparts'
			),
			'shapes' => array(
				'title' => $customdesign->lang('Shapes'),
				'icon'  => '<i class="fa fa-cube"></i>',
				'child' => array(
					'shapes'   => array(
						'type'   => '',
						'title'  => $customdesign->lang('All shapes'),
						'link'   => $customdesign->cfg->admin_url.'customdesign-page=shapes',
						'hidden' => false,
					),
					'shape' => array(
						'type'   => '',
						'title'  => $customdesign->lang('Add New Shape'),
						'link'   => $customdesign->cfg->admin_url.'customdesign-page=shape',
						'hidden' => false,
					),
				),
				'capability' => 'customdesign_read_shapes'
			),
			'printings' => array(
				'title' => $customdesign->lang('Printing Type'),
				'icon'  => '<i class="fa fa-print"></i>',
				'child' => array(
					'printings'   => array(
						'type'   => '',
						'title'  => $customdesign->lang('All Printing Type'),
						'link'   => $customdesign->cfg->admin_url.'customdesign-page=printings',
						'hidden' => false,
					),
					'printing' => array(
						'type'   => '',
						'title'  => $customdesign->lang('Add New Printing'),
						'link'   => $customdesign->cfg->admin_url.'customdesign-page=printing',
						'hidden' => false,
					),
				),
				'capability' => 'customdesign_read_printings'
			),
			'fonts' => array(
				'title' => $customdesign->lang('Fonts'),
				'icon'  => '<i class="fa fa-font"></i>',
				'child' => array(
					'fonts'   => array(
						'type'   => '',
						'title'  => $customdesign->lang('All Fonts'),
						'link'   => $customdesign->cfg->admin_url.'customdesign-page=fonts',
						'hidden' => false,
					),
					'font' => array(
						'type'   => '',
						'title'  => $customdesign->lang('Add New Font'),
						'link'   => $customdesign->cfg->admin_url.'customdesign-page=font',
						'hidden' => false,
					),
				),
				'capability' => 'customdesign_read_fonts'
			),
			'languages' => array(
				'title' => $customdesign->lang('Languages'),
				'icon'  => '<i class="fa fa-language"></i>',
				'child' => array(
					'languages'   => array(
						'type'   => '',
						'title'  => $customdesign->lang('Languages'),
						'link'   => $customdesign->cfg->admin_url.'customdesign-page=languages',
						'hidden' => false,
					),
					'language' => array(
						'type'   => '',
						'title'  => $customdesign->lang('Add Translate Text'),
						'link'   => $customdesign->cfg->admin_url.'customdesign-page=language',
						'hidden' => false,
					),
				),
				'capability' => 'customdesign_read_languages'
			),
			'orders' => array(
				'title' => $customdesign->lang('Orders'),
				'icon'  => '<i class="fa fa-shopping-bag"></i>',
				'link'   => $customdesign->cfg->admin_url.'customdesign-page=orders',
				'child' => array(
					'orders'   => array(
						'type'   => '',
						'title'  => $customdesign->lang('All Orders'),
						'link'   => $customdesign->cfg->admin_url.'customdesign-page=orders',
						'hidden' => false,
					),
					'order'   => array(
						'type'   => '',
						'title'  => $customdesign->lang('Order'),
						'link'   => $customdesign->cfg->admin_url.'customdesign-page=order',
						'hidden' => true,
					)
				),
				'capability' => 'customdesign_read_orders'
			),
			'shares' => array(
				'title' => $customdesign->lang('Shares'),
				'icon'  => '<i class="fa fa-share-alt"></i>',
				'link'   => $customdesign->cfg->admin_url.'customdesign-page=shares',
				'capability' => 'customdesign_read_shares'
			),
			'bugs' => array(
				'title' => $customdesign->lang('Bugs'),
				'icon'  => '<i class="fa fa-bug"></i>',
				'child' => array(
					'bugs'   => array(
						'type'   => '',
						'title'  => $customdesign->lang('All Bugs'),
						'link'   => $customdesign->cfg->admin_url.'customdesign-page=bugs',
						'hidden' => false,
					),
					'bug' => array(
						'type'   => '',
						'title'  => $customdesign->lang('Add New Bug'),
						'link'   => $customdesign->cfg->admin_url.'customdesign-page=bug',
						'hidden' => false,
					),
				),
				'capability' => 'customdesign_read_bugs'
			),
			'addons' => array(
				'title' => $customdesign->lang('Addons'),
				'icon'  => '<i class="fa fa-plug"></i>',
				'link'   => $customdesign->cfg->admin_url.'customdesign-page=addons',
				'child' => array(
					'explore-addons' => array(
						'type'   => '',
						'title'  => $customdesign->lang('Explore'),
						'link'   => $customdesign->cfg->admin_url.'customdesign-page=explore-addons',
					),
					'addons' => array(
						'type'   => '',
						'title'  => $customdesign->lang('Installed'),
						'link'   => $customdesign->cfg->admin_url.'customdesign-page=addons',
					),
					'addon' => array(
						'type'   => '',
						'title'  => $customdesign->lang('Detail'),
						'link'   => $customdesign->cfg->admin_url.'customdesign-page=addon',
						'hidden' => true,
					),
				),
				'capability' => 'customdesign_read_addons',
			),
			'settings' => array(
				'title' => $customdesign->lang('Settings'),
				'icon'  => '<i class="fa fa-cog"></i>',
				'link'   => $customdesign->cfg->admin_url.'customdesign-page=settings',
				'capability' => 'customdesign_read_settings'
			),
		));
		
		$this->_load_assets = $load_assets;

		if (empty($customdesign_page) && isset($_REQUEST['customdesign-page']))
			$this->_customdesign_page = $_REQUEST['customdesign-page'];
		else
			$this->_customdesign_page = 'dashboard';
		
		foreach ($this->menus as $key => $menu) {
			
			if ($key == $this->_customdesign_page)
				$this->_allow = true;
			if (isset($menu['child']) && is_array($menu['child'])) {
				foreach ($menu['child'] as $k => $ch) {
					if ($k == $this->_customdesign_page)
						$this->_allow = true;
				}
			}
		}
			
        if ((isset($_REQUEST['customdesign_ajax']) && $_REQUEST['customdesign_ajax'] == 1) || $_SERVER['REQUEST_METHOD'] =='POST')
            $this->_is_ajax = true;
		
		$this->check_caps();
		
	}
	
	public function check_caps () {
		
		global $customdesign;
		$page = isset($_GET['customdesign-page']) ? $_GET['customdesign-page'] : '';
		
		$cap = (
			isset($this->menus[$page]) && 
			isset($this->menus[$page]['capability'])
		) ? $this->menus[$page]['capability'].'-s' : '';
		
		if ($cap == '') {
			foreach ($this->menus as $key => $val) {
				if (
					isset($this->menus[$key]['capability']) &&
					isset($val['child']) && 
					isset($val['child'][$page])
				)$cap = $this->menus[$key]['capability'].'-s';
			}
		}
				
		$cap = str_replace(array('s-s', '-s'), array('', ''), $cap);
		$cap2 = str_replace('_read_', '_edit_', $cap);
		$cap3 = str_replace('_read_', '_edit_', $cap.'s');
		
		if (
			!$customdesign->caps($cap) && 
			!$customdesign->caps($cap.'s') && 
			!$customdesign->caps($cap2) && 
			!$customdesign->caps($cap3)
		) $this->_allow = false;
			
	}
	
	public function update_notice() {
		
		global $customdesign;
		
		$lpage = isset($_GET['customdesign-page']) ? $_GET['customdesign-page'] : '';

		if($customdesign->connector->platform == 'php'){
			$key = $customdesign->get_option('purchase_key');
			$key_valid = ($key === null || empty($key) || strlen($key) != 36 || count(explode('-', $key)) != 5) ? false : true;

			if(!$key_valid){
				?>
				<div class="customdesign_container">
					<div class="customdesign-col customdesign-col-12">
						<div class="customdesign-update-notice top warning">
							<?php echo $customdesign->lang('You must verify your purchase code MagicRugs Product Designer to access to all features'); ?>.
							<a href="<?php echo $customdesign->cfg->admin_url; ?>customdesign-page=license"><?php echo $customdesign->lang('Enter your license now'); ?> &rarr;</a>
						</div>
					</div>
				</div>
				<?php
			}
			$addon_list = $customdesign->addons->addon_installed_list();
			$actives = $customdesign->get_option('active_addons');
			if ($actives !== null && !empty($actives))
				$actives = (Array)@json_decode($actives);
			if( isset($addon_list) && !empty($addon_list) && count($addon_list) > 0 
				&& (
					(isset($addon_list['assign']) && isset($actives['assign']))
					|| (isset($addon_list['display_template_clipart']) && isset($actives['display_template_clipart']))
					|| (isset($addon_list['dropbox_sync']) && isset($actives['dropbox_sync']))
					|| (isset($addon_list['distress']) && isset($actives['distress']))
					|| (isset($addon_list['images']) && isset($actives['images']))
				)
			){
				$key_addon_bundle = $customdesign->get_option('purchase_key_addon_bundle');
				$key_valid_addon_bundle = ($key_addon_bundle === null || empty($key_addon_bundle) || strlen($key_addon_bundle) != 36 || count(explode('-', $key_addon_bundle)) != 5) ? false : true;

				if (!$key_valid_addon_bundle) {
					?>
					<div class="customdesign_container">
						<div class="customdesign-col customdesign-col-12">
							<div class="customdesign-update-notice top warning">
								<?php echo $customdesign->lang('You must verify your purchase code for addon bundle to access to all features'); ?>.
								<a href="<?php echo $customdesign->cfg->admin_url; ?>customdesign-page=license#customdesign-tab-addon-bundle"><?php echo $customdesign->lang('Enter your license now'); ?></a>
							</div>
						</div>
					</div>
					<?php	
				}	
			}
		}

		if(
			$lpage != 'updates' && 
			$lpage != 'license' && 
			!empty($this->check_update) && 
			isset($this->check_update->version) && 
			version_compare(CUSTOMDESIGN, $this->check_update->version, '<')
		) {
		
		?>	
		<div class="customdesign_container">
			<div class="customdesign-col customdesign-col-12">
				<div class="customdesign-update-notice top">
					<a href="https://www.magicrugs.com/<?php echo $customdesign->connector->platform; ?>?utm_source=client-site&utm_medium=text&utm_campaign=update-page&utm_term=links&utm_content=<?php echo $customdesign->connector->platform; ?>" target=_blank>MagicRugs <?php echo $this->check_update->version; ?></a> 
					<?php echo $customdesign->lang('is available'); ?>! 
					<a href="<?php echo $customdesign->cfg->admin_url; ?>customdesign-page=updates"><?php echo $customdesign->lang('Please update now'); ?></a>.
				</div>
			</div>
		</div>
		<?php 
			
		}
			
	}
	
	public function display() {

		global $customdesign_router, $customdesign, $customdesign_helper, $customdesign_admin;
		
		$customdesign->do_action('admin-verify');
		
		require_once($this->_admin_path.'admin.php');
		
        if(!isset($_POST['do']) && !isset($_POST['action_submit'])) {
            include($this->_admin_path . 'partials' .DS. 'header.php');
		}
		
		$page = $customdesign->apply_filters('admin_page', $this->_admin_path . 'pages' .DS. $this->_customdesign_page . '.php', $this->_customdesign_page);
		
		if ($this->_allow && is_file($page)) {
			$this->update_notice();
			include($page);
		} else {
			echo '<div class="customdesign_container">';
			echo '<div class="customdesign-col customdesign-col-12">';
			echo '<div class="customdesign-update-notice top">';
			if (!$this->_allow && is_file($page))
				echo $customdesign->lang('Sorry, you are not allowed to access this page.');
			else echo $customdesign->lang('File not found').': <i>'.$page.'</i>';
			echo '</div>';
			echo '</div>';
			echo '</div>';
		}
		
        if(!isset($_POST['do'])) {
             include($this->_admin_path . 'partials' .DS. 'footer.php');
		}
	}

}

/*===================================*/

global $customdesign_router;
$customdesign_router = new customdesign_router();
$customdesign_router->display();
