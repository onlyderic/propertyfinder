
<?php #Used by Shortlist, Recent Views, Comparisons ?>
<div id="dlgcfrm" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-body">
        <p id="dlgcfrmmsg"></p>
    </div>
    <div class="modal-footer">
        <button class="btn cancel" data-dismiss="modal" aria-hidden="true">Cancel</button>
        <button class="btn btn-primary confirm">Confirm</button>
    </div>
</div>
<?php #Used by Rater Boxes ?>
<div id="dlgcfrm2" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-body">
        <p id="dlgcfrmmsg2"></p>
    </div>
    <div class="modal-footer">
        <button class="btn cancel2" data-dismiss="modal" aria-hidden="true">No</button>
        <button class="btn btn-primary confirm2">Yes</button>
    </div>
</div>
<?php #Used by Property Item Cognito ?>
<div id="dlgcfrm3" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-body">
        <p id="dlgcfrmmsg3"></p>
    </div>
    <div class="modal-footer">
        <button class="btn cancel3" data-dismiss="modal" aria-hidden="true">No</button>
        <button class="btn btn-primary confirm3">Yes</button>
    </div>
</div>

<div id="dlgmsg" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-body">
        <p id="dlgmsgmsg"></p>
    </div>
    <div class="modal-footer">
        <button class="btn btn-primary" data-dismiss="modal">Okay</button>
    </div>
</div>
<div id="dlgprocess" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-body">
        Processing... <img src="<?php echo site_url('assets/img/spinner.gif'); ?>">
    </div>
</div>

<div id="dlgmessage" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>Send a message</h3>
    </div>
    <div class="modal-body">
        <div class="msgagent-hdr">
            <div class="pull-left span1 msgagentthumbs" align="center"></div>
            <div class="pull-left span4 msgagentname"></div>
            <div class="clearfix"></div>
        </div>
        <div align="center">
            <form id="frmreply" action="<?php echo site_url('messages/send_reply'); //Unused ?>" method="post" accept-charset="UTF-8">
                <div class="control-group">
                    <div class="controls">
                        <textarea class="span5 newmsg" id="newmsg" name="newmsg" placeholder="Your message"></textarea>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
        <button class="btn btn-primary confirmmessage" data-dismiss="modal">Send</button><span></span>
    </div>
</div>
<script>
head.js({jquery:"<?php echo site_url(); ?>assets/js/jquery.js"}, "<?php echo site_url(); ?>assets/js/jquery-ui.min.js", "<?php echo site_url(); ?>assets/js/bootstrap.min.js", "<?php echo site_url(); ?>assets/js/propertyfinder.js", "<?php echo site_url(); ?>assets/js/scrollpagination.min.js", "<?php echo site_url(); ?>assets/js/jquery.raty.min.js", function() {
    logged = '<?php echo $userlogin; ?>';
});
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

ga('create', 'UA-40207804-1', 'propertyfinder.com');
ga('send', 'pageview');
</script>
</body>
</html>