<div class="wrapper">
    
<div class="bannertop"></div>

<div class="realtygusto homehead">
    <div class="container">
        <div class="home">
            <h1>Forgot your password?</h1>
        </div>
    </div>
</div>

<div class="container">

    <div class="bg-box">
        Provide the email address you use to login to your account.
        <div class="spacer"></div>
        
        <?php $message = validation_errors(); ?>
        <?php if(!empty($message) || (isset($error_message) && !empty($error_message)) ) { ?><div class="alert alert-error alert-block"><a class="close" data-dismiss="alert" href="#">&times;</a><?php echo $message . (isset($error_message) ? $error_message : ''); ?></div><?php } ?>
        <form action="<?php echo site_url('account/forgot-password'); ?>" method="post" class="form-inline">
            <input type="text" id="userlogin" name="userlogin" class="input-large" placeholder="Email Address" value="<?php echo set_value('userlogin'); ?>" />
            <button type="submit" name="submit" class="btn">Email me for instructions</button>
        </form>
    </div>
    
    <div class="spacer"></div>
    <div class="push"></div>

</div> <!-- /container -->

</div> <!-- /wrapper -->

<div class="solo-foot footer">
    By using <a href="<?php echo site_url('wiki/about-propertyfinder'); ?>">propertyfinder.com</a>, you agree to it's <a href="<?php echo site_url('wiki/terms-of-use'); ?>">Terms of Use</a>
</div>