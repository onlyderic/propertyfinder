<div class="wrapper">
    
<div class="bannertop"></div>

<div class="realtygusto homehead">
    <div class="container">
        <div class="home">
            <h1>Sign in.</h1>
        </div>
    </div>
</div>

<div class="container">

    <div class="bg-box">
        
        Don't have an account yet? <a href="<?php echo site_url('register'); ?>">Sign up here!</a>
        <div class="spacer"></div>
        
        <div align="left">
            <div style="padding:20px 0 0 0;" align="center">
                <?php if( isset($error_message) && !empty($error_message) ) { ?><div class="alert alert-error alert-block"><a class="close" data-dismiss="alert" href="#">&times;</a><?php echo $error_message; ?></div><?php } ?>
                <?php if(!empty($redirect_message)) { ?><div class="alert alert-<?php echo $redirect_message_status; ?>" align="left"><a class="close" data-dismiss="alert" href="#">&times;</a><?php echo $redirect_message; ?></div><?php } ?>
                <form action="<?php echo site_url('login'); ?>" method="post" accept-charset="UTF-8" class="form-horizontal">
                    
                    <?php if($show_captcha) { ?>
                    <div style="width:55%;">
                        <div class="alert alert-block alert-info" style="padding-left:50px;">
                            Enter the code exactly as it appears:<br/>
                            <?php echo $captcha_html; ?>
                            <?php $err = form_error('confirmationcode'); ?>
                            <div class="control-group <?php echo ($err != '' ? 'error' : ''); ?>" style="margin-top:10px;margin-bottom:0px;">
                                <input type="text" id="confirmationcode" name="confirmationcode" class="input-large" placeholder="Confirmation Code" value="" />
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                    <input type="hidden" id="call_reference" name="call_reference" value="<?php echo $call_reference; ?>" />
                    
                    <?php $err = form_error('userlogin'); ?>
                    <div class="control-group <?php echo ($err != '' ? 'error' : ''); ?>">
                        <label class="control-label" for="userlogin" style="width:150px;">Email Address</label>
                        <div class="controls" style="margin-left:0px;">
                            <input type="text" id="userlogin" name="userlogin" class="span4" placeholder="Email Address" value="<?php echo set_value('userlogin'); ?>" />
                        </div>
                    </div>
                    <?php $err = form_error('userpass'); ?>
                    <div class="control-group <?php echo ($err != '' ? 'error' : ''); ?>">
                        <label class="control-label" for="userpass" style="width:150px;">Password</label>
                        <div class="controls" style="margin-left:0px;">
                            <input type="password" id="userpass" name="userpass" maxlength="300" class="span4" placeholder="Password" value="<?php echo set_value('userpass'); ?>" />
                        </div>
                    </div>
                    <div class="pull-left span4" style="padding-top:15px;">
                        <div class="pull-left" style="padding-right:10px;">
                            <a href="<?php echo site_url('account/forgot-password'); ?>">Forgot your password?</a>
                        </div>
                        <div class="pull-left" style="padding-left:10px;">
                            <label class="checkbox">
                                <input type="checkbox" id="userremember" name="userremember" value="1" <?php echo set_checkbox('userremember', '1'); ?> /> Remember me
                            </label>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="pull-right span2" align="center">
                        <input class="btn btn-primary btn-large" type="submit" value="Login" />
                    </div>
                    <div class="clearfix"></div>
                </form>
            </div>
        </div>
        
        <div class="spacer"></div>
        <button class="btn btn-large btn-fb-login facebook-color" type="button"><i class="icon2-facebook-sign"></i> Login with Facebook</button>&nbsp;
        <button class="btn btn-large btn-twitter-login twitter-color" type="button"><i class="icon2-twitter-sign"></i> Login with Twitter</button>
        <div class="spacer"></div>
        
    </div>
    
    <div class="spacer"></div>
    <div class="push"></div>

</div> <!-- /container -->

</div> <!-- /wrapper -->

<div class="solo-foot footer">
    By using <a href="<?php echo site_url('wiki/about-propertyfinder'); ?>">propertyfinder.com</a>, you agree to it's <a href="<?php echo site_url('wiki/terms-of-use'); ?>">Terms of Use</a>
</div>

<?php if(isset($forgot_password) && !empty($forgot_password)) { ?>

<div id="modfp" class="modal hide fade">
  <div class="modal-header">
    <h3>Password Reset Sent!</h3>
  </div>
  <div class="modal-body">
    <p>We have sent you an email for instructions on how to reset your password.<br/><br/>Please check your email.</p>
  </div>
  <div class="modal-footer">
    <a href="#" data-dismiss="modal" class="btn btn-primary">Okay</a>
  </div>
</div>

<script type="text/javascript">
head.ready(function() {
    $('#modfp').modal('show');
});
</script>
<?php } ?>