<?php if(empty($record['code'])) { ?>

<div class="bannertop"></div>

<div class="realtygusto homehead">
    <div class="container">
        <div class="home">
            <h1>propertyfinder not found.</h1>
        </div>
    </div>
</div>

<div class="container">

    <div class="bg-box">
        <div class="alert alert-info invalid-profile" align="center">
            Sorry, but the requested record could not be found.
        </div>
        <div align="center">
            <input class="btn btn-primary btn-large searchverified" type="button" value="Search for agents with verified licenses" />
            <input class="btn btn-primary btn-large searchlevel" type="button" value="Search for agents by their level" />
        </div>
    </div>

</div> <!-- /container -->

<?php } else { ?>

<?php $fullname = $record['fname'] . ' ' . $record['lname']; ?>
    
<div class="wrapper">
    
<div class="bannertop"></div>

<div class="container">

    <div class="bg-profile-container">
        
        <div class="bg-profile-strip">
            <div class="profile-container-left">
                <div class="profile-photo-hdr profmainthumb">
                    <img src="<?php echo site_url() . (!empty($record['pic']) ? 'profiles/' . $record['pic'] : 'assets/img/agent150.png'); ?>" width="150" class="img-rounded">
                </div>
                <div class="profile-name-hdr">
                    <h1 class="profmainname"><?php echo $fullname; ?></h1>
                    <?php echo ( !empty($record['position']) ? '<div>' . $record['position'] . '</div>' : '' ); ?>
                    <?php echo ( !empty($record['licensenum']) ? '<div>License No.: ' . $record['licensenum'] . '</div>' : '' ); ?>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="profile-container-right">
                <div class="profile-verify-agent" align="right"><?php echo $record['verifiedagent']; ?></div>
                <div class="profile-rater-agent" align="right">
                    <?php
                    $class = ( $userlogin ? '' : 'tooltip-propertyfinder' );
                    $attr = ( $userlogin ? ' data-urate="' . $record['useragentrating'] . '"' : ' data-placement="top" data-title="Please login"' );
                    ?>
                    <div class="arater rater-right <?php echo $class; ?>" <?php echo $attr; ?> data-url="<?php echo site_url('services/rate-agent/' . url_title($fullname) . '/' . $record['code']); ?>" data-qstring="<?php echo $record['code']; ?>" data-url2="<?php echo $record['code']; ?>" data-orate="<?php echo $record['rating']; ?>" data-nrate="<?php echo $record['numrating']; ?>"></div>
                    <div class="rated"></div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
        
        <div class="bg-profile-content">
            
            <div class="profile-detail">
                
                <table cellpadding="0" cellmargin="0">
                    <tr>
                        <td class="profile-container-left-td profile-detail-left" style="vertical-align:top;">

                            <div class="spacer-small"></div>

                            <ul class="nav nav-pills">
                                <li class="<?php echo ( !$notifications ? 'active' : '' ); ?>">
                                    <a href="#tabproperties" data-toggle="tab">Properties</a>
                                </li>
                                <li><a href="#tabprofile" data-toggle="tab" data-mode="">Profile</a></li>
                                <?php if($notifications || $ownprofile) { ?>
                                <li class="<?php echo ( $notifications ? 'active' : '' ); ?>"><a href="#tabnotifications" data-toggle="tab" data-mode="">Notifications</a></li>
                                <?php } ?>
                                <li><a href="#tabcomments" data-toggle="tab" class="tab-comments" data-mode="">Comments</a></li>
                            </ul>

                            <div class="spacer"></div>

                            <div class="tab-content">
                                
                                <div id="tabproperties" align="center" class="tab-pane <?php echo ( !$notifications ? 'active' : '' ); ?> listing-prof">
                                    <div class="listsort">
                                        <div align="right">
                                            <div class="btn-group">
                                                <button class="btn btn-small dropdown-toggle" data-toggle="dropdown" type="button">
                                                    Sort <i class="icon-chevron-down" style="opacity:0.7;"></i>
                                                </button>
                                                <ul class="dropdown-menu pull-right" style="text-align:left;">
                                                    <li><a href="#" class="sort-prof" data-mode="name" data-url="properties/agent/<?php echo $record['code']; ?>">Name</a></li>
                                                    <li><a href="#" class="sort-prof" data-mode="price" data-url="properties/agent/<?php echo $record['code']; ?>">Price</a></li>
                                                    <li><a href="#" class="sort-prof" data-mode="upload-date" data-url="properties/agent/<?php echo $record['code']; ?>">Upload Date</a></li>
                                                    <li><a href="#" class="sort-prof" data-mode="popularity" data-url="properties/agent/<?php echo $record['code']; ?>">Popularity</a></li>
                                                    <li><a href="#" class="sort-prof" data-mode="featured" data-url="properties/agent/<?php echo $record['code']; ?>">Featured</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <ul class="proplist">
                                    </ul>
                                    <div align="center">
                                        <div class="loading"><img src="../../assets/img/spinner.gif"></div>
                                        <div class="nomoreresults"></div>
                                        <div class="spacer"></div>
                                    </div>
                                    <form id="frmsearch" action="<?php echo site_url('properties/agent'); ?>" method="post" accept-charset="UTF-8">
                                        <input type="hidden" id="off" name="off" value="<?php echo 0; ?>" />
                                        <input type="hidden" id="lmt" name="lmt" value="<?php echo LIMIT_AGENTPROPERTIES; ?>" />
                                        <input type="hidden" id="sort" name="sort" value="" />
                                        <input type="hidden" id="ord" name="ord" value="" />
                                    </form>                                    
                                </div>
                                
                                <div id="tabprofile" class="tab-pane" style="text-align:left;">
                                    <?php echo nl2br($record['profile']); ?>
                                </div>

                                <?php if($notifications || $ownprofile) { ?>
                                <div id="tabnotifications" class="tab-pane <?php echo ( $notifications ? 'active' : '' ); ?>" style="text-align:left;">
                                    <ul class="notifications-list"></ul>
                                </div>
                                <?php } ?>

                                <div id="tabcomments" class="tab-pane comments" data-mode="">
                                    <div align="center"><img src="../../assets/img/spinner.gif"></div>
                                </div>
                                
                            </div>
                            
                            <div class="spacer"></div>
                        </td>
                        <td class="profile-container-right-td profile-detail-right" style="vertical-align:top;">
                            
                            <div class="spacer-small"></div>

                            <div>
                                <h4 class="profile-detail-right-hdr">propertyfinder Info</h4>
                                <?php if($record['featured'] == YES) { ?>
                                <div align="center">
                                    <span class="label label-inverse"><i class="icon-certificate icon-white"></i> FEATURED propertyfinder!</span>
                                    <div class="spacer"></div>
                                </div>
                                <?php } ?>

                                <?php $location = ( !empty($record['city']) ? $record['city'] : '' ) . ( !empty($record['city']) && !empty($record['country']) ? ', ' : '' ) . ( !empty($record['country']) ? $record['country'] : '' ); ?>                                
                                <?php if( !empty($record['company']) || !empty($location) || 
                                        !empty($record['dateregistered']) || !empty($record['numproperties']) ) { ?>
                                <table class="table table-condensed">
                                    <?php if( !empty($record['company']) ) { ?>
                                    <tr>
                                        <th style="width:70px;">Company</th>
                                        <td><?php echo '<a href="' . site_url('company/' . url_title($record['company']) . '/' . $record['companycode']) . '" title="' . $record['company'] . '">' . $record['company'] . '</a>'; ?></td>
                                    </tr>
                                    <?php } ?>
                                    <?php if( !empty($location) ) { ?>
                                    <tr>
                                        <th style="width:70px;">Location</th>
                                        <td><?php echo $location; ?></td>
                                    </tr>
                                    <?php } ?>
                                    <?php if( !empty($record['dateregistered']) ) { ?>
                                    <tr>
                                        <th style="width:70px;">Joined</th>
                                        <td><?php echo $record['dateregistered']; ?></td>
                                    </tr>
                                    <?php } ?>
                                    <?php if( !empty($record['numproperties']) ) { ?>
                                    <tr>
                                        <th style="width:70px;">Posts</th>
                                        <td><?php echo $record['numproperties']; ?></td>
                                    </tr>
                                    <?php } ?>
                                </table>
                                <?php } ?>
                            </div>

                            <div class="spacer"></div>

                            <div>
                                <h4 class="profile-detail-right-hdr">Contact</h4>
                                <?php if( !empty($record['mobilenum']) || !empty($record['homenum']) || 
                                        !empty($record['officenum']) || !empty($record['skype']) ) { ?>
                                <table class="table table-condensed">
                                    <?php if( !empty($record['mobilenum']) ) { ?>
                                    <tr>
                                        <th style="width:70px;">Mobile No.</th>
                                        <td><?php echo $record['mobilenum']; ?></td>
                                    </tr>
                                    <?php } ?>
                                    <?php if( !empty($record['homenum']) ) { ?>
                                    <tr>
                                        <th style="width:70px;">Home No.</th>
                                        <td><?php echo $record['homenum']; ?></td>
                                    </tr>
                                    <?php } ?>
                                    <?php if( !empty($record['officenum']) ) { ?>
                                    <tr>
                                        <th style="width:70px;">Office No.</th>
                                        <td><?php echo $record['officenum']; ?></td>
                                    </tr>
                                    <?php } ?>
                                    <?php if( !empty($record['skype']) ) { ?>
                                    <tr>
                                        <th style="width:70px;">Skype</th>
                                        <td><?php echo $record['skype']; ?></td>
                                    </tr>
                                    <?php } ?>
                                </table>
                                <?php } ?>
                                <div class="profsocials">
                                    <?php if(!empty($record['accfb'])) { ?>
                                    <a href="<?php echo $record['accfb']; ?>" target="_blank" class="sociallink tooltip-propertyfinder" data-placement="top" data-title="Facebook profile"><i class="icon2-facebook-sign icon2-2x"></i></a>
                                    <?php } ?>
                                    <?php if(!empty($record['acctwitter'])) { ?>
                                    <a href="<?php echo $record['acctwitter']; ?>" target="_blank" class="sociallink tooltip-propertyfinder" data-placement="top" data-title="Twitter profile"><i class="icon2-twitter-sign icon2-2x"></i></a>
                                    <?php } ?>
                                    <?php if(!empty($record['accgoogle'])) { ?>
                                    <a href="<?php echo $record['accgoogle']; ?>" target="_blank" class="sociallink tooltip-propertyfinder" data-placement="top" data-title="Google+ profile"><i class="icon2-google-plus-sign icon2-2x"></i></a>
                                    <?php } ?>
                                    <?php if(!empty($record['acclinkedin'])) { ?>
                                    <a href="<?php echo $record['acclinkedin']; ?>" target="_blank" class="sociallink tooltip-propertyfinder" data-placement="top" data-title="LinkedIn profile"><i class="icon2-linkedin-sign icon2-2x"></i></a>
                                    <?php } ?>
                                </div>
                                <?php
                                if($record['code'] == $usercode) {
                                    $class = '';
                                    $attr = ' disabled="disabled"';
                                } else {
                                    $class = ( $userlogin ? '' : 'tooltip-propertyfinder' );
                                    $attr = ( $userlogin ? ' ' : ' data-placement="bottom" data-title="Please login"' );
                                }
                                ?>
                                <div align="center">
                                    <button class="btn btn-medium message <?php echo $class; ?>" <?php echo $attr; ?> type="button" data-url="<?php echo site_url('messages/start-conversation/' . url_title($fullname) . '/' . $record['code']); ?>">
                                        <i class="icon-envelope"></i> Start a conversation
                                    </button>
                                </div>
                            </div>
                            
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
var off = 0, lmt = <?php echo LIMIT_AGENTPROPERTIES; ?>;
head.ready(function() {
    load_properties('3', baseurl+'properties/agent/<?php echo $record['code']; ?>', off, lmt);
    off = off + lmt;
    $('#off').val( off );
    
    urlpaginate = baseurl+'properties/agent/<?php echo $record['code']; ?>';
    objprof = {'id':'<?php echo $record['code']; ?>','name':'<?php echo $fullname; ?>','link':'<?php echo site_url('agent/' . url_title($fullname) . '/' . $record['code']); ?>'};
    
    <?php if($ownprofile) { ?>
    load_notifications();
    <?php } ?>
});
</script>

<?php } ?>