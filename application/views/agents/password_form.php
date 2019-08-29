<div class="wrapper">
    
<div class="bannertop"></div>

<div class="container">

    <div class="bg-container">
    
        <div class="bg-strip">
            <h3>Update Your Password</h3>
            <h5>Secure your propertyfinder account with a strong password.</h5>
        </div>
        
        <div class="bg-form-content">
                
            <div class="form-detail">
                
                <table cellpadding="0" cellmargin="0">
                    <tr>
                        <td class="form-container-left">
                            
                            <div class="spacer"></div>
            
                            <div align="center">
                                <button class="btn btn-large btn-primary formsave"><i class="icon-circle-arrow-down icon-white"></i> Save</button>
                            </div>
                            
                            <div class="spacer"></div>
                        </td>
                        <td class="form-container-right">
                            
                            <form action="<?php echo current_url(''); ?>" class="form-horizontal" id="frmpropertyfinder" method="post">

                                <section id="change-password">

                                    <?php if(!empty($message)) { ?><div class="alert alert-<?php echo $message_status; ?>"><?php echo $message; ?><a class="close" data-dismiss="alert" href="#">&times;</a></div><?php } ?>
                                    <?php
                                    $errs = validation_errors();
                                    if(!empty($errs)) {
                                    ?>
                                        <div class="alert alert-error">There are errors on the form. Please correct and save again.<a class="close" data-dismiss="alert" href="#">&times;</a></div>
                                    <?php } ?>

                                    <h4>Change Password</h4>

                                    <?php $err = form_error('upass'); ?>
                                    <div class="control-group <?php echo ($err != '' ? 'error' : ''); ?>">
                                        <label class="control-label" for="upass">New Password</label>
                                        <div class="controls">
                                            <input type="password" id="upass" name="upass" class="span5" placeholder="New Password" maxlength="30" value="<?php echo set_value('upass'); ?>" />
                                        </div>
                                    </div>
                                    <?php $err = form_error('ucpass'); ?>
                                    <div class="control-group <?php echo ($err != '' ? 'error' : ''); ?>">
                                        <label class="control-label" for="ucpass">Confirm New Password</label>
                                        <div class="controls">
                                            <input type="password" id="ucpass" name="ucpass" class="span5" placeholder="Confirm New Password" maxlength="30" value="<?php echo set_value('ucpass'); ?>" />
                                            <?php if(!empty($err)) { ?><div class="alert alert-error form-inline-message"><?php echo $err; ?><a class="close" data-dismiss="alert" href="#">&times;</a></div><?php } ?>
                                        </div>
                                    </div>
                                </section>

                            </form>
                            
                            <div class="spacer"></div>
                        </td>
                    </tr>
                </table>
                
            </div>
            
        </div>
    </div>
    
    <div class="spacer"></div>
    <div class="push"></div>

</div> <!-- /container -->

</div> <!-- /wrapper -->

<?php $this->load->view('footer_summary'); ?>