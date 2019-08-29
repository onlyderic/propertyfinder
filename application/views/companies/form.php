<style>
  .ui-autocomplete-loading {
    background: white url('<?php echo site_url(); ?>assets/img/spinner.gif') right center no-repeat;
  }
</style>

<div class="wrapper">
    
<div class="bannertop"></div>

<div class="container">

    <div class="bg-container">
    
        <div class="bg-strip">
            <h3>Update Your Profile</h3>
            <h5>Improve your profile and provide your contact details so people can connect to you easily.</h5>
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
                            
                            <form action="<?php echo current_url(''); ?>" class="form-horizontal" id="frmpropertyfinder" method="post" enctype="multipart/form-data">

                                <section id="company-information">

                                    <?php if(!empty($message)) { ?><div class="alert alert-<?php echo $message_status; ?>"><?php echo $message; ?><a class="close" data-dismiss="alert" href="#">&times;</a></div><?php } ?>
                                    <?php
                                    $errs = validation_errors();
                                    if(!empty($errs)) {
                                    ?>
                                        <div class="alert alert-error">There are errors on the form. Please correct and save again.<a class="close" data-dismiss="alert" href="#">&times;</a></div>
                                    <?php } ?>

                                    <h4>Company Information</h4>

                                    <div class="control-group">
                                        <label class="control-label" for="upic">Profile Picture</label>
                                        <div class="controls">
                                            <div id="divcpicimg">
                                                <img id="cimg" src="<?php echo site_url(). ( empty($upic) ? 'assets/img/agent150.png' : 'realties/' . $upic ); ?>" width="50" height="50" title="<?php echo $ucompanyname; ?>" />
                                                <img id="spinner1" src="<?php echo site_url(); ?>assets/img/spinner.gif" style="display:none;" />
                                            </div>
                                            <input type="file" id="cpic" name="cpic" accept="image/*" />
                                            <div class="alert alert-error form-inline-message" style="display:none;" id="divcpicmsg"></div>
                                        </div>
                                    </div>
                                    <?php $err = form_error('ucompanyname'); ?>
                                    <div class="control-group <?php echo ($err != '' ? 'error' : ''); ?>">
                                        <label class="control-label" for="ucompanyname">Company Name</label>
                                        <div class="controls">
                                            <input type="text" id="ucompanyname" name="ucompanyname" class="span5" placeholder="Company Name" maxlength="200" value="<?php echo set_value('ucompanyname', $ucompanyname); ?>" />
                                        </div>
                                    </div>
                                    <?php $err = form_error('uaddress'); ?>
                                    <div class="control-group <?php echo ($err != '' ? 'error' : ''); ?>">
                                        <label class="control-label" for="uaddress">Address</label>
                                        <div class="controls">
                                            <input type="text" id="uaddress" name="uaddress" class="span5" placeholder="Address" maxlength="500" value="<?php echo set_value('uaddress', $uaddress); ?>" />
                                        </div>
                                    </div>
                                    <?php $err = form_error('udescription'); ?>
                                    <div class="control-group <?php echo ($err != '' ? 'error' : ''); ?>">
                                        <label class="control-label" for="udescription">Profile Description</label>
                                        <div class="controls">
                                            <textarea id="udescription" name="udescription" rows="5" class="span5"><?php echo set_value('udescription', $udescription); ?></textarea>
                                        </div>
                                    </div>
                                </section>
                                
                                <div class="spacer"></div>
                                
                                <section id="contact-details">
                                    
                                    <h4>Contact Details</h4>

                                    <?php $err = form_error('uaddress'); ?>
                                    <div class="control-group <?php echo ($err != '' ? 'error' : ''); ?>">
                                        <label class="control-label" for="uaddress">Address</label>
                                        <div class="controls">
                                            <input type="text" id="uaddress" name="uaddress" class="span5" placeholder="Address" maxlength="500" value="<?php echo set_value('uaddress', $uaddress); ?>" />
                                        </div>
                                    </div>
                                    <?php $err = form_error('ucountry'); ?>
                                    <div class="control-group <?php echo ($err != '' ? 'error' : ''); ?>">
                                        <label class="control-label" for="ucity">City, Country</label>
                                        <div class="controls">
                                            <input type="text" id="ucity" name="ucity" class="span3 inline" placeholder="City" maxlength="50" value="<?php echo set_value('ucity', $ucity); ?>" />
                                            <select id="ucountry" name="ucountry" class="span2 inline2" placeholder="Country">
                                                <option value=""></option>
                                                <?php foreach($countries as $key => $val) { ?>
                                                <option value="<?php echo $key; ?>" <?php echo set_select('ucountry', $key, ( $ucountry == $key ? true : false ) ); ?> ><?php echo $val; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <?php $err = form_error('uofficenum'); ?>
                                    <div class="control-group <?php echo ($err != '' ? 'error' : ''); ?>">
                                        <label class="control-label" for="uofficenum">Office Number</label>
                                        <div class="controls">
                                            <input type="text" id="uofficenum" name="uofficenum" class="span5" placeholder="Office Number" maxlength="25" value="<?php echo set_value('uofficenum', $uofficenum); ?>" />
                                        </div>
                                    </div>
                                    <?php $err = form_error('ufaxnum'); ?>
                                    <div class="control-group <?php echo ($err != '' ? 'error' : ''); ?>">
                                        <label class="control-label" for="ufaxnum">Fax Number</label>
                                        <div class="controls">
                                            <input type="text" id="ufaxnum" name="ufaxnum" class="span5" placeholder="Fax Number" maxlength="25" value="<?php echo set_value('ufaxnum', $ufaxnum); ?>" />
                                        </div>
                                    </div>
                                    <?php $err = form_error('uothernum'); ?>
                                    <div class="control-group <?php echo ($err != '' ? 'error' : ''); ?>">
                                        <label class="control-label" for="uothernum">Other Contact</label>
                                        <div class="controls">
                                            <input type="text" id="uothernum" name="uothernum" class="span5" placeholder="Other Contact Number" maxlength="200" value="<?php echo set_value('uothernum', $uothernum); ?>" />
                                        </div>
                                    </div>
                                    <?php $err = form_error('uskype'); ?>
                                    <div class="control-group <?php echo ($err != '' ? 'error' : ''); ?>">
                                        <label class="control-label" for="uskype">Skype</label>
                                        <div class="controls">
                                            <input type="text" id="uskype" name="uskype" class="span5" placeholder="Skype" maxlength="50" value="<?php echo set_value('uskype', $uskype); ?>" />
                                        </div>
                                    </div>
                                </section>
                                
                                <div class="spacer"></div>

                                <section id="email-address">
                                    <h4>Email Address / Login</h4>

                                    <?php $err = form_error('uemail'); ?>
                                    <div class="control-group <?php echo ($err != '' ? 'error' : ''); ?>">
                                        <label class="control-label" for="uemail">Email Address</label>
                                        <div class="controls">
                                            <input type="text" id="uemail" name="uemail" class="span5" placeholder="Email Address" maxlength="300" value="<?php echo set_value('uemail', $uemail); ?>" />
                                            <?php if(!empty($err)) { ?><div class="alert alert-error form-inline-message"><?php echo $err; ?><a class="close" data-dismiss="alert" href="#">&times;</a></div><?php } ?>
                                        </div>
                                    </div>
                                </section>
                                
                                <div class="spacer"></div>

                                <section id="social-links">
                                    <h4>Social Links</h4>

                                    <?php $err = form_error('uaccfb'); ?>
                                    <div class="control-group <?php echo ($err != '' ? 'error' : ''); ?>">
                                        <label class="control-label" for="uaccfb" style="padding-top:0px;">Facebook&nbsp;&nbsp;<i class="icon2-facebook-sign icon2-2x"></i></label>
                                        <div class="controls">
                                            <input type="text" id="uaccfb" name="uaccfb" class="span5" placeholder="www.facebook.com/YourFacebookName" maxlength="200" value="<?php echo set_value('uaccfb', $uaccfb); ?>" />
                                        </div>
                                    </div>
                                    <?php $err = form_error('uacctwitter'); ?>
                                    <div class="control-group <?php echo ($err != '' ? 'error' : ''); ?>">
                                        <label class="control-label" for="uacctwitter" style="padding-top:0px;">Twitter&nbsp;&nbsp;<i class="icon2-twitter-sign icon2-2x"></i></label>
                                        <div class="controls">
                                            <input type="text" id="uacctwitter" name="uacctwitter" class="span5" placeholder="twitter.com/YourTwitterName" maxlength="200" value="<?php echo set_value('uacctwitter', $uacctwitter); ?>" />
                                        </div>
                                    </div>
                                    <?php $err = form_error('uaccgoogle'); ?>
                                    <div class="control-group <?php echo ($err != '' ? 'error' : ''); ?>">
                                        <label class="control-label" for="uaccgoogle" style="padding-top:0px;">Google+&nbsp;&nbsp;<i class="icon2-google-plus-sign icon2-2x"></i></label>
                                        <div class="controls">
                                            <input type="text" id="uaccgoogle" name="uaccgoogle" class="span5" placeholder="plus.google.com/u/0/YourGooglePlusID" maxlength="200" value="<?php echo set_value('uaccgoogle', $uaccgoogle); ?>" />
                                        </div>
                                    </div>
                                    <?php $err = form_error('uacclinkedin'); ?>
                                    <div class="control-group <?php echo ($err != '' ? 'error' : ''); ?>">
                                        <label class="control-label" for="uacclinkedin" style="padding-top:0px;">LinkedIn&nbsp;&nbsp;<i class="icon2-linkedin-sign icon2-2x"></i></label>
                                        <div class="controls">
                                            <input type="text" id="uacclinkedin" name="uacclinkedin" class="span5" placeholder="www.linkedin.com/in/YourLinkedInName" maxlength="200" value="<?php echo set_value('uacclinkedin', $uacclinkedin); ?>" />
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

<script type="text/javascript">
head.ready(function() {
    head.js("<?php echo site_url(); ?>assets/js/ajaxfileupload.js");
});
</script>