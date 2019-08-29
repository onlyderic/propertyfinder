<div class="wrapper">
    
<div class="bannertop"></div>

<div class="container">

    <div class="bg-container">
    
        <div class="bg-strip">
            <h3>Verify My License</h3>
            <h5>Verified license is a testament of being a legal and true real estate agent who can be trusted in propertyfinder community.</h5>
        </div>
        
        <div class="bg-form-content">
                
            <div class="form-detail">
                
                <table cellpadding="0" cellmargin="0">
                    <tr>
                        <td class="form-container-left">
                            
                            <div class="spacer"></div>
            
                            <div align="center">
                                <button class="btn btn-large btn-primary formsave"><i class="icon-circle-arrow-right icon-white"></i> Continue to Payment</button>
                            </div>
                            
                            <div class="spacer"></div>
                        </td>
                        <td class="form-container-right">
                            
                            <form action="<?php echo current_url(''); ?>" class="form-horizontal" id="frmpropertyfinder" method="post">

                                <section id="verify-license">
                                    
                                    <div class="spacer"></div>
        
                                    <?php if(!empty($message)) { ?><div class="alert alert-<?php echo $message_status; ?>"><?php echo $message; ?><a class="close" data-dismiss="alert" href="#">&times;</a></div><?php } ?>
                                    <?php
                                    $errs = validation_errors();
                                    if(!empty($errs) && $record->verifiedagent != YES) {
                                    ?>
                                        <div class="alert alert-error">There are errors on the form. Please correct and continue.<a class="close" data-dismiss="alert" href="#">&times;</a></div>
                                    <?php } ?>
                                        
                                    <div align="center">
                                        <ul class="proplist">
                                            <li>                
                                                <?php $userfullname = $record->fname . ' ' . $record->lname; ?>
                                                <?php $userlink = site_url('agent/' . url_title($userfullname) . '/' . $record->code); ?>
                                                <div class="agentlistitem">
                                                    <div class="userthumb">
                                                        <a href="<?php echo $userlink; ?>" title="<?php echo $userfullname; ?>">
                                                            <img src="<?php echo site_url(). ( empty($record->profilepic) ? 'assets/img/agent150.png' : 'profiles/' . $record->profilepic ); ?>" style="height:100px;max-height:100px;max-width:150px;">
                                                        </a>
                                                    </div>
                                                    <div class="agentlistitemsum">
                                                        <?php $empties = ''; ?>
                                                        <a href="<?php echo $userlink; ?>"><strong><?php echo $userfullname; ?></strong></a>
                                                        <?php if( !empty($record->licensenum) ) { echo '<div>License No.: ' . $record->licensenum . '</div>'; } else { $empties .= '<div>&nbsp;</div>'; } ?>
                                                        <?php if( !empty($record->companyname) ) { echo '<div><a href="' . site_url('company/' . url_title($record->companyname) . '/' . $record->companycode) . '" title="' . $record->companyname . '">' . $record->companyname . '</a></div>'; } else { $empties .= '<div>&nbsp;</div>'; } ?>
                                                        <?php $location = ( !empty($record->city) ? $record->city : '' ) . ( !empty($record->city) && !empty($record->country) ? ', ' : '' ) . ( !empty($record->country) ? get_text_country($record->country) : '' ); ?>
                                                        <?php if( !empty($location) ) { echo '<div>' . $location . '</div>'; } else { $empties .= '<div>&nbsp;</div>'; } ?>
                                                        <?php echo $empties; ?>
                                                        <div class="spacer"></div>
                                                        <div class="clearfix"></div>
                                                        <div class="profposterdate">
                                                            <?php echo ( !empty($record->fdatecreated) ? 'Joined ' . $record->fdatecreated : '&nbsp;' ); ?>
                                                        </div>
                                                        <div class="profposterposts">
                                                            Posts: <?php echo ( !empty($record->numproperties) ? $record->numproperties : '0' ); ?>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                        <div>
                                                            <div class="profposterlevel">
                                                                <?php echo gettext_profile_level($record->level, true); ?>
                                                                <?php echo ( $record->verifiedagent == YES ? '<span class="badge badge-warning tooltip-propertyfinder" data-placement="top" data-title="This is a verified real estate agent!"><i class="icon-ok-sign"></i> Verified</span>' : '' ); ?>
                                                            </div>
                                                            <div class="clearfix"></div>
                                                        </div>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <input type="hidden" name="id" value="" />
                                    <div class="spacer"></div>
                                    <div class="spacer"></div>

                                    <?php if($record->verifiedagent == YES) { ?>

                                        <div class="alert alert-info">
                                            Your license is already verified.
                                        </div>

                                    <?php } else { ?>
                                    
                                        <div class="alert alert-info">
                                            <h5>Do you know that you can get a verified account for free?</h5>
                                            If your profile becomes popular by getting a large number of likes or high ratings from a considerable amount of your co-propertyfinders, we will automatically verify your profile for free!
                                        </div>
                                        <div class="spacer"></div>

                                        <div align="center">
                                            Thank you for your interest in our Verified Accounts.<br/>
                                            This will be a <strong>one-time process</strong> at only <strong>299.00 USD</strong>.
                                            <div class="spacer"></div>
                                            In the event of negative verification, you will be notified through email.<br/>
                                            Please take note that no refund of payment will be made.<br/>
                                            For successful verification, it will automatically reflect on your account.
                                            <div class="spacer"></div>
                                            <div class="spacer"></div>
                                            <strong>Please click Continue to Payment</strong><br/>
                                            to proceed with the processing of verifying your license.
                                        </div>

                                        <div class="spacer"></div>
                                        <!-- PayPal Logo --><table border="0" cellpadding="10" cellspacing="0" align="center"><tr><td align="center"></td></tr><tr><td align="center"><a href="https://www.paypal.com/webapps/mpp/paypal-popup" title="How PayPal Works" onclick="javascript:window.open('https://www.paypal.com/webapps/mpp/paypal-popup','WIPaypal','toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=1060, height=700'); return false;"><img src="https://www.paypalobjects.com/webstatic/mktg/logo/AM_SbyPP_mc_vs_dc_ae.jpg" border="0" alt="PayPal Acceptance Mark"></a></td></tr></table><!-- PayPal Logo -->

                                        <div align="center">
                                            By using <a href="<?php echo site_url('wiki/about-propertyfinder'); ?>">propertyfinder.com</a>, you agree to it's <a href="<?php echo site_url('wiki/terms-of-use'); ?>"><strong>Terms of Use</strong></a>
                                        </div>

                                    <?php } ?>
                    
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