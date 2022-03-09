<?php
/**
*
*	(c) copyright:	Magic
*	(i) website:	magicrugs
*
*/

if(!defined('MAGIC')) {
	header('HTTP/1.0 403 Forbidden');
	exit;
}

class magic_admin extends magic_lib{

	public function __construct() {
		global $magic;
		$this->main = $magic;
		$this->process_actions();
	}

	public function get_category_item($item_id, $type){

		global $magic;
		$db = $magic->get_db();
		$db->join("categories_reference ca", "cate.id=ca.category_id", "LEFT");
		$db->where("ca.item_id", $item_id);
		$db->where("ca.type", $type);
		$result = $db->get ("categories cate", null, "cate.id, cate.name");

		return $result;

	}

	public function convert_slug_name($slug, $arr, $type) {

		$arr_name = array();
		$slug = explode (',', $slug);

		for ($i = 0; $i < count($slug); $i++) {
			foreach ($arr as $value) {
				if ($value['slug'] == $slug[$i] && $value['type'] == $type) {
					$arr_name[] = $value['name'];
				}
			}
		}
		$arr_name = implode(', ', $arr_name);

		return $arr_name;

	}

	protected function process_save_data($field, $data) {
		if (isset($field['type']) && $field['type'] == 'trace')
			return $data;
			
		global $magic_admin, $magic;
		
		$pg = $magic->esc('magic-page').'-s';
		$pg = str_replace(array('s-s', '-s'), array('s', 's'), $pg);
		
		if ($magic->esc('magic-page') == 'category' || $magic->esc('magic-page') == 'tag')
			$pg = $_POST['type'];
			
		if (!$magic->caps('magic_edit_'.$pg)) {
			$data['errors'] = array($magic->lang('Sorry, you are not allowed to save data in this section').' '.$pg);
			return $data;
		}
		
		if (isset($field['type']) && $field['type'] != 'categories') {
			$field_name = $this->esc($field['name']);
			if ((isset($field['required']) && $field['required'] === true) && empty($field_name))
				$data['errors'][$field['name']] = $magic->lang('The required fields can not be empty: ').$field['label'];
			else if ((!isset($field['db']) || $field['db'] !== false) && isset($_POST[$field['name']])) {
				$data[$field['name']] = $_POST[$field['name']];
				if (isset($field['numberic'])){
					switch ($field['numberic']) {
						case 'int':
							$data[$field['name']] = intval($_POST[$field['name']]);
							break;
						
						case 'float':
							$data[$field['name']] = floatval($_POST[$field['name']]);
							break;
						
						default:
							# code...
							break;
					}
				}
				if ($field['type'] == 'resource'){
					$tab_resource = array_combine(array_keys($field['tabs']),array_column($field['tabs'], 'fields'));
					foreach($tab_resource as $key => $tab_fields){

						foreach($tab_fields as $f){
							if (isset($data[$field['name']][$key][$f['name']]) && is_array($data[$field['name']][$key][$f['name']])){
								$data[$field['name']][$key][$f['name']] = array_filter($data[$field['name']][$key][$f['name']]);
							}

							if(isset($f['type']) && $f['type'] == 'toggle' && !isset($data[$field['name']][$key][$f['name']])){
								$data[$field['name']][$key][$f['name']] = '0';
							}
						}
					}
					$data[$field['name']] = $magic->lib->enjson($data[$field['name']]);
				}elseif ($field['type'] == 'groups' ){
					if(isset($field['fields'])){
						foreach($field['fields'] as $k => $f){
							if (is_array($data[$field['name']][$f['name']]))
								$data[$field['name']][$f['name']] = array_filter($data[$field['name']][$f['name']]);
						}
					}
					$data[$field['name']] = $magic->lib->enjson($data[$field['name']]);
				}elseif ($field['type'] == 'tabs')	
					$data[$field['name']] = json_encode($data[$field['name']]);
				else if (is_array($data[$field['name']]))
					$data[$field['name']] = implode(',', array_diff($data[$field['name']], array("")));
			}
		}
		
		if (isset($field['type']) && $field['type'] == 'parent') {
			if ($_POST[$field['name']] == 'None')
				$data[$field['name']] = '0';
			else
				$data[$field['name']] = $_POST[$field['name']];
		}	

		if (isset($field['type']) && $field['type'] == 'upload')
			$data = $this->process_upload($field, $data);
			
		if (isset($field['type']) && $field['type'] == 'toggle' && !isset($data[$field['name']]))
			$data[$field['name']] = '0';

		if (isset($field['type']) && $field['type'] == 'tags' && isset($_POST[$field['name']])){
			$data[$field['name']] = $_POST[$field['name']];
		}
		
		$data = $magic->apply_filters('save_fields', $data, $field);
		
		if (isset($field['db']) && $field['db'] === false) {
			unset($data[$field['name']]);
		}
		
		return $data;

	}

	protected function process_upload($field, $data) {

		global $magic;
		
		if (!$magic->caps('magic_can_upload')) {
			$data['errors'][$field['name']] = $magic->lang('Sorry, you are not allowed to upload files');
			return $data;
		}
		
		$name = $field['name'];
		$old_upload = isset($_POST['old-'.$name])? $_POST['old-'.$name] : null;
		$old_thumbn = (isset($field['thumbn']) && isset($_POST['old-'.$field['thumbn']])) ? $_POST['old-'.$field['thumbn']] : null;

		if (isset($data[$name]) && $data[$name] == $old_upload)
			return $data;
			
		if (isset($data[$name]) && !empty($data[$name])) {

			if ($data[$name] != $old_upload) {

				$time = time();
				$path = isset($field['path']) ? $field['path'] : '';

				$check = $magic->check_upload($time);

				if ($check !== 1) {

					$data['errors'][$name] = $check;
					unset($data[$name]);

				}else{

					$process = $this->upload_file($data[$name], $path);
					
					if (isset($process['error'])) {
						$data['errors'][$name] = $process['error'];
					}else{
						$data[$name] = str_replace(DS, '/', $path).$process['name'];
						
						if (
							isset($_POST['old-'.$name]) &&
							$_POST['old-'.$name] != $data[$name] &&
							file_exists($magic->cfg->upload_path.$_POST['old-'.$name])
						) {
							@unlink($magic->cfg->upload_path.$_POST['old-'.$name]);
						}

						if (isset($process['thumbn']) && isset($field['thumbn'])) {
							$data[$field['thumbn']] = $magic->cfg->upload_url.str_replace(DS, '/', $path.$process['thumbn']);
						}

						if (
							isset($field['thumbn']) && isset($_POST['old-'.$field['thumbn']]) && 
							$data[$field['thumbn']] != $_POST['old-'.$field['thumbn']]
						) {
							$old_thumn = str_replace(array($magic->cfg->upload_url, '/'), array($magic->cfg->upload_path, DS), $_POST['old-'.$field['thumbn']]);
							@unlink($old_thumn);

						}

					}

				}
			}

		} else {

			if (file_exists($magic->cfg->upload_path.$old_upload))
				@unlink($magic->cfg->upload_path.$old_upload);

			if (isset($old_thumbn) && $old_thumbn !== null) {
				$old_thumn = str_replace(array($magic->cfg->upload_url, '/'), array($magic->cfg->upload_path, DS), $old_thumbn);
				@unlink($old_thumn);
				$data[$field['thumbn']] = '';
			}

		}
		
		return $data;

	}

	protected function process_save_reference($args, $id) {

		global $magic_admin, $magic;
		$cates = array();
		$tags = array();

		if (isset($args['tabs'])) {
			foreach ($args['tabs'] as $key => $tab) {
				foreach($tab as $key2 => $field) {
					if (isset($field['type']) && $field['type'] == 'categories')
						array_push($cates, $field);
					if (isset($field['type']) && $field['type'] == 'tags')
						array_push($tags, $field);
				}
			}
		} else {
			foreach($args as $key => $field) {
				if (isset($field['type']) && $field['type'] == 'categories')
					array_push($cates, $field);
				if (isset($field['type']) && $field['type'] == 'tags')
					array_push($tags, $field);
			}
		}

		if (count($cates) > 0) {
			
			foreach ($cates as $field) {
				
				if (isset($_POST[$field['name']]) && is_array($_POST[$field['name']]))
					$post_cates = array_diff($_POST[$field['name']], array(''));
				else $post_cates = array();
				
				$magic->db->rawQuery("DELETE FROM `{$magic->db->prefix}categories_reference` WHERE `item_id`='{$id}' AND `type`='{$field['cate_type']}'");
				
				if (is_array($post_cates) && count($post_cates) > 0) {
					foreach ($post_cates as $cate) {
						$magic_admin->add_row(array(
							'category_id' => $cate,
							'item_id' => $id,
							'type' => $field['cate_type']
						), 'categories_reference');
					}
				}
			}
		}

		if (count($tags) > 0) {
			foreach ($tags as $field) {
				if( !isset($_POST[$field['name']]) || empty($_POST[$field['name']]) ) break;
				
				$post_tags = $_POST[$field['name']];	
				$post_tags = preg_replace('/,\s+,|,\s+/', ',', $post_tags);
				$post_tags = explode(',', trim($post_tags, ','));
				$post_tags = array_unique($post_tags);

				$magic->db->rawQuery("DELETE FROM `{$magic->db->prefix}tags_reference` WHERE `item_id`='{$id}' AND `type`='{$field['tag_type']}'");

				if (is_array($post_tags) && count($post_tags) > 0) {
					foreach ($post_tags as $tag) {

						$tid = $magic->db->rawQuery("SELECT `id` FROM `{$magic->db->prefix}tags` WHERE `author`='{$magic->vendor_id}' AND `slug`='{$this->slugify($tag)}' AND `type`='{$field['tag_type']}'");

						if (!isset($tid[0])) {
							$tid = $this->add_row( array(
								'name' => $tag,
								'slug' => $this->slugify($tag),
								'author' => $magic->vendor_id,
								'updated' => date("Y-m-d").' '.date("H:i:s"),
								'created' => date("Y-m-d").' '.date("H:i:s"),
								'type' => $field['tag_type']
							), 'tags' );
						}else $tid = $tid[0]['id'];

						$magic_admin->add_row(array(
							'tag_id' => $tid,
							'item_id' => $id,
							'author' => $magic->vendor_id, 
							'type' => $field['tag_type']
						), 'tags_reference');

					}
				}
			}
		}

	}

	protected function process_field($args, $data) {
		
		if (isset($args['name']) && (!isset($args['db']) || $args['db'] !== false)) {
			$args['value'] = isset($data[$args['name']]) ? $data[$args['name']] : '';
			if (
				$args['type'] == 'upload' &&
				isset($args['thumbn']) &&
				isset($data[$args['thumbn']])
			) {
				$args['thumbn_value'] = $data[$args['thumbn']];
			}
		}

		return $args;

	}

	public function process_data($args, $name) {
		
		global $magic;
		
		$args = $magic->apply_filters('process-section-'.$name, $args);
		
		$_id = isset($_GET['id'])? $_GET['id'] : 0;
		$_cb = isset($_GET['callback']) ? $_GET['callback'] : '';

		if (isset($_id)) {
			
			$data = $this->get_row_id($_id, $name);

			if (isset($args['tabs'])) {
				foreach ($args['tabs'] as $key => $tab) {
					foreach($tab as $key2 => $fields) {
						$args['tabs'][$key][$key2] = $this->process_field($args['tabs'][$key][$key2], $data);
					}
				}
			} else {
				foreach($args as $key => $field) {
					$args[$key] = $this->process_field($args[$key], $data);
				}
			}
		}
		
		if (isset($_POST['magic-section'])) {
			$section = $_POST['magic-section'];

			$data = array(
				'errors' => array()
			);

			$data_id = $this->esc('id');
			/*
			* Begin checking permision
			*/
			if (!empty($data_id)) {
				
				$db = $magic->get_db();
				
				$check_per = $db->rawQuery(
					sprintf(
						"SELECT * FROM `%s` WHERE `id`=%d",
						$db->prefix.$name,
						$data_id
					)
				);
				
				if (count($check_per) > 0) {
					
					if (
						isset($check_per[0]['author']) &&
						$check_per[0]['author'] != $magic->vendor_id
					) {
						
						$magic_msg = array('status' => 'error', 'errors' => array(
							$this->main->lang('Error, Access denied on changing this section!')
						));
						
						$magic->connector->set_session('magic_msg', $magic_msg);
						
						if (isset($_POST['redirect'])) {
							$magic->redirect(urldecode($_POST['redirect']).(!empty($data_id) ? '?id='.$data_id : ''));
							exit;
						}
						
						$magic->redirect(
							$magic->cfg->admin_url . 
							"magic-page=$section".
							(isset($data['type']) ? '&type='.$data['type'] : '').
							(isset($_GET['callback']) ? '&callback='.$_GET['callback'] : '')
						);
						
						exit;
						
					}
				} 
			}
			
			/*
			* End checking permision
			*/
			
			if (isset($args['tabs'])) {
				foreach ($args['tabs'] as $key => $tab) {
					foreach($tab as $key2 => $field) {
						$data = $this->process_save_data($field, $data);
					}
				}
			} else {
				foreach($args as $key => $field) {
					$data = $this->process_save_data($field, $data);
				}
			}

			if ($section == 'font') {
				
				$fi = 0;
				$fn = $magic->lib->slugify($data['name']);
				if(isset($data['name_desc']) && $data['name_desc'] != ''){
					$data['name_desc'] = preg_replace("/,/m", "", $data['name_desc']);
				}
				
				do {
					$data['name'] = $fn.($fi > 0 ? '-'.$fi : '');
					$fquery = "SELECT `id` FROM `{$magic->db->prefix}fonts`";
					$fquery .= " WHERE `author`='{$magic->vendor_id}' AND `name` = '".$magic->lib->sql_esc($data['name'])."'";
					if (!empty($data_id))
						$fquery .= " AND `id` <> {$data_id}";
					$check = $magic->db->rawQuery ($fquery);
					$fi++;
				} while (count($check) > 0);
				
			}
			
			if (isset($data['type'])) {

				$data_slug = array();
				$data['slug'] = $this->slugify($data['name']);

				if ($name == 'tags')
					$val = $this->get_rows_custom(array('slug', 'type'), 'tags');

				if ($name == 'categories')
					$val = $this->get_rows_custom(array('slug', 'type'), 'categories');

				foreach ($val as $value) {
					if ($value['type'] == $data['type']) {
						$data_slug[] = $value['slug'];
					}
				}

				if (in_array($data['slug'], $data_slug))
					$data['slug'] = $this->add_count($data['slug'], $data_slug);
			}

			if (empty($data_id))
				$data['created'] = date("Y-m-d").' '.date("H:i:s");
			
			$data['updated'] = date("Y-m-d").' '.date("H:i:s");

			/* echo "<pre>";
			print_r($data);
			die(); */

			if (count($data['errors']) == 0) {

				unset($data['errors']);
				
				if (!empty($data_id)) {
					$data = $magic->apply_filters('edit-section', $data, $name);
					$id = $this->edit_row( $data_id, $data, $name );
				} else {
					$data = $magic->apply_filters('new-section', $data, $name);
					$id = $this->add_row( $data, $name );
				}
				
				$magic->do_action('process-fields', $section, $id);
				
				$magic->connector->set_session('magic_msg', array('status' => 'success'));

			}
				
			if (isset($id) && is_array($id) && isset($id['error'])) {
				if (!isset($data['errors']))
					$data['errors'] = array();
				array_push($data['errors'], $id['error']);
			}
			
			if (!isset($id) || empty($id)) {
				if (!isset($data['errors']))
					$data['errors'] = array();
				array_push($data['errors'], $magic->db->getLastError());
			}
			
			if (isset($data['errors']) && count($data['errors']) > 0) {

				$magic_msg = array('status' => 'error', 'errors' => $data['errors']);
				$magic->connector->set_session('magic_msg', $magic_msg);
				
				if (isset($_POST['redirect'])) {
					$magic->redirect(urldecode($_POST['redirect']).(!empty($data_id) ? '?id='.$data_id : ''));
					exit;
				}
				
				if (!empty($data_id)) {
					$magic->redirect($magic->cfg->admin_url . "magic-page=$section&id=$data_id&".(isset($data['type']) ? '&type='.$data['type'] : '').(isset($_GET['callback']) ? '&callback='.$_GET['callback'] : ''));
				} else {
					$magic->redirect($magic->cfg->admin_url . "magic-page=$section".(isset($data['type']) ? '&type='.$data['type'] : '').(isset($_GET['callback']) ? '&callback='.$_GET['callback'] : ''));
				}
				exit;

			}

			if (isset($id) && !empty($id)) {

				$this->process_save_reference($args, $id);

				if (!empty($_cb) && $this->process_callback($id, $_cb) === false)
					exit;
				
				if (isset($_POST['redirect'])) {
					$magic->redirect(urldecode($_POST['redirect']).'?id='.$id);
					exit;
				}
				
				$magic->redirect($magic->cfg->admin_url . "magic-page=$section&id=$id".(isset($data['type']) ? '&type='.$data['type'] : '').(!empty($_cb) ? '&callback='.$_cb : ''));

				exit;

			}
			
		}
		
		return $args;

	}

	public function process_callback($id = 0, $cb = '') {

		global $magic;

		switch ($cb) {
			case 'edit-cms-product':
				$data = $magic->db->rawQuery("SELECT `name`,`stages`,`attributes` FROM `{$magic->db->prefix}products` WHERE `author`='{$magic->vendor_id}' AND `id`=$id");
	        	if (isset($data[0]) && isset($data[0]['stages'])) {
		        	$color = $magic->lib->get_color($data[0]['attributes']);
		        	echo "<script>top.magic_reset_products({
						id: '$id',
						name: '{$data[0]['name']}',
						color: '{$color}',
						stages: ".urldecode(base64_decode($data[0]['stages'])).
					"});</script>";
	        	}
				$magic->connector->set_session('magic_msg', array('status' => ''));
				return false;
			break;
			case 'edit-base-product':
				$data = $magic->db->rawQuery("SELECT `name`,`stages`,`attributes` FROM `{$magic->db->prefix}products` WHERE `author`='{$magic->vendor_id}' AND `id`=$id");
	        	if (isset($data[0]) && isset($data[0]['stages'])) {
		        	$color = $magic->lib->get_color($data[0]['attributes']);
		        	echo "<script>top.magic_reset_products({
						id: '$id',
						name: '{$data[0]['name']}',
						color: '{$color}',
						stages: ".urldecode(base64_decode($data[0]['stages'])).
					"});</script>";
	        	}
				$magic->connector->set_session('magic_msg', array('status' => ''));
				return false;
			break;
		}

	}

	public function process_settings_data($args) {
		
		global $magic;

		$fields = array();
		$data = array('errors' => array());
		
		if (isset($args['tabs'])) {
			foreach ($args['tabs'] as $tab => $tab_fields) {
				foreach ($tab_fields as $i => $field) {
					if (isset($field['name'])) {
						$args['tabs'][$tab][$i]['value'] = $magic->get_option($field['name']);
						if (isset($_POST['magic-section']))
							$data = $this->process_save_data($field, $data);
					}
				}
			}
		} else {
			foreach ($args as $i => $field) {
				if (isset($field['name'])) {
					$args[$i]['value'] = $magic->get_option($field['name']);
					if (isset($_POST['magic-section']))
						$data = $this->process_save_data($field, $data);
				}
			}
		}
		
		if (isset($_POST['magic-section'])) {
			
			if (isset($_POST['admin_email']) && !empty($_POST['admin_email'])) {
				if ($magic->cfg->settings['admin_email'] != trim($_POST['admin_email'])) {
					if (filter_var(trim($_POST['admin_email']), FILTER_VALIDATE_EMAIL)) {
						$magic->set_option('admin_email', trim($_POST['admin_email']));
					} else array_push($data['errors'], $magic->lang('Error: Invalid email format'));
				}
				if (isset($_POST['admin_password']) && !empty($_POST['admin_password'])) {
					if (
						!isset($_POST['re_admin_password']) || 
						empty($_POST['re_admin_password']) ||
						$_POST['admin_password'] != $_POST['re_admin_password'] ||
						strlen($_POST['admin_password']) < 8
					) {
						array_push($data['errors'], $magic->lang('Error: Admin Passwords do not match or less than 8 characters'));
					}else{
						$magic->set_option('admin_password', md5(trim($_POST['admin_password'])));
					}
				}
			}
			
			if (
				$_POST['magic-section'] == 'settings' &&
				count($data['errors']) === 0 && 
				!$magic->lib->render_css($data)
			) {
				$data['errors'][] = $magic->lang('Could not save the custom css to file');
				foreach ($data as $key => $val) {
					$magic->set_option($key, $val);
				}
				$magic->set_option('last_update', time());
			}
			
			if (count($data['errors']) === 0) {
	
				unset($data['errors']);
				
				if ($_POST['magic-section'] == 'settings') {
						
					$magic->lib->render_css($data);
					
					$magic->set_option('last_update', time());
					
					$magic->apply_filters('after_save_settings', $data);
					
				}
				
				foreach ($data as $key => $val) {
					$magic->set_option($key, $val);
				}
				
				$magic->connector->set_session('magic_msg', array('status' => 'success'));
	
				if (!isset($_POST['magic-redirect']))
					$magic->redirect($magic->cfg->admin_url . "magic-page=settings");
				else $magic->redirect($_POST['magic-redirect']);
				
				exit;
	
			} else {
				$magic->connector->set_session('magic_msg', array('status' => 'error', 'errors' => $data['errors']));
				$magic->redirect($magic->cfg->admin_url . "magic-page=settings");
				exit;
			}
			
		}
		
		return $args;

	}
	
	public function render_custom_css($css) {
		
		global $magic;
		$path = $magic->cfg->root_path.'assets'.DS.'css'.DS.'custom.css';

		if (!empty($css)) {
			$content = str_replace(
				array('&gt;', '; ', ' }', '{ ', "\r\n", "\r", "\n", "\t",'  ','    ','    '),
				array('>', ';', '}', '{', '', '', '', '', '', '', ''),
				$css
			);
			@file_put_contents($path, stripslashes($content));
		}
	}
	
	public function process_actions() {
		
		$do_action = $this->main->lib->esc('do_action');
		if (isset($do_action)) {
			switch ($do_action) {
				
				case 'verify-license' : 
				
					$key = $this->esc('key');
					
					if (empty($key) || strlen($key) != 36 || count(explode('-', $key)) != 5) {
						$magic_msg['status'] = 'error';
						$magic_msg['errors'] = array($this->main->lang('The purchase code is not valid'));
						$this->main->connector->set_session('magic_msg', $magic_msg);
						return;
					}
					
					$check = $this->main->lib->remote_connect(
						$this->main->cfg->api_url.'updates/verify/',
						array(), 
						array(
							"Key: ".$key,
							"Referer: ".$_SERVER['HTTP_HOST'],
				        	"Platform: ".$this->main->connector->platform,
				        	"Scheme: ".$this->main->cfg->scheme,
				        	"Cookie: PHPSESSID=".str_replace('=', '', base64_encode($_SERVER['HTTP_HOST']))
				        )
					);
					
					$check = @simplexml_load_string($check);
					
					$resp = (string)$check->response[0];
					$magic_msg = $this->main->connector->get_session('magic_msg');
					if (!is_array($magic_msg))
							$magic_msg = array();
							
					if ($resp == 'anti_spam') {
						$magic_msg['status'] = 'error';
						$magic_msg['errors'] = array($this->main->lang('It seems you have sent too many requests, please wait for a few minutes and try again later'));
					}else if ($resp == 'register_success') {
						$this->main->set_option('purchase_key', $key);
						$magic_msg['status'] = 'success';
						$magic_msg['msg'] =$this->main->lang('Your purchase code has been verified successfully');
					}else{
						$this->main->set_option('purchase_key', '');
						$magic_msg['status'] = 'error';
						$magic_msg['errors'] = array($this->main->lang('An error occurred').': '.strtoupper($resp));
					}
					
					$this->main->connector->set_session('magic_msg', $magic_msg);
					
				break;
				
				case 'revoke-license' : 
					
					$key = $this->esc('key');
					
					if (empty($key) || strlen($key) != 36 || count(explode('-', $key)) != 5) {
						$magic_msg['status'] = 'error';
						$magic_msg['errors'] = array($this->main->lang('The purchase code is not valid'));
						$this->main->connector->set_session('magic_msg', $magic_msg);
						return;
					}
					
					$check = $this->main->lib->remote_connect(
						$this->main->cfg->api_url.'updates/verify/',
						array(), 
						array(
							"Revoke: yes",
							"Key: ".$key,
							"Referer: ".$_SERVER['HTTP_HOST'],
				        	"Platform: ".$this->main->connector->platform,
				        	"Scheme: ".$this->main->cfg->scheme,
				        	"Cookie: PHPSESSID=".str_replace('=', '', base64_encode($_SERVER['HTTP_HOST']))
				        )
					);
					
					$check = @simplexml_load_string($check);
					
					$resp = (string)$check->response[0];
					
					$magic_msg = $this->main->connector->get_session('magic_msg');
					if (!is_array($magic_msg))
							$magic_msg = array();
					
					if ($resp == 'anti_spam') {
						$magic_msg['status'] = 'error';
						$magic_msg['errors'] = array($this->main->lang('You sent too much request, please wait for a few minutes and try again'));
					}else if ($resp == 'success') {
						$this->main->set_option('purchase_key', '');
						$magic_msg['status'] = 'success';
						$magic_msg['msg'] =$this->main->lang('Your purchase code has been revoked successful');
					}else{
						$magic_msg['status'] = 'error';
						$magic_msg['errors'] = array($this->main->lang('An error occurred while processing this request, please try again later.').$resp);
					}
					
					$this->main->connector->set_session('magic_msg', $magic_msg);
					
				break;
				
				case 'check-update':
					
					$data = $this->main->update->check();
					
					if ($data === null || !isset($data['version'])) {
						
						$magic_msg['status'] = 'error';
						$magic_msg['errors'] = array($this->main->lang('Something went wrong. We could not check the update this time, please check your connection and try again later.'));
						$this->main->connector->set_session('magic_msg', $magic_msg);
					}
					
				break;
				
				case 'do-update':
					
					$key = $this->main->get_option('purchase_key');
					$sys = $this->main->lib->check_sys_update();
					
					if ($key === null || empty($key) || strlen($key) != 36 || count(explode('-', $key)) != 5) {
						$this->main->set_option('purchase_key', '');
						echo '<script type="text/javascript">window.location.href = "'.$this->main->cfg->admin_url.'magic-page=license";</script></body></html>';
						exit;
					
					} else if ($sys !== true) {
						
						$magic_msg['status'] = 'error';
						$magic_msg['errors'] = $sys;
						$this->main->connector->set_session('magic_msg', $magic_msg);
						
					} else {
						
						$this->main->check_upload();
						$this->main->lib->delete_dir($this->main->cfg->upload_path.'tmpl');
						
						if (
							!is_dir($this->main->cfg->upload_path.'tmpl') && 
							!mkdir($this->main->cfg->upload_path.'tmpl', 0755)
						) {
							
							$magic_msg['status'] = 'error';
							$magic_msg['errors'] = array(
								$this->main->lang('Error: Could not create download folder, make sure that the permissions on magic-data directory is 755')
							);
							$this->main->connector->set_session('magic_msg', $magic_msg);
							return;
						
						}
						
						$file = $this->main->cfg->upload_path.'tmpl/lumize.zip';
						
						$fh = $this->main->lib->remote_connect(
							$this->main->cfg->api_url.'updates/verify/',
							array(), 
							array(
								"Download: yes",
								"Key: ".$key,
								"Referer: ".$_SERVER['HTTP_HOST'],
					        	"Platform: ".$this->main->connector->platform,
					        	"Scheme: ".$this->main->cfg->scheme,
					        	"Cookie: PHPSESSID=".str_replace('=', '', base64_encode($_SERVER['HTTP_HOST']))
					        )
						);
						
						$data = file_put_contents($file, $fh);
						@fclose($fh);
						
						if ($data === 0) {
							
							$magic_msg['status'] = 'error';
							$magic_msg['errors'] = array(
								$this->main->lang('Error: Could not download file, make sure that the fopen() funtion on your server is enabled')
							);
							
							@unlink($file);
							
						} else if ($data < 250) {
							
							$magic_msg['status'] = 'error';
							$erro = @file_get_contents($file);
							$magic_msg['errors'] = array($this->main->lang('Error: ').$erro);
							
							@unlink($file);
							
						} else {
							
							$zip = new ZipArchive;
							$res = $zip->open($file);
							$rpath = str_replace(DS.'core'.DS, '', $this->main->cfg->root_path);
							
							if ($res === TRUE) {
								
								$zip->extractTo($this->main->cfg->upload_path.'tmpl');
								$zip->close();
								
								if ($this->main->connector->update()) {
									$magic_msg['status'] = 'success';
									$magic_msg['msg'] = $this->main->lang('Congratulations, magicrugs has updated successfully, enjoy it!');
									$this->main->connector->set_session('magic_msg', $magic_msg);
									echo '<script type="text/javascript">window.location.href = "'.$this->main->cfg->admin_url.'magic-page=updates";</script></body></html>';
									exit;
								} else {
									$magic_msg['status'] = 'error';
									$magic_msg['errors'] = array($this->main->lang('Error: Could not move files'));
								}
								
							} else {
								$magic_msg['status'] = 'error';
								$magic_msg['errors'] = array($this->main->lang('Error: Could not open file').$file);
							}
							
						}
						
						$this->main->connector->set_session('magic_msg', $magic_msg);
						
					}
					
				break;

				// end product function evantor

				case 'verify-license-addon-bundle' : 
				
					$key_addon_bundle = $this->esc('key');
					
					if (empty($key_addon_bundle) || strlen($key_addon_bundle) != 36 || count(explode('-', $key_addon_bundle)) != 5) {
						$magic_msg['status'] = 'error';
						$magic_msg['errors'] = array($this->main->lang('The purchase code is not valid'));
						$this->main->connector->set_session('magic_msg', $magic_msg);
						return;
					}
					
					$check = $this->main->lib->remote_connect(
						$this->main->cfg->api_url.'updates/verify_addon_bundle/',
						array(), 
						array(
							"Key: ".$key_addon_bundle,
							"Referer: ".$_SERVER['HTTP_HOST'],
				        	"Platform: ".$this->main->connector->platform,
				        	"Scheme: ".$this->main->cfg->scheme,
				        	"Cookie: PHPSESSID=".str_replace('=', '', base64_encode($_SERVER['HTTP_HOST']))
				        )
					);
					
					
					$check = @simplexml_load_string($check);
					
					$resp = (string)$check->response[0];
					$magic_msg = $this->main->connector->get_session('magic_msg');
					if (!is_array($magic_msg))
							$magic_msg = array();
							
					if ($resp == 'anti_spam') {
						$magic_msg['status'] = 'error';
						$magic_msg['errors'] = array($this->main->lang('It seems you have sent too many requests, please wait for a few minutes and try again later'));
					}else if ($resp == 'register_success') {
						$this->main->set_option('purchase_key_addon_bundle', $key_addon_bundle);
						$magic_msg['status'] = 'success';
						$magic_msg['msg'] =$this->main->lang('Your purchase code has been verified successfully');
					}else{
						$this->main->set_option('purchase_key_addon_bundle', '');
						$magic_msg['status'] = 'error';
						$magic_msg['errors'] = array($this->main->lang('An error occurred').': '.strtoupper($resp));
					}
					
					$this->main->connector->set_session('magic_msg', $magic_msg);
					
				break;
				
				case 'revoke-license-addon-bundle' : 
					
					$key_addon_bundle = $this->esc('key');
					
					if (empty($key_addon_bundle) || strlen($key_addon_bundle) != 36 || count(explode('-', $key_addon_bundle)) != 5) {
						$magic_msg['status'] = 'error';
						$magic_msg['errors'] = array($this->main->lang('The purchase code is not valid'));
						$this->main->connector->set_session('magic_msg', $magic_msg);
						return;
					}
					
					$check = $this->main->lib->remote_connect(
						$this->main->cfg->api_url.'updates/verify_addon_bundle/',
						array(), 
						array(
							"Revoke: yes",
							"Key: ".$key_addon_bundle,
							"Referer: ".$_SERVER['HTTP_HOST'],
				        	"Platform: ".$this->main->connector->platform,
				        	"Scheme: ".$this->main->cfg->scheme,
				        	"Cookie: PHPSESSID=".str_replace('=', '', base64_encode($_SERVER['HTTP_HOST']))
				        )
					);
					
					$check = @simplexml_load_string($check);
					
					$resp = (string)$check->response[0];
					
					$magic_msg = $this->main->connector->get_session('magic_msg');
					if (!is_array($magic_msg))
							$magic_msg = array();
					
					if ($resp == 'anti_spam') {
						$magic_msg['status'] = 'error';
						$magic_msg['errors'] = array($this->main->lang('You sent too much request, please wait for a few minutes and try again'));
					}else if ($resp == 'success') {
						$this->main->set_option('purchase_key_addon_bundle', '');
						$magic_msg['status'] = 'success';
						$magic_msg['msg'] =$this->main->lang('Your purchase code has been revoked successful');
					}else{
						$magic_msg['status'] = 'error';
						$magic_msg['errors'] = array($this->main->lang('An error occurred while processing this request, please try again later.').$resp);
					}
					
					$this->main->connector->set_session('magic_msg', $magic_msg);
					
				break;
				
				case 'check-update-addon-bundle':
					
					$data = $this->main->update->check();
					
					if ($data === null || !isset($data['version'])) {
						
						$magic_msg['status'] = 'error';
						$magic_msg['errors'] = array($this->main->lang('Something went wrong. We could not check the update this time, please check your connection and try again later.'));
						$this->main->connector->set_session('magic_msg', $magic_msg);
					}
					
				break;
				
				case 'do-update-addon-bundle':
					
					$key = $this->main->get_option('purchase_key_addon_bundle');
					$sys = $this->main->lib->check_sys_update();
					
					if ($key === null || empty($key) || strlen($key) != 36 || count(explode('-', $key)) != 5) {
						$this->main->set_option('purchase_key_addon_bundle', '');
						echo '<script type="text/javascript">window.location.href = "'.$this->main->cfg->admin_url.'magic-page=license";</script></body></html>';
						exit;
					
					} else if ($sys !== true) {
						
						$magic_msg['status'] = 'error';
						$magic_msg['errors'] = $sys;
						$this->main->connector->set_session('magic_msg', $magic_msg);
						
					} else {
						
						$this->main->check_upload();
						$this->main->lib->delete_dir($this->main->cfg->upload_path.'tmpl');
						
						if (
							!is_dir($this->main->cfg->upload_path.'tmpl') && 
							!mkdir($this->main->cfg->upload_path.'tmpl', 0755)
						) {
							
							$magic_msg['status'] = 'error';
							$magic_msg['errors'] = array(
								$this->main->lang('Error: Could not create download folder, make sure that the permissions on magic-data directory is 755')
							);
							$this->main->connector->set_session('magic_msg', $magic_msg);
							return;
						
						}
						
						$file = $this->main->cfg->upload_path.'tmpl/lumize.zip';
						
						$fh = $this->main->lib->remote_connect(
							$this->main->cfg->api_url.'updates/verify/',
							array(), 
							array(
								"Download: yes",
								"Key: ".$key,
								"Referer: ".$_SERVER['HTTP_HOST'],
					        	"Platform: ".$this->main->connector->platform,
					        	"Scheme: ".$this->main->cfg->scheme,
					        	"Cookie: PHPSESSID=".str_replace('=', '', base64_encode($_SERVER['HTTP_HOST']))
					        )
						);
						
						$data = file_put_contents($file, $fh);
						@fclose($fh);
						
						if ($data === 0) {
							
							$magic_msg['status'] = 'error';
							$magic_msg['errors'] = array(
								$this->main->lang('Error: Could not download file, make sure that the fopen() funtion on your server is enabled')
							);
							
							@unlink($file);
							
						} else if ($data < 250) {
							
							$magic_msg['status'] = 'error';
							$erro = @file_get_contents($file);
							$magic_msg['errors'] = array($this->main->lang('Error: ').$erro);
							
							@unlink($file);
							
						} else {
							
							$zip = new ZipArchive;
							$res = $zip->open($file);
							$rpath = str_replace(DS.'core'.DS, '', $this->main->cfg->root_path);
							
							if ($res === TRUE) {
								
								$zip->extractTo($this->main->cfg->upload_path.'tmpl');
								$zip->close();
								
								if ($this->main->connector->update()) {
									$magic_msg['status'] = 'success';
									$magic_msg['msg'] = $this->main->lang('Congratulations, magicrugs has updated successfully, enjoy it!');
									$this->main->connector->set_session('magic_msg', $magic_msg);
									echo '<script type="text/javascript">window.location.href = "'.$this->main->cfg->admin_url.'magic-page=updates";</script></body></html>';
									exit;
								} else {
									$magic_msg['status'] = 'error';
									$magic_msg['errors'] = array($this->main->lang('Error: Could not move files'));
								}
								
							} else {
								$magic_msg['status'] = 'error';
								$magic_msg['errors'] = array($this->main->lang('Error: Could not open file').$file);
							}
							
						}
						
						$this->main->connector->set_session('magic_msg', $magic_msg);
						
					}
					
				break;

				// end product function evantor

				case 'verify-license-addon-vendor' : 
				
					$key_addon_vendor = $this->esc('key');
					
					if (empty($key_addon_vendor) || strlen($key_addon_vendor) != 36 || count(explode('-', $key_addon_vendor)) != 5) {
						$magic_msg['status'] = 'error';
						$magic_msg['errors'] = array($this->main->lang('The purchase code is not valid'));
						$this->main->connector->set_session('magic_msg', $magic_msg);
						return;
					}
					$check = $this->main->lib->remote_connect(
						$this->main->cfg->api_url.'updates/verify_addon_vendor/',
						array(), 
						array(
							"Key: ".$key_addon_vendor,
							"Referer: ".$_SERVER['HTTP_HOST'],
				        	"Platform: ".$this->main->connector->platform,
				        	"Scheme: ".$this->main->cfg->scheme,
				        	"Cookie: PHPSESSID=".str_replace('=', '', base64_encode($_SERVER['HTTP_HOST']))
				        )
					);
					
					
					$check = @simplexml_load_string($check);
					
					$resp = (string)$check->response[0];
					$magic_msg = $this->main->connector->get_session('magic_msg');
					if (!is_array($magic_msg))
							$magic_msg = array();
							
					if ($resp == 'anti_spam') {
						$magic_msg['status'] = 'error';
						$magic_msg['errors'] = array($this->main->lang('It seems you have sent too many requests, please wait for a few minutes and try again later'));
					}else if ($resp == 'register_success') {
						$this->main->set_option('purchase_key_addon_vendor', $key_addon_vendor);
						$magic_msg['status'] = 'success';
						$magic_msg['msg'] =$this->main->lang('Your purchase code has been verified successfully');
					}else{
						$this->main->set_option('purchase_key_addon_vendor', '');
						$magic_msg['status'] = 'error';
						$magic_msg['errors'] = array($this->main->lang('An error occurred').': '.strtoupper($resp));
					}
					
					$this->main->connector->set_session('magic_msg', $magic_msg);
					
				break;
				
				case 'revoke-license-addon-vendor' : 
					
					$key_addon_vendor = $this->esc('key');
					
					if (empty($key_addon_vendor) || strlen($key_addon_vendor) != 36 || count(explode('-', $key_addon_vendor)) != 5) {
						$magic_msg['status'] = 'error';
						$magic_msg['errors'] = array($this->main->lang('The purchase code is not valid'));
						$this->main->connector->set_session('magic_msg', $magic_msg);
						return;
					}
					
					$check = $this->main->lib->remote_connect(
						$this->main->cfg->api_url.'updates/verify_addon_vendor/',
						array(), 
						array(
							"Revoke: yes",
							"Key: ".$key_addon_vendor,
							"Referer: ".$_SERVER['HTTP_HOST'],
				        	"Platform: ".$this->main->connector->platform,
				        	"Scheme: ".$this->main->cfg->scheme,
				        	"Cookie: PHPSESSID=".str_replace('=', '', base64_encode($_SERVER['HTTP_HOST']))
				        )
					);
					
					$check = @simplexml_load_string($check);
					
					$resp = (string)$check->response[0];
					
					$magic_msg = $this->main->connector->get_session('magic_msg');
					if (!is_array($magic_msg))
							$magic_msg = array();
					
					if ($resp == 'anti_spam') {
						$magic_msg['status'] = 'error';
						$magic_msg['errors'] = array($this->main->lang('You sent too much request, please wait for a few minutes and try again'));
					}else if ($resp == 'success') {
						$this->main->set_option('purchase_key_addon_vendor', '');
						$magic_msg['status'] = 'success';
						$magic_msg['msg'] =$this->main->lang('Your purchase code has been revoked successful');
					}else{
						$magic_msg['status'] = 'error';
						$magic_msg['errors'] = array($this->main->lang('An error occurred while processing this request, please try again later.').$resp);
					}
					
					$this->main->connector->set_session('magic_msg', $magic_msg);
					
				break;
				
				case 'check-update-addon-vendor':
					
					$data = $this->main->update->check();
					
					if ($data === null || !isset($data['version'])) {
						
						$magic_msg['status'] = 'error';
						$magic_msg['errors'] = array($this->main->lang('Something went wrong. We could not check the update this time, please check your connection and try again later.'));
						$this->main->connector->set_session('magic_msg', $magic_msg);
					}
					
				break;
				
				case 'do-update-addon-vendor':
					
					$key = $this->main->get_option('purchase_key');
					$sys = $this->main->lib->check_sys_update();
					
					if ($key === null || empty($key) || strlen($key) != 36 || count(explode('-', $key)) != 5) {
						$this->main->set_option('purchase_key', '');
						echo '<script type="text/javascript">window.location.href = "'.$this->main->cfg->admin_url.'magic-page=license";</script></body></html>';
						exit;
					
					} else if ($sys !== true) {
						
						$magic_msg['status'] = 'error';
						$magic_msg['errors'] = $sys;
						$this->main->connector->set_session('magic_msg', $magic_msg);
						
					} else {
						
						$this->main->check_upload();
						$this->main->lib->delete_dir($this->main->cfg->upload_path.'tmpl');
						
						if (
							!is_dir($this->main->cfg->upload_path.'tmpl') && 
							!mkdir($this->main->cfg->upload_path.'tmpl', 0755)
						) {
							
							$magic_msg['status'] = 'error';
							$magic_msg['errors'] = array(
								$this->main->lang('Error: Could not create download folder, make sure that the permissions on magic-data directory is 755')
							);
							$this->main->connector->set_session('magic_msg', $magic_msg);
							return;
						
						}
						
						$file = $this->main->cfg->upload_path.'tmpl/lumize.zip';
						
						$fh = $this->main->lib->remote_connect(
							$this->main->cfg->api_url.'updates/verify/',
							array(), 
							array(
								"Download: yes",
								"Key: ".$key,
								"Referer: ".$_SERVER['HTTP_HOST'],
					        	"Platform: ".$this->main->connector->platform,
					        	"Scheme: ".$this->main->cfg->scheme,
					        	"Cookie: PHPSESSID=".str_replace('=', '', base64_encode($_SERVER['HTTP_HOST']))
					        )
						);
						
						$data = file_put_contents($file, $fh);
						@fclose($fh);
						
						if ($data === 0) {
							
							$magic_msg['status'] = 'error';
							$magic_msg['errors'] = array(
								$this->main->lang('Error: Could not download file, make sure that the fopen() funtion on your server is enabled')
							);
							
							@unlink($file);
							
						} else if ($data < 250) {
							
							$magic_msg['status'] = 'error';
							$erro = @file_get_contents($file);
							$magic_msg['errors'] = array($this->main->lang('Error: ').$erro);
							
							@unlink($file);
							
						} else {
							
							$zip = new ZipArchive;
							$res = $zip->open($file);
							$rpath = str_replace(DS.'core'.DS, '', $this->main->cfg->root_path);
							
							if ($res === TRUE) {
								
								$zip->extractTo($this->main->cfg->upload_path.'tmpl');
								$zip->close();
								
								if ($this->main->connector->update()) {
									$magic_msg['status'] = 'success';
									$magic_msg['msg'] = $this->main->lang('Congratulations, magicrugs has updated successfully, enjoy it!');
									$this->main->connector->set_session('magic_msg', $magic_msg);
									echo '<script type="text/javascript">window.location.href = "'.$this->main->cfg->admin_url.'magic-page=updates";</script></body></html>';
									exit;
								} else {
									$magic_msg['status'] = 'error';
									$magic_msg['errors'] = array($this->main->lang('Error: Could not move files'));
								}
								
							} else {
								$magic_msg['status'] = 'error';
								$magic_msg['errors'] = array($this->main->lang('Error: Could not open file').$file);
							}
							
						}
						
						$this->main->connector->set_session('magic_msg', $magic_msg);
						
					}
					
				break;


				// end product function evantor

				case 'verify-license-addon-printful' : 
				
					$key_addon_printful = $this->esc('key');
					
					if (empty($key_addon_printful) || strlen($key_addon_printful) != 36 || count(explode('-', $key_addon_printful)) != 5) {
						$magic_msg['status'] = 'error';
						$magic_msg['errors'] = array($this->main->lang('The purchase code is not valid'));
						$this->main->connector->set_session('magic_msg', $magic_msg);
						return;
					}
					$check = $this->main->lib->remote_connect(
						$this->main->cfg->api_url.'updates/verify_addon_printful/',
						array(), 
						array(
							"Key: ".$key_addon_printful,
							"Referer: ".$_SERVER['HTTP_HOST'],
				        	"Platform: ".$this->main->connector->platform,
				        	"Scheme: ".$this->main->cfg->scheme,
				        	"Cookie: PHPSESSID=".str_replace('=', '', base64_encode($_SERVER['HTTP_HOST']))
				        )
					);
					
					
					$check = @simplexml_load_string($check);
					
					$resp = (string)$check->response[0];
					$magic_msg = $this->main->connector->get_session('magic_msg');
					if (!is_array($magic_msg))
							$magic_msg = array();
							
					if ($resp == 'anti_spam') {
						$magic_msg['status'] = 'error';
						$magic_msg['errors'] = array($this->main->lang('It seems you have sent too many requests, please wait for a few minutes and try again later'));
					}else if ($resp == 'register_success') {
						$this->main->set_option('purchase_key_addon_printful', $key_addon_printful);
						$magic_msg['status'] = 'success';
						$magic_msg['msg'] =$this->main->lang('Your purchase code has been verified successfully');
					}else{
						$this->main->set_option('purchase_key_addon_printful', '');
						$magic_msg['status'] = 'error';
						$magic_msg['errors'] = array($this->main->lang('An error occurred').': '.strtoupper($resp));
					}
					
					$this->main->connector->set_session('magic_msg', $magic_msg);
					
				break;
				
				case 'revoke-license-addon-printful' : 
					
					$key_addon_printful = $this->esc('key');
					
					if (empty($key_addon_printful) || strlen($key_addon_printful) != 36 || count(explode('-', $key_addon_printful)) != 5) {
						$magic_msg['status'] = 'error';
						$magic_msg['errors'] = array($this->main->lang('The purchase code is not valid'));
						$this->main->connector->set_session('magic_msg', $magic_msg);
						return;
					}
					
					$check = $this->main->lib->remote_connect(
						$this->main->cfg->api_url.'updates/verify_addon_printful/',
						array(), 
						array(
							"Revoke: yes",
							"Key: ".$key_addon_printful,
							"Referer: ".$_SERVER['HTTP_HOST'],
				        	"Platform: ".$this->main->connector->platform,
				        	"Scheme: ".$this->main->cfg->scheme,
				        	"Cookie: PHPSESSID=".str_replace('=', '', base64_encode($_SERVER['HTTP_HOST']))
				        )
					);
					
					$check = @simplexml_load_string($check);
					
					$resp = (string)$check->response[0];
					
					$magic_msg = $this->main->connector->get_session('magic_msg');
					if (!is_array($magic_msg))
							$magic_msg = array();
					
					if ($resp == 'anti_spam') {
						$magic_msg['status'] = 'error';
						$magic_msg['errors'] = array($this->main->lang('You sent too much request, please wait for a few minutes and try again'));
					}else if ($resp == 'success') {
						$this->main->set_option('purchase_key_addon_printful', '');
						$magic_msg['status'] = 'success';
						$magic_msg['msg'] =$this->main->lang('Your purchase code has been revoked successful');
					}else{
						$magic_msg['status'] = 'error';
						$magic_msg['errors'] = array($this->main->lang('An error occurred while processing this request, please try again later.').$resp);
					}
					
					$this->main->connector->set_session('magic_msg', $magic_msg);
					
				break;
				
				case 'check-update-addon-printful':
					
					$data = $this->main->update->check();
					
					if ($data === null || !isset($data['version'])) {
						
						$magic_msg['status'] = 'error';
						$magic_msg['errors'] = array($this->main->lang('Something went wrong. We could not check the update this time, please check your connection and try again later.'));
						$this->main->connector->set_session('magic_msg', $magic_msg);
					}
					
				break;
				
				case 'do-update-addon-printful':
					
					$key = $this->main->get_option('purchase_key');
					$sys = $this->main->lib->check_sys_update();
					
					if ($key === null || empty($key) || strlen($key) != 36 || count(explode('-', $key)) != 5) {
						$this->main->set_option('purchase_key', '');
						echo '<script type="text/javascript">window.location.href = "'.$this->main->cfg->admin_url.'magic-page=license";</script></body></html>';
						exit;
					
					} else if ($sys !== true) {
						
						$magic_msg['status'] = 'error';
						$magic_msg['errors'] = $sys;
						$this->main->connector->set_session('magic_msg', $magic_msg);
						
					} else {
						
						$this->main->check_upload();
						$this->main->lib->delete_dir($this->main->cfg->upload_path.'tmpl');
						
						if (
							!is_dir($this->main->cfg->upload_path.'tmpl') && 
							!mkdir($this->main->cfg->upload_path.'tmpl', 0755)
						) {
							
							$magic_msg['status'] = 'error';
							$magic_msg['errors'] = array(
								$this->main->lang('Error: Could not create download folder, make sure that the permissions on magic-data directory is 755')
							);
							$this->main->connector->set_session('magic_msg', $magic_msg);
							return;
						
						}
						
						$file = $this->main->cfg->upload_path.'tmpl/lumize.zip';
						
						$fh = $this->main->lib->remote_connect(
							$this->main->cfg->api_url.'updates/verify/',
							array(), 
							array(
								"Download: yes",
								"Key: ".$key,
								"Referer: ".$_SERVER['HTTP_HOST'],
					        	"Platform: ".$this->main->connector->platform,
					        	"Scheme: ".$this->main->cfg->scheme,
					        	"Cookie: PHPSESSID=".str_replace('=', '', base64_encode($_SERVER['HTTP_HOST']))
					        )
						);
						
						$data = file_put_contents($file, $fh);
						@fclose($fh);
						
						if ($data === 0) {
							
							$magic_msg['status'] = 'error';
							$magic_msg['errors'] = array(
								$this->main->lang('Error: Could not download file, make sure that the fopen() funtion on your server is enabled')
							);
							
							@unlink($file);
							
						} else if ($data < 250) {
							
							$magic_msg['status'] = 'error';
							$erro = @file_get_contents($file);
							$magic_msg['errors'] = array($this->main->lang('Error: ').$erro);
							
							@unlink($file);
							
						} else {
							
							$zip = new ZipArchive;
							$res = $zip->open($file);
							$rpath = str_replace(DS.'core'.DS, '', $this->main->cfg->root_path);
							
							if ($res === TRUE) {
								
								$zip->extractTo($this->main->cfg->upload_path.'tmpl');
								$zip->close();
								
								if ($this->main->connector->update()) {
									$magic_msg['status'] = 'success';
									$magic_msg['msg'] = $this->main->lang('Congratulations, magicrugs has updated successfully, enjoy it!');
									$this->main->connector->set_session('magic_msg', $magic_msg);
									echo '<script type="text/javascript">window.location.href = "'.$this->main->cfg->admin_url.'magic-page=updates";</script></body></html>';
									exit;
								} else {
									$magic_msg['status'] = 'error';
									$magic_msg['errors'] = array($this->main->lang('Error: Could not move files'));
								}
								
							} else {
								$magic_msg['status'] = 'error';
								$magic_msg['errors'] = array($this->main->lang('Error: Could not open file').$file);
							}
							
						}
						
						$this->main->connector->set_session('magic_msg', $magic_msg);
						
					}
					
				break;
				
			}
		}
		
	}
	
	public function check_caps($cap) {
		
		$data_action = isset($_POST['action']) ? $_POST['action'] : '';
		
		if (
			in_array($data_action, array('active', 'deactive', 'delete')) &&
			!$this->main->caps('magic_edit_'.$cap)
		) {
			$this->main->connector->set_session('magic_msg', array(
					'status' => 'error', 
					'errors' => array($this->main->lang('Sorry, you are not allowed to do this action'))
				)
			);
			echo '<script type="text/javascript">window.location.reload();</script></body></html>';
			exit;
		}
	}
	
}

class magic_helper {

	public function breadcrumb($magic_page, $type = null) {

		global $magic;
		global $magic_router;
		return;
		$arr = $magic->apply_filters('admin_breadcrumb', array(
			'cliparts' => array(
				'title' => $magic->lang('Cliparts'),
				'link'   => $magic->cfg->admin_url.'magic-page=cliparts',
				'child' => array(
					'clipart' => array(
						'type'   => '',
						'title'  => $magic->lang('Clipart'),
						'link'   => $magic->cfg->admin_url.'magic-page=clipart',
					),
					'categories' => array(
						'type'   => 'cliparts',
						'title'  => $magic->lang('Categories'),
						'link'   => $magic->cfg->admin_url.'magic-page=categories&type=cliparts',
					),
					'category' => array(
						'type'   => 'cliparts',
						'title'  => $magic->lang('Category'),
						'link'   => $magic->cfg->admin_url.'magic-page=category&type=cliparts',
					),
					'tags' => array(
						'type'   => 'cliparts',
						'title'  => $magic->lang('Tags'),
						'link'   => $magic->cfg->admin_url.'magic-page=tags&type=cliparts',
					),
					'tag' => array(
						'type'   => 'cliparts',
						'title'  => $magic->lang('Tag'),
						'link'   => $magic->cfg->admin_url.'magic-page=tag&type=cliparts',
					),
				),
			),
			'designs' => array(
				'title' => $magic->lang('Designs'),
				'link'   => $magic->cfg->admin_url.'magic-page=designs',
				'child' => array(
					'design' => array(
						'type'   => '',
						'title'  => $magic->lang('Design'),
						'link'   => $magic->cfg->admin_url.'magic-page=design',
					),
				),
			),
			'templates' => array(
				'title' => $magic->lang('Templates'),
				'link'   => $magic->cfg->admin_url.'magic-page=templates',
				'child' => array(
					'template' => array(
						'type'   => '',
						'title'  => $magic->lang('Template'),
						'link'   => $magic->cfg->admin_url.'magic-page=template',
					),
					'categories' => array(
						'type'   => 'templates',
						'title'  => $magic->lang('Categories'),
						'link'   => $magic->cfg->admin_url.'magic-page=categories&type=templates',
					),
					'category' => array(
						'type'   => 'templates',
						'title'  => $magic->lang('Category'),
						'link'   => $magic->cfg->admin_url.'magic-page=category&type=templates',
					),
					'tags' => array(
						'type'   => 'templates',
						'title'  => $magic->lang('Tags'),
						'link'   => $magic->cfg->admin_url.'magic-page=tags&type=templates',
					),
					'tag' => array(
						'type'   => 'templates',
						'title'  => $magic->lang('Tag'),
						'link'   => $magic->cfg->admin_url.'magic-page=tag&type=templates',
					),
				),
			),
			'products' => array(
				'title' => $magic->lang('Products'),
				'link'   => $magic->cfg->admin_url.'magic-page=products',
				'child' => array(
					'product' => array(
						'type'   => '',
						'title'  => $magic->lang('Product'),
						'link'   => $magic->cfg->admin_url.'magic-page=product',
					),
					'categories' => array(
						'type'   => 'products',
						'title'  => $magic->lang('Product Categories'),
						'link'   => $magic->cfg->admin_url.'magic-page=categories&type=products',
					),
					'category' => array(
						'type'   => 'products',
						'title'  => $magic->lang('Add New Category'),
						'link'   => $magic->cfg->admin_url.'magic-page=category&type=products',
					),
				),
			),
			'shapes' => array(
				'title' => $magic->lang('Shapes'),
				'link'   => $magic->cfg->admin_url.'magic-page=shapes',
				'child' => array(
					'shape' => array(
						'type'   => '',
						'title'  => $magic->lang('Shape'),
						'link'   => $magic->cfg->admin_url.'magic-page=shape',
					),
				),
			),
			'addons' => array(
				'title' => $magic->lang('Addons'),
				'link'   => $magic->cfg->admin_url.'magic-page=addons',
				'child' => array(
					'explore-addons' => array(
						'type'   => '',
						'title'  => $magic->lang('Explore'),
						'link'   => $magic->cfg->admin_url.'magic-page=explore-addons',
					),
					'addons' => array(
						'type'   => '',
						'title'  => $magic->lang('Installed'),
						'link'   => $magic->cfg->admin_url.'magic-page=addons',
					),
				),
			),
			'printings' => array(
				'title' => $magic->lang('Printing Type'),
				'link'   => $magic->cfg->admin_url.'magic-page=printings',
				'child' => array(
					'printing' => array(
						'type'   => '',
						'title'  => $magic->lang('Printing'),
						'link'   => $magic->cfg->admin_url.'magic-page=printing',
					),
				),
			),
			'fonts' => array(
				'title' => $magic->lang('Fonts'),
				'link'   => $magic->cfg->admin_url.'magic-page=fonts',
				'child' => array(
					'font' => array(
						'type'   => '',
						'title'  => $magic->lang('Edit Font'),
						'link'   => $magic->cfg->admin_url.'magic-page=font',
					)
				),
			),
			'languages' => array(
				'title' => $magic->lang('Languages'),
				'link'   => $magic->cfg->admin_url.'magic-page=languages',
				'child' => array(
					'language' => array(
						'type'   => '',
						'title'  => $magic->lang('Language'),
						'link'   => $magic->cfg->admin_url.'magic-page=language',
					),
				),
			),
			'orders' => array(
				'title' => $magic->lang('Orders'),
				'link'   => $magic->cfg->admin_url.'magic-page=orders',
			),
			'settings' => array(
				'title' => $magic->lang('Settings'),
				'link'   => $magic->cfg->admin_url.'magic-page=settings',
			)
		));

		$html = '<ul class="magic_breadcrumb">';
		
		foreach ($arr as $keys => $values) {


			if ($keys == $magic_page) {

				$html .= '<li><a href="'.$magic->cfg->admin_url.'magic-page=dashboard">'.$magic->lang('Dashboard').'</a></li><li><span>'.$values['title'].'</span></li>';

			}

			if (isset($values['child'])) {

				if (isset($values['child'][$magic_page]) && $values['child'][$magic_page]['type'] == $type) {

					$html .= '<li><a href="'.$magic->cfg->admin_url.'magic-page=dashboard">'.$magic->lang('Dashboard').'</a></li><li><a href="'.$values['link'].'">'.$values['title'].'</a></li>';

				}

				foreach ($values['child'] as $key => $child) {

					if ($key == $magic_page && $child['type'] == $type) {

						$html .= '<li><span>'.$child['title'].'</span></li>';

					}

				}

			}

		}

		$html .= '</ul>';
		
		ob_start();
			$magic->views->header_message();
			$content = ob_get_contents();
		ob_end_clean();
		
		if (!empty($content))
			$html .= '<br><br>'.$content;
		
		return $html;

	}

	public function resize_image($file, $w, $h) {

		$image_info = getimagesize($file);
		$type = $image_info['mime'];
		$width = $image_info[0];
		$height = $image_info[1];
		$ratio = $width/$height;
		$img = array();

		switch ($type) {
		    case 'image/jpeg':
		        $image = imagecreatefromjpeg($file);
		        break;
		    case 'image/jpg':
		        $image = imagecreatefromjpeg($file);
		        break;
		    case 'image/gif':
		        $image = imagecreatefromgif($file);
		        break;
		    case 'image/png':
		        $image = imagecreatefrompng($file);
		        break;
		    default:
		        $img['type'] = 'error';
		        break;
		}

	    if ($w == 'auto' && preg_match('/^[0-9]+$/', $h)) {

	    	if ($w/$h < $ratio) {
	    		$newwidth = $h*$ratio;
	    		$newheight = $h;
	    	} else {
	    		$newwidth = $h/$ratio;
	    		$newheight = $h;
	    	}

	    } else if (preg_match('/^[0-9]+$/', $w) && $h == 'auto') {

	    	if ($w/$h > $ratio) {
	    		$newheight = $w*$ratio;
	    		$newwidth = $w;
	    	} else {
	    		$newheight = $w/$ratio;
	    		$newwidth = $w;
	    	}

	    } else if (preg_match('/^[0-9]+$/', $w) && preg_match('/^[0-9]+$/', $h)) {
	    	$newwidth = $w;
	        $newheight = $h;
	    } else {
	    	$img['size'] = 'error';
	    }

		$new_image = imagecreatetruecolor($newwidth, $newheight);
		imagefill($new_image, 0, 0, imagecolorallocate($new_image, 255, 255, 255));
		imagecopyresampled($new_image, $image, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

		$before_etx = implode('.', array_pop(explode('.', $file)));
		$file = $before_etx.'-thumbn.jpeg';
		$count = 1;

		while(file_exists($file)) {
			$file = $before_etx.'-thumbn-'.$count.'.jpeg';
			$count++;
		}
		$img['file'] = $file;

		imagejpeg($new_image, $file, 75);
    	imagedestroy($image);

		return $img;

	}

	public function upload_file( $file, $filename, $tar_file, $filetype, $filesize ) {
		
		if (!$this->main->caps('magic_can_upload')) {
			echo $this->main->lang('Sorry, You do not have permission to upload');
			exit;
		}
		
		$target_file = $tar_file . basename($file[$filename]["name"]);
			
		$path_parts = pathinfo($target_file);
		$imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

		$rs = array();
		$rs['file_name'] = basename($file[$filename]["name"]);
		$rs['thumbnail'] = '';

		$count = 1;
		while (file_exists($target_file)) {
			$rs['file_name'] = $path_parts['filename'].'-'.$count.'.'.$path_parts['extension'];
			$target_file = $tar_file.$rs['file_name'];
			$count++;
		}

		if (!in_array($imageFileType, $filetype)) {
			$filetype = implode(', ', $filetype);
			$rs['thumbnail'] = 'Sorry, only '.$filetype.' files are allowed.';
		}

		if ( $file[$filename]['size'] > $filesize ) {
			$filesize = round ($filesize/1048576, 1);
			$rs['thumbnail'] = 'Max size '.$filesize.'MB';
		}
		if (empty($rs['thumbnail'])) {
			$rs['error'] = move_uploaded_file($file[$filename]["tmp_name"], $target_file);

		}

		return $rs;

	}

	public function format_uri( $string, $separator = '-' ){

	    $accents_regex = '~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i';
	    $special_cases = array( '&' => 'and', "'" => '');
	    $string = mb_strtolower( trim( $string ), 'UTF-8' );
	    $string = str_replace( array_keys($special_cases), array_values( $special_cases), $string );
	    $string = preg_replace( $accents_regex, '$1', htmlentities( $string, ENT_QUOTES, 'UTF-8' ) );
	    $string = preg_replace("/[^a-z0-9]/u", "$separator", $string);
	    $string = preg_replace("/[$separator]+/u", "$separator", $string);

	    return $string;
	}

	public function import_sample_shapes($shapes) {

		global $magic, $magic_router;
		
		for ($i = 0; $i < count($shapes); $i++) {
			$magic->db->insert('shapes', array(
				"name" => "Shape ".($i+1),
				"content" => $shapes[$i],
				"author" => $magic->vendor_id,
				"active" => 1,
				"created" => date("Y-m-d").' '.date("h:i:sa"),
				"updated" => date("Y-m-d").' '.date("h:i:sa"),
			));
		}

		$magic->redirect($magic->cfg->admin_url.'magic-page=shapes');

	}

}

global $magic_admin, $magic_pagination;
$magic_admin = new magic_admin();
$magic_pagination = new magic_pagination();
$magic_helper = new magic_helper();
