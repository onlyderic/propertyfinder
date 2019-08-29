<?php if(empty($record['code'])) { ?>

<div class="bannertop"></div>

<div class="realtygusto homehead">
    <div class="container">
        <div class="home">
            <h1>Property not found.</h1>
        </div>
    </div>
</div>

<div class="container">

    <div class="bg-box">
        <div class="alert alert-info invalid-profile" align="center">
            Sorry, but the requested property record could not be found.
        </div>
        <div align="center">
            <input class="btn btn-primary btn-large searchprop" type="button" value="Search for other properties!" />
        </div>
    </div>

</div> <!-- /container -->

<?php } else { ?>
    
<div class="wrapper">
    
<div class="bannertop"></div>

<div class="container">

    <div class="bg-profile-container">
        
        <div class="bg-profile-strip-property">
            <div class="carousel">
                <div class="profimg" align="center">
                    <a href="<?php echo site_url('photos/' . $record['code'] . '/' . $record['profilepic']); ?>" class="gallery">
                        <img src="<?php echo site_url('photos/' . $record['code'] . '/' . $record['profilepic']); ?>" style="<?php echo ( !empty($record['profilepicwidth']) ? 'width:' . $record['profilepicwidth'] . 'px;' : '' ); ?><?php echo ( !empty($record['profilepicheight']) ? 'height:' . $record['profilepicheight'] . 'px;' : '' ); ?>" >
                    </a>
                    <?php if($record['recstatus'] == PROPSTATUS_DRAFT) { ?>
                    <div class="draft">I'm still a DRAFT!</div>
                    <?php } ?>
                </div>
                <div class="profthumbs"></div>
                <div class="clearfix"></div>
            </div>
            <div class="spacer"></div>
        </div>
        
        <div class="bg-profile-content">

            <div class="bg-profile-strip-main">
                <div class="profile-container-left">
                    <h1><?php echo $record['name']; ?></h1>
                </div>
                <div class="profile-container-right">
                    <?php
                    $class = ( $userlogin ? '' : 'tooltip-propertyfinder' );
                    $attr = ( $userlogin ? ' data-urate="' . $record['userrating'] . '"' : ' data-placement="top" data-title="Please login"' );
                    ?>
                    <div class="pull-left" style="margin-top:5px;">
                        <div class="rater rater-left <?php echo $class; ?>" <?php echo $attr; ?> data-url="<?php echo site_url('services/rate-property/' . url_title($record['name']) . '/' . $record['code']); ?>" data-qstring="<?php echo $record['code']; ?>" data-orate="<?php echo $record['rating']; ?>" data-nrate="<?php echo $record['numrating']; ?>"></div>
                        <div class="rated"></div>
                    </div>
                    <?php
                    $attr1 = ( $userlogin ? ' data-uthumbs="' . $record['userthumbs'] . '"' : '' );
                    $attr2 = ( $userlogin ? '' : ' data-placement="top" data-title="Please login"' );
                    ?>
                    <div clas="pull-right" align="right">
                        <div class="liker btn-group" <?php echo $attr1; ?> data-qstring="<?php echo $record['code']; ?>">
                            <a class="btn btn-medium thumbs-up <?php echo $class; ?>" <?php echo $attr2; ?> href="#" data-url="<?php echo site_url('services/like-property/' . url_title($record['name']) . '/' . $record['code']); ?>"><span><i class="icon-thumbs-up"></i> <span><?php echo ( !empty($record['numlikes']) ? $record['numlikes'] : '' ); ?></span></span><span></span></a>
                            <a class="btn btn-medium thumbs-down <?php echo $class; ?>" <?php echo $attr2; ?> href="#" data-url="<?php echo site_url('services/dislike-property/' . url_title($record['name']) . '/' . $record['code']); ?>"><span><i class="icon-thumbs-down"></i> <span><?php echo ( !empty($record['numdislikes']) ? $record['numdislikes'] : '' ); ?></span></span><span></span></a>
                        </div>
                        <div class="numviews"><?php echo $record['numviews']; ?></div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
            </div>        
            
            <div class="profile-detail">
                
                <table cellpadding="0" cellmargin="0">
                    <tr>
                        <td class="profile-container-left-td profile-detail-left" style="vertical-align:top;">

                            <div class="spacer-small"></div>

                            <ul class="nav nav-pills">
                                <li class="active">
                                    <a href="#tabdetails" data-toggle="tab">Details</a>
                                </li>
                                <?php if(!empty($record['video'])) { ?>
                                <li><a href="#tabvideos" data-toggle="tab" class="tab-videos" data-mode="">Videos</a></li>
                                <?php } ?>
                                <li><a href="#tabcomments" data-toggle="tab" class="tab-comments" data-mode="">Comments</a></li>
                            </ul>

                            <div class="spacer"></div>

                            <div class="tab-content">

                                <div id="tabdetails" class="tab-pane active">

                                    <div class="profile-detail-block">
                                        <table class="table table-condensed table-striped">
                                            <tr>
                                                <th class="summary-tbl-hdr">Posting For</th>
                                                <td><?php echo $record['posting']; ?></td>
                                            </tr>
                                            <tr>
                                                <th class="summary-tbl-hdr tbl-td">Price</th>
                                                <td><span class="price"><?php echo $record['price2']; ?></span></td>
                                            </tr>
                                            <tr>
                                                <th class="summary-tbl-hdr">Type</th>
                                                <td><?php echo $record['classification']; ?></td>
                                            </tr>
                                            <?php if(!empty($record['location'])) { ?>
                                            <tr>
                                                <th class="summary-tbl-hdr">Location</th>
                                                <td><?php echo $record['location']; ?></td>
                                            </tr>
                                            <?php } ?>
                                            <?php if(!empty($record['address'])) { ?>
                                            <tr>
                                                <th class="summary-tbl-hdr">Address</th>
                                                <td><?php echo $record['address']; ?></td>
                                            </tr>
                                            <?php } ?>
                                            <?php if(!empty($record['companyname'])) { ?>
                                            <tr>
                                                <th class="summary-tbl-hdr">Developer</th>
                                                <td><a href="<?php echo site_url('company/' . url_title($record['companyname']) . '/' . $record['companycode']); ?>" title=""><?php echo $record['companyname']; ?></a></td>
                                            </tr>
                                            <?php } ?>
                                            <tr>
                                                <th class="summary-tbl-hdr">Date Posted</th>
                                                <td><?php echo $record['fdatepublished']; ?></td>
                                            </tr>
                                        </table>
                                    </div>

                                    <?php if( !empty($record['rooms']) || !empty($record['toilets']) ||
                                              !empty($record['area']) || !empty($record['garage']) ||
                                              !empty($record['floorsnum']) || !empty($record['unitsnum']) ) { ?>

                                    <h4 class="profile-detail-hdr">Size</h4>

                                    <div class="profile-detail-block">
                                        <table class="table table-condensed table-striped">
                                            <?php echo ( !empty($record['area']) ? '<tr><th class="summary-tbl-hdr">Area</th><td>' . $record['area'] . '</td></tr>' : '' ); ?>
                                            <?php echo ( !empty($record['rooms']) ? '<tr><th class="summary-tbl-hdr">Rooms</th><td>' . $record['rooms'] . '</td></tr>' : '' ); ?>
                                            <?php echo ( !empty($record['toilets']) ? '<tr><th class="summary-tbl-hdr">Toilets</th><td>' . $record['toilets'] . '</td></tr>' : '' ); ?>
                                            <?php echo ( !empty($record['garage']) ? '<tr><th class="summary-tbl-hdr">' . $record['garagelabel'] . '</th><td>' . $record['garage'] . '</td></tr>' : '' ); ?>
                                            <?php echo ( !empty($record['floorsnum']) ? '<tr><th class="summary-tbl-hdr">Floors</th><td>' . $record['floorsnum'] . '</td></tr>' : '' ); ?>
                                            <?php echo ( !empty($record['unitsnum']) ? '<tr><th class="summary-tbl-hdr">Units</th><td>' . $record['unitsnum'] . '</td></tr>' : '' ); ?>
                                        </table>
                                    </div>
                                    <?php } ?>

                                    <?php if( !empty($record['financing']) || !empty($record['pricedown']) ||
                                              !empty($record['pricereserve']) || !empty($record['pricediscount']) ||
                                              !empty($record['paymentscheme']) ) { ?>

                                    <h4 class="profile-detail-hdr">Finances</h4>

                                    <div class="profile-detail-block">
                                        <table class="table table-condensed table-striped">
                                            <?php echo ( !empty($record['financing']) ? '<tr><th class="summary-tbl-hdr">Accepted Financing</th><td>' . $record['financing'] . '</td></tr>' : '' ); ?>
                                            <?php echo ( !empty($record['pricereserve']) ? '<tr><th class="summary-tbl-hdr">Reservation</th><td>' . $record['pricereserve'] . '</td></tr>' : '' ); ?>
                                            <?php echo ( !empty($record['pricedown']) ? '<tr><th class="summary-tbl-hdr">Down Payment</th><td>' . $record['pricedown'] . '</td></tr>' : '' ); ?>
                                            <?php echo ( !empty($record['pricediscount']) ? '<tr><th class="summary-tbl-hdr">Discount</th><td>' . $record['pricediscount'] . '</td></tr>' : '' ); ?>
                                            <?php if(!empty($record['paymentscheme'])) { ?>
                                            <tr>
                                                <th colspan="2">Payment Scheme</th>
                                            </tr>
                                            <tr>
                                                <td colspan="2"><?php echo nl2br($record['paymentscheme']); ?></td>
                                            </tr>
                                            <?php } ?>
                                        </table>
                                    </div>
                                    <?php } ?>

                                    <?php if( !empty($record['tenure']) || !empty($record['foreclosure']) ||
                                              !empty($record['resale']) ) { ?>

                                    <h4 class="profile-detail-hdr">Legal</h4>

                                    <div class="profile-detail-block">
                                        <table class="table table-condensed table-striped">
                                            <?php echo ( !empty($record['tenure']) ? '<tr><th class="summary-tbl-hdr">Tenure</th><td>' . $record['tenure'] . '</td></tr>' : '' ); ?>
                                            <?php echo ( !empty($record['foreclosure']) ? '<tr><th class="summary-tbl-hdr">Foreclosure</th><td>' . $record['foreclosure'] . '</td></tr>' : '' ); ?>
                                            <?php echo ( !empty($record['resale']) ? '<tr><th class="summary-tbl-hdr">Resale</th><td>' . $record['resale'] . '</td></tr>' : '' ); ?>
                                        </table>
                                    </div>
                                    <?php } ?>

                                    <?php if( !empty($record['construction']) || !empty($record['completion']) ||
                                              !empty($record['occupancy']) || !empty($record['furnished']) ) { ?>

                                    <h4 class="profile-detail-hdr">Development</h4>

                                    <div class="profile-detail-block">
                                        <table class="table table-condensed table-striped">
                                            <?php echo ( !empty($record['construction']) ? '<tr><th class="summary-tbl-hdr">Construction</th><td>' . $record['construction'] . '</td></tr>' : '' ); ?>
                                            <?php echo ( !empty($record['completion']) ? '<tr><th class="summary-tbl-hdr">Completion</th><td>' . $record['completion'] . '</td></tr>' : '' ); ?>
                                            <?php echo ( !empty($record['occupancy']) ? '<tr><th class="summary-tbl-hdr">Ready for Occupancy</th><td>' . $record['occupancy'] . '</td></tr>' : '' ); ?>
                                            <?php echo ( !empty($record['furnished']) ? '<tr><th class="summary-tbl-hdr">Furnish</th><td>' . $record['furnished'] . '</td></tr>' : '' ); ?>
                                        </table>
                                    </div>
                                    <?php } ?>

                                    <?php if(!empty($record['furnishings'])) { ?>

                                    <h4 class="profile-detail-hdr">Furnishings</h4>

                                    <div class="profile-detail-block">
                                        <table class="table table-condensed">
                                            <tr>
                                                <td colspan="2"><?php echo $record['furnishings']; ?></td>
                                            </tr>
                                        </table>
                                    </div>
                                    <?php } ?>

                                    <?php if(!empty($record['features'])) { ?>

                                    <h4 class="profile-detail-hdr">Features</h4>

                                    <div class="profile-detail-block">
                                        <table class="table table-condensed">
                                            <tr>
                                                <td colspan="2"><?php echo $record['features']; ?></td>
                                            </tr>
                                        </table>
                                    </div>
                                    <?php } ?>

                                    <?php if(!empty($record['facilities'])) { ?>

                                    <h4 class="profile-detail-hdr">Facilities</h4>

                                    <div class="profile-detail-block">
                                        <table class="table table-condensed">
                                            <tr>
                                                <td colspan="2"><?php echo $record['facilities']; ?></td>
                                            </tr>
                                        </table>
                                    </div>
                                    <?php } ?>

                                    <div class="spacer"></div>

                                    <?php if( !empty($record['coordlat']) && !empty($record['coordlong']) ) { ?>
                                    <div>
                                        <div id="divmap" style="height:300px;"></div>
                                    </div>
                                    <div class="spacer"></div>
                                    <div class="spacer"></div>
                                    <?php } ?>

                                    <?php if(!empty($record['description'])) { ?>
                                    <div>
                                        <?php echo nl2br($record['description']); ?>
                                    </div>
                                    <div class="spacer"></div>
                                    <?php } ?>

                                    <div class="spacer"></div>

                                </div>

                                <?php if(!empty($record['video'])) { ?>
                                <div id="tabvideos" class="tab-pane videos">
                                    <div align="center"><img src="../../assets/img/spinner.gif"></div>
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

                            <div class="profbtns" align="center">
                                <button class="btn btn-medium comparison" type="button">
                                    <span><i class="icon-screenshot"></i> Compare</span><span></span>
                                </button>
                                <button class="btn btn-medium shortlist" type="button">
                                    <span><i class="icon-list-alt"></i> Shortlist</span><span></span>
                                </button>
                                <?php if( !empty($record['ownercode']) && $usercode != $record['ownercode'] ) { ?>
                                <?php
                                $class = ( $userlogin ? '' : 'tooltip-propertyfinder' );
                                $attr = ( $userlogin ? ' ' : ' data-placement="bottom" data-title="Please login"' );
                                ?>
                                <button class="btn btn-medium message <?php echo $class; ?>" <?php echo $attr; ?> type="button" data-url="<?php echo site_url('messages/reply/' . url_title($record['ownername']) . '/' . $record['ownercode']); ?>">
                                    <i class="icon-envelope"></i>
                                </button>
                                <?php } ?>
                                <?php if( !empty($record['ownercode']) && $usercode == $record['ownercode'] ) { ?>
                                <div class="btn-group" align="left">
                                    <button class="btn btn-medium dropdown-toggle" data-toggle="dropdown" type="button">
                                        <i class="icon-cog"></i>
                                    </button>
                                    <ul class="dropdown-menu pull-right">
                                        <li><a href="#" class="appended-edit-property edit-property" data-url="<?php echo site_url('property/post/' . url_title($record['name']) . '/' . $record['code']); ?>">Edit property</a></li>
                                        <?php if($record['soldout'] != YES || $record['closed'] != YES) { ?>
                                        <li class="divider"></li>
                                        <?php if($record['soldout'] != YES) { ?>
                                        <li><a href="#" class="appended-sold-out-property sold-out-property" data-profile="<?php echo current_url(); ?>" data-url="<?php echo site_url('services/property-sold-out/' . url_title($record['name']) . '/' . $record['code']); ?>">Change status: Sold-out</a></li>
                                        <?php } ?>
                                        <?php if($record['closed'] != YES) { ?>
                                        <li><a href="#" class="appended-closed-property closed-property" data-profile="<?php echo current_url(); ?>" data-url="<?php echo site_url('services/property-closed/' . url_title($record['name']) . '/' . $record['code']); ?>">Change status: Closed</a></li>
                                        <?php } ?>
                                        <?php } ?>
                                        <?php if($record['featured'] != YES) { ?>
                                        <li class="divider"></li>
                                        <li><a href="#" class="appended-feature-property feature-property" data-profile="<?php echo current_url(); ?>" data-url="<?php echo site_url('feature/property/' . url_title($record['name']) . '/' . $record['code']); ?>">Feature this!</a></li>
                                        <?php } ?>
                                    </ul>
                                </div>
                                <?php } ?>
                            </div>

                            <div class="spacer"></div>

                            <div>
                                <h4 class="profile-detail-right-hdr">Summary</h4>
                                <?php if($record['featured'] == YES) { ?>
                                <div align="center">
                                    <span class="label label-inverse"><i class="icon-certificate icon-white"></i> This is a FEATURED property!</span>
                                    <div class="spacer"></div>
                                </div>
                                <?php } ?>
                                <table class="table table-condensed">
                                    <?php if($record['soldout'] == YES || $record['closed'] == YES) { ?>
                                    <tr>
                                        <th style="width:100px;">Availability</th>
                                        <td><?php echo ($record['soldout'] == YES ? '<span class="propstatus">SOLD OUT</span>' : '') . ($record['soldout'] == YES && $record['closed'] == YES ? ' | ' : '') . ($record['closed'] == YES ? '<span class="propstatus">CLOSED</span>' : ''); ?></td>
                                    </tr>
                                    <?php } ?>
                                    <tr>
                                        <th style="width:100px;">Price</th>
                                        <td><span class="price"><?php echo $record['price']; ?></span></td>
                                    </tr>
                                    <tr>
                                        <th>Type</th>
                                        <td><?php echo $record['classification']; ?></td>
                                    </tr>
                                    <?php if(!empty($record['location'])) { ?>
                                    <tr>
                                        <th>Location</th>
                                        <td><?php echo $record['location']; ?></td>
                                    </tr>
                                    <?php } ?>
                                    <?php if(!empty($record['address'])) { ?>
                                    <tr>
                                        <th>Address</th>
                                        <td><?php echo $record['address']; ?></td>
                                    </tr>
                                    <?php } ?>
                                    <?php if(!empty($record['companyname'])) { ?>
                                    <tr>
                                        <th>Developer</th>
                                        <td><a href="<?php echo site_url('company/' . url_title($record['companyname']) . '/' . $record['companycode']); ?>" title=""><?php echo $record['companyname']; ?></a></td>
                                    </tr>
                                    <?php } ?>
                                    <tr>
                                        <th>Date Posted</th>
                                        <td><?php echo $record['fdatepublished']; ?></td>
                                    </tr>
                                </table>
                            </div>

                            <div class="spacer"></div>

                            <div>
                                <h4 class="profile-detail-right-hdr">Posted By</h4>
                                <?php $ownerlink = site_url( ( $record['ownertype'] == USERTYPE_COMPANY ? 'company/' : 'agent/' ) . url_title($record['ownername']) . '/' . $record['ownercode']); ?>
                                <div>
                                    <div class="spacer-small"></div>
                                    <div align="center">
                                        <a href="<?php echo $ownerlink; ?>" class="profpostermainthumblink profmainthumb">
                                            <img src="<?php echo site_url(). ( empty($record['ownerpic']) ? 'assets/img/agent150.png' : ( $record['ownertype'] == USERTYPE_COMPANY ? 'realties/' : 'profiles/' ) . $record['ownerpic'] ); ?>" width="100" class="img-rounded">
                                        </a>
                                    </div>
                                    <div class="clearfix spacer"></div>
                                    <a href="<?php echo $ownerlink; ?>" class="profpostermainname profmainname"><?php echo $record['ownername']; ?></a>
                                    <?php echo ( !empty($record['ownerlicense']) ? '<br/>License No.: ' . $record['ownerlicense'] : '' ); ?>
                                    <div class="profposterrating">
                                        <div class="profposterlevel">
                                            <?php echo $record['ownerlevel']; ?>
                                            <?php echo $record['ownerverifiedagent']; ?>
                                        </div>
                                        <div class="profposterrate">
                                            <?php
                                            $class = ( $userlogin ? '' : 'tooltip-propertyfinder' );
                                            $attr = ( $userlogin ? ' data-urate="' . $record['useragentrating'] . '"' : ' data-placement="top" data-title="Please login"' );
                                            ?>
                                            <div class="arater rater-small pull-right <?php echo $class; ?>" <?php echo $attr; ?> data-url="<?php echo site_url('services/rate-agent/' . url_title($record['ownername']) . '/' . $record['ownercode']); ?>" data-qstring="<?php echo $record['ownercode']; ?>" data-orate="<?php echo $record['ownerrating']; ?>" data-nrate="<?php echo $record['ownernumrating']; ?>"></div>
                                            <div class="rated rated-right"></div>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="spacer"></div>
                            <div class="spacer"></div>

                            <div>
                                <h4 class="profile-detail-right-hdr">Contact</h4>
                                <?php if( !empty($record['ownermobilenum']) || !empty($record['ownerhomenum']) || 
                                        !empty($record['ownerofficenum']) || !empty($record['ownerskype']) ) { ?>
                                <table class="table table-condensed">
                                    <?php if( !empty($record['ownermobilenum']) ) { ?>
                                    <tr>
                                        <th style="width:70px;">Mobile No.</th>
                                        <td><?php echo $record['ownermobilenum']; ?></td>
                                    </tr>
                                    <?php } ?>
                                    <?php if( !empty($record['ownerhomenum']) ) { ?>
                                    <tr>
                                        <th style="width:70px;">Home No.</th>
                                        <td><?php echo $record['ownerhomenum']; ?></td>
                                    </tr>
                                    <?php } ?>
                                    <?php if( !empty($record['ownerofficenum']) ) { ?>
                                    <tr>
                                        <th style="width:70px;">Office No.</th>
                                        <td><?php echo $record['ownerofficenum']; ?></td>
                                    </tr>
                                    <?php } ?>
                                    <?php if( !empty($record['ownerskype']) ) { ?>
                                    <tr>
                                        <th style="width:70px;">Skype</th>
                                        <td><?php echo $record['ownerskype']; ?></td>
                                    </tr>
                                    <?php } ?>
                                </table>
                                <?php } ?>
                                <div class="profsocials">
                                    <?php if(!empty($record['owneraccfb'])) { ?>
                                    <a href="<?php echo $record['owneraccfb']; ?>" target="_blank" class="sociallink tooltip-propertyfinder" data-placement="top" data-title="Facebook profile"><i class="icon2-facebook-sign icon2-2x"></i></a>
                                    <?php } ?>
                                    <?php if(!empty($record['owneracctwitter'])) { ?>
                                    <a href="<?php echo $record['owneracctwitter']; ?>" target="_blank" class="sociallink tooltip-propertyfinder" data-placement="top" data-title="Twitter profile"><i class="icon2-twitter-sign icon2-2x"></i></a>
                                    <?php } ?>
                                    <?php if(!empty($record['owneraccgoogle'])) { ?>
                                    <a href="<?php echo $record['owneraccgoogle']; ?>" target="_blank" class="sociallink tooltip-propertyfinder" data-placement="top" data-title="Google+ profile"><i class="icon2-google-plus-sign icon2-2x"></i></a>
                                    <?php } ?>
                                    <?php if(!empty($record['owneracclinkedin'])) { ?>
                                    <a href="<?php echo $record['owneracclinkedin']; ?>" target="_blank" class="sociallink tooltip-propertyfinder" data-placement="top" data-title="LinkedIn profile"><i class="icon2-linkedin-sign icon2-2x"></i></a>
                                    <?php } ?>
                                </div>
                                <?php if( !empty($record['ownercode']) && $usercode != $record['ownercode'] ) { ?>
                                <div align="center">
                                    <?php
                                    $class = ( $userlogin ? '' : 'tooltip-propertyfinder' );
                                    $attr = ( $userlogin ? ' ' : ' data-placement="bottom" data-title="Please login"' );
                                    ?>
                                    <button class="btn btn-medium message <?php echo $class; ?>" <?php echo $attr; ?> type="button" data-url="<?php echo site_url('messages/reply/' . url_title($record['ownername']) . '/' . $record['ownercode']); ?>">
                                        <i class="icon-envelope"></i> Start a conversation
                                    </button>
                                </div>
                                <?php } ?>
                            </div>

                            <div class="spacer"></div>
                            <div class="spacer"></div>
                            
                            <div>
                                <h4 class="profile-detail-right-hdr">Share to your network</h4>
                                <div align="center">
                                    <?php $pg_url = site_url('property/' . url_title($record['name']) . '/' . $record['code']); ?>
                                    <a href="http://www.facebook.com/sharer/sharer.php?u=<?php echo $pg_url; ?>" class="sociallink socialshare tooltip-propertyfinder" data-placement="top" data-title="Share to your Facebook"><i class="icon2-facebook-sign icon2-3x"></i></a>&nbsp;
                                    <a href="http://twitter.com/home?status=<?php echo $pg_url; ?>" class="sociallink socialshare tooltip-propertyfinder" data-placement="top" data-title="Share to your Twitter"><i class="icon2-twitter-sign icon2-3x"></i></a>&nbsp;
                                    <a href="https://plusone.google.com/_/+1/confirm?hl=en&url=<?php echo $pg_url; ?>" class="sociallink socialshare tooltip-propertyfinder" data-placement="top" data-title="Share to your Google+"><i class="icon2-google-plus-sign icon2-3x"></i></a>
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

<link href="<?php echo site_url(); ?>assets/js/colorbox/colorbox.css" rel="stylesheet">

<script type="text/javascript">
var curl = 'comparisons/add/<?php echo url_title($record['name']) ?>/<?php echo $record['code']; ?>';
var surl = 'shortlist/add/<?php echo url_title($record['name']) ?>/<?php echo $record['code']; ?>';
head.ready(function() {
    head.js("<?php echo site_url(); ?>assets/js/colorbox/jquery.colorbox-min.js");
    objprof = {'id':'<?php echo $record['code']; ?>','name':'<?php echo $record['name']; ?>','link':'<?php echo site_url('property/' . url_title($record['name']) . '/' . $record['code']); ?>','profpic':'<?php echo $record['profilepic']; ?>'};
    <?php if(!empty($record['code'])) { ?>
    load_property_profile();
    <?php } ?>
});
</script>
<?php if( !empty($record['coordlat']) && !empty($record['coordlong']) ) { ?>
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?v=3&sensor=false&key=AIzaSyDngCmTbQXV7kK3polRDeN3Td6pjVwsaOk"></script>
<script type="text/javascript">
    var latlng = new google.maps.LatLng('<?php echo $record['coordlat']; ?>', '<?php echo $record['coordlong']; ?>');

    google.maps.event.addDomListener(window, "load", function() {
        var map = new google.maps.Map(document.getElementById("divmap"), {
          center: latlng,
          zoom: 15,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        });

        var marker=new google.maps.Marker({
            position: latlng,
        });

        marker.setMap(map);

        var infowindow = new google.maps.InfoWindow({
            content:"<div><strong><?php echo $record['name']; ?></strong></div><div>for <?php echo $record['posting']; ?></div><div><?php echo $record['classification']; ?></div>"
        });

        infowindow.open(map,marker);
    }); 
</script>
<?php } ?>

<?php } ?>