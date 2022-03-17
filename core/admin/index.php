<?php
//defines

if (!defined('TS'))
	define('TS', DIRECTORY_SEPARATOR);

if (!defined('MAGIC_ADMIN_PATH'))
    define('MAGIC_ADMIN_PATH', dirname(__FILE__));

if (!defined('MAGIC_ADMIN'))
    define('MAGIC_ADMIN', true);

date_default_timezone_set('UTC');

class magic_router {
	
	protected $_action;
	protected $_load_assets;
	protected $_asset_uri;
	protected $_allow = false;
	protected $_is_ajax = false;
	protected $_magic = false;
	protected $_cfg = false;
	protected $_admin_path;
	
	public $menus;
	public $check_update;
	
	public function __construct($magic_page = '', $load_assets = true) {

        global $magic;
        $this->_magic = $magic;
        $this->_admin_path = $magic->cfg->root_path.'admin'.DS;
		
		$this->check_update = @json_decode($magic->get_option('last_check_update'));
		$this->menus =  $magic->apply_filters('admin_menus', array(
			'dashboard' => array(
				'title' => $magic->lang('Dashboard'),
				'icon'  => '<i class="fa fa-home"></i>',
				'link'   => $magic->cfg->admin_url.'magic-page=dashboard',
				'child'	=> array(
					'dashboard' => array(
						'title' => $magic->lang('Home'),
						'link'   => $magic->cfg->admin_url.'magic-page=dashboard',
					),
					// 'updates' => array(
					// 	'title' => $magic->lang('Updates').(!empty($this->check_update) && isset($this->check_update->version) && version_compare(MAGIC, $this->check_update->version, '<') ? ' <span class="update-notice">1</span>' : ''),
					// 	'link'   => $magic->cfg->admin_url.'magic-page=updates',
					// ),
					// 'license' => array(
					// 	'title' => $magic->lang('License'),
					// 	'link'   => $magic->cfg->admin_url.'magic-page=license',
					// ),
					'system' => array(
						'title' => $magic->lang('Status'),
						'link'   => $magic->cfg->admin_url.'magic-page=system',
					)
				),
				'capability' => 'magic_read_dashboard'
			),
			'products' => array(
				'title' => $magic->lang('Products Base'),
				'icon'  => '<i class="fa fa-cube"></i>',
				'child' => array(
					'products'   => array(
						'type'   => '',
						'title'  => $magic->lang('All Products Base'),
						'link'   => $magic->cfg->admin_url.'magic-page=products',
						'hidden' => false,
					),
					'product' => array(
						'type'   => '',
						'title'  => $magic->lang('Add New Product Base'),
						'link'   => $magic->cfg->admin_url.'magic-page=product',
						'hidden' => false,
					),
					'categories' => array(
						'type'   => 'products',
						'title'  => $magic->lang('Product Categories'),
						'link'   => $magic->cfg->admin_url.'magic-page=categories&type=products',
						'hidden' => false,
					),
					'category' => array(
						'type'   => 'products',
						'title'  => $magic->lang('Add New Category'),
						'link'   => $magic->cfg->admin_url.'magic-page=category&type=products',
						'hidden' => true,
					),
				),
				'capability' => 'magic_read_products'
			),
			'templates' => array(
				'title' => $magic->lang('Design Templates'),
				'icon'  => '<i class="fa fa-paper-plane-o"></i>',
				'child' => array(
					'templates'   => array(
						'type'   => '',
						'title'  => $magic->lang('All Templates'),
						'link'   => $magic->cfg->admin_url.'magic-page=templates',
						'hidden' => false,
					),
					'template' => array(
						'type'   => '',
						'title'  => $magic->lang('Add New Template'),
						'link'   => $magic->cfg->admin_url.'magic-page=template',
						'hidden' => false,
					),
					'categories' => array(
						'type'   => 'templates',
						'title'  => $magic->lang('Categories'),
						'link'   => $magic->cfg->admin_url.'magic-page=categories&type=templates',
						'hidden' => false,
					),
					'category' => array(
						'type'   => 'templates',
						'title'  => $magic->lang('Add New Category'),
						'link'   => $magic->cfg->admin_url.'magic-page=category&type=templates',
						'hidden' => true,
					),
					'tags' => array(
						'type'   => 'templates',
						'title'  => $magic->lang('Tags'),
						'link'   => $magic->cfg->admin_url.'magic-page=tags&type=templates',
						'hidden' => false,
					),
					'tag' => array(
						'type'   => 'templates',
						'title'  => $magic->lang('Add New Tag'),
						'link'   => $magic->cfg->admin_url.'magic-page=tag&type=templates',
						'hidden' => true,
					),
				),
				'capability' => 'magic_read_templates'
			),
			'cliparts' => array(
				'title' => $magic->lang('Cliparts'),
				'icon'  => '<i class="fa fa-file-image-o"></i>',
				'child' => array(
					'cliparts'   => array(
						'type'   => '',
						'title'  => $magic->lang('All Cliparts'),
						'link'   => $magic->cfg->admin_url.'magic-page=cliparts',
						'hidden' => false,
					),
					'clipart' => array(
						'type'   => '',
						'title'  => $magic->lang('Add New Clipart'),
						'link'   => $magic->cfg->admin_url.'magic-page=clipart',
						'hidden' => false,
					),
					'categories' => array(
						'type'   => 'cliparts',
						'title'  => $magic->lang('Categories'),
						'link'   => $magic->cfg->admin_url.'magic-page=categories&type=cliparts',
						'hidden' => false,
					),
					'category' => array(
						'type'   => 'cliparts',
						'title'  => $magic->lang('Add New Category'),
						'link'   => $magic->cfg->admin_url.'magic-page=category&type=cliparts',
						'hidden' => true,
					),
					'tags' => array(
						'type'   => 'cliparts',
						'title'  => $magic->lang('Tags'),
						'link'   => $magic->cfg->admin_url.'magic-page=tags&type=cliparts',
						'hidden' => false,
					),
					'tag' => array(
						'type'   => 'cliparts',
						'title'  => $magic->lang('Add New Tag'),
						'link'   => $magic->cfg->admin_url.'magic-page=tag&type=cliparts',
						'hidden' => true,
					),
				),
				'capability' => 'magic_read_cliparts'
			),
			'shapes' => array(
				'title' => $magic->lang('Shapes'),
				'icon'  => '<i class="fa fa-cube"></i>',
				'child' => array(
					'shapes'   => array(
						'type'   => '',
						'title'  => $magic->lang('All shapes'),
						'link'   => $magic->cfg->admin_url.'magic-page=shapes',
						'hidden' => false,
					),
					'shape' => array(
						'type'   => '',
						'title'  => $magic->lang('Add New Shape'),
						'link'   => $magic->cfg->admin_url.'magic-page=shape',
						'hidden' => false,
					),
				),
				'capability' => 'magic_read_shapes'
			),
			'printings' => array(
				'title' => $magic->lang('Printing Type'),
				'icon'  => '<i class="fa fa-print"></i>',
				'child' => array(
					'printings'   => array(
						'type'   => '',
						'title'  => $magic->lang('All Printing Type'),
						'link'   => $magic->cfg->admin_url.'magic-page=printings',
						'hidden' => false,
					),
					'printing' => array(
						'type'   => '',
						'title'  => $magic->lang('Add New Printing'),
						'link'   => $magic->cfg->admin_url.'magic-page=printing',
						'hidden' => false,
					),
				),
				'capability' => 'magic_read_printings'
			),
			'fonts' => array(
				'title' => $magic->lang('Fonts'),
				'icon'  => '<i class="fa fa-font"></i>',
				'child' => array(
					'fonts'   => array(
						'type'   => '',
						'title'  => $magic->lang('All Fonts'),
						'link'   => $magic->cfg->admin_url.'magic-page=fonts',
						'hidden' => false,
					),
					'font' => array(
						'type'   => '',
						'title'  => $magic->lang('Add New Font'),
						'link'   => $magic->cfg->admin_url.'magic-page=font',
						'hidden' => false,
					),
				),
				'capability' => 'magic_read_fonts'
			),
			'languages' => array(
				'title' => $magic->lang('Languages'),
				'icon'  => '<i class="fa fa-language"></i>',
				'child' => array(
					'languages'   => array(
						'type'   => '',
						'title'  => $magic->lang('Languages'),
						'link'   => $magic->cfg->admin_url.'magic-page=languages',
						'hidden' => false,
					),
					'language' => array(
						'type'   => '',
						'title'  => $magic->lang('Add Translate Text'),
						'link'   => $magic->cfg->admin_url.'magic-page=language',
						'hidden' => false,
					),
				),
				'capability' => 'magic_read_languages'
			),
			'orders' => array(
				'title' => $magic->lang('Orders'),
				'icon'  => '<i class="fa fa-shopping-bag"></i>',
				'link'   => $magic->cfg->admin_url.'magic-page=orders',
				'child' => array(
					'orders'   => array(
						'type'   => '',
						'title'  => $magic->lang('All Orders'),
						'link'   => $magic->cfg->admin_url.'magic-page=orders',
						'hidden' => false,
					),
					'order'   => array(
						'type'   => '',
						'title'  => $magic->lang('Order'),
						'link'   => $magic->cfg->admin_url.'magic-page=order',
						'hidden' => true,
					)
				),
				'capability' => 'magic_read_orders'
			),
			'shares' => array(
				'title' => $magic->lang('Shares'),
				'icon'  => '<i class="fa fa-share-alt"></i>',
				'link'   => $magic->cfg->admin_url.'magic-page=shares',
				'capability' => 'magic_read_shares'
			),
			'bugs' => array(
				'title' => $magic->lang('Bugs'),
				'icon'  => '<i class="fa fa-bug"></i>',
				'child' => array(
					'bugs'   => array(
						'type'   => '',
						'title'  => $magic->lang('All Bugs'),
						'link'   => $magic->cfg->admin_url.'magic-page=bugs',
						'hidden' => false,
					),
					'bug' => array(
						'type'   => '',
						'title'  => $magic->lang('Add New Bug'),
						'link'   => $magic->cfg->admin_url.'magic-page=bug',
						'hidden' => false,
					),
				),
				'capability' => 'magic_read_bugs'
			),
			// 'addons' => array(
			// 	'title' => $magic->lang('Addons'),
			// 	'icon'  => '<i class="fa fa-plug"></i>',
			// 	'link'   => $magic->cfg->admin_url.'magic-page=addons',
			// 	'child' => array(
			// 		'explore-addons' => array(
			// 			'type'   => '',
			// 			'title'  => $magic->lang('Explore'),
			// 			'link'   => $magic->cfg->admin_url.'magic-page=explore-addons',
			// 		),
			// 		'addons' => array(
			// 			'type'   => '',
			// 			'title'  => $magic->lang('Installed'),
			// 			'link'   => $magic->cfg->admin_url.'magic-page=addons',
			// 		),
			// 		'addon' => array(
			// 			'type'   => '',
			// 			'title'  => $magic->lang('Detail'),
			// 			'link'   => $magic->cfg->admin_url.'magic-page=addon',
			// 			'hidden' => true,
			// 		),
			// 	),
			// 	'capability' => 'magic_read_addons',
			// ),
			'settings' => array(
				'title' => $magic->lang('Settings'),
				'icon'  => '<i class="fa fa-cog"></i>',
				'link'   => $magic->cfg->admin_url.'magic-page=settings',
				'capability' => 'magic_read_settings'
			),
		));
		
		$this->_load_assets = $load_assets;

		if (empty($magic_page) && isset($_REQUEST['magic-page']))
			$this->_magic_page = $_REQUEST['magic-page'];
		else
			$this->_magic_page = 'dashboard';
		
		foreach ($this->menus as $key => $menu) {
			
			if ($key == $this->_magic_page)
				$this->_allow = true;
			if (isset($menu['child']) && is_array($menu['child'])) {
				foreach ($menu['child'] as $k => $ch) {
					if ($k == $this->_magic_page)
						$this->_allow = true;
				}
			}
		}
			
        if ((isset($_REQUEST['magic_ajax']) && $_REQUEST['magic_ajax'] == 1) || $_SERVER['REQUEST_METHOD'] =='POST')
            $this->_is_ajax = true;
		
		$this->check_caps();
		
	}
	
	public function check_caps () {
		
		global $magic;
		$page = isset($_GET['magic-page']) ? $_GET['magic-page'] : '';
		
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
			!$magic->caps($cap) && 
			!$magic->caps($cap.'s') && 
			!$magic->caps($cap2) && 
			!$magic->caps($cap3)
		) $this->_allow = false;
			
	}
	
	public function update_notice() {
		
		global $magic;
		
		$lpage = isset($_GET['magic-page']) ? $_GET['magic-page'] : '';

		if($magic->connector->platform == 'php'){
			$key = $magic->get_option('purchase_key');
			$key_valid = ($key === null || empty($key) || strlen($key) != 36 || count(explode('-', $key)) != 5) ? false : true;

			if(!$key_valid){
				?>
				<div class="magic_container">
					<div class="magic-col magic-col-12">
						<div class="magic-update-notice top warning">
							<?php echo $magic->lang('You must verify your purchase code MagicRugs Product Designer to access to all features'); ?>.
							<a href="<?php echo $magic->cfg->admin_url; ?>magic-page=license"><?php echo $magic->lang('Enter your license now'); ?> &rarr;</a>
						</div>
					</div>
				</div>
				<?php
			}
			$addon_list = $magic->addons->addon_installed_list();
			$actives = $magic->get_option('active_addons');
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
				$key_addon_bundle = $magic->get_option('purchase_key_addon_bundle');
				$key_valid_addon_bundle = ($key_addon_bundle === null || empty($key_addon_bundle) || strlen($key_addon_bundle) != 36 || count(explode('-', $key_addon_bundle)) != 5) ? false : true;

				if (!$key_valid_addon_bundle) {
					?>
					<div class="magic_container">
						<div class="magic-col magic-col-12">
							<div class="magic-update-notice top warning">
								<?php echo $magic->lang('You must verify your purchase code for addon bundle to access to all features'); ?>.
								<a href="<?php echo $magic->cfg->admin_url; ?>magic-page=license#magic-tab-addon-bundle"><?php echo $magic->lang('Enter your license now'); ?></a>
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
			version_compare(MAGIC, $this->check_update->version, '<')
		) {
		
		?>	
		<div class="magic_container">
			<div class="magic-col magic-col-12">
				<div class="magic-update-notice top">
					<a href="https://www.magicrugs.com/<?php echo $magic->connector->platform; ?>?utm_source=client-site&utm_medium=text&utm_campaign=update-page&utm_term=links&utm_content=<?php echo $magic->connector->platform; ?>" target=_blank>MagicRugs <?php echo $this->check_update->version; ?></a> 
					<?php echo $magic->lang('is available'); ?>! 
					<a href="<?php echo $magic->cfg->admin_url; ?>magic-page=updates"><?php echo $magic->lang('Please update now'); ?></a>.
				</div>
			</div>
		</div>
		<?php 
			
		}
			
	}
	
	public function display() {

		global $magic_router, $magic, $magic_helper, $magic_admin;
		
		$magic->do_action('admin-verify');
		
		require_once($this->_admin_path.'admin.php');
		
        if(!isset($_POST['do']) && !isset($_POST['action_submit'])) {
            include($this->_admin_path . 'partials' .DS. 'header.php');
		}
		
		$page = $magic->apply_filters('admin_page', $this->_admin_path . 'pages' .DS. $this->_magic_page . '.php', $this->_magic_page);
		
		if ($this->_allow && is_file($page)) {
			$this->update_notice();
			include($page);
		} else {
			echo '<div class="magic_container">';
			echo '<div class="magic-col magic-col-12">';
			echo '<div class="magic-update-notice top">';
			if (!$this->_allow && is_file($page))
				echo $magic->lang('Sorry, you are not allowed to access this page.');
			else echo $magic->lang('File not found').': <i>'.$page.'</i>';
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

global $magic_router;
$magic_router = new magic_router();
$magic_router->display();
