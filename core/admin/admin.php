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
                    
                    $lumise->db->rawQuery("DELETE FROM `{$lumise->db->prefix}categories_reference` WHERE `item_id`='{$id}' AND `type`='{$field['cate_type']}'");
                    
                    if (is_array($post_cates) && count($post_cates) > 0) {
                        foreach ($post_cates as $cate) {
                            $lumise_admin->add_row(array(
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

        public function process_filed($args, $name) {

            global $customdesign

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

                            if (isset($))
                        }
                    }
                }
            }
        }
    }

}