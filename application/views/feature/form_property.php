<div class="wrapper">
    
<div class="bannertop"></div>

<div class="container">

    <div class="bg-container">
    
        <div class="bg-strip">
            <h3>Feature My Property</h3>
            <h5>Turn your property to an eye-candy! Put its profile on top of property listings.</h5>
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

                                <section id="feature-property">
                                    
                                    <div class="spacer"></div>
                                    
                                    <div align="center">
                                        <ul class="proplist">
                                            <li>
                                                <div class="proplistitem-form-feature">
                                                    <div class="proplistitemsum">
                                                        <div class="featured">
                                                            <div class="proplistitemimg" align="center">
                                                                <a href="<?php echo site_url('property/' . url_title($record->name) . '/' . $record->code); ?>" class="proplistitemimglink" title="<?php echo $record->name; ?>" target="_blank">
                                                                    <img src="<?php echo site_url('photos/' . $record->code . '/thumbs/' . $record->profilepic); ?>" style="<?php echo (!empty($record->profilepicwidth) ? 'width:' . $record->profilepicwidth . 'px;' : '') . (!empty($record->profilepicheight) ? 'height:' . $record->profilepicheight . 'px;' : ''); ?>" >
                                                                </a>
                                                            </div>
                                                            
                                                            <div class="proplistitemname">
                                                                <a href="<?php echo site_url('property/' . url_title($record->name) . '/' . $record->code); ?>" class="proplistitemnamelink"><?php echo $record->name; ?></a>
                                                            </div>
                                                            <div class="proplistitemdtl">
                                                                <div style="padding:0 5px;">
                                                                    <div>
                                                                        <span>
                                                                            <a href="<?php echo site_url('properties/' . url_title(get_text_subcategory($record->subcategory)) ); ?>" class="proplistitemtypelink"><?php echo get_text_classification($record->classification); ?></a>
                                                                        </span> in 
                                                                        <span>
                                                                            <?php $location = $record->city . ( !empty($record->city) && !empty($record->country) ? ', ' : '' ) . ( !empty($record->country) ? get_text_country($record->country) : '' ); ?>
                                                                            <a href="<?php echo site_url('map/location') . '/' . str_replace('+', '%20', urlencode($location)); ?>" class="proplistitemloclink"><?php echo $location; ?></a>
                                                                        </span>
                                                                    </div>
                                                                    <div class="proplistitemprice"><?php echo money_symbol($record->priceunit) . format_money($record->pricemin) . ( !empty($record->pricemax) ? ' - ' . format_money($record->pricemax) : '' ); ?></div>
                                                                    <?php
                                                                    $summary = ( !empty($record->roomsmin) ? $record->roomsmin . ( !empty($record->roomsmax) ? '-' . $record->roomsmax : '' ) . ' Rooms' : '' );
                                                                    $summary .= ( !empty($record->areamin) ? ( !empty($summary) ? ' <span class="bullet">&bull;</span> ' : '' ) . format_number_whole($record->areamin) . ( !empty($record->areamax) ? ' to ' . format_number_whole($record->areamax) : '' ) . ' ' . $record->areaunit : '' );
                                                                    $summary .= ( !empty($record->datepublished) ? ( !empty($summary) ? ' <span class="bullet">&bull;</span> ' : '' ) . time_elapsed($record->datepublished) : '' );
                                                                    echo $summary;
                                                                    ?>
                                                                </div>
                                                            </div>
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
                                            This is a currently featured property.
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
                                                <br/><br/>45.00 USD
                                            </button>
                                            <button type="button" class="btn btn-large btn-warning form-opt <?php echo ( $pckg == '90DAYS' ? 'active' : ''); ?>" data-mod="form-pckg" data-value="90DAYS">
                                                <strong style="font-size:27px;">90 Days</strong>
                                                <br/><br/>94.50 USD
                                            </button>
                                            <button type="button" class="btn btn-large btn-warning form-opt <?php echo ( $pckg == '180DAYS' ? 'active' : ''); ?>" data-mod="form-pckg" data-value="180DAYS">
                                                <strong style="font-size:27px;">180 Days</strong>
                                                <br/><br/>189.00 USD
                                            </button>
                                            <button type="button" class="btn btn-large btn-warning form-opt <?php echo ( $pckg == '360DAYS' ? 'active' : ''); ?>" data-mod="form-pckg" data-value="360DAYS">
                                                <strong style="font-size:27px;">360 Days</strong>
                                                <br/><br/>249.00 USD
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