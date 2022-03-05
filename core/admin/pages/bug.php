<?php
    global $customdesign;
    $section = 'bug';

    $fields = $customdesign_admin->process_data(array(
        array(
            'type' => 'text',
            'name' => 'content',
            'label' => $customdesign->lang('Content')
        ),
        array(
            'type' => 'dropbox',
            'name' => 'status',
            'label' => $customdesign->lang('Status'),
            'options' => array(
                'new' => 'New',
                'pending' => 'Pending',
                'fixed' => 'Fixed',
            )
        ),
    ), 'bugs');
    ?>

    <div class="customdesign_wrapper">
        <div class="customdesign_content">
            <?php
                $customdesign->views->detail_header(array(
                    'add' => $customdesign->lang('Add new bug'),
                    'edit' => '#'.isset($_GET['id']) ? intval($_GET['id']) : '',
                    'page' => $section
                ));
            ?>
            <form action="<?php echo $customdesign->cfg->admin_url; ?>customdesign-page=<?php echo $section.(isset($_GET['callback']) ? '&callback='.$_GET['callback'] : '') ?>" id="customdesign-clipart-form" method="post" class="customdesign-form" enctype="multipart/form-data">
                
                <?php $customdesign->view->tabs_render($fields) ?>

                <div class="customdesign_form_group customdesign_form_submit">
                    <input type="submit" class="customdesign-button customdesign-button-primary" value="<?php echo $customdesign->lang('Save Bug'); ?>"/>
                    <input type="hidden" name="do" value="action" />
                    <a class="customdesign_cansel" href="<?php echo $customdesign->cfg->admin_url;?>customdesign-page=bugs">
                        <?php echo $customdesign->lang('Cancel'); ?>
                    </a>
                    <input type="hidden" name="customdesign-section" value="<?php echo $section; ?>">
                </div>
            </form>
        </div>
    </div>