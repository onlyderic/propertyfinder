<div class="wrapper">
    
<div class="bannertop"></div>

<div class="container">

    <div class="bg-container">
    
        <div class="bg-strip">
            <h3>Feature My Profile</h3>
            <h5>Get noticed! Put your profile on top of agent listings.</h5>
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

                                <section id="feature-agent">
                                    
                                    <div class="spacer"></div>
        
                                    <?php if(!empty($message)) { ?><div class="alert alert-<?php echo $message_status; ?>"><?php echo $message; ?><a class="close" data-dismiss="alert" href="#">&times;</a></div><?php } ?>
                                    <?php
                                    $errs = validation_errors();
                                    if(!empty($errs) && $record->featured != YES) {
                                    ?>
                                        <div class="alert alert-error">There are errors on the form. Please correct and continue.<a class="close" data-dismiss="alert" href="#">&times;</a></div>
                                    <?php } ?>
                                        
                                    <div align="center">
                                        <ul class="proplist">
                                            <li>                
                                                <?php $userfullname = $record->fname . ' ' . $record->lname; ?>
                                                <?php $userlink = site_url( ( $record->usertype == USERTYPE_COMPANY ? 'company/' : 'agent/' ) . url_title($userfullname) . '/' . $record->code); ?>
                                                <div class="agentlistitem">
                                                    <div class="userthumb">
                                                        <a href="<?php echo $userlink; ?>" title="<?php echo $userfullname; ?>">
                                                            <img src="<?php echo site_url(). ( empty($record->profilepic) ? 'assets/img/agent150.png' : ( $record->usertype == USERTYPE_COMPANY ? 'realties/' : 'profiles/' ) . $record->profilepic ); ?>" style="height:100px;max-height:100px;max-width:150px;">
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

                                    <?php if($record->featured == YES) { ?>

                                        <div class="alert alert-info">
                                            This is a currently featured profile.
                                        </div>

                                    <?php } else { ?>

                                        <?php 
                                        $err = form_error('pckg');
                                        if($err != '') {
                                        ?>
                                            <div class="alert alert-error">Please select a package for this feature.<a class="close" data-dismiss="alert" href="#">&times;</a></div>
                                        <?php } ?>
                                            
                                        <div data-toggle="buttons-radio" align="center">
                                            <button type="button" class="btn btn-large btn-warning form-opt <?php echo ( $pckg == '30DAYS' ? 'active' : ''); ?>" data-mod="form-pckg" data-value="30DAYS">
                                                <strong style="font-size:27px;">30 Days</strong>
                                                <br/><br/>25.00 USD
                                            </button>
                                            <button type="button" class="btn btn-large btn-warning form-opt <?php echo ( $pckg == '90DAYS' ? 'active' : ''); ?>" data-mod="form-pckg" data-value="90DAYS">
                                                <strong style="font-size:27px;">90 Days</strong>
                                                <br/><br/>52.50 USD
                                            </button>
                                            <button type="button" class="btn btn-large btn-warning form-opt <?php echo ( $pckg == '180DAYS' ? 'active' : ''); ?>" data-mod="form-pckg" data-value="180DAYS">
                                                <strong style="font-size:27px;">180 Days</strong>
                                                <br/><br/>105.00 USD
                                            </button>
                                            <button type="button" class="btn btn-large btn-warning form-opt <?php echo ( $pckg == '360DAYS' ? 'active' : ''); ?>" data-mod="form-pckg" data-value="360DAYS">
                                                <strong style="font-size:27px;">360 Days</strong>
                                                <br/><br/>199.00 USD
                                            </button>
                                            <div style="display:none;">
                                                <input type="radio" id="form-pckg-30DAYS" name="pckg" value="30DAYS" <?php echo set_radio('pckg', '30DAYS', ($pckg == '30DAYS' ? true : false) ); ?> />
                                                <input type="radio" id="form-pckg-90DAYS" name="pckg" value="90DAYS" <?php echo set_radio('pckg', '90DAYS', ($pckg == '90DAYS' ? true : false) ); ?> />
                                                <input type="radio" id="form-pckg-180DAYS" name="pckg" value="180DAYS" <?php echo set_radio('pckg', '180DAYS', ($pckg == '180DAYS' ? true : false) ); ?> />
                                                <input type="radio" id="form-pckg-360DAYS" name="pckg" value="360DAYS" <?php echo set_radio('pckg', '360DAYS', ($pckg == '360DAYS' ? true : false) ); ?> />
                                            </div>
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