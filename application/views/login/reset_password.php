<?php if(isset($invalid_message)) { ?>

<div class="bannertop"></div>

<div class="realtygusto homehead">
    <div class="container">
        <div class="home">
            <h1>Link error.</h1>
        </div>
    </div>
</div>

<div class="container">

    <div class="bg-box">
        <div class="alert alert-info invalid-profile" align="center">
            Sorry, but there seems to be a problem with your link.<br/>
            Either it is an incorrect link or it's already an expired request.
            <br/><br/>
            Please check the link on your email again.
        </div>
        <div align="center">
            <input class="btn btn-primary btn-large btnlogin" type="button" value="Login" />
            <input class="btn btn-primary btn-large btnpassword" type="button" value="Forgot your password? Send a new request." />
        </div>
    </div>

</div> <!-- /container -->

<?php } else { ?>

<div class="wrapper">
    
<div class="bannertop"></div>

<div class="realtygusto homehead">
    <div class="container">
        <div class="home">
            <h1>Reset your password.</h1>
        </div>
    </div>
</div>

<div class="container">

    <div class="bg-box">
        Please provide your new password.
        <div class="spacer"></div>
        
        <?php $message = validation_errors(); ?>
        <?php if(!empty($redirect_message)) { ?><div class="alert alert-<?php echo $redirect_message_status; ?>"><a class="close" data-dismiss="alert" href="#">&times;</a><?php echo $redirect_message; ?></div><?php } ?>
        <?php if(!empty($message) || (isset($error_message) && !empty($error_message)) ) { ?><div class="alert alert-error alert-block"><a class="close" data-dismiss="alert" href="#">&times;</a><?php echo $message . (isset($error_message) ? $error_message : ''); ?></div><?php } ?>
        <form action="<?php echo site_url('account/reset-password/' . $key); ?>" method="post" class="form-horizontal">
            <?php $err = form_error('userpass'); ?>
            <div class="control-group <?php echo ($err != '' ? 'error' : ''); ?>">
                <label class="control-label" for="userpass" style="width:120px;">Password</label>
                <div class="controls" style="margin-left:150px;">
                    <input type="password" id="userpass" name="userpass" maxlength="30" class="span4" placeholder="Password" value="<?php echo set_value('userpass'); ?>" />
                </div>
            </div>
            <?php $err = form_error('usercpass'); ?>
            <div class="control-group <?php echo ($err != '' ? 'error' : ''); ?>">
                <label class="control-label" for="usercpass" style="width:120px;">Confirm</label>
                <div class="controls" style="margin-left:150px;">
                    <input type="password" id="usercpass" name="usercpass" maxlength="30" class="span4" placeholder="Confirm Password" value="<?php echo set_value('usercpass'); ?>" />
                </div>
            </div>
            <div align="center"><button type="submit" name="submit" class="btn">Update my password</button></div>
        </form>
    </div>
    
    <div class="spacer"></div>
    <div class="push"></div>

</div> <!-- /container -->

</div> <!-- /wrapper -->

<div class="solo-foot footer">
    By using <a href="<?php echo site_url('wiki/about-propertyfinder'); ?>">propertyfinder.com</a>, you agree to it's <a href="<?php echo site_url('wiki/terms-of-use'); ?>">Terms of Use</a>
</div>

<?php } ?>