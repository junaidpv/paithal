<div id="login-form">
    <form method="post" action="<?php echo $this->baseUrl.'/user/login' ?>" >
        <fieldset>
            <legend><?php echo $this->translate->_('Login') ?></legend>
            <label for="user_name"><?php echo $this->translate->_('Username:') ?></label>
            <input name="user_name" type="text" /><br />
            <label for="user_password"><?php echo $this->translate->_('Password:') ?></label>
            <input name="user_password" type="text" /><br />
            <input type="submit" value="<?php echo $this->translate->_('Submit') ?>" />
        </fieldset>
    </form>
</div>