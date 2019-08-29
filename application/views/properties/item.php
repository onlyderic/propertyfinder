<div class="appended-proplistitem proplistitem">
    <?php if(isset($showuser) && !$showuser) { ?>
    <div class="pull-left" style="padding-left:25px;">&nbsp;</div>
    <?php } else { ?>
    <div class="userthumb">
        <?php
        $profilecontroller = ( $record->ownerusertype == USERTYPE_COMPANY ? 'company' : 'agent' );
        $profileimgfolder = ( $record->ownerusertype == USERTYPE_COMPANY ? 'realties' : 'profiles' );
        ?>
        <a href="<?php echo site_url($profilecontroller . '/' . url_title($record->ownername) . '/' . $record->ownercode); ?>" title="<?php echo $record->ownername; ?>">
            <img src="<?php echo site_url(). ( empty($record->ownerpic) ? 'assets/img/agent50.png' : $profileimgfolder . '/' . $record->ownerpic ); ?>" width="50" title="" class="img-rounded img-polaroid" />
        </a>
    </div>
    <?php } ?>
    <div class="proplistitemsum">
        <div class="<?php echo ( $record->featured == YES ? 'featured' : '' ); ?>">
            <div class="proplistitemimg" align="center">
                <a href="<?php echo site_url('property/' . url_title($record->propname) . '/' . $record->propcode); ?>" class="proplistitemimglink" title="<?php echo $record->propname; ?>">
                    <img src="<?php echo site_url('photos/' . $record->propcode . '/thumbs/' . $record->profilepic); ?>" style="<?php echo (!empty($record->profilepicwidth) ? 'width:' . $record->profilepicwidth . 'px;' : '') . (!empty($record->profilepicheight) ? 'height:' . $record->profilepicheight . 'px;' : ''); ?>">
                </a>
            </div>
            <div class="proplistitemname">
                <a href="<?php echo site_url('property/' . url_title($record->propname) . '/' . $record->propcode); ?>" class="proplistitemnamelink"><?php echo shorten_text($record->propname, 60); ?></a>
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
                    $summary = ( !empty($record->roomsmin) ? get_text_room($record->roomsmin) . ( !empty($record->roomsmax) ? ' to ' . $record->roomsmax : '' ) . ' Rooms' : '' );
                    $summary .= ( !empty($record->areamin) ? ( !empty($summary) ? ' <span class="bullet">&bull;</span> ' : '' ) . format_number_whole($record->areamin) . ( !empty($record->areamax) ? ' to ' . format_number_whole($record->areamax) : '' ) . ' ' . $record->areaunit : '' );
                    $summary .= ( !empty($record->datepublished) ? ( !empty($summary) ? ' <span class="bullet">&bull;</span> ' : '' ) . time_elapsed($record->datepublished) : '' );
                    echo $summary;
                    ?>
                </div>
                <div class="item-btns">
                    <?php
                    $class = ( $userlogin ? '' : 'tooltip-propertyfinder' );
                    $attr = ( $userlogin ? ' data-urate="' . $record->userrating . '"' : ' data-placement="top" data-title="Please login"' );
                    $attr1 = ( $userlogin ? ' data-uthumbs="' . $record->userthumbs . '"' : '' );
                    $attr2 = ( $userlogin ? '' : ' data-placement="top" data-title="Please login"' );
                    ?>
                    <div style="border:none;box-shadow:none;" class="pull-left btn rater <?php echo ( isset($appended) ? 'appendedrater' : '' ); ?> <?php echo $class; ?>" <?php echo $attr; ?> data-url="<?php echo site_url('services/rate-property/' . url_title($record->propname) . '/' . $record->propcode); ?>" data-qstring="<?php echo $record->propcode; ?>" data-orate="<?php echo $record->rating; ?>" data-nrate="<?php echo $record->numrating; ?>"></div>
                    <div class="rated pull-left item-btns-mid" align="left">&nbsp;</div>
                    <div class="liker <?php echo ( isset($appended) ? 'appendedliker' : '' ); ?>" <?php echo $attr1; ?> data-qstring="<?php echo $record->propcode; ?>" >
                        <a style="border:none;box-shadow:none;border-radius:0 0 4px 0;" <?php echo $attr1; ?> class="pull-right btn btn-medium thumbs-down <?php echo $class; ?>" <?php echo $attr2; ?> href="#" data-url="<?php echo site_url('services/dislike-property/' . url_title($record->propname) . '/' . $record->propcode); ?>"><span><i class="icon-thumbs-down"></i> <span class="item-btns-thumbs"><?php echo ( !empty($record->numdislikes) ? $record->numdislikes : '' ); ?></span></span><span></span></a>
                        <a style="border:none;box-shadow:none;border-radius:0px;" <?php echo $attr1; ?> class="pull-right btn btn-medium thumbs-up <?php echo $class; ?>" <?php echo $attr2; ?> href="#" data-url="<?php echo site_url('services/like-property/' . url_title($record->propname) . '/' . $record->propcode); ?>"><span><i class="icon-thumbs-up"></i> <span class="item-btns-thumbs"><?php echo ( !empty($record->numlikes) ? $record->numlikes : '' ); ?></span></span><span></span></a>
                    </div>
                    <div class="numviews item-btns-mid" align="right"><?php echo format_number_whole($record->numviews) . ( $record->numviews == 1 ? ' view' : ' views' ); ?></div>
                    <div class="clearfix"></div>
                </div>
            </div>

            <?php
            $ulstr = '';
            if(isset($shortlist) && $shortlist) {
            $ulstr .= '<li><a href="#" class="remove" data-url="' . site_url('shortlist/remove/' . url_title($record->propname) . '/' . $record->propcode) . '">Remove from shortlist</a></li>';            
            }
            if(isset($recentviews) && $recentviews) {
            $ulstr .= '<li><a href="#" class="remove" data-url="' . site_url('recent_views/remove/' . url_title($record->propname) . '/' . $record->propcode) . '">Remove from viewed</a></li>';            
            }
            if(empty($record->compared)) {
            $ulstr .= '<li><a href="#" class="compare-property appended-compare-property" data-url="' . site_url('comparisons/add/' . url_title($record->propname) . '/' . $record->propcode) . '">Add to comparison</a></li>';
            }
            if(empty($record->shortlisted)) {
            $ulstr .= '<li><a href="#" class="shortlist-property appended-shortlist-property" data-url="' . site_url('shortlist/add/' . url_title($record->propname) . '/' . $record->propcode) . '">Add to shortlist</a></li>';
            }
            if($record->ownercode == $usercode) {
            $ulstr .= '<li><a href="#" class="edit-property appended-edit-property" data-url="' . site_url('property/post/' . url_title($record->propname) . '/' . $record->propcode) . '">Edit property</a></li>';
            if($record->soldout != YES) {
            $ulstr .= '<li><a href="#" class="sold-out-property appended-sold-out-property" data-url="' . site_url('services/property-sold-out/' . url_title($record->propname) . '/' . $record->propcode) . '">Set to Sold-out</a></li>';
            }
            if($record->closed != YES) {
            $ulstr .= '<li><a href="#" class="closed-property appended-closed-property" data-url="' . site_url('services/property-closed/' . url_title($record->propname) . '/' . $record->propcode) . '">Set to Closed</a></li>';
            }
            if($record->featured != YES) {
            $ulstr .= '<li><a href="#" class="feature-property appended-feature-property" data-url="' . site_url('feature/property/' . url_title($record->propname) . '/' . $record->propcode) . '">Feature this!</a></li>';
            }
            }
            ?>
            <div class="propcog btn-group">
                <button class="btn btn-small dropdown-toggle" data-toggle="dropdown" type="button" <?php if(empty($ulstr)) { ?>disabled="disabled"<?php } ?>>
                    <i class="icon-cog"></i>
                </button>
                <ul class="dropdown-menu pull-right">
                    <?php echo $ulstr; ?>
                </ul>
            </div>

        </div>
    </div>
    <div class="clearfix"></div>
</div>
<div class="spacer"></div>