<div id="user-navigation">
    <?php if ($this->user()->loggedIn()) {
 ?>
        <ul>
            <li><a href="<?php echo $this->baseUrl . "/user/name/{$this->user->user_name}"; ?>" >
<?php if ($this->user()->info('display_name')) {
            echo $this->user()->info('display_name');
        } else {
            echo $this->user()->info('name');
        } ?>
                </a></li>
        </ul>
<?php } else { ?>
    <p><?php echo $this->translate->_('Welcome, Guest'); ?></p>
    <?php } ?>
</div>