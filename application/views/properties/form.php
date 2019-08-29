<div class="wrapper">
    
<div class="bannertop"></div>

<div class="container">

    <div class="bg-container">
    
        <div class="bg-strip">
            <h3>Property Posting</h3>
        </div>
        
        <div class="bg-form-content">
                
            <div class="form-detail">
                
                <table cellpadding="0" cellmargin="0">
                    <tr>
                        <td class="form-container-left" align="center">
                            
                            <div class="spacer"></div>
            
                            <div class="completion-bar">
                                <div>
                                    <div id="progressbar"><div id="progresslabel" class="progress-label" align="center"><?php echo $propcompletion; ?>% Complete</div></div>
                                </div>
                            </div>
                            <div>
                                <?php if($proprecstatus == PROPSTATUS_DRAFT) { ?>
                                <button class="btn btn-large btn-primary formpublish"><i class="icon-share icon-white"></i> Publish</button>&nbsp;
                                <?php } ?>
                                <button class="btn btn-large btn-primary formsave"><i class="icon-circle-arrow-down icon-white"></i> Save</button>
                            </div>
                            
                            <div class="spacer"></div>
                            <i class="muted" style="font-size:smaller;">Input fields marked with <?php echo REQUIRED_INPUT; ?> are compulsory fields</i>
                            
                            <div class="spacer"></div>
                        </td>
                        <td class="form-container-right">
                            
                            <form action="<?php echo current_url(); ?>" class="form-horizontal" id="frmpropertyfinder" method="post">

                                <ul class="nav nav-pills">
                                    <li class="active"><a href="#tabprofile" data-toggle="tab">Profile</a></li>
                                    <li><a href="#tabdetails" data-toggle="tab" class="tab-details" data-mode="">Details</a></li>
                                    <li><a href="#tabfff" data-toggle="tab" class="tab-fff" data-mode="">Furnishings, Features & Facilities</a></li>
                                    <li><a href="#tabvideo" data-toggle="tab" class="tab-video" data-mode="">Video</a></li>
                                    <li><a href="#tabmap" data-toggle="tab" class="tab-map" data-mode="">Map</a></li>
                                </ul>

                                <div class="spacer"></div>

                                <div class="tab-content">

                                    <div id="tabprofile" class="tab-pane active">
                                        
                                        <input type="hidden" name="id" value="<?php echo set_value('tempid', $tempid); ?>" />
                                        <input type="hidden" id="propcompletion" name="propcompletion" value="<?php echo set_value('propcompletion', $propcompletion); ?>" />
                                        <input type="hidden" id="pub" name="pub" value="" />

                                        <section id="photos">

                                            <?php if(!empty($message)) { ?><div class="alert alert-<?php echo $message_status; ?>"><a class="close" data-dismiss="alert" href="#">&times;</a><?php echo $message; ?></div><?php } ?>
                                            <?php
                                            $errs = validation_errors();
                                            if(!empty($errs)) {
                                            ?>
                                                <div class="alert alert-error">There are errors on the form. Please correct and save again.<a class="close" data-dismiss="alert" href="#">&times;</a></div>
                                            <?php } ?>
                                                
                                            <h4>Photos</h4>

                                            <div id="container">
                                                <div class="pull-left" style="width:350px;">
                                                    <span id="btnselectphotos" class="btn btn-success fileinput-button ">
                                                        <i class="icon-picture icon-white"></i>
                                                        <span>Select photos</span>
                                                    </span>
                                                    <span id="btnuploadphotos" class="btn btn-warning fileinput-button">
                                                        <i class="icon-upload icon-white"></i>
                                                        <span>Upload photos</span>
                                                    </span>
                                                    <i class="icon-info-sign tooltip-propertyfinder" data-placement="right" data-title="Select photos and click upload button. Limit the number of photos to maximum of 9 so your property will load faster." style="opacity:0.5;"></i> <i class="icon-info-sign tooltip-propertyfinder" data-placement="right" data-title="Select a default photo. It will become the profile picture for this property." style="opacity:0.5;"></i>
                                                </div>
                                                <div class="pull-left" style="width:200px;padding-top:5px;">
                                                    <div id="progress" class="progress progress-striped" style="display:none;">
                                                        <div class="bar" style="width: 0%;"></div>
                                                    </div>
                                                </div>
                                                <div class="clearfix"></div>
                                                <?php $err = form_error('profilepic'); ?>
                                                <?php $err = ($err == '' ? form_error('profilepic') : $err); ?>
                                                <?php if(!empty($err)) { ?><div class="alert alert-error form-inline-message">Upload at least 1 photo and select a default profile photo.<a class="close" data-dismiss="alert" href="#">&times;</a></div><?php } ?>
                                                <div id="filelist" style="margin-top:10px;">No runtime found.</div>
                                                <div class="well property-photos">

                                                    <div id="uploadedphotos"></div>
                                                    <div class="clearfix"></div>
                                                </div>
                                                <input type="hidden" id="profilepic" name="profilepic" value="<?php echo set_value('profilepic', $profilepic); ?>" />                    
                                            </div>
                                        </section>
                                
                                        <div class="spacer"></div>
            
                                        <section id="profile-information">

                                            <h4>Profile Information</h4>
                                            <?php $err = form_error('propname'); ?>
                                            <div class="control-group <?php echo ($err != '' ? 'error' : ''); ?>">
                                                <label class="control-label" for="propname">Property Name<?php echo REQUIRED_INPUT; ?></label>
                                                <div class="controls">
                                                    <input type="text" id="propname" name="propname" class="span5" placeholder="Property Name" maxlength="500" value="<?php echo set_value('propname', $propname); ?>" />
                                                </div>
                                            </div>
                                            <?php $err = form_error('proppost[]'); ?>
                                            <div class="control-group <?php echo ($err != '' ? 'error' : ''); ?>">
                                                <label class="control-label" for="proppost">Posting<?php echo REQUIRED_INPUT; ?></label>
                                                <div class="controls">
                                                    <div data-toggle="buttons-checkbox">
                                                        <button type="button" class="btn form-ck form-proppost <?php echo ( isset($proppost[PROPPOST_SALE]) ? 'active' : ''); ?>" data-mod="form-proppost" data-value="<?php echo PROPPOST_SALE; ?>">For SALE</button>
                                                        <button type="button" class="btn form-ck form-proppost <?php echo ( isset($proppost[PROPPOST_RENT]) ? 'active' : ''); ?>" data-mod="form-proppost" data-value="<?php echo PROPPOST_RENT; ?>">For RENT</button>
                                                        <button type="button" class="btn form-ck form-proppost <?php echo ( isset($proppost[PROPPOST_OWN]) ? 'active' : ''); ?>" data-mod="form-proppost" data-value="<?php echo PROPPOST_OWN; ?>">For RENT-TO-OWN</button>
                                                        <div style="display:none;">
                                                            <input type="checkbox" id="form-proppost-<?php echo PROPPOST_SALE; ?>" name="proppost[]" value="<?php echo PROPPOST_SALE; ?>" <?php echo set_checkbox('proppost[]', PROPPOST_SALE, (isset($proppost[PROPPOST_SALE]) ? true: false ) ); ?> />
                                                            <input type="checkbox" id="form-proppost-<?php echo PROPPOST_RENT; ?>" name="proppost[]" value="<?php echo PROPPOST_RENT; ?>" <?php echo set_checkbox('proppost[]', PROPPOST_RENT, (isset($proppost[PROPPOST_RENT]) ? true: false ) ); ?> />
                                                            <input type="checkbox" id="form-proppost-<?php echo PROPPOST_OWN; ?>" name="proppost[]" value="<?php echo PROPPOST_OWN; ?>" <?php echo set_checkbox('proppost[]', PROPPOST_OWN, (isset($proppost[PROPPOST_OWN]) ? true: false ) ); ?> />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php $err = form_error('proptype'); ?>
                                            <div class="control-group <?php echo ($err != '' ? 'error' : ''); ?>">
                                                <label class="control-label" for="proptype">Type<?php echo REQUIRED_INPUT; ?></label>
                                                <div class="controls">
                                                    <select id="proptype" name="proptype" class="span5">
                                                        <option value=""></option>
                                                        <optgroup label="Residential">
                                                            <option value="<?php echo PROPSUBCATEGORY_R_CONDOMINIUM; ?>" <?php echo set_select('proptype', PROPSUBCATEGORY_R_CONDOMINIUM, ($proptype == PROPSUBCATEGORY_R_CONDOMINIUM ? true: false ) ); ?> >Condominium</option>
                                                            <option value="<?php echo PROPSUBCATEGORY_R_HOUSEANDLOT; ?>" <?php echo set_select('proptype', PROPSUBCATEGORY_R_HOUSEANDLOT, ($proptype == PROPSUBCATEGORY_R_HOUSEANDLOT ? true: false ) ); ?> >House and Lot</option>
                                                            <option value="<?php echo PROPSUBCATEGORY_R_APARTMENT; ?>" <?php echo set_select('proptype', PROPSUBCATEGORY_R_APARTMENT, ($proptype == PROPSUBCATEGORY_R_APARTMENT ? true: false ) ); ?> >Apartment</option>
                                                            <option value="<?php echo PROPSUBCATEGORY_R_HDB; ?>" <?php echo set_select('proptype', PROPSUBCATEGORY_R_HDB, ($proptype == PROPSUBCATEGORY_R_HDB ? true: false ) ); ?> >HDB</option>
                                                            <option value="<?php echo PROPSUBCATEGORY_R_BOARDINGHOUSE; ?>" <?php echo set_select('proptype', PROPSUBCATEGORY_R_BOARDINGHOUSE, ($proptype == PROPSUBCATEGORY_R_BOARDINGHOUSE ? true: false ) ); ?> >Boarding House</option>
                                                        </optgroup>
                                                        <optgroup label="Commercial">
                                                            <option value="<?php echo PROPSUBCATEGORY_C_OFFICE; ?>" <?php echo set_select('proptype', PROPSUBCATEGORY_C_OFFICE, ($proptype == PROPSUBCATEGORY_C_OFFICE ? true: false ) ); ?> >Office</option>
                                                            <option value="<?php echo PROPSUBCATEGORY_C_SOHO; ?>" <?php echo set_select('proptype', PROPSUBCATEGORY_C_SOHO, ($proptype == PROPSUBCATEGORY_C_SOHO ? true: false ) ); ?> >SOHO</option>
                                                            <option value="<?php echo PROPSUBCATEGORY_C_RETAIL; ?>" <?php echo set_select('proptype', PROPSUBCATEGORY_C_RETAIL, ($proptype == PROPSUBCATEGORY_C_RETAIL ? true: false ) ); ?> >Retail Shop</option>
                                                            <option value="<?php echo PROPSUBCATEGORY_C_INDUSTRIAL; ?>" <?php echo set_select('proptype', PROPSUBCATEGORY_C_INDUSTRIAL, ($proptype == PROPSUBCATEGORY_C_INDUSTRIAL ? true: false ) ); ?> >Industrial</option>
                                                        </optgroup>
                                                        <optgroup label="Land">
                                                            <option value="<?php echo PROPSUBCATEGORY_L_LANDONLY; ?>" <?php echo set_select('proptype', PROPSUBCATEGORY_L_LANDONLY, ($proptype == PROPSUBCATEGORY_L_LANDONLY ? true: false ) ); ?> >Land only</option>
                                                            <option value="<?php echo PROPSUBCATEGORY_L_LANDWITHSTRUCTURE; ?>" <?php echo set_select('proptype', PROPSUBCATEGORY_L_LANDWITHSTRUCTURE, ($proptype == PROPSUBCATEGORY_L_LANDWITHSTRUCTURE ? true: false ) ); ?> >Land with structure</option>
                                                            <option value="<?php echo PROPSUBCATEGORY_L_FARM; ?>" <?php echo set_select('proptype', PROPSUBCATEGORY_L_FARM, ($proptype == PROPSUBCATEGORY_L_FARM ? true: false ) ); ?> >Farm</option>
                                                            <option value="<?php echo PROPSUBCATEGORY_L_BEACH; ?>" <?php echo set_select('proptype', PROPSUBCATEGORY_L_BEACH, ($proptype == PROPSUBCATEGORY_L_BEACH ? true: false ) ); ?> >Beach</option>
                                                        </optgroup>
                                                        <optgroup label="Hotel">
                                                            <option value="<?php echo PROPSUBCATEGORY_H_HOTELRESORT; ?>" <?php echo set_select('proptype', PROPSUBCATEGORY_H_HOTELRESORT, ($proptype == PROPSUBCATEGORY_H_HOTELRESORT ? true: false ) ); ?> >Hotel/Resort</option>
                                                            <option value="<?php echo PROPSUBCATEGORY_H_PENSIONINN; ?>" <?php echo set_select('proptype', PROPSUBCATEGORY_H_PENSIONINN, ($proptype == PROPSUBCATEGORY_H_PENSIONINN ? true: false ) ); ?> >Pension Inn</option>
                                                            <option value="<?php echo PROPSUBCATEGORY_H_CONVENTIONCENTER; ?>" <?php echo set_select('proptype', PROPSUBCATEGORY_H_CONVENTIONCENTER, ($proptype == PROPSUBCATEGORY_H_CONVENTIONCENTER ? true: false ) ); ?> >Convention Center</option>
                                                        </optgroup>
                                                    </select>
                                                </div>
                                            </div>
                                            <?php $err = form_error('propclass'); ?>
                                            <div id="divpropclass" style="display:<?php echo (!empty($proptype) ? 'block' : 'none'); ?>;" class="control-group <?php echo ($err != '' ? 'error' : ''); ?>">
                                                <label class="control-label" for="propclass">Classification<?php echo REQUIRED_INPUT; ?></label>
                                                <div class="controls">
                                                    <select id="propclass" name="propclass" class="span5">
                                                        <option value=""></option>
                                                        <?php if( !empty($proptype) ) { ?>
                                                        <?php foreach($classifications[$proptype] as $k => $v) { ?>
                                                        <option value="<?php echo $k; ?>" <?php echo ($k == $propclass ? 'selected="selected"' : ''); ?>><?php echo $v; ?></option>
                                                        <?php } ?>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <?php $err = form_error('proppricemin'); ?>
                                            <?php $err = ($err == '' ? form_error('proppricemax') : $err); ?>
                                            <?php $err = ($err == '' ? form_error('proppriceunit') : $err); ?>
                                            <div class="control-group <?php echo ($err != '' ? 'error' : ''); ?>" align="left">
                                                <label id="lblpropprice" class="control-label" for="proppricemin"><?php echo $display_pricelabel; ?></label>
                                                <div class="controls">
                                                    <input type="text" id="proppricemin" name="proppricemin" class="span2 inline" placeholder="Price" maxlength="12" value="<?php echo set_value('proppricemin', $proppricemin); ?>" />
                                                    <input type="text" id="proppricemax" name="proppricemax" class="span2 inline" placeholder="" maxlength="12" value="<?php echo set_value('proppricemax', $proppricemax); ?>" <?php echo ($proppricerange == '1' ? '' : 'style="display:none;"'); ?> />
                                                    <select id="proppriceunit" name="proppriceunit" class="span1 inline">
                                                        <option value=""></option>
                                                        <?php foreach($currencies as $key => $val) { ?>
                                                        <option value="<?php echo $key; ?>" <?php echo set_select('proppriceunit', $key, ($proppriceunit == $key ? true: false ) ); ?> ><?php echo $key; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                    &nbsp;<a href="#" id="propprice" class="proprange"><?php echo ($proppricerange == '1' ? 'Remove range' : 'Create a range'); ?></a>
                                                    <input type="hidden" id="proppricerange" name="proppricerange" value="<?php echo set_value('proppricerange', $proppricerange); ?>" />
                                                    <?php if(!empty($err)) { ?><div class="alert alert-error form-inline-message">Prices should be valid numerical values.<a class="close" data-dismiss="alert" href="#">&times;</a><br/>If you're creating a range, both fields should be filled.<br/>Provide a unit.</div><?php } ?>
                                                </div>
                                            </div>
                                            <?php $err = form_error('propnegotiable[]'); ?>
                                            <div class="control-group <?php echo ($err != '' ? 'error' : ''); ?>">
                                                <label class="control-label" for="propnegotiable">Price Negotiable?</label>
                                                <div class="controls">
                                                    <div data-toggle="buttons-radio">
                                                        <button type="button" class="btn form-opt <?php echo ( isset($propnegotiable[YES]) ? 'active' : ''); ?>" data-mod="form-propnegotiable" data-value="<?php echo YES; ?>">Negotiable</button>
                                                        <button type="button" class="btn form-opt <?php echo ( isset($propnegotiable[NO]) ? 'active' : ''); ?>" data-mod="form-propnegotiable" data-value="<?php echo NO; ?>">Non-Negotiable</button>
                                                        <div style="display:none;">
                                                            <input type="radio" id="form-propnegotiable-<?php echo YES; ?>" name="propnegotiable[]" value="<?php echo YES; ?>" <?php echo set_radio('propnegotiable[]', YES, (isset($propnegotiable[YES]) ? true: false ) ); ?> />
                                                            <input type="radio" id="form-propnegotiable-<?php echo NO; ?>" name="propnegotiable[]" value="<?php echo NO; ?>" <?php echo set_radio('propnegotiable[]', NO, (isset($propnegotiable[NO]) ? true: false ) ); ?> />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php $err = form_error('propscheme'); ?>
                                            <div class="control-group <?php echo ($err != '' ? 'error' : ''); ?>">
                                                <label class="control-label" for="propscheme">
                                                    Payment Scheme
                                                    <i class="icon-info-sign tooltip-propertyfinder" data-placement="left" data-title="Description of Payments. Sample: 5 yrs. term: P73,957/month" style="opacity:0.5;"></i>
                                                </label>
                                                <div class="controls">
                                                    <textarea id="propscheme" name="propscheme" class="span5" placeholder="Payment Scheme"><?php echo set_value('propscheme', $propscheme); ?></textarea>
                                                </div>
                                            </div>
                                            <?php $err = form_error('propfinance[]'); ?>
                                            <div class="control-group <?php echo ($err != '' ? 'error' : ''); ?>">
                                                <label class="control-label" for="propfinance">Financing<?php echo REQUIRED_INPUT; ?></label>
                                                <div class="controls">
                                                    <div data-toggle="buttons-checkbox">
                                                        <button type="button" class="btn form-ck form-propfinance <?php echo ( isset($propfinance[PROPFINANCING_CASH]) ? 'active' : ''); ?>" data-mod="form-propfinance" data-value="<?php echo PROPFINANCING_CASH; ?>">Cash</button>
                                                        <button type="button" class="btn form-ck form-propfinance <?php echo ( isset($propfinance[PROPFINANCING_BANK]) ? 'active' : ''); ?>" data-mod="form-propfinance" data-value="<?php echo PROPFINANCING_BANK; ?>">Bank</button>
                                                        <button type="button" class="btn form-ck form-propfinance <?php echo ( isset($propfinance[PROPFINANCING_PAGIBIG]) ? 'active' : ''); ?>" data-mod="form-propfinance" data-value="<?php echo PROPFINANCING_PAGIBIG; ?>">Government Loans</button>
                                                        <div style="display:none;">
                                                            <input type="checkbox" id="form-propfinance-<?php echo PROPFINANCING_CASH; ?>" name="propfinance[]" value="<?php echo PROPFINANCING_CASH; ?>" <?php echo set_checkbox('propfinance[]', PROPFINANCING_CASH, (isset($propfinance[PROPFINANCING_CASH]) ? true: false ) ); ?> />
                                                            <input type="checkbox" id="form-propfinance-<?php echo PROPFINANCING_BANK; ?>" name="propfinance[]" value="<?php echo PROPFINANCING_BANK; ?>" <?php echo set_checkbox('propfinance[]', PROPFINANCING_BANK, (isset($propfinance[PROPFINANCING_BANK]) ? true: false ) ); ?> />
                                                            <input type="checkbox" id="form-propfinance-<?php echo PROPFINANCING_PAGIBIG; ?>" name="propfinance[]" value="<?php echo PROPFINANCING_PAGIBIG; ?>" <?php echo set_checkbox('propfinance[]', PROPFINANCING_PAGIBIG, (isset($propfinance[PROPFINANCING_PAGIBIG]) ? true: false ) ); ?> />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                
                                        <div class="spacer"></div>

                                        <section id="location">
                                            <h4>Address</h4>
                                            <?php $err = form_error('proploccountry'); ?>
                                            <?php $err = ($err == '' ? form_error('proploccity') : $err); ?>
                                            <div class="control-group <?php echo ($err != '' ? 'error' : ''); ?>">
                                                <label class="control-label" for="proploccity">Location<?php echo REQUIRED_INPUT; ?></label>
                                                <div class="controls">
                                                    <input type="text" id="proploccity" name="proploccity" class="span3 inline" placeholder="City" maxlength="25" value="<?php echo set_value('proploccity', $proploccity); ?>" />
                                                    <select id="proploccountry" name="proploccountry" class="span2 inline">
                                                        <option value=""></option>
                                                        <?php foreach($countries as $key => $val) { ?>
                                                        <option value="<?php echo $key; ?>" <?php echo set_select('proploccountry', $key, ($proploccountry == $key ? true: false ) ); ?> ><?php echo $val; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <?php $err = form_error('propaddress'); ?>
                                            <div class="control-group <?php echo ($err != '' ? 'error' : ''); ?>">
                                                <label class="control-label" for="propaddress">Address</label>
                                                <div class="controls">
                                                    <input type="text" id="propaddress" name="propaddress" class="span5" placeholder="Address" maxlength="500" value="<?php echo set_value('propaddress', $propaddress); ?>" />
                                                </div>
                                            </div>
                                            <?php $err = form_error('proppostal'); ?>
                                            <div class="control-group <?php echo ($err != '' ? 'error' : ''); ?>">
                                                <label class="control-label" for="proppostal">Postal Code</label>
                                                <div class="controls">
                                                    <input type="text" id="proppostal" name="proppostal" class="span5" placeholder="Postal Code" maxlength="10" value="<?php echo set_value('proppostal', $proppostal); ?>" />
                                                </div>
                                            </div>
                                        </section>
                                        
                                    </div>

                                    <div id="tabdetails" class="tab-pane">

                                        <section id="description">
                                            <h4>Description</h4>
                                            <?php $err = form_error('propdesc'); ?>
                                            <div class="control-group <?php echo ($err != '' ? 'error' : ''); ?>">
                                                <label class="control-label" for="propdesc">
                                                    Description&nbsp;
                                                    <i class="icon-info-sign tooltip-propertyfinder" data-placement="left" data-title="Complete description of the property. No HTML/CSS codes accepted." style="opacity:0.5;"></i>
                                                </label>
                                                <div class="controls">
                                                    <textarea id="propdesc" name="propdesc" class="span5" rows="10" placeholder="Description"><?php echo set_value('propdesc', $propdesc); ?></textarea>
                                                </div>
                                            </div>
                                        </section>

                                        <section id="developer">
                                            <h4>Developer</h4>
                                            <?php $err = form_error('propdeveloper'); ?>
                                            <div class="control-group <?php echo ($err != '' ? 'error' : ''); ?>">
                                                <label class="control-label" for="propdeveloper">Developer</label>
                                                <div class="controls">
                                                    <input type="hidden" id="propdeveloperid" name="propdeveloperid" value="<?php echo set_value('propdeveloperid', $propdeveloperid); ?>" />
                                                    <input type="text" id="propdeveloper" name="propdeveloper" class="span5" placeholder="Developer" maxlength="200" value="<?php echo set_value('propdeveloper', $propdeveloper); ?>" />
                                                </div>
                                            </div>
                                        </section>

                                        <section id="fees">
                                            <h4>Fees</h4>
                                            <?php $err = form_error('propreserve'); ?>
                                            <div class="control-group <?php echo ($err != '' ? 'error' : ''); ?>">
                                                <label class="control-label" for="propreserve">
                                                    Reservation Fee&nbsp;
                                                    <i class="icon-info-sign tooltip-propertyfinder" data-placement="left" data-title="Description of Reservation Fees. Sample: $10,000 Deductible from the price" style="opacity:0.5;"></i>
                                                </label>
                                                <div class="controls">
                                                    <input type="text" id="propreserve" name="propreserve" class="span5" placeholder="Reservation Fee" maxlength="1000" value="<?php echo set_value('propreserve', $propreserve); ?>" />
                                                </div>
                                            </div>
                                            <?php $err = form_error('propdown'); ?>
                                            <div class="control-group <?php echo ($err != '' ? 'error' : ''); ?>">
                                                <label class="control-label" for="propdown">
                                                    Down Payment&nbsp;
                                                    <i class="icon-info-sign tooltip-propertyfinder" data-placement="left" data-title="Description of Down Payment. Sample: 20% Payable in 1 year" style="opacity:0.5;"></i>
                                                </label>
                                                <div class="controls">
                                                    <input type="text" id="propdown" name="propdown" class="span5" placeholder="Down Payment" maxlength="1000" value="<?php echo set_value('propdown', $propdown); ?>" />
                                                </div>
                                            </div>
                                            <?php $err = form_error('propdiscount'); ?>
                                            <div class="control-group <?php echo ($err != '' ? 'error' : ''); ?>">
                                                <label class="control-label" for="propdiscount">
                                                    Discount&nbsp;
                                                    <i class="icon-info-sign tooltip-propertyfinder" data-placement="left" data-title="Description of price discounts." style="opacity:0.5;"></i>
                                                </label>
                                                <div class="controls">
                                                    <input type="text" id="propdiscount" name="propdiscount" class="span5" placeholder="Discount" maxlength="1000" value="<?php echo set_value('propdiscount', $propdiscount); ?>" />
                                                </div>
                                            </div>
                                        </section>
                                        
                                        <section id="detailed-information">
                                            <h4>Size</h4>

                                            <?php $err = form_error('proproommin'); ?>
                                            <?php $err = ($err == '' ? form_error('proproommax') : $err); ?>
                                            <div id="divproprooms" class="control-group <?php echo ($err != '' ? 'error' : ''); ?>" style="<?php echo $display_rooms; ?>">
                                                <label class="control-label" for="proproommin">Rooms</label>
                                                <div class="controls">
                                                    <select id="proproommin" name="proproommin" class="span2 inline">
                                                        <option value=""></option>
                                                        <option value="S" <?php echo set_select('proproommin', 'S', ($proproommin == 'S' ? true: false ) ); ?> >Studio/Bachelor's Pad</option>
                                                        <option value="1" <?php echo set_select('proproommin', '1', ($proproommin == '1' ? true: false ) ); ?> >1</option>
                                                        <option value="2" <?php echo set_select('proproommin', '2', ($proproommin == '2' ? true: false ) ); ?> >2</option>
                                                        <option value="3" <?php echo set_select('proproommin', '3', ($proproommin == '3' ? true: false ) ); ?> >3</option>
                                                        <option value="4" <?php echo set_select('proproommin', '4', ($proproommin == '4' ? true: false ) ); ?> >4</option>
                                                        <option value="5" <?php echo set_select('proproommin', '5', ($proproommin == '5' ? true: false ) ); ?> >5</option>
                                                        <option value="6" <?php echo set_select('proproommin', '6', ($proproommin == '6' ? true: false ) ); ?> >6</option>
                                                        <option value="7" <?php echo set_select('proproommin', '7', ($proproommin == '7' ? true: false ) ); ?> >7</option>
                                                        <option value="8" <?php echo set_select('proproommin', '8', ($proproommin == '8' ? true: false ) ); ?> >8</option>
                                                        <option value="9" <?php echo set_select('proproommin', '9', ($proproommin == '9' ? true: false ) ); ?> >9</option>
                                                        <option value="10" <?php echo set_select('proproommin', '10', ($proproommin == '10' ? true: false ) ); ?> >10</option>
                                                        <option value="11" <?php echo set_select('proproommin', '11', ($proproommin == '11' ? true: false ) ); ?> >11</option>
                                                        <option value="12" <?php echo set_select('proproommin', '12', ($proproommin == '12' ? true: false ) ); ?> >12</option>
                                                    </select>
                                                    <input type="text" id="proproommax" name="proproommax" class="span2 inline" maxlength="2" value="<?php echo set_value('proproommax', $proproommax); ?>" <?php echo ($proproomrange == '1' ? '' : 'style="display:none;"'); ?> />
                                                    &nbsp;<a href="#" id="proproom" class="proprange"><?php echo ($proproomrange == '1' ? 'Remove range' : 'Create a range'); ?></a>
                                                    <input type="hidden" id="proproomrange" name="proproomrange" value="<?php echo set_value('proproomrange', $proproomrange); ?>" />
                                                    <?php if(!empty($err)) { ?><div class="alert alert-error form-inline-message">Rooms should be valid numerical values.<a class="close" data-dismiss="alert" href="#">&times;</a><br/>If you're creating a range, both fields should be filled.</div><?php } ?>
                                                </div>
                                            </div>
                                            <?php $err = form_error('proptoiletmin'); ?>
                                            <?php $err = ($err == '' ? form_error('proptoiletmax') : $err); ?>
                                            <div id="divproptoilets" class="control-group <?php echo ($err != '' ? 'error' : ''); ?>" style="<?php echo $display_toilets; ?>">
                                                <label class="control-label" for="proptoiletmin">Toilets</label>
                                                <div class="controls">
                                                    <select id="proptoiletmin" name="proptoiletmin" class="span2 inline">
                                                        <option value=""></option>
                                                        <option value="1" <?php echo set_select('proptoiletmin', '1', ($proptoiletmin == '1' ? true: false ) ); ?> >1</option>
                                                        <option value="2" <?php echo set_select('proptoiletmin', '2', ($proptoiletmin == '2' ? true: false ) ); ?> >2</option>
                                                        <option value="3" <?php echo set_select('proptoiletmin', '3', ($proptoiletmin == '3' ? true: false ) ); ?> >3</option>
                                                        <option value="4" <?php echo set_select('proptoiletmin', '4', ($proptoiletmin == '4' ? true: false ) ); ?> >4</option>
                                                        <option value="5" <?php echo set_select('proptoiletmin', '5', ($proptoiletmin == '5' ? true: false ) ); ?> >5</option>
                                                    </select>
                                                    <input type="text" id="proptoiletmax" name="proptoiletmax" class="span2 inline" maxlength="2" value="<?php echo set_value('proptoiletmax', $proptoiletmax); ?>" <?php echo ($proptoiletrange == '1' ? '' : 'style="display:none;"'); ?> />
                                                    &nbsp;<a href="#" id="proptoilet" class="proprange"><?php echo ($proptoiletrange == '1' ? 'Remove range' : 'Create a range'); ?></a>
                                                    <input type="hidden" id="proptoiletrange" name="proptoiletrange" value="<?php echo set_value('proptoiletrange', $proptoiletrange); ?>" />
                                                    <?php if(!empty($err)) { ?><div class="alert alert-error form-inline-message">Toilets should be valid numerical values.<a class="close" data-dismiss="alert" href="#">&times;</a><br/>If you're creating a range, both fields should be filled.</div><?php } ?>
                                                </div>
                                            </div>
                                            <?php $err = form_error('propareamin'); ?>
                                            <?php $err = ($err == '' ? form_error('propareamax') : $err); ?>
                                            <?php $err = ($err == '' ? form_error('propareaunit') : $err); ?>
                                            <div class="control-group <?php echo ($err != '' ? 'error' : ''); ?>" align="left">
                                                <label class="control-label" for="propareamin">Area</label>
                                                <div class="controls">
                                                    <input type="text" id="propareamin" name="propareamin" class="span2 inline" placeholder="Area" maxlength="12" value="<?php echo set_value('propareamin', $propareamin); ?>" />
                                                    <input type="text" id="propareamax" name="propareamax" class="span2 inline" placeholder="" maxlength="12" value="<?php echo set_value('propareamax', $propareamax); ?>" <?php echo ($proparearange == '1' ? '' : 'style="display:none;"'); ?> />
                                                    <select id="propareaunit" name="propareaunit" class="span1 inline">
                                                        <option value=""></option>
                                                        <option value="sqm" <?php echo set_select('propareaunit', 'sqm', ($propareaunit == 'sqm' ? true: false ) ); ?> >sqm</option>
                                                        <option value="sqf" <?php echo set_select('propareaunit', 'sqf', ($propareaunit == 'sqf' ? true: false ) ); ?> >sqf</option>
                                                        <option value="ha" <?php echo set_select('propareaunit', 'ha', ($propareaunit == 'ha' ? true: false ) ); ?> >hectares</option>
                                                    </select>
                                                    &nbsp;<a href="#" id="proparea" class="proprange"><?php echo ($proparearange == '1' ? 'Remove range' : 'Create a range'); ?></a>
                                                    <input type="hidden" id="proparearange" name="proparearange" value="<?php echo set_value('proparearange', $proparearange); ?>" />
                                                    <?php if(!empty($err)) { ?><div class="alert alert-error form-inline-message">Areas should be valid numerical values.<a class="close" data-dismiss="alert" href="#">&times;</a><br/>If you're creating a range, both fields should be filled.<br/>Provide a unit.</div><?php } ?>
                                                </div>
                                            </div>
                                            <?php $err = form_error('propgaragemin'); ?>
                                            <?php $err = ($err == '' ? form_error('propgaragemax') : $err); ?>
                                            <div id="divpropgarage" class="control-group <?php echo ($err != '' ? 'error' : ''); ?>" style="<?php echo $display_garages; ?>">
                                                <label id="lblpropgarage" class="control-label" for="propgaragemin"><?php echo $display_garagelabel; ?></label>
                                                <div class="controls">
                                                    <select id="propgaragemin" name="propgaragemin" class="span2 inline">
                                                        <option value=""></option>
                                                        <option value="1" <?php echo set_select('propgaragemin', '1', ($propgaragemin == '1' ? true: false ) ); ?> >1</option>
                                                        <option value="2" <?php echo set_select('propgaragemin', '2', ($propgaragemin == '2' ? true: false ) ); ?> >2</option>
                                                        <option value="3" <?php echo set_select('propgaragemin', '3', ($propgaragemin == '3' ? true: false ) ); ?> >3</option>
                                                        <option value="4" <?php echo set_select('propgaragemin', '4', ($propgaragemin == '4' ? true: false ) ); ?> >4</option>
                                                        <option value="5" <?php echo set_select('propgaragemin', '5', ($propgaragemin == '5' ? true: false ) ); ?> >5</option>
                                                    </select>
                                                    <input type="text" id="propgaragemax" name="propgaragemax" class="span2 inline" maxlength="2" value="<?php echo set_value('propgaragemax', $propgaragemax); ?>" <?php echo ($propgaragerange == '1' ? '' : 'style="display:none;"'); ?> />
                                                    &nbsp;<a href="#" id="propgarage" class="proprange"><?php echo ($propgaragerange == '1' ? 'Remove range' : 'Create a range'); ?></a>
                                                    <input type="hidden" id="propgaragerange" name="propgaragerange" value="<?php echo set_value('propgaragerange', $propgaragerange); ?>" />
                                                    <?php if(!empty($err)) { ?><div class="alert alert-error form-inline-message">Garage/Parkings should be valid numerical values.<a class="close" data-dismiss="alert" href="#">&times;</a><br/>If you're creating a range, both fields should be filled.</div><?php } ?>
                                                </div>
                                            </div>
                                            <?php $err = form_error('propfloornum'); ?>
                                            <div id="divpropfloornum" class="control-group <?php echo ($err != '' ? 'error' : ''); ?>" style="<?php echo $display_floornum; ?>">
                                                <label class="control-label" for="propfloornum">Number of Floors</label>
                                                <div class="controls">
                                                    <input type="text" id="propfloornum" name="propfloornum" class="span2 inline" placeholder="Number of Floors" maxlength="4" value="<?php echo set_value('propfloornum', $propfloornum); ?>" />
                                                </div>
                                            </div>
                                            <?php $err = form_error('propunitnum'); ?>
                                            <div id="divpropunitnum" class="control-group <?php echo ($err != '' ? 'error' : ''); ?>" style="<?php echo $display_unitnum; ?>">
                                                <label class="control-label" for="propunitnum">Number of Units</label>
                                                <div class="controls">
                                                    <input type="text" id="propunitnum" name="propunitnum" class="span2 inline" placeholder="Number of Units" maxlength="4" value="<?php echo set_value('propunitnum', $propunitnum); ?>" />
                                                </div>
                                            </div>
                                        </section>
                                
                                        <div class="spacer"></div>

                                        <section id="other-information">
                                            <h4>Other Information</h4>

                                            <?php $err = form_error('proptenure[]'); ?>
                                            <div class="control-group <?php echo ($err != '' ? 'error' : ''); ?>">
                                                <label class="control-label" for="proptenure">Tenure</label>
                                                <div class="controls">
                                                    <div id="tenuresale" data-toggle="buttons-radio" style="<?php echo $display_tenuresale; ?>">
                                                        <button type="button" class="btn form-opt <?php echo ( isset($proptenure[TENURE_FREEHOLD]) ? 'active' : ''); ?>" data-mod="form-proptenure" data-value="<?php echo TENURE_FREEHOLD; ?>">Freehold</button>
                                                        <button type="button" class="btn form-opt <?php echo ( isset($proptenure[TENURE_LEASEHOLD]) ? 'active' : ''); ?>" data-mod="form-proptenure" data-value="<?php echo TENURE_LEASEHOLD; ?>">Leasehold</button>
                                                        <div style="display:none;">
                                                            <input type="radio" id="form-proptenure-<?php echo TENURE_FREEHOLD; ?>" name="proptenure[]" value="<?php echo TENURE_FREEHOLD; ?>" <?php echo set_radio('proptenure[]', TENURE_FREEHOLD, (isset($proptenure[TENURE_FREEHOLD]) ? true: false ) ); ?> />
                                                            <input type="radio" id="form-proptenure-<?php echo TENURE_LEASEHOLD; ?>" name="proptenure[]" value="<?php echo TENURE_LEASEHOLD; ?>" <?php echo set_radio('proptenure[]', TENURE_LEASEHOLD, (isset($proptenure[TENURE_LEASEHOLD]) ? true: false ) ); ?> />
                                                        </div>
                                                    </div>
                                                    <div id="tenurerent" data-toggle="buttons-radio" style="<?php echo $display_tenurerent; ?>">
                                                        <button type="button" class="btn form-opt <?php echo ( isset($proptenure[TENURE_1YEAR]) ? 'active' : ''); ?>" data-mod="form-proptenure" data-value="<?php echo TENURE_1YEAR; ?>">1 year</button>
                                                        <button type="button" class="btn form-opt <?php echo ( isset($proptenure[TENURE_2YEARS]) ? 'active' : ''); ?>" data-mod="form-proptenure" data-value="<?php echo TENURE_2YEARS; ?>">2 years</button>
                                                        <button type="button" class="btn form-opt <?php echo ( isset($proptenure[TENURE_3UP]) ? 'active' : ''); ?>" data-mod="form-proptenure" data-value="<?php echo TENURE_3UP; ?>">3 years up</button>
                                                        <button type="button" class="btn form-opt <?php echo ( isset($proptenure[TENURE_FLEXIBLE]) ? 'active' : ''); ?>" data-mod="form-proptenure" data-value="<?php echo TENURE_FLEXIBLE; ?>">Flexible</button>
                                                        <button type="button" class="btn form-opt <?php echo ( isset($proptenure[TENURE_SHORTTERM]) ? 'active' : ''); ?>" data-mod="form-proptenure" data-value="<?php echo TENURE_SHORTTERM; ?>">Short Term</button>
                                                        <div style="display:none;">                                                            
                                                            <input type="radio" id="form-proptenure-<?php echo TENURE_1YEAR; ?>" name="proptenure[]" value="<?php echo TENURE_1YEAR; ?>" <?php echo set_radio('proptenure[]', TENURE_1YEAR, (isset($proptenure[TENURE_1YEAR]) ? true: false ) ); ?> />
                                                            <input type="radio" id="form-proptenure-<?php echo TENURE_2YEARS; ?>" name="proptenure[]" value="<?php echo TENURE_2YEARS; ?>" <?php echo set_radio('proptenure[]', TENURE_2YEARS, (isset($proptenure[TENURE_2YEARS]) ? true: false ) ); ?> />
                                                            <input type="radio" id="form-proptenure-<?php echo TENURE_3UP; ?>" name="proptenure[]" value="<?php echo TENURE_3UP; ?>" <?php echo set_radio('proptenure[]', TENURE_3UP, (isset($proptenure[TENURE_3UP]) ? true: false ) ); ?> />
                                                            <input type="radio" id="form-proptenure-<?php echo TENURE_FLEXIBLE; ?>" name="proptenure[]" value="<?php echo TENURE_FLEXIBLE; ?>" <?php echo set_radio('proptenure[]', TENURE_FLEXIBLE, (isset($proptenure[TENURE_FLEXIBLE]) ? true: false ) ); ?> />
                                                            <input type="radio" id="form-proptenure-<?php echo TENURE_SHORTTERM; ?>" name="proptenure[]" value="<?php echo TENURE_SHORTTERM; ?>" <?php echo set_radio('proptenure[]', TENURE_SHORTTERM, (isset($proptenure[TENURE_SHORTTERM]) ? true: false ) ); ?> />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php $err = form_error('proptenureyears'); ?>
                                            <div id="divproptenureyears" class="control-group <?php echo ($err != '' ? 'error' : ''); ?>" style="<?php echo $display_tenureyears; ?>">
                                                <label class="control-label" for="proptenureyears">Number of Years</label>
                                                <div class="controls">
                                                    <input type="text" id="proptenureyears" name="proptenureyears" class="span2" maxlength="3" value="<?php echo set_value('proptenureyears', $proptenureyears); ?>" /> <span><?php echo $display_tenurelabel; ?></span>
                                                </div>
                                            </div>
                                            <?php $err = form_error('propconstruction'); ?>
                                            <div id="divpropconstruction" class="control-group <?php echo ($err != '' ? 'error' : ''); ?>" style="<?php echo $display_construction; ?>">
                                                <label class="control-label" for="propconstruction">Construction</label>
                                                <div class="controls">
                                                    <div class="span3" style="padding-top:10px;margin-left:10px;"><div id="slider-range-min" style="width:270px;"></div></div><div id="propconstructionlbl" class="span1" style="padding-top:5px;"></div>
                                                    <input type="hidden" id="propconstruction" name="propconstruction" value="<?php echo set_value('propconstruction', $propconstruction); ?>" />
                                                </div>
                                            </div>
                                            <?php $err = form_error('propcompletionmo'); ?>
                                            <div id="divpropcompletion" class="control-group <?php echo ($err != '' ? 'error' : ''); ?>" style="<?php echo $display_completion; ?>">
                                                <label class="control-label" for="propcompletionmo">Expected Completion</label>
                                                <div class="controls">
                                                    <select id="propcompletionmo" name="propcompletionmo" class="span2 inline">
                                                        <option value=""></option>
                                                        <option value="1" <?php echo set_select('propcompletionmo', 1, ($propcompletionmo == 1 ? true: false ) ); ?> >January</option>
                                                        <option value="2" <?php echo set_select('propcompletionmo', 2, ($propcompletionmo == 2 ? true: false ) ); ?> >February</option>
                                                        <option value="3" <?php echo set_select('propcompletionmo', 3, ($propcompletionmo == 3 ? true: false ) ); ?> >March</option>
                                                        <option value="4" <?php echo set_select('propcompletionmo', 4, ($propcompletionmo == 4 ? true: false ) ); ?> >April</option>
                                                        <option value="5" <?php echo set_select('propcompletionmo', 5, ($propcompletionmo == 5 ? true: false ) ); ?> >May</option>
                                                        <option value="6" <?php echo set_select('propcompletionmo', 6, ($propcompletionmo == 6 ? true: false ) ); ?> >June</option>
                                                        <option value="7" <?php echo set_select('propcompletionmo', 7, ($propcompletionmo == 7 ? true: false ) ); ?> >July</option>
                                                        <option value="8" <?php echo set_select('propcompletionmo', 8, ($propcompletionmo == 8 ? true: false ) ); ?> >August</option>
                                                        <option value="9" <?php echo set_select('propcompletionmo', 9, ($propcompletionmo == 9 ? true: false ) ); ?> >September</option>
                                                        <option value="10" <?php echo set_select('propcompletionmo', 10, ($propcompletionmo == 10 ? true: false ) ); ?> >October</option>
                                                        <option value="11" <?php echo set_select('propcompletionmo', 11, ($propcompletionmo == 11 ? true: false ) ); ?> >November</option>
                                                        <option value="12" <?php echo set_select('propcompletionmo', 12, ($propcompletionmo == 12 ? true: false ) ); ?> >December</option>
                                                    </select>
                                                    <select id="propcompletionyr" name="propcompletionyr" class="span1 inline">
                                                        <option value=""></option>
                                                        <?php
                                                        $yr = date('Y');
                                                        $has_set = false;
                                                        for($ctr = 1; $ctr < 10; $ctr++, $yr++) {
                                                            if($propcompletionyr == $yr) {
                                                                $has_set = true;
                                                            }
                                                        ?>
                                                        <option value="<?php echo $yr; ?>" <?php echo set_select('propcompletionyr', $yr, ($propcompletionyr == $yr ? true: false ) ); ?> ><?php echo $yr; ?></option>
                                                        <?php } ?>
                                                        <?php if(!$has_set && !empty($propcompletionyr)) { ?>
                                                        <option value="<?php echo $propcompletionyr; ?>" selected="selected"><?php echo $propcompletionyr; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <?php $err = form_error('propforeclosure[]'); ?>
                                            <div class="control-group <?php echo ($err != '' ? 'error' : ''); ?>">
                                                <label class="control-label" for="propforeclosure">Foreclosure?</label>
                                                <div class="controls">
                                                    <div data-toggle="buttons-radio">
                                                        <button type="button" class="btn form-opt <?php echo ( isset($propforeclosure['A']) ? 'active' : ''); ?>" data-mod="form-propforeclosure" data-value="A">Not Applicable</button>
                                                        <button type="button" class="btn form-opt <?php echo ( isset($propforeclosure[YES]) ? 'active' : ''); ?>" data-mod="form-propforeclosure" data-value="<?php echo YES; ?>">Foreclosed</button>
                                                        <div style="display:none;">
                                                            <input type="radio" id="form-propforeclosure-A" name="propforeclosure[]" value="A" <?php echo set_radio('propforeclosure[]', 'A', (isset($propforeclosure['A']) ? true: false ) ); ?> />
                                                            <input type="radio" id="form-propforeclosure-<?php echo YES; ?>" name="propforeclosure[]" value="<?php echo YES; ?>" <?php echo set_radio('propforeclosure[]', YES, (isset($propforeclosure[YES]) ? true: false ) ); ?> />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php $err = form_error('propresale[]'); ?>
                                            <div class="control-group <?php echo ($err != '' ? 'error' : ''); ?>">
                                                <label class="control-label" for="propresale">Resale?</label>
                                                <div class="controls">
                                                    <div data-toggle="buttons-radio">
                                                        <button type="button" class="btn form-opt <?php echo ( (isset($propresale[NO]) ? true: false ) ? 'active' : ''); ?>" data-mod="form-propresale" data-value="<?php echo NO; ?>">No</button>
                                                        <button type="button" class="btn form-opt <?php echo ( (isset($propresale[YES]) ? true: false ) ? 'active' : ''); ?>" data-mod="form-propresale" data-value="<?php echo YES; ?>">Yes</button>
                                                        <div style="display:none;">
                                                            <input type="radio" id="form-propresale-<?php echo NO; ?>" name="propresale[]" value="<?php echo NO; ?>" <?php echo set_radio('propresale[]', NO, (isset($propresale[NO]) ? true: false ) ); ?> />
                                                            <input type="radio" id="form-propresale-<?php echo YES; ?>" name="propresale[]" value="<?php echo YES; ?>" <?php echo set_radio('propresale[]', YES, (isset($propresale[YES]) ? true: false ) ); ?> />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php $err = form_error('propoccupancy[]'); ?>
                                            <div id="divpropoccupancy" class="control-group <?php echo ($err != '' ? 'error' : ''); ?>" style="<?php echo $display_occupancy; ?>">
                                                <label class="control-label" for="propoccupancy">Ready for Occupancy?</label>
                                                <div class="controls">
                                                    <div data-toggle="buttons-radio">
                                                        <button type="button" class="btn form-opt <?php echo ( isset($propoccupancy[NO]) ? 'active' : ''); ?>" data-mod="form-propoccupancy" data-value="<?php echo NO; ?>">No</button>
                                                        <button type="button" class="btn form-opt <?php echo ( isset($propoccupancy[YES]) ? 'active' : ''); ?>" data-mod="form-propoccupancy" data-value="<?php echo YES; ?>">Yes</button>
                                                        <div style="display:none;">
                                                            <input type="radio" id="form-propoccupancy-<?php echo NO; ?>" name="propoccupancy[]" value="<?php echo NO; ?>" <?php echo set_radio('propoccupancy[]', NO, (isset($propoccupancy[NO]) ? true: false ) ); ?> />
                                                            <input type="radio" id="form-propoccupancy-<?php echo YES; ?>" name="propoccupancy[]" value="<?php echo YES; ?>" <?php echo set_radio('propoccupancy[]', YES, (isset($propoccupancy[YES]) ? true: false ) ); ?> />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                        
                                    </div>

                                    <div id="tabfff" class="tab-pane content-fff">
                                        <section id="furnishings">
                                            <?php
                                            $data = array(
                                                'display_furnishingsall' => $display_furnishingsall,
                                                'display_furnishings1' => $display_furnishings1,
                                                'display_furnishings2' => $display_furnishings2,
                                                'display_furnishings3' => $display_furnishings3,
                                                'display_furnishings4' => $display_furnishings4,
                                                'propfurnished' => $propfurnished,
                                                'propfurnish1' => $propfurnish1,
                                                'propfurnish2' => $propfurnish2,
                                                'propfurnish3' => $propfurnish3,
                                                'propfurnish4' => $propfurnish4,
                                                'furnishings_residentials' => $furnishings_residentials,
                                                'furnishings_commercials' => $furnishings_commercials,
                                                'furnishings_lands' => $furnishings_lands,
                                                'furnishings_hotels' => $furnishings_hotels
                                            );
                                            $this->load->view('properties/form_furnishings', $data);
                                            ?>  
                                        </section>
                                
                                        <div class="spacer"></div>

                                        <section id="features">
                                            <?php
                                            $data = array(
                                                'display_featuresall' => $display_featuresall,
                                                'display_features1' => $display_features1,
                                                'display_features2' => $display_features2,
                                                'display_features3' => $display_features3,
                                                'display_features4' => $display_features4,
                                                'propfeatures1' => $propfeatures1,
                                                'propfeatures2' => $propfeatures2,
                                                'propfeatures3' => $propfeatures3,
                                                'propfeatures4' => $propfeatures4,
                                                'features_residentials' => $features_residentials,
                                                'features_commercials' => $features_commercials,
                                                'features_lands' => $features_lands,
                                                'features_hotels' => $features_hotels
                                            );
                                            $this->load->view('properties/form_features', $data);
                                            ?>  
                                        </section>
                                
                                        <div class="spacer"></div>

                                        <section id="facilities">
                                            <?php 
                                            $data = array(
                                                'display_facilitiesall' => $display_facilitiesall,
                                                'display_facilities1' => $display_facilities1,
                                                'display_facilities2' => $display_facilities2,
                                                'display_facilities3' => $display_facilities3,
                                                'display_facilities4' => $display_facilities4,
                                                'propfacilities1' => $propfacilities1,
                                                'propfacilities2' => $propfacilities2,
                                                'propfacilities3' => $propfacilities3,
                                                'propfacilities4' => $propfacilities4,
                                                'facilities_residentials' => $facilities_residentials,
                                                'facilities_commercials' => $facilities_commercials,
                                                'facilities_lands' => $facilities_lands,
                                                'facilities_hotels' => $facilities_hotels
                                            );
                                            $this->load->view('properties/form_facilities', $data);
                                            ?>  
                                        </section>
                                    </div>

                                    <div id="tabvideo" class="tab-pane content-video">
                                        <section id="video">
                                            <h4>Videos</h4>

                                            <?php $err = form_error('propvideo'); ?>
                                            <div class="control-group <?php echo ($err != '' ? 'error' : ''); ?>">
                                                <label class="control-label" for="propvideo">
                                                    YouTube or Vimeo Link&nbsp;
                                                    <i class="icon-info-sign tooltip-propertyfinder" data-placement="left" data-title="Copy the link of your YouTube or Vimeo video clip." style="opacity:0.5;"></i>
                                                </label>
                                                <div class="controls">
                                                    <input type="text" id="propvideo" name="propvideo" class="span5" placeholder="URL of your YouTube or Vimeo video" maxlength="150" value="<?php echo set_value('propvideo', $propvideo); ?>" />
                                                </div>
                                            </div>
                                        </section>
                                    </div>

                                    <div id="tabmap" class="tab-pane content-map" data-mode="">
                                        <section id="map">
                                            <h4>Map <i class="icon-info-sign tooltip-propertyfinder" data-placement="right" data-title="Zoom in to the location as close as possible. Click on a spot to set the marker." style="opacity:0.5;"></i></h4>

                                            <div id="divmap" style="height:400px;"><img src="<?php echo $this->config->item('image_path'); ?>spinner.gif"></div>
                                            <input type="hidden" id="propcoordlat" name="propcoordlat" value="<?php echo set_value('propcoordlat', $propcoordlat); ?>" />
                                            <input type="hidden" id="propcoordlng" name="propcoordlng" value="<?php echo set_value('propcoordlng', $propcoordlng); ?>" />

                                        </section>
                                    </div>
                                    
                                </div>

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

<link href="<?php echo site_url(); ?>assets/css/jquery-ui.min.css" rel="stylesheet">
<style>
.ui-widget-header {
    border:1px solid #fff;
    background-color: <?php echo $color_propcompletion; ?>;
    background-image: -webkit-gradient(linear, 0 100%, 100% 0, color-stop(0.25, rgba(255, 255, 255, 0.15)), color-stop(0.25, transparent), color-stop(0.5, transparent), color-stop(0.5, rgba(255, 255, 255, 0.15)), color-stop(0.75, rgba(255, 255, 255, 0.15)), color-stop(0.75, transparent), to(transparent));
    background-image: -webkit-linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent);
    background-image: -moz-linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent);
    background-image: -o-linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent);
    background-image: linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent);
    -webkit-background-size: 40px 40px;
    -moz-background-size: 40px 40px;
    -o-background-size: 40px 40px;
    background-size: 40px 40px;
}
</style>

<?php if(!isset($error)) { ?>

<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?v=3&sensor=false&key=AIzaSyDngCmTbQXV7kK3polRDeN3Td6pjVwsaOk"></script>
<script type="text/javascript">
var classifications = <?php echo json_encode($classifications); ?>;
objprof = {'tid':'<?php echo $tempid; ?>','propcompletion':<?php echo $propcompletion; ?>,'propconstruction':'<?php echo $propconstruction; ?>','propcoordlat':'<?php echo ( !empty($propcoordlat) ? $propcoordlat : 33.808678 ); ?>','propcoordlng':'<?php echo ( !empty($propcoordlng) ? $propcoordlng : -117.918921 ); ?>','propmapzoom':'<?php echo ( !empty($propcoordlat) ? 15 : 10 ); ?>'};
head.ready(function() {
    head.js("<?php echo site_url(); ?>assets/js/plupload/plupload.full.js","<?php echo site_url(); ?>assets/js/propertyfinderproperties.js");
});
</script>

<?php } ?>