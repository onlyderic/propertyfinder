<div class="wrapper">
    
<div class="bannertop"></div>

<div class="realtygusto homehead">
    <div class="container">
        <div class="home">
            <h1>Redirecting...</h1>
        </div>
    </div>
</div>

<div class="container">

    <div class="bg-box">
        <div class="spacer"></div>      
        <div class="spacer"></div>        
        <img src="<?php echo site_url('assets/img/spinner.gif'); ?>"> Please wait while we transfer you to the PayPal website.
        <div class="spacer"></div>
        
        <form id="frmpaypal" action="<?php echo ($this->config->item('paymentmode') == 'sandbox' ? 'https://www.sandbox.paypal.com/cgi-bin/webscr' : 'https://www.paypal.com/cgi-bin/webscr'); ?>" method="post">
            <input type="hidden" name="business" value="<?php echo $this->config->item('paypal_businessemail'); ?>" />
            <input type="hidden" name="cmd" value="_xclick" />
            <input type="hidden" name="return" value="<?php echo site_url() . $this->config->item('paypal_return') . (isset($purchase_urladd) ? '/' . $purchase_urladd : ''); ?>" />
            <input type="hidden" name="cancel_return" value="<?php echo site_url() . $this->config->item('paypal_cancel') . (isset($purchase_urladd) ? '/' . $purchase_urladd : ''); ?>" />
            <input type="hidden" name="notify_url" value='<?php echo site_url() . $this->config->item('paypal_notifyurl'); ?>' />
            <input type="hidden" name="currency_code" value="<?php echo $this->config->item('paypal_currency'); ?>" />
            <input type="hidden" name="lc" value="<?php echo $this->config->item('paypal_country'); ?>" />
            <input type="hidden" name="bn" value="PP-BuyNowBF" />
            <input type="hidden" name="quantity" value="1" />
            <input type="hidden" name="item_name" id="item_name" value="<?php echo $purchase_name; ?>" />
            <input type="hidden" name="item_number" id="item_number" value="<?php echo $purchase_id; ?>" />
            <input type="hidden" name="amount" id="amount" value="<?php echo $purchase_amount; ?>" />
            <input type="hidden" name="custom" id="custom" value="<?php echo $purchase_type; ?>" />
        </form>
    </div>
    
    <div class="spacer"></div>
    <div class="push"></div>

</div> <!-- /container -->

</div> <!-- /wrapper -->

<?php $this->load->view('footer_summary'); ?>

<script type="text/javascript">
    head.ready(function() { $('#frmpaypal').submit(); });
</script>