<div class="wrapper">
    
<div class="bannertop"></div>

<div class="container">
    
    <div class="bg-container">
    
        <div class="bg-strip">
            <h3>My Account</h3>
        </div>
        
        <div class="bg-content">
            
            <div class="spacer-small"></div>
            
            <ul class="nav nav-pills">
                <li class="active"><a href="#tabfeatureproperties" data-toggle="tab">Featured Properties</a></li>
                <li><a href="#tabfeatureprofile" data-toggle="tab" data-mode="">Featured Profile</a></li>
                <?php if($usertype != USERTYPE_COMPANY) { ?>
                <li><a href="#tabprofileverification" data-toggle="tab" data-mode="">Profile Verification</a></li>
                <?php } ?>
            </ul>

            <div class="spacer"></div>

            <form action="<?php echo current_url(''); ?>" class="form-horizontal" id="frmpropertyfinder" method="post">
                <div class="tab-content">

                    <div id="tabfeatureproperties" class="tab-pane active">
                        <?php 
                        $data = array('list_featured_properties' => $list_featured_properties);
                        $this->load->view('accounts/list_featured_properties', $data);
                        ?>
                    </div>

                    <div id="tabfeatureprofile" class="tab-pane">
                        <?php 
                        $data = array('list_featured_profile' => $list_featured_profile, 'featured' => $featured, 'usercode' => $usercode, 'userfullname' => $userfullname);
                        $this->load->view('accounts/list_featured_profile', $data);
                        ?>  
                    </div>

                    <?php if($usertype != USERTYPE_COMPANY) { ?>
                    <div id="tabprofileverification" class="tab-pane">
                        <?php 
                        $data = array('list_profile_verification' => $list_profile_verification, 'verifiedagent' => $verifiedagent, 'usercode' => $usercode, 'userfullname' => $userfullname);
                        $this->load->view('accounts/list_profile_verification', $data);
                        ?>
                    </div>
                    <?php } ?>

                </div>
            </form>

            <div class="spacer"></div>
            
        </div>
        
    </div>

    <div class="spacer"></div>
    <div class="push"></div>

</div> <!-- /container -->

</div> <!-- /wrapper -->

<?php $this->load->view('footer_summary'); ?>