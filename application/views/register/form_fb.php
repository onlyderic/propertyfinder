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
        
        <?php if(!empty($message)) { ?><div class="alert alert-error alert-block"><a class="close" data-dismiss="alert" href="#">&times;</a><?php echo $message; ?></div><?php } ?>
        
        <div class="fb-registration"
            data-fields='[{"name":"name"},
                            {"name":"email"},
                            {"name":"password"}]' 
            data-redirect-uri="<?php echo site_url('register/facebook'); ?>">
        </div>
        
        <div id="fb-root"></div>
        <script type="text/javascript">
          window.fbAsyncInit = function() {
            FB.init({
              appId      : '492334204146422',
              status     : true,
              xfbml      : true
            });
          };
          (function(d){
             var js, id = 'facebook-jssdk'; if (d.getElementById(id)) {return;}
             js = d.createElement('script'); js.id = id; js.async = true;
             js.src = "//connect.facebook.net/en_US/all.js";
             d.getElementsByTagName('head')[0].appendChild(js);
           }(document));
        </script>
    </div>
    
    <div class="spacer"></div>
    <div class="push"></div>
    
</div> <!-- /container -->

</div> <!-- /wrapper -->

<div class="solo-foot footer">
    By signing up, you agree to <a href="<?php echo site_url('wiki/about-propertyfinder'); ?>" target="_blank">propertyfinder.com</a>'s <a href="<?php echo site_url('wiki/terms-of-use'); ?>" target="_blank">Terms of Use</a>
</div>