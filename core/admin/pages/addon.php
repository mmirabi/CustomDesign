<?php 

$section = 'addon';
$name = isset($_GET['name']) ? $_GET['name'] : '';

if (
    !isset($customdesign->addons->storage{$name}) ||
    !method_exists($customdesign->addons->storage->{$name}, 'settings')
) {
?>
<div class="customdesign_wrapper">
    <div class="customdesign_content">
        <div class="customdesign_header">
            <h2>
                <a href="<?php echo $customdesign->cfg->admin_url?>customdesign-page=addons" title="<?php echo $customdesign->lang('Back to Addons') ;?>">
            </a>
            <i class="fa fa-angle-right"></i>
            <?php echo str_replace(array('_', '-'), ' ', $name); ?>
            </h2>
        </div>
        <form action="<?php echo $customdesign->cfg->admin_url ?>customdesign-page=addons"></form>
    </div>
</div>
<?php
}
?>