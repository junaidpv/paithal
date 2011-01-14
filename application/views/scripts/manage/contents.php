<?php echo $this->render('header.php'); ?>
<?php
$contents = $this->getContentsList();

?>
<div id="contents">
    <table>
        <caption><?php echo $this->translate->_('Contents'); ?></caption>
        <thead>
            <tr>
                <th><?php echo $this->translate->_('Name'); ?></th>
                <th><?php echo $this->translate->_('Title'); ?></th>
                <th><?php echo $this->translate->_('Created'); ?></th>
                <th><?php echo $this->translate->_('Modified'); ?></th>
            </tr>
        </thead>
        <tbody>
    <?php foreach($contents as $content) { ?>
            <tr>
                <td><?php echo $content->content_name; ?></td>
                <td><?php echo $content->content_title; ?></td>
                <td><?php echo $content->content_created; ?></td>
                <td><?php echo $content->content_modified; ?></td>
            </tr>
    <?php } ?>
        </tbody>
    </table>
</div>
<?php echo $this->render('side_menu.php'); ?>
<?php echo $this->render('footer.php'); ?>