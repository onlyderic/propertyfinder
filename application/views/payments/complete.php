<div class="wrapper">
    
<div class="bannertop"></div>

<div class="realtygusto homehead">
    <div class="container">
        <div class="home">
            <?php if($mode == 'property') { ?>
            <h1>Thank you for using propertyfinder's Property Feature!</h1>
            <?php } else { ?>
            <h1>Thank you for using propertyfinder.com!</h1>
            <?php } ?>
        </div>
    </div>
</div>

<div class="container">

    <div class="bg-box">
        
        The process has been completed. Please wait for a moment while PayPal will confirm the transaction.
        <br/>
        If you encounter a problem with this transaction, please report it to us at <a href="mailto:report@propertyfinder.com">report@propertyfinder.com</a>
        <br/><br/>
        The voucher for this transaction has been sent to your email.
        
        <div class="spacer"></div>
        <div align="center">
            <?php if($mode == 'property') { ?>
            <input class="btn btn-primary btn-large property-detail" type="button" value="View property detail" />&nbsp;
            <?php } ?>
            <input class="btn btn-primary btn-large my-account" type="button" value="Go to My Account" />
        </div>
        
    </div>
    
    <div class="spacer"></div>
    <div class="push"></div>

</div> <!-- /container -->

</div> <!-- /wrapper -->

<?php $this->load->view('footer_summary'); ?>

<script type="text/javascript">
head.ready(function() {
    <?php if($mode == 'property' && $name != '' && $code != '') { ?>
    purl = baseurl+'<?php echo 'property/' . $name . '/' . $code; ?>';
    <?php } ?>
});
</script>