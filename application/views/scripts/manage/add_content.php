<?php echo $this->render('header.php'); ?>
<div id="content">
    <form action="<?php echo $this->baseUrl; ?>/admin/content/add?submit=1"  method="post">
        <label><?php echo $this->translate->_('Content Name:'); ?></label>
        <input type="text" name="content_name" /><br />
        <label><?php echo $this->translate->_('Content Title:'); ?></label>
        <input type="text" name="content_title" /><br />
        <label><?php echo $this->translate->_('Content Publish Date and time:'); ?></label>
        <input type="text" name="content_publish_ts" /><br />
        <label><?php echo $this->translate->_('Content Text:'); ?></label>
        <textarea cols="30" rows="15" name="rev_text" ></textarea><br />
        <label><?php echo $this->translate->_('Content Format:'); ?></label>
        <input type="text" name="rformat_name" /><br />
        <input type="submit" value="<?php echo $this->translate->_('Submit'); ?>" />
    </form>
</div>
<?php echo $this->render('footer.php'); ?>