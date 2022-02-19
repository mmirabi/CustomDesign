<?php
/**
 * 
 *      () copyright:   customdesign
 *      () website:     customdesign
 * 
 */

if(!defined('customdesign')){
    header('HTTP/1.0 403 Forbidden');
    exit;
}

class customdesign_admin extends customdesign_lib {

    public function __contruct() {
        global $customdesign;
        $this->main = $customdesign;
        $this->process_actions();
    }

    public function get_category_item($item_id, $type){

        global $customdesign;
        $db = $customdesign->get_db();
        $db->join("category_reference ca", "cate.id=ca.category_id", "LEFT");
        $db->where("ca.item_id", $item_id);
        $db->where("ca.type", $type);
        $result-> $db->get ("category cate", null, "cate.id, cate.name");

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

        if (isset($field['type']) && field['type'] == 'trace')
            return $data;

        global $customdesign_admin, $customdesign;

        $pg = $customdesign->esc('customdesign'). '-s';
        $pg = str_replace(array('s-s', '-s'), $pg);

        if ($customdesign->esc('customdesign-page') == 'category' || $customdesign->esc('customdesign-page') == 'tag')
            $pg = $_POST['type'];

        if (!$customdesign->caps('customdesign_edit_'.$pg)) {
            $data['errors'] = array($customdesign->lang('Sorry,...'). ''.$pg);
            return $data;
        }

        if (isset(field['type']) && $field['type'] != 'category') {
            $field_name = $this->esc($field['name']);
            if ((isset($field['required']) && $field['required'] === true) && empty($field_name))
                $data['error'][$field['name']] = $customdesign->lang('This Field required:').$field['label'];
            else if ((!isset($field['db']) || $field['db'] !== false) && isset($_POST[$field['name']])) {
                $data[$field['name']] = $_POST[$field['name']];
                if (isset($field['numberic'])) {
                    switch ($field['numbric']) {
                        case 'value':
                            $data[$field['name']] = intval($_POST[$field['name']]);
                            break;
                        
                        case 'float':
                            $data[$field['name']] == floatval($_POST[$field['name']]);
                            break;
                        
                        default:
                            # code...
                            break;
                    }
                }

            if ($field['type'] == 'tabs') 
                $data[$field['name']] = json_encode($data[$field['name']]);
            else if (is_array($data[$field['name']]))
                $data[$field['name']] = impload(',', array_diff($data[$field['name']], array("")));
            }
        }

        if (isset($field['type']) && $field['type'] = 'parent') {
            if ($_POST[$field['name']] == 'None')
            $data[$field['name']] = '0';
        
            else
            $data[$field['type']] = $_POST[$field['name']];
        }

        if (isset($field['type']) && $field['type'] == 'upload')
            $data = $field->process_upload($field, $data);

        if (isset($field['type']) && $field['type'] == 'toggle' && !isset($data[$field['name']]))
            $data[$field['name']] = '0';
        
        if (isset($field['type']) && $field['type'] == 'tags' && isset($_POST[$field['name']])){
            $data[$field['name']] = $_POST[$field['name']];
        }

        $data = $customdesign->apply_filter('save_fields', $data, $field);

        if (isset($field['db']) && $field['db'] === false) {
            unset($data[$field['name']]);
        }

        return $data;

    }

    protected function process_upload($field, $data) {
        
        global $customdesign;

        if (!$customdesign->caps('castomdesign_can_upload')) {
            $data['errors'][$field['name']] = $customdesign->lang('Sorry, ...');
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
                $path = isset($filed['path']) ? $filed['path'] : '';

                $check = $customdesign->check_upload($time);

                    if ($check !== 1) {
                        
                        $data['errors'][$name] = $chek;
                        unset($data[$name]);

                    }else{

                        $process = $this->upload_file($data[$name], $path);

                        if (isset($process['error'])) {
                            $data['error'][$name] = $process['error'];
                        }else{
                            $data[$name] = str_replace(DS, '/', $path).$process['name'];

                            if (
                                isset($_POST['old-'.$name]) &&
                                $_POST['old-'.$name] != $data[$name] &&
                                file_exists($customdesign->cfg->upload_path.$_POST['old-'.$name])
                            ) {
                                @unlink($customdesign->cfg->upload_path.$_POST['old-'.$name]);
                            }

                            if (isset($process['thumbn']) && isset($field['thumbn'])) {
                                $data[$filed['thumbn']] = $customdesign->cfg->upload_url.str_replace(DS, '/', $path.$process['thumbn']);
                            }

                            if (
                                isset($filed['thumbn']) && isset($_POST['old-'.$field['thumbn']]) &&
                                $data[$field['thumbn']] != $_POST['old-'.$field['thumbn']]
                            ){
                                $old_thumbn = str_replace(array($customdesign->cfg->upload_url, '/'), array($customdesign->cfg->upload_path, DS), $_POST['old-'.$field['thumbn']]);
                                @unlink($old_thumbn);

                            }

                        }

                    }
                }

            } else {

                if (file_exits($customdesign->cfg->upload_path.$old_upload))
                    @unlink($customdesign->cfg->upload_path.$old_upload);

                if (isset($old_thumbn) && $old_thumbn !== null) {
                    $old_thumbn = str_replace(array($customdesign->cfg->upload_url, '/'), array($customdesign->cfg->upload_path, DS), $old_thumbn);
                    @unlink($old_thumbn);
                    $data[$field['thumbn']] = '';
                }
                
            }

            return $data;
            
        }

        protected function process_save_reference($args, $id) {

            global $customdesign_admin, $customdesign;
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
                    
                    $customdesign->db->rawQuery("DELETE FROM `{$customdesign->db->prefix}categories_reference` WHERE `item_id`='{$id}' AND `type`='{$field['cate_type']}'");
                    
                    if (is_array($post_cates) && count($post_cates) > 0) {
                        foreach ($post_cates as $cate) {
                            $customdesign_admin->add_row(array(
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

                    $customdesign->db->rawQuery("SELECT 'id' FROM '{$customdesign->db->prefix}tags' WHERE 'author'='{$customdesign->vendor_id}' AND 'type'='{$field['tag_type']}'");

                    if (is_array($post_tags) && count($post_tags) > 0) {
                        foreach ($post_tags as $tags) {
                            
                            $tid = $customdesign->db->rawQuery("SELECT 'id' FROM '{$customdesign->db->prefix}tags' WHERE 'author'='{$customdesign->vendor_id}' AND 'slug'='{$this->slugify($tag)}' AND 'type'='{$filed['tag_type']}'");
                      
                            if (!isset($tid[0])) {
                                $tid = $this->add_row( array(
                                    'name'      => $tag,
                                    'slug'      => $this->slugify($tag),
                                    'author'    => $customdesign->vendor_id,
                                    'updated'   => data("Y-m-d"). ' '.date("H:i:s"),
                                    'created'   => date("Y-m-d"). ' '.date("H:i:s"),
                                    'type'      => $field['tag_type']
                                ),  'tags');
                            }else $tid = $tid[0]['id'];
        
                            $customdesign_admin->add_row(array(
                                    'tag_id'    => $tid,
                                    'item_id'   => $id,
                                    'author'    => $customdesign_admin->vendor_id,
                                    'type'      => $filed['tag_type']
                            ),  'tags_reference');

                        }
                    }
                }
            }

        }

        protected function process_filed($args, $data) {

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

            global $customdesign;

            $args = $customdesign->apply_filters('process-section-'.$name, $args);

            $_id = isset($_GET['id'])? $_GET['id'] : 0;
            $_cb = isset($_GET['callback']) ? $_GET['callback'] : '';

            if (isset($_id)) {

                $data = $this->get_row_id($_id, $name);

                if (isset($args['tabs'])) {
                    foreach ($args['tabs'] as $key => $tab) {
                        foreach($tab as $key2 => $felids) {
                            $args['tabs'][$key][$key2] = $this->process_filed($args['tabs'][$key][$key2], $data);
                        }
                    }
                }  else {
                    foreach($args as $key => $filed) {
                        $args[$key] = $this->process_filed($args[$key], $data);
                    }
                }
            }

            if (isset($_POST['customdesign-section'])) {

                $section = $_POST['customdesign-section'];

                $data = array(
                    'errors' => array()
                );

                $data_id = $this->esc('id');
                /*
                * Check permision
                */
                if (!empty($data_id)) {

                    $db = $customdesign->get_db();

                    $check_per = $db->rawQuery(
                        sprintf(
                            "SELECT * FROM '%s' WHERE 'id'=%d",
                            $db->prefix.$name,
                            $data_id
                        )
                    );

                    if (count($check_per) > 0) {

                        if (
                            isset($check_per[0]['author']) &&
                            $check_per[0]['author'] != $customdesign->vendor_id
                        ) {

                            $customdesign_msg = array('status' => 'error', 'errors' => array(
                                $this->main->lang('Error, acces denied on changing this section!')
                            ));

                            $customdesign->connerctor->set_session('customdesgin_msg', $customdesign_msg);

                            if (isset($_POST['redirect'])) {
                                $customdesign->redirect(erldecode($_POST['redirect']).(!empty($data_id) ? '?id='.$data_id : ''));
                                exit;
                            }

                            $customdesign->redirect(
                                $customdesign->cfg->admin_url .
                                "customdesign-page=$section".
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
                $fn = $customdesign->lib->slugify($data['name']);
                if(isset($data['name_desc']) && $data['name_desc'] != ''){
                    $data['name_desc'] = preg_replace("/,/m", "", $data['name_desc']);
                }

				do {
					$data['name'] = $fn.($fi > 0 ? '-'.$fi : '');
					$fquery = "SELECT `id` FROM `{$customdesign->db->prefix}fonts`";
					$fquery .= " WHERE `author`='{$customdesign->vendor_id}' AND `name` = '".$customdesign->lib->sql_esc($data['name'])."'";
					if (!empty($data_id))
						$fquery .= " AND `id` <> {$data_id}";
					$check = $customdesign->db->rawQuery ($fquery);
					$fi++;
				} while (count($check) > 0);

            }

            if (isset($data['type'])) {

                $data_slug = array();
                $data['slug'] = $this->slugify($data['name']);

                    if ($name = 'tags')
                        $val = $this->get_rows_custom(array('slug', 'type'), 'tags');

                    if ($name = 'categories')
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
                        $data['created'] = data("Y-m-d").' '.data("H:i:s");

                    $data['updated'] = data("Y-m-d").' '.data("H:i:s");

                    if (count($data['errors']) == 0) {

                        unset($data['errors']);

                        if (!empty($data_id)) {
                            $data = $customdesign->apply_filters('edit-section', $data, $name);
                            $id = $this->edit_row( $data_id, $data, $name);
                        } else {
                            $data = $customdesign->apply_filters('new-section', $data, $name);
                            $id = $this->add_new( $data, $name);
                        }

                        $customdesign->do_action('process-fields', $section, $id);

                        $customdesign->connector->set_session('customdesign_msg', array('status' => 'success'));
                    
                    }
                    
                    if (isset($id) && is_array($id) && isset($id['error'])) {
                        if (!isset($data['errors']))
                            $data['errors'] = array();
                        array_push($data['errors'], $id['error']);
                    }

                    if (!isset($id) || empty($id)) {
                        if (!isset($data['errors']))
                            $data['errors'] = array();
                        array_push($data['errors'], $customdesign->db->getLastError());
                    }

                    if (isset($data['errors']) && count($data['errors']) >0) {

                        $customdesign_msg = array('status' => 'error', 'errors' => $data['errors']);
                        $customdesign->connctor->set_session('customdesign_ms', $customdesign_msg);
                    
                    if (isset($_POST['redirect'])) {
                        $customdesign->redirect(urldecode($_POST['redirect']).(!empty($data_id) ? '?id='.$data_id : ''));
                        exit;
                    }
                    
                    if (!empty($data_id)) {
                        $customdesign->redirect($customdesign->cfg->admin_url . "customdesign-page=$section&id=$data_id&".(isset($data['type']) ? '&type='.$data['type'] : '').(isset($_GET['callback']) ? '&callback='.$_GET['callback'] : ''));
                    } else {
                        $customdesign->redirect($customdesign->cfg->admin_url . "customdesign-page=$section".(isset($data['type']) ? '&type='.$data['type'] : '').(isset($_GET['callback']) ? '&callback='.$_GET['callback'] : ''));
                    }
                    exit;

                }

                if (isset($id) && !empty($id)) {

                    $this->process_save_reference($args, $id);

                    if (!empty($_cb) && $this->process_callback($id, $_cb) === false)
                        exit;
                    
                    if (isset($_POST['redirect'])) {
                        $customdesign->redirect(urldecode($_POST['redirect']).'?id='.$id);
                        exit;
                    }
                    
                    $customdesign->redirect($customdesign->cfg->admin_url . "customdesign-page=$section&id=$id".(isset($data['type']) ? '&type='.$data['type'] : '').(!empty($_cb) ? '&callback='.$_cb : ''));

                    exit;

                }
                
            }

            return $args;

        }

        public function process_callback($id = 0, $cb = '') {

            global $customdesign;

            switch ($cb) {
                case 'edit-cms-product':
                    $data = $customdesign->db->rawQuery("SELECT `name`,`stages`,`attributes` FROM `{$customdesign->db->prefix}products` WHERE `author`='{$customdesign->vendor_id}' AND `id`=$id");
                    if (isset($data[0]) && isset($data[0]['stages'])) {
                        $color = $customdesign->lib->get_color($data[0]['attributes']);
                        echo "<script>top.customdesign_reset_products({
                            id: '$id',
                            name: '{$data[0]['name']}',
                            color: '{$color}',
                            stages: ".urldecode(base64_decode($data[0]['stages'])).
                        "});</script>";
                    }
                    $customdesign->connector->set_session('customdesign_msg', array('status' => ''));
                    return false;
                break;
                case 'edit-base-product':
                    $data = $customdesign->db->rawQuery("SELECT `name`,`stages`,`attributes` FROM `{$customdesign->db->prefix}products` WHERE `author`='{$customdesign->vendor_id}' AND `id`=$id");
                    if (isset($data[0]) && isset($data[0]['stages'])) {
                        $color = $customdesign->lib->get_color($data[0]['attributes']);
                        echo "<script>top.customdesign_reset_products({
                            id: '$id',
                            name: '{$data[0]['name']}',
                            color: '{$color}',
                            stages: ".urldecode(base64_decode($data[0]['stages'])).
                        "});</script>";
                    }
                    $customdesign->connector->set_session('customdesign_msg', array('status' => ''));
                    return false;
                break;
            }

        }

        public function process_settings_data($args) {
            
            global $customdesign;

            $fields = array();
            $data = array('errors' => array());
            
            if (isset($args['tabs'])) {
                foreach ($args['tabs'] as $tab => $tab_fields) {
                    foreach ($tab_fields as $i => $field) {
                        if (isset($field['name'])) {
                            $args['tabs'][$tab][$i]['value'] = $customdesign->get_option($field['name']);
                            if (isset($_POST['customdesign-section']))
                                $data = $this->process_save_data($field, $data);
                        }
                    }
                }
            } else {
                foreach ($args as $i => $field) {
                    if (isset($field['name'])) {
                        $args[$i]['value'] = $customdesign->get_option($field['name']);
                        if (isset($_POST['customdesign-section']))
                            $data = $this->process_save_data($field, $data);
                    }
                }
            }
            
            if (isset($_POST['customdesign-section'])) {
                
                if (isset($_POST['admin_email']) && !empty($_POST['admin_email'])) {
                    if ($customdesign->cfg->settings['admin_email'] != trim($_POST['admin_email'])) {
                        if (filter_var(trim($_POST['admin_email']), FILTER_VALIDATE_EMAIL)) {
                            $customdesign->set_option('admin_email', trim($_POST['admin_email']));
                        } else array_push($data['errors'], $customdesign->lang('Error: Invalid email format'));
                    }
                    if (isset($_POST['admin_password']) && !empty($_POST['admin_password'])) {
                        if (
                            !isset($_POST['re_admin_password']) || 
                            empty($_POST['re_admin_password']) ||
                            $_POST['admin_password'] != $_POST['re_admin_password'] ||
                            strlen($_POST['admin_password']) < 8
                        ) {
                            array_push($data['errors'], $customdesign->lang('Error: Admin Passwords do not match or less than 8 characters'));
                        }else{
                            $customdesign->set_option('admin_password', md5(trim($_POST['admin_password'])));
                        }
                    }
                }
                
                if (
                    $_POST['customdesign-section'] == 'settings' &&
                    count($data['errors']) === 0 && 
                    !$customdesign->lib->render_css($data)
                ) {
                    $data['errors'][] = $customdesign->lang('Could not save the custom css to file');
                    foreach ($data as $key => $val) {
                        $customdesign->set_option($key, $val);
                    }
                    $customdesign->set_option('last_update', time());
                }
                
                if (count($data['errors']) === 0) {
        
                    unset($data['errors']);
                    
                    if ($_POST['customdesign-section'] == 'settings') {
                            
                        $customdesign->lib->render_css($data);
                        
                        $customdesign->set_option('last_update', time());
                        
                        $customdesign->apply_filters('after_save_settings', $data);
                        
                    }
                    
                    foreach ($data as $key => $val) {
                        $customdesign->set_option($key, $val);
                    }
                    
                    $customdesign->connector->set_session('customdesign_msg', array('status' => 'success'));
        
                    if (!isset($_POST['customdesign-redirect']))
                        $customdesign->redirect($customdesign->cfg->admin_url . "customdesign-page=settings");
                    else $customdesign->redirect($_POST['customdesign-redirect']);
                    
                    exit;
        
                } else {
                    $customdesign->connector->set_session('customdesign_msg', array('status' => 'error', 'errors' => $data['errors']));
                    $customdesign->redirect($customdesign->cfg->admin_url . "customdesign-page=settings");
                    exit;
                }
                
            }
            
            return $args;

        }
        
        public function render_custom_css($css) {
            
            global $customdesign;
            $path = $customdesign->cfg->root_path.'assets'.DS.'css'.DS.'custom.css';

            if (!empty($css)) {
                $content = str_replace(
                    array('&gt;', '; ', ' }', '{ ', "\r\n", "\r", "\n", "\t",'  ','    ','    '),
                    array('>', ';', '}', '{', '', '', '', '', '', '', ''),
                    $css
                );
                @file_put_contents($path, stripslashes($content));
            }
        }
        
        public function process_actions(){
            // 680-1549 added codes
        }
        
        public function check_caps($cap) {
            
            $data_action = isset($_POST['action']) ? $_POST['action'] : '';
            
            if (
                in_array($data_action, array('active', 'deactive', 'delete')) &&
                !$this->main->caps('customdesign_edit_'.$cap)
            ) {
                $this->main->connector->set_session('customdesign_msg', array(
                        'status' => 'error', 
                        'errors' => array($this->main->lang('Sorry, you are not allowed to do this action'))
                    )
                );
                echo '<script type="text/javascript">window.location.reload();</script></body></html>';
                exit;
            }
        }
        
    }

    class customdesign_helper {

        public function breadcrumb($customdesign_page, $type = null) {

            global $customdesign;
            global $customdesign_router;
            return;
            $arr = $customdesign->apply_filters('admin_breadcrumb', array(
                'cliparts' => array(
                    'title' => $customdesign->lang('Cliparts'),
                    'link'   => $customdesign->cfg->admin_url.'customdesign-page=cliparts',
                    'child' => array(
                        'clipart' => array(
                            'type'   => '',
                            'title'  => $customdesign->lang('Clipart'),
                            'link'   => $customdesign->cfg->admin_url.'customdesign-page=clipart',
                        ),
                        'categories' => array(
                            'type'   => 'cliparts',
                            'title'  => $customdesign->lang('Categories'),
                            'link'   => $customdesign->cfg->admin_url.'customdesign-page=categories&type=cliparts',
                        ),
                        'category' => array(
                            'type'   => 'cliparts',
                            'title'  => $customdesign->lang('Category'),
                            'link'   => $customdesign->cfg->admin_url.'customdesign-page=category&type=cliparts',
                        ),
                        'tags' => array(
                            'type'   => 'cliparts',
                            'title'  => $customdesign->lang('Tags'),
                            'link'   => $customdesign->cfg->admin_url.'customdesign-page=tags&type=cliparts',
                        ),
                        'tag' => array(
                            'type'   => 'cliparts',
                            'title'  => $customdesign->lang('Tag'),
                            'link'   => $customdesign->cfg->admin_url.'customdesign-page=tag&type=cliparts',
                        ),
                    ),
                ),
                'designs' => array(
                    'title' => $customdesign->lang('Designs'),
                    'link'   => $customdesign->cfg->admin_url.'customdesign-page=designs',
                    'child' => array(
                        'design' => array(
                            'type'   => '',
                            'title'  => $customdesign->lang('Design'),
                            'link'   => $customdesign->cfg->admin_url.'customdesign-page=design',
                        ),
                    ),
                ),
                'templates' => array(
                    'title' => $customdesign->lang('Templates'),
                    'link'   => $customdesign->cfg->admin_url.'customdesign-page=templates',
                    'child' => array(
                        'template' => array(
                            'type'   => '',
                            'title'  => $customdesign->lang('Template'),
                            'link'   => $customdesign->cfg->admin_url.'customdesign-page=template',
                        ),
                        'categories' => array(
                            'type'   => 'templates',
                            'title'  => $customdesign->lang('Categories'),
                            'link'   => $customdesign->cfg->admin_url.'customdesign-page=categories&type=templates',
                        ),
                        'category' => array(
                            'type'   => 'templates',
                            'title'  => $customdesign->lang('Category'),
                            'link'   => $customdesign->cfg->admin_url.'customdesign-page=category&type=templates',
                        ),
                        'tags' => array(
                            'type'   => 'templates',
                            'title'  => $customdesign->lang('Tags'),
                            'link'   => $customdesign->cfg->admin_url.'customdesign-page=tags&type=templates',
                        ),
                        'tag' => array(
                            'type'   => 'templates',
                            'title'  => $customdesign->lang('Tag'),
                            'link'   => $customdesign->cfg->admin_url.'customdesign-page=tag&type=templates',
                        ),
                    ),
                ),
                'products' => array(
                    'title' => $customdesign->lang('Products'),
                    'link'   => $customdesign->cfg->admin_url.'customdesign-page=products',
                    'child' => array(
                        'product' => array(
                            'type'   => '',
                            'title'  => $customdesign->lang('Product'),
                            'link'   => $customdesign->cfg->admin_url.'customdesign-page=product',
                        ),
                        'categories' => array(
                            'type'   => 'products',
                            'title'  => $customdesign->lang('Product Categories'),
                            'link'   => $customdesign->cfg->admin_url.'customdesign-page=categories&type=products',
                        ),
                        'category' => array(
                            'type'   => 'products',
                            'title'  => $customdesign->lang('Add New Category'),
                            'link'   => $customdesign->cfg->admin_url.'customdesign-page=category&type=products',
                        ),
                    ),
                ),
                'shapes' => array(
                    'title' => $customdesign->lang('Shapes'),
                    'link'   => $customdesign->cfg->admin_url.'customdesign-page=shapes',
                    'child' => array(
                        'shape' => array(
                            'type'   => '',
                            'title'  => $customdesign->lang('Shape'),
                            'link'   => $customdesign->cfg->admin_url.'customdesign-page=shape',
                        ),
                    ),
                ),
                'addons' => array(
                    'title' => $customdesign->lang('Addons'),
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
                    ),
                ),
                'printings' => array(
                    'title' => $customdesign->lang('Printing Type'),
                    'link'   => $customdesign->cfg->admin_url.'customdesign-page=printings',
                    'child' => array(
                        'printing' => array(
                            'type'   => '',
                            'title'  => $customdesign->lang('Printing'),
                            'link'   => $customdesign->cfg->admin_url.'customdesign-page=printing',
                        ),
                    ),
                ),
                'fonts' => array(
                    'title' => $customdesign->lang('Fonts'),
                    'link'   => $customdesign->cfg->admin_url.'customdesign-page=fonts',
                    'child' => array(
                        'font' => array(
                            'type'   => '',
                            'title'  => $customdesign->lang('Edit Font'),
                            'link'   => $customdesign->cfg->admin_url.'customdesign-page=font',
                        )
                    ),
                ),
                'languages' => array(
                    'title' => $customdesign->lang('Languages'),
                    'link'   => $customdesign->cfg->admin_url.'customdesign-page=languages',
                    'child' => array(
                        'language' => array(
                            'type'   => '',
                            'title'  => $customdesign->lang('Language'),
                            'link'   => $customdesign->cfg->admin_url.'customdesign-page=language',
                        ),
                    ),
                ),
                'orders' => array(
                    'title' => $customdesign->lang('Orders'),
                    'link'   => $customdesign->cfg->admin_url.'customdesign-page=orders',
                ),
                'settings' => array(
                    'title' => $customdesign->lang('Settings'),
                    'link'   => $customdesign->cfg->admin_url.'customdesign-page=settings',
                )
            ));

            $html = '<ul class="customdesign_breadcrumb">';
            
            foreach ($arr as $keys => $values) {


                if ($keys == $customdesign_page) {

                    $html .= '<li><a href="'.$customdesign->cfg->admin_url.'customdesign-page=dashboard">'.$customdesign->lang('Dashboard').'</a></li><li><span>'.$values['title'].'</span></li>';

                }

                if (isset($values['child'])) {

                    if (isset($values['child'][$customdesign_page]) && $values['child'][$customdesign_page]['type'] == $type) {

                        $html .= '<li><a href="'.$customdesign->cfg->admin_url.'customdesign-page=dashboard">'.$customdesign->lang('Dashboard').'</a></li><li><a href="'.$values['link'].'">'.$values['title'].'</a></li>';

                    }

                    foreach ($values['child'] as $key => $child) {

                        if ($key == $customdesign_page && $child['type'] == $type) {

                            $html .= '<li><span>'.$child['title'].'</span></li>';

                        }

                    }

                }

            }

            $html .= '</ul>';
            
            ob_start();
                $customdesign->views->header_message();
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
            
            if (!$this->main->caps('customdesign_can_upload')) {
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

            global $customdesign, $customdesign_router;
            
            for ($i = 0; $i < count($shapes); $i++) {
                $customdesign->db->insert('shapes', array(
                    "name" => "Shape ".($i+1),
                    "content" => $shapes[$i],
                    "author" => $customdesign->vendor_id,
                    "active" => 1,
                    "created" => date("Y-m-d").' '.date("h:i:sa"),
                    "updated" => date("Y-m-d").' '.date("h:i:sa"),
                ));
            }

            $customdesign->redirect($customdesign->cfg->admin_url.'customdesign-page=shapes');

        }

    }

    global $customdesign_admin, $customdesign_pagination;
    $customdesign_admin = new customdesign_admin();
    $customdesign_pagination = new customdesign_pagination();
    $customdesign_helper = new customdesign_helper();
