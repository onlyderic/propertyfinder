<div class="wrapper">
    
<div class="bannertop"></div>

<div class="realtygusto homehead">
    <div class="container">
        <div class="home">
            <h1>Sign up. It's FREE!</h1>
        </div>
    </div>
</div>

<div class="container">

    <div class="bg-box">

        Already a propertyfinder? <a href="<?php echo site_url('login'); ?>">Login here!</a>
        <div class="spacer"></div>
        
        <?php $message = validation_errors(); ?>
        <?php if(!empty($message)) { ?><div class="alert alert-error alert-block"><a class="close" data-dismiss="alert" href="#">&times;</a><?php echo $message; ?></div><?php } ?>
        <div class="spacer"></div>
        <form action="<?php echo site_url('register/twitter-phase-1'); ?>" method="post" accept-charset="UTF-8" class="form-horizontal">
            <?php $err = form_error('useremail'); ?>
            <div class="control-group <?php echo ($err != '' ? 'error' : ''); ?>">
                <label class="control-label" for="useremail" style="width:100px;">Email</label>
                <div class="controls" style="margin-left:0px;">
                    <input type="text" id="useremail" name="useremail" maxlength="300" class="span4" placeholder="Email Address" value="<?php echo set_value('useremail'); ?>" />
                </div>
            </div>
            <div align="center">
                <input class="btn btn-large" type="submit" name="register" value="Proceed to Twitter Authentication" />
            </div>
            <div class="spacer"></div>
            <div align="center">
                <a href="#" class="twitter-ask">Why are we asking this?</a>
            </div>
        </form>
    </div>
    
    <div class="spacer"></div>
    <div class="push"></div>
    
</div> <!-- /container -->

</div> <!-- /wrapper -->

<div class="solo-foot footer">
    By signing up, you agree to <a href="<?php echo site_url('wiki/about-propertyfinder'); ?>" target="_blank">propertyfinder.com</a>'s <a href="<?php echo site_url('wiki/terms-of-use'); ?>" target="_blank">Terms of Use</a>
</div>