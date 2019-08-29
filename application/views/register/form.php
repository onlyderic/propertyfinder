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
        <button class="btn btn-large btn-fb facebook-color" type="button"><i class="icon2-facebook-sign"></i> Sign up with Facebook</button>&nbsp;
        <button class="btn btn-large btn-twitter twitter-color" type="button"><i class="icon2-twitter-sign"></i> Sign up with Twitter</button>
        <div class="spacer"></div>
        <div class="spacer"></div>
        Or, sign up with your email address:
        <div class="spacer"></div>
        
        <?php $message = validation_errors(); ?>
        <?php if(!empty($message) || (isset($error_message) && !empty($error_message)) ) { ?><div class="alert alert-error alert-block"><a class="close" data-dismiss="alert" href="#">&times;</a><?php echo $message . (isset($error_message) ? $error_message : ''); ?></div><?php } ?>
        <form action="<?php echo site_url('register'); ?>" method="post" accept-charset="UTF-8" class="form-horizontal">
            <?php $err = form_error('username'); ?>
            <div class="control-group <?php echo ($err != '' ? 'error' : ''); ?>">
                <label class="control-label" for="username" style="width:100px;">Name</label>
                <div class="controls" style="margin-left:0px;">
                    <input type="text" id="username" name="username" maxlength="250" class="span4" placeholder="Name" value="<?php echo set_value('username'); ?>" />
                </div>
            </div>
            <?php $err = form_error('useremail'); ?>
            <div class="control-group <?php echo ($err != '' ? 'error' : ''); ?>">
                <label class="control-label" for="useremail" style="width:100px;">Email</label>
                <div class="controls" style="margin-left:0px;">
                    <input type="text" id="useremail" name="useremail" maxlength="300" class="span4" placeholder="Email Address" value="<?php echo set_value('useremail'); ?>" />
                </div>
            </div>
            <?php $err = form_error('userpass'); ?>
            <div class="control-group <?php echo ($err != '' ? 'error' : ''); ?>">
                <label class="control-label" for="userpass" style="width:100px;">Password</label>
                <div class="controls" style="margin-left:0px;">
                    <input type="password" id="userpass" name="userpass" maxlength="30" class="span4" placeholder="Password" value="<?php echo set_value('userpass'); ?>" />
                </div>
            </div>
            <?php $err = form_error('usercpass'); ?>
            <div class="control-group <?php echo ($err != '' ? 'error' : ''); ?>">
                <label class="control-label" for="usercpass" style="width:100px;">Confirm</label>
                <div class="controls" style="margin-left:0px;">
                    <input type="password" id="usercpass" name="usercpass" maxlength="30" class="span4" placeholder="Confirm Password" value="<?php echo set_value('usercpass'); ?>" />
                </div>
            </div>
            <input type="hidden" id="userme" name="userme" value="<?php echo set_value('userme'); ?>" />
            <div align="center">
                <div data-toggle="buttons-radio">
                    <button type="button" class="userme btn btn-inverse <?php echo ($userme == 'Regular' ? 'active' : ''); ?>" data-value="Regular">Regular user</button>
                    <button type="button" class="userme btn btn-inverse <?php echo ($userme == 'Agent' ? 'active' : ''); ?>" data-value="Agent">I'm an agent</button>
                    <button type="button" class="userme btn btn-inverse <?php echo ($userme == 'Broker' ? 'active' : ''); ?>" data-value="Broker">I'm a broker</button>
                    <button type="button" class="userme btn btn-inverse <?php echo ($userme == 'Company' ? 'active' : ''); ?>" data-value="Company">I'm a company</button>
                </div>
                <div class="spacer"></div>
                <input class="btn btn-primary btn-large register" type="submit" name="register" value="Sign me up!" />
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