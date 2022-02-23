<?php
/**
*
*	(p) package: Custom Design
*	(c) author:	Mehdi Mirabi
*	(i) website: https://www.magicrugs.com
*
*/

require_once( CUSTOMDESIGN_CORE_PATH . DS. 'tmpl.php' );

class customdesign_cfg extends customdesign_tmpl_register{

	public $root_path;
	public $upload_path;
	public $editor_url;
	public $checkout_url;
	public $upload_url;
	public $database;
	public $url;
	public $tool_url;
	public $color;
	public $logo = '4db6ac';
	public $site_uri;
	public $ajax_url;
	public $assets_url;
	public $security_name = 'form_key';
	public $security_code;
	public $admin_url;
	public $admin_assets_url;
	public $admin_ajax_url;
	public $load_jquery;
	public $js_lang;
	public $default_fonts;
	public $base_default;
	public $size_default;
	public $active_language;
	public $active_language_frontend;
	public $active_language_backend;
	public $product;
	public $print_types;
	public $api_url;
	public $scheme;
	public $lang_storage = array();
	public $lang_storage_frontend = array();
	public $lang_storage_backend = array();
    public $settings = array(
	
		'admin_email' => '',
		
		'title' => 'Rug Custom',
		'logo' => '',
		'favicon' => '',
		'logo_link' => 'https://rugcustom.com',
		'primary_color' => '',
		'conditions' => '',
		
		'enable_colors' => '1',
		'colors' => '#3fc7ba:#546e7a,#757575,#6d4c41,#f4511e,#ffb300,#fdd835,#c0cA33,#a0ce4e,#7cb342,#43a047,#00acc1,#3fc7ba,#039be5,#3949ab,#5e35b1,#d81b60,#eeeeee,#3a3a3a',
		'rtl' => '',
		'user_print' => '',
		'user_download' => '1',
		
		'currency' => '$',
		'currency_code' => 'USD',
		'thousand_separator' => ',',
		'decimal_separator' => '.',
		'number_decimals' => 2,
		'currency_position' => 0,
		'show_only_design' => 0,
		'merchant_id' => '',
		'sanbox_mode' => 0,
		
		'google_fonts' => '{"Roboto":["greek%2Clatin%2Ccyrillic-ext%2Ccyrillic%2Cvietnamese%2Cgreek-ext%2Clatin-ext","100%2C100italic%2C300%2C300italic%2Cregular%2Citalic%2C500%2C500italic%2C700%2C700italic%2C900%2C900italic"],"Poppins":["devanagari%2Clatin%2Clatin-ext","300%2Cregular%2C500%2C600%2C700"],"Oxygen":["latin%2Clatin-ext","300%2Cregular%2C700"],"Anton":["latin%2Clatin-ext%2Cvietnamese","regular"],"Lobster":["latin%2Clatin-ext%2Ccyrillic%2Cvietnamese","regular"],"Abril%20Fatface":["latin%2Clatin-ext","regular"],"Pacifico":["latin%2Clatin-ext%2Cvietnamese","regular"],"Quicksand":["latin%2Clatin-ext%2Cvietnamese","300%2Cregular%2C500%2C700"],"Patua%20One":["latin","regular"],"Great%20Vibes":["latin%2Clatin-ext","regular"],"Monoton":["latin","regular"],"Berkshire%20Swash":["latin%2Clatin-ext","regular"]}',
		
	    'admin_lang' => 'en',
		'editor_lang' => 'en',
		'allow_select_lang' => 1,
		'activate_langs' => array(),


		'help_title' => '',
		'helps' => array(),
		'about' => '',

		'tab' => 'general',
		'share' => 0,
		'report_bugs' => 2,
		'email_design' => 1,
		'components' => array('shop', 'product', 'templates', 'cliparts', 'text', 'uploads', 'shapes', 'drawing', 'layers', 'back'),
		'disable_resources' => '',
		'min_upload' => '',
		'max_upload' => '',
		'dis_qrcode' => '',
		'min_dimensions' => '50x50',
		'max_dimensions' => '1500x1500',
		'min_ppi' => '',
		'max_ppi' => '',
		'ppi_notice' => 'no',
		'required_full_design' => 'no',
		'auto_fit' => '1',
		'calc_formula' => '1',
		'custom_css' => '',
		'custom_js' => '',
		'prefix_file' => 'customdesign',
		'text_direction' => '',
		'auto_snap' => 0,
		'template_append' => 0,
		'replace_image' => 0,
		'user_font' => 1,
		'stages' => '4',
		'label_stage_1' => 'Front',
		'label_stage_2' => 'Back',
		'label_stage_3' => 'Left',
		'label_stage_4' => 'Right',
		'toolbars' => array ('replace-image','crop','mask','remove-bg','filter','fill','layer','position','transform','advance-SVG','select-font','text-effect','font-size','line-height','letter-spacing','text-align','font-style'),
		'last_update' => '',
	);
	
	protected $allows = array(
		'editor_url',
		'checkout_url',
		'upload_path',
		'upload_url',
		'database',
		'logo',
		'url',
		'site_uri',
		'print_types',
		'security_name',
		'security_code',
		'ajax_url',
		'assets_url',
		'load_jquery',
		'root_path',
        'admin_url',
		'admin_assets_url',
		'admin_ajax_url',
		'js_lang',
		'default_fonts',
		'base_default',
		'size_default',
		'settings',
		'product_attributes',
		'api_url',
		'scheme',
		'tool_url',
		'langs'
	);
	
	protected $langs = array(
		"af" => "Afrikaans",
		"sq" => "Albanian",
		"am" => "Amharic",
		"ar" => "Arabic",
		"hy" => "Armenian",
		"az" => "Azerbaijani",
		"eu" => "Basque",
		"be" => "Belarusian",
		"bn" => "Bengali",
		"bs" => "Bosnian",
		"bg" => "Bulgarian",
		"ca" => "Catalan",
		"ceb" => "Cebuano",
		"ny" => "Chichewa",
		"zh-CN" => "Chinese",
		"co" => "Corsican",
		"hr" => "Croatian",
		"cs" => "Czech",
		"da" => "Danish",
		"nl" => "Dutch",
		"en" => "English",
		"eo" => "Esperanto",
		"et" => "Estonian",
		"tl" => "Filipino",
		"fi" => "Finnish",
		"fr" => "French",
		"fy" => "Frisian",
		"gl" => "Galician",
		"ka" => "Georgian",
		"de" => "German",
		"el" => "Greek",
		"gu" => "Gujarati",
		"ht" => "Haitian Creole",
		"ha" => "Hausa",
		"haw" => "Hawaiian",
		"hk"    => "Hongkong",
		"iw" => "Hebrew",
		"hi" => "Hindi",
		"hmn" => "Hmong",
		"hu" => "Hungarian",
		"is" => "Icelandic",
		"ig" => "Igbo",
		"id" => "Indonesian",
		"ga" => "Irish",
		"it" => "Italian",
		"ja" => "Japanese",
		"jw" => "Javanese",
		"kn" => "Kannada",
		"kk" => "Kazakh",
		"km" => "Khmer",
		"ko" => "Korean",
		"ku" => "Kurdish (Kurmanji)",
		"ky" => "Kyrgyz",
		"lo" => "Lao",
		"la" => "Latin",
		"lv" => "Latvian",
		"lt" => "Lithuanian",
		"lb" => "Luxembourgish",
		"mk" => "Macedonian",
		"mg" => "Malagasy",
		"ms" => "Malay",
		"ml" => "Malayalam",
		"mt" => "Maltese",
		"mi" => "Maori",
		"mr" => "Marathi",
		"mn" => "Mongolian",
		"my" => "Myanmar (Burmese)",
		"ne" => "Nepali",
		"no" => "Norwegian",
		"ps" => "Pashto",
		"fa" => "Persian",
		"pl" => "Polish",
		"pt" => "Portuguese",
		"pa" => "Punjabi",
		"ro" => "Romanian",
		"ru" => "Russian",
		"sm" => "Samoan",
		"gd" => "Scots Gaelic",
		"sr" => "Serbian",
		"st" => "Sesotho",
		"sn" => "Shona",
		"sd" => "Sindhi",
		"si" => "Sinhala",
		"sk" => "Slovak",
		"sl" => "Slovenian",
		"so" => "Somali",
		"es" => "Spanish",
		"su" => "Sundanese",
		"sw" => "Swahili",
		"sv" => "Swedish",
		"tg" => "Tajik",
		"ta" => "Tamil",
		"te" => "Telugu",
		"th" => "Thai",
		"tr" => "Turkish",
		"uk" => "Ukrainian",
		"ur" => "Urdu",
		"uz" => "Uzbek",
		"vi" => "Vietnamese",
		"cy" => "Welsh",
		"xh" => "Xhosa",
		"yi" => "Yiddish",
		"yo" => "Yoruba",
		"zu" => "Zulu"
	);
	
	protected $editor_menus = array();
	protected $product_attributes = array();
	
	protected $access_core = array();

	private $max_stages = 4;
	
	public function __construct($conn) {
		
		global $customdesign;
		
		if (
			(function_exists('session_status') && session_status() == PHP_SESSION_NONE) ||
			(function_exists('session_id') && session_id() == '')
		) {
			@session_start();
		}

		if(!defined('DS'))
			define('DS', DIRECTORY_SEPARATOR );
		if(!defined('CUSTOMDESIGN_FILE'))
			define('CUSTOMDESIGN_FILE', __FILE__);
		if(!defined('CUSTOMDESIGN_PATH'))
			define('CUSTOMDESIGN_PATH', str_replace(DS.'includes','',dirname(__FILE__)));
		define('CUSTOMDESIGN_SLUG', basename(dirname(__FILE__)));
		
		
		$this->set($conn->config);
		$this->settings['logo'] = $this->assets_url.'assets/images/logo.png';
		
		require_once(CUSTOMDESIGN_PATH.DS.'includes'.DS.'secure.php');
		require_once(CUSTOMDESIGN_PATH.DS.'includes'.DS.'database.php');

	}
	
	public function set_stages($num = 4) {
		
		global $customdesign;
		
		$actives = $customdesign->get_option( 'active_addons');
		
		if ($actives !== null && !empty($actives))
			$actives = (Array)@json_decode($actives);
		
		if (!is_array($actives) || !isset($actives['stages']) || $actives['stages'] !== 1)
			return;
		
		$this->max_stages = $num;
		
	}
	
	public function set($args) {

		if (is_array($args)) {
			foreach($args as $name => $val) {
				if (in_array($name, $this->allows)) {
					$this->{$name} = $val;
				}
			}
		}

	}

	public function get($name = '') {

		if (in_array($name, $this->allows)) {
			return $this->{$name};
		}

		return null;

	}

	public function __get( $name ) {
        if ( isset( $this->{$name} ) ) {
            return $this->{$name};
        } else {
            return null;
        }
    }

    public function __set( $name, $value ) {
        if ( isset( $this->$name ) ) {
            throw new Exception( "Tried to set nonexistent '$name' property of MyClass class" );
            return false;
        } else {
            throw new Exception( "Tried to set read-only '$name' property of MyClass class" );
            return false;
        }
    }

    public function set_lang($customdesign) {

    	if($customdesign->connector->platform == 'php'){
    		if (
				defined('CUSTOMDESIGN_ADMIN') && 
				CUSTOMDESIGN_ADMIN === true
			) {

				if (
					isset($this->settings['admin_lang']) &&
					!empty($this->settings['admin_lang'])
				)
					$this->active_language = $this->settings['admin_lang'];
				else
					$this->active_language = 'en';

			}else{
				$this->active_language = $customdesign->connector->get_session('customdesign-active-lang');

				$this->active_language_frontend = $customdesign->connector->get_session('customdesign-active-lang');
				
				if (
					!isset($this->active_language) ||
					empty($this->active_language) || 
					!$this->settings['allow_select_lang']
				) {

					if (
						isset($this->settings['editor_lang']) &&
						!empty($this->settings['editor_lang'])
					)
						$this->active_language = $this->settings['editor_lang'];
					else
						$this->active_language = 'en';
						
						$customdesign->connector->set_session('customdesign-active-lang', $this->active_language);

				}
			} 
			
			if (
				isset($this->active_language) &&
				!empty($this->active_language) 
				// && $this->active_language != 'en'
			) {

				$get_query = "SELECT `original_text`, `text` FROM `{$customdesign->db->prefix}languages` WHERE `author`='{$customdesign->vendor_id}' AND `lang`='".$this->active_language."'";
				$get_langs = $customdesign->db->rawQuery($get_query);

				if (count($get_langs) > 0) {
					foreach ($get_langs as $lang) {
						$this->lang_storage[strtolower($lang['original_text'])] = $lang['text'];
					}
				}
				
				$this->lang_storage = $customdesign->apply_filters('language', $this->lang_storage);
				
			}
    	}

    	if($customdesign->connector->platform == 'woocommerce'){
    		// backend
	    	if(is_admin()){
	    		if ( isset($this->settings['admin_lang']) && !empty($this->settings['admin_lang']) ){
					$this->active_language_backend = $this->settings['admin_lang'];
				} else {
					$this->active_language_backend = 'en';
				}

				if ( isset($this->settings['editor_lang']) && !empty($this->settings['editor_lang']) ){
					$this->active_language_frontend = $this->settings['editor_lang'];
				} else {
					$this->active_language_frontend = 'en';
				}

				if(isset($this->active_language_backend) && !empty($this->active_language_backend) && $this->active_language_backend != 'en'){

					$customdesign->connector->set_session('customdesign-active-lang-backend', $this->active_language_backend);

					$get_query = "SELECT `original_text`, `text` FROM `{$customdesign->db->prefix}languages` WHERE `author`='{$customdesign->vendor_id}' AND `lang`='".$this->active_language_backend."'";
					$get_langs = $customdesign->db->rawQuery($get_query);

					if (count($get_langs) > 0) {
						foreach ($get_langs as $lang) {
							$this->lang_storage = $this->lang_storage_backend[strtolower($lang['original_text'])] = $lang['text'];
						}
					}
					
					$this->lang_storage_backend = $customdesign->apply_filters('language', $this->lang_storage_backend);
				}

				if(isset($this->active_language_frontend) && !empty($this->active_language_frontend) && $this->active_language_frontend != 'en'){
					$customdesign->connector->set_session('customdesign-active-lang-frontend', $this->active_language_frontend);

					$get_query = "SELECT `original_text`, `text` FROM `{$customdesign->db->prefix}languages` WHERE `author`='{$customdesign->vendor_id}' AND `lang`='".$this->active_language_frontend."'";
					$get_langs = $customdesign->db->rawQuery($get_query);

					if (count($get_langs) > 0) {
						foreach ($get_langs as $lang) {
							$this->lang_storage_frontend[strtolower($lang['original_text'])] = $lang['text'];
						}
					}
					
					$this->lang_storage_frontend = $customdesign->apply_filters('language', $this->lang_storage_frontend);
				}
	    	}

	    	// frontend
	    	if(!is_admin()){

	    		// get frontend language session
	    		$this->active_language_frontend = $customdesign->connector->get_session('customdesign-active-lang-frontend');
				
				// if frontend language session not set or not allow user change, get from setting
				if ( !isset($this->active_language_frontend) || empty($this->active_language_frontend) || !$this->settings['allow_select_lang']) {
					if (!isset($this->settings['editor_lang']) || empty($this->settings['editor_lang'])){
						$this->active_language_frontend = 'en';
						
					}
					if(isset($this->settings['editor_lang']) || !empty($this->settings['editor_lang'])){
						$this->active_language_frontend = $this->settings['editor_lang'];
					}
					$customdesign->connector->set_session('customdesign-active-lang-frontend', $this->active_language_frontend);
				}

				$get_query = "SELECT `original_text`, `text` FROM `{$customdesign->db->prefix}languages` WHERE `author`='{$customdesign->vendor_id}' AND `lang`='".$this->active_language_frontend."'";
				$get_langs = $customdesign->db->rawQuery($get_query);

				if (count($get_langs) > 0) {
					foreach ($get_langs as $lang) {
						$this->lang_storage_frontend[strtolower($lang['original_text'])] = $lang['text'];
					}
				}
				
				$this->lang_storage_frontend = $customdesign->apply_filters('language', $this->lang_storage_frontend);
	    	}
    	}

    }

    public function set_settings($customdesign) {
	    
	    global $customdesign;
	    
	    $this->settings = $customdesign->apply_filters('init_settings', $this->settings);

	    foreach ($this->settings as $key => $val) {
		    $this->settings[$key] = $customdesign->get_option($key, $val);
	    }
    }

	public function ex_settings($set = array()) {
		
		global $customdesign;
		
		foreach ($set as $key => $val) {
			$this->settings[$key] = $customdesign->get_option($key, $val);
		}	
	}

	public function editor_menus($args) {
		
		if (is_array($args)) {
			foreach ($args as $id => $arg) {
				if (!isset($this->editor_menus[$id])) {
					$this->editor_menus[$id] = $arg;
				}
			}
		}
		
	}
	
	public function access_core($name) {
		if (isset($name) && !empty($name) && !in_array($name, $this->access_core))
			array_push($this->access_core, $name);
	}
	
	public function apply_filters($customdesign) {
		
		$this->settings = $customdesign->apply_filters('settings', $this->settings);
		$this->editor_menus = $customdesign->apply_filters('editor_menus', $this->editor_menus);
		$this->product_attributes = $customdesign->apply_filters('product_attributes', $this->product_attributes);
		$this->size_default = $customdesign->apply_filters('size_default', $this->size_default);
		$this->langs = $customdesign->apply_filters('langs_name', $this->langs);
		
	}
	
    public function init() {

	    global $customdesign;

		$this->set_settings($customdesign);
		$this->set_lang($customdesign);
		
		$this->editor_menus = $this->reg_editor_menus();
		
		$this->product_attributes = $this->reg_product_attributes();
		
		$color = explode(':', isset($this->settings['primary_color']) ? $this->settings['primary_color'] : '#4db6ac');
		$this->color = str_replace('#', '', $color[0]);
		
	    if (is_string($customdesign->cfg->settings['activate_langs'])) {
		    $customdesign->cfg->settings['activate_langs'] = explode(',', $customdesign->cfg->settings['activate_langs']);
	    }
		
		if (!empty($customdesign->cfg->settings['logo']) && strpos($customdesign->cfg->settings['logo'], 'http') === false)
			$customdesign->cfg->settings['logo'] = $customdesign->cfg->upload_url.$customdesign->cfg->settings['logo'];
		
		$customdesign->cfg->scheme = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? 'https' : 'http';
		$customdesign->cfg->api_url = 'https://rugcustom.com/';
		
		$this->base_default = array(
			"bag_back.png", 
			"test_rugs.png"
		);
		
		$this->size_default = array(
			'A0' => array(
				'cm' => '84.1 x 118.9',
				'inch' => '33.1 x 46.8',
				'px' => '9933 x 14043'
			),
			'A1' => array(
				'cm' => '59.4 x 84.1',
				'inch' => '23.4 x 33.1',
				'px' => '7016 x 9933'
			),
			'A2' => array(
				'cm' => '42 x 59.4',
				'inch' => '16.5 x 23.4',
				'px' => '4960 x 7016'
			),
			'A3' => array(
				'cm' => '29.7 x 42',
				'inch' => '11.7 x 16.5',
				'px' => '3508 x 4960'
			),
			'A4' => array(
				'cm' => '21 x 29.7',
				'inch' => '8.3 x 11.7',
				'px' => '2480 x 3508'
			),
			'A5' => array(
				'cm' => '14.8 x 21.0',
				'inch' => '5.8 x 8.3',
				'px' => '1748 x 2480'
			),
			'A6' => array(
				'cm' => '10.5 x 14.8',
				'inch' => '4.1 x 5.8',
				'px' => '1240 x 1748'
			),
			'A7' => array(
				'cm' => '7.4 x 10.5',
				'inch' => '2.9 x 4.1',
				'px' => '874 x 1240'
			),
			'A8' => array(
				'cm' => '5.2 x 7.4',
				'inch' => '2 x 2.9',
				'px' => '614 x 874'
			),
			'A9' => array(
				'cm' => '3.7 x 5.2',
				'inch' => '1.5 x 2',
				'px' => '437 x 614'
			),
			'A10' => array(
				'cm' => '2.6 x 3.7',
				'inch' => '1 x 1.5',
				'px' => '307 x 437'
			)
		);
		
	    $this->js_lang = array(
		    'sure'=> $customdesign->lang('Are you sure?'),
			'save'=> $customdesign->lang('Save'),
			'edit'=> $customdesign->lang('Edit'),
			'remove'=> $customdesign->lang('Remove'),
			'delete'=> $customdesign->lang('Delete'),
			'cancel'=> $customdesign->lang('Cancel'),
			'reset'=> $customdesign->lang('Reset'),
			'stage'=> $customdesign->lang('Stage'),
			'front'=> $customdesign->lang('Front'),
			'back'=> $customdesign->lang('Back'),
			'left'=> $customdesign->lang('Left'),
			'right'=> $customdesign->lang('Right'),
			'loading'=> $customdesign->lang('Loading'),
			'importing'=> $customdesign->lang('Importing'),
			'apply'=> $customdesign->lang('Apply Now'),
			'render'=> $customdesign->lang('Rendering design'),
			'wait'=> $customdesign->lang('Please wait..'),
			'clone'=> $customdesign->lang('Clone'),
			'double'=> $customdesign->lang('Double'),
			'processing'=> $customdesign->lang('Processing..'),
			'error_403'=> $customdesign->lang('Your session is expired, Please reload your browser'),
			'01'=> $customdesign->lang('Center center'),
			'02'=> $customdesign->lang('Horizontal center'),
			'03'=> $customdesign->lang('Vertical center'),
			'04'=> $customdesign->lang('Square'),
			'05'=> $customdesign->lang('Are you sure that you want to make selected objects to one object?'),
			'06'=> $customdesign->lang('No layer'),
			'07'=> $customdesign->lang('Add new layer to use it as a mask'),
			'08'=> $customdesign->lang('Error, the active object should be covered by the mask layer'),
			'09'=> $customdesign->lang('Your QRCode text'),
			'10'=> $customdesign->lang('Create QR Code'),
			'11'=> $customdesign->lang('Enter your text or a link'),
			'12'=> $customdesign->lang('Select color for QR Code'),
			'13'=> $customdesign->lang('Choose color'),
			'14'=> $customdesign->lang('Visibility'),
			'15'=> $customdesign->lang('Lock layer'),
			'16'=> $customdesign->lang('Delete layer'),
			'17'=> $customdesign->lang('Error when select stage, missing configuration'),
			'18'=> $customdesign->lang('Invalid type of current active object'),
			'19'=> $customdesign->lang('Invalid type of current active object'),
			'20'=> $customdesign->lang('Error: missing configuration.'),
			'21'=> $customdesign->lang('Your design has been saved successful.'),
			'22'=> $customdesign->lang('The design has been removed'),
			'23'=> $customdesign->lang('Error : Your session is invalid. Please reload the page to continue.'),
			'24'=> $customdesign->lang('We just updated your expired session. Please redo your action'),
			'25'=> $customdesign->lang('Data structure error'),
			'26'=> $customdesign->lang('The design has been loaded successfully'),
			'27'=> $customdesign->lang('You have not created any designs yet. <br>After designing, press Ctrl+S to save your designs in here.'),
			'28'=> $customdesign->lang('New design has been created'),
			'29'=> $customdesign->lang('The design has been successfully cleaned!'),
			'30'=> $customdesign->lang('Enter the new design title'),
			'31'=> $customdesign->lang('The export data under JSON has been storaged in your clipboard.'),
			'32'=> $customdesign->lang('Only accept the file with type JSON that exported by our system.'),
			'33'=> $customdesign->lang('Error loading image '),
			'34'=> $customdesign->lang('Double-click on the text to type'),
			'35'=> $customdesign->lang('Invalid size, please enter Width x Height'),
			'36'=> $customdesign->lang('Error, File too large. Please try to set smaller size'),
			'37'=> $customdesign->lang('Your design is not saved. Are you sure you want to leave this page?'),
			'38'=> $customdesign->lang('Your design is not saved. Are you sure you want to load new design?'),
			'39'=> $customdesign->lang('The link has been copied to your clipboard'),
			'40'=> $customdesign->lang('Please save your design first to create link'),
			'41'=> $customdesign->lang('You have not granted permission to view or edit this design'),
			'42'=> $customdesign->lang('No items found'),
			'43'=> $customdesign->lang('Back to categories'),
			'44'=> $customdesign->lang('Please wait..'),
			'45'=> $customdesign->lang('Prev'),
			'46'=> $customdesign->lang('Next'),
			'47'=> $customdesign->lang('Delete this image'),
			'48'=> $customdesign->lang('Edit this design'),
			'49'=> $customdesign->lang('Make a copy'),
			'50'=> $customdesign->lang('Download design'),
			'51'=> $customdesign->lang('Delete design'),
			'52'=> $customdesign->lang('Click to edit design title'),
			'53'=> $customdesign->lang('Warning: Images too large may slow down the tool'),
			'54'=> $customdesign->lang('Design Title'),
			'55'=> $customdesign->lang('Error while loading font'),
			'56'=> $customdesign->lang('Categories'),
			'57'=> $customdesign->lang('All categories'),
			'58'=> $customdesign->lang('Design options'),
			'59'=> $customdesign->lang('Keep current design'),
			'60'=> $customdesign->lang('Select design from templates'),
			'61'=> $customdesign->lang('Design from blank'),
			'62'=> $customdesign->lang('Start design now!'),
			'63'=> $customdesign->lang('Search product'),
			'64'=> $customdesign->lang('Printing'),
			'65'=> $customdesign->lang('Side'),
			'66'=> $customdesign->lang('Quantity'),
			'67'=> $customdesign->lang('Prices table'),
			'68'=> $customdesign->lang('Details'),
			'69'=> $customdesign->lang('More'),
			'70'=> $customdesign->lang('Successfull, view the full cart and checkout in the menu "My Cart"'),
			'71'=> $customdesign->lang('Your cart is empty'),
			'72'=> $customdesign->lang('Editing'),
			'73'=> $customdesign->lang('Your cart details'),
			'74'=> $customdesign->lang('Total'),
			'75'=> $customdesign->lang('Checkout'),
			'76'=> $customdesign->lang('Products'),
			'77'=> $customdesign->lang('Options'),
			'78'=> $customdesign->lang('Actions'),
			'79'=> $customdesign->lang('Updated'),
			'80'=> $customdesign->lang('Choose product'),
			'81'=> $customdesign->lang('Colors'),
			'82'=> $customdesign->lang('Unsave'),
			'83'=> $customdesign->lang('File not found'),
			'84'=> $customdesign->lang('Your uploaded image'),
			'85'=> $customdesign->lang('Active'),
			'86'=> $customdesign->lang('Deactive'),
			'87'=> $customdesign->lang('Select product'),
			'88'=> $customdesign->lang('Loading fonts'),
			'89'=> $customdesign->lang('No category'),
			'90'=> $customdesign->lang('Categories'),
			'91'=> $customdesign->lang('Design templates'),
			'92'=> $customdesign->lang('Search design templates'),
			'93'=> $customdesign->lang('Select design'),
			'94'=> $customdesign->lang('Load more'),
			'95'=> $customdesign->lang('Remove template'),
			'96'=> $customdesign->lang('Error! Your design is empty, please add the objects'),
			'97'=> $customdesign->lang('Can not updated'),
			'98'=> $customdesign->lang('Are you sure that you want to remove this stage?'),
			'99'=> $customdesign->lang('Please select one of print method.'),
			'100'=> $customdesign->lang('Free'),
			'101'=> $customdesign->lang('Are you sure that you want to clear design?'),
			'102'=> $customdesign->lang('This field is required.'),
			'103'=> $customdesign->lang('Enter at least the minimum 1 quantity.'),
			'104'=> $customdesign->lang('Price'),
			'105'=> $customdesign->lang('Tags:'),
			'106'=> $customdesign->lang('Overwrite this design'),
			'107'=> $customdesign->lang('New Design'),
			'108'=> $customdesign->lang('Printing'),
			'109'=> $customdesign->lang('Your design has been saved successfully!'),
			'110'=> $customdesign->lang('Draft was saved'),
			'111'=> $customdesign->lang('Load draft'),
			'112'=> $customdesign->lang('Load the draft designs which was saved before'),
			'113'=> $customdesign->lang('Successful! Your next changes will be updated to draft automatically'),
			'114'=> $customdesign->lang('Reset to default design'),
			'115'=> $customdesign->lang('You are editting an item from your shopping cart'),
			'116'=> $customdesign->lang('Your cart item was changed'),
			'117'=> $customdesign->lang('Cancel cart editting'),
			'118'=> $customdesign->lang('Your cart item has been updated successful'),
			'119'=> $customdesign->lang('A cart item is being edited. Do you want to change product for starting new design?'),
			'120'=> $customdesign->lang('Error: Cart item not found'),
			'121'=> $customdesign->lang('Are you sure to delete this item?'),
			'122'=> $customdesign->lang('You are viewing the design of the order'),
			'123'=> $customdesign->lang('Error, could not load the design file of this order'),
			'124'=> $customdesign->lang('Yes, Start New'),
			'125'=> $customdesign->lang('No, Update Current'),
			'126'=> $customdesign->lang('Attribute name exists, please enter new name.'),
			'127'=> $customdesign->lang('Warning: Please fix issues on attributes marked as red before submit.'),
			'128'=> $customdesign->lang('Owhh, Please slow down. You seem to be sharing too much, waiting a few more minutes to continue'),
			'129'=> $customdesign->lang('Oops, no item found'),
			'130'=> $customdesign->lang('Copy link'),
			'131'=> $customdesign->lang('Open link'),
			'132'=> $customdesign->lang('Delete link'),
			'133'=> $customdesign->lang('Are you sure that you want to delete this link?'),
			'134'=> $customdesign->lang('There is no more item'),
			'135'=> $customdesign->lang('The link has been copied successfully'),
			'136'=> $customdesign->lang('The share link has been loaded successfully'),
			'137'=> $customdesign->lang('Less'),
			'138'=> $customdesign->lang('Advanced SVG Editor'),
			'139'=> $customdesign->lang('Colors Manage'),
			'140'=> $customdesign->lang('Add to list'),
			'141'=> $customdesign->lang('Select all'),
			'142'=> $customdesign->lang('Unselect all'),
			'143'=> $customdesign->lang('List of your colors'),
			'144'=> $customdesign->lang('No item found, please add new color to your list'),
			'145'=> $customdesign->lang('Add new color'),
			'146'=> $customdesign->lang('Delete selection'),
			'147'=> $customdesign->lang('The size of images you upload is invalid, your upload size is'),
			'148'=> $customdesign->lang('Your file upload is not allowed, please upload image files only'),
			'149'=> $customdesign->lang('Your total quantity is less than the minimum quantity'),
			'150'=> $customdesign->lang('Your total quantity is larger than maximum quantity'),
			'151'=> $customdesign->lang('Enter the new label'),
			'152'=> $customdesign->lang('Enter number of color'),
			'153'=> $customdesign->lang('Add more column'),
			'154'=> $customdesign->lang('Reduce  column'),
			'155'=> $customdesign->lang('Enter the label'),
			'156'=> $customdesign->lang('Average'),
			'157'=> $customdesign->lang('item'),
			'158'=> $customdesign->lang('Click or drag to add shape'),
			'159'=> $customdesign->lang('Upload completed, please wait for a moment'),
			'160'=> $customdesign->lang('Failure to add: The minimum dimensions requirement'),
			'161'=> $customdesign->lang('Redirecting..'),
			'162'=> $customdesign->lang('Error: You can not delete the last item'),
			'163'=> $customdesign->lang('Error: Exceeded maximum allowed number of Stages'),
			'164'=> $customdesign->lang('Error: You must select a color before upload image'),
			'165'=> $customdesign->lang('Could not find your upload image'),
			'166'=> $customdesign->lang('Error, could not load the design'),
			'167'=> $customdesign->lang('Enter the size of editzone width x height in px'),
			'168'=> $customdesign->lang('Constrain aspect ratio'),
			'169'=> $customdesign->lang('No items found! Please upload new image or select the samples.'),
			'170'=> $customdesign->lang('Delete this image will affect the products that are using it. Are you sure that you want to delete?'),
			'171'=> $customdesign->lang('Click to edit image name'),
			'172'=> $customdesign->lang('Your cart has been updated'),
			'173'=> $customdesign->lang('View cart details'),
			'174'=> $customdesign->lang('Start new product'),
			'175'=> $customdesign->lang('Checkout Now'),
			'176'=> $customdesign->lang('Dismiss and continue design'),
			'177'=> $customdesign->lang('I understand and agree with the Terms & Conditions'),
			'178'=> $customdesign->lang('Choose an option'),
			'179'=> $customdesign->lang('Please select required product options before continue.'),
			'180'=> $customdesign->lang('Price calculation formula'),
			'181'=> $customdesign->lang('per 1 quantity'),
			'182'=> $customdesign->lang('Base price'),
			'183'=> $customdesign->lang('External'),
			'184'=> $customdesign->lang('You have successfully exited the edit mode!'),
			'185'=> $customdesign->lang('Clear designs'),
			'186'=> $customdesign->lang('You are editing your custom design'),
			'187'=> $customdesign->lang('Cancel editing'),
			'188'=> $customdesign->lang('Your design were saved at'),
			'189'=> $customdesign->lang('You can save or update your curent design for later use'),
			'190'=> $customdesign->lang('Save to MyDesigns'),
			'191'=> $customdesign->lang('Number stages'),
			'192'=> $customdesign->lang('You are viewing the designs of order'),
			'193'=> $customdesign->lang('Price, quantity and printing are affected by the variation'),
			'194'=> $customdesign->lang('Failure to add: Your image has low quality, the minimum PPI requirement'),
			'195'=> $customdesign->lang('Failure to add: The maximum PPI requirement'),
			'196'=> $customdesign->lang('Please render all pages before downloading'),
			'197'=> $customdesign->lang('Waring: Your image resolution is too low, it will affect print quality'),
			'198'=> $customdesign->lang('Addition price from multi quantity'),
			'199'=> $customdesign->lang('Attributes'),
			'200'=> $customdesign->lang('Filter by'),
			'201'=> $customdesign->lang('Apply for'),
			'202'=> $customdesign->lang('New value'),
			'203'=> $customdesign->lang('Bulk edit variations'),
			'204'=> $customdesign->lang('It has been successfully applied to %s variations'),
			'205'=> $customdesign->lang('Min Qty'),
			'206'=> $customdesign->lang('Max Qty'),
			'207'=> $customdesign->lang('Description'),
			'208'=> $customdesign->lang('Error, no configuration for the product you choose'),
			'209'=> $customdesign->lang('Error, no configuration for this product'),
			'210'=> $customdesign->lang('Error! Please design all stages before adding to cart'),
			'211'=> $customdesign->lang('Save your design for later use'),
			'212'=> $customdesign->lang('USE THIS'),
			'213'=> $customdesign->lang('OVERWRITE THIS'),
			'214'=> $customdesign->lang('Failure to add: The maximum number of characters for a text is'),
			'215'=> $customdesign->lang('Failure to add: The minimum number of characters for a text is'),
			'216'=> $customdesign->lang('Failure to add: The maximum dimensions requirement'),
			'217'=> $customdesign->lang('Failure to add: The minimum width requirement'),
			'218'=> $customdesign->lang('Failure to add: The maximum width requirement'),
	    );

	    $this->default_fonts = $customdesign->cfg->settings['google_fonts'];
		
		if ($customdesign->cfg->settings['components'] === null) {
			$customdesign->cfg->settings['components'] = array('product', 'templates', 'cliparts', 'text', 'uploads', 'layers');
			$customdesign->set_option('components', $customdesign->cfg->settings['components']);
		}
		
		$customdesign->do_action('config_init');
		
    }

}
