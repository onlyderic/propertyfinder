<div class="appended-proplistitem proplistitem">
    <div class="userthumb">
        <?php
        $profilecontroller = ( $record->ownerusertype == USERTYPE_COMPANY ? 'company' : 'agent' );
        $profileimgfolder = ( $record->ownerusertype == USERTYPE_COMPANY ? 'realties' : 'profiles' );
        ?>
        <a href="<?php echo site_url($profilecontroller . '/' . url_title($record->ownername) . '/' . $record->ownercode); ?>" title="<?php echo $record->ownername; ?>">
            <img src="<?php echo site_url(). ( empty($record->ownerpic) ? 'assets/img/agent50.png' : $profileimgfolder . '/' . $record->ownerpic ); ?>" width="50" title="" class="img-rounded img-polaroid" />
        </a>
    </div>
    <div class="proplistitemsum">
        <div class="<?php echo ( $record->featured == YES ? 'featured' : '' ); ?>">
            <div class="proplistitemimg" align="center">
                <a href="<?php echo site_url('property/' . url_title($record->propname) . '/' . $record->propcode); ?>" class="proplistitemimglink" title="<?php echo $record->propname; ?>">
                    <img src="<?php echo site_url('photos/' . $record->propcode . '/thumbs/' . $record->profilepic); ?>" style="<?php echo (!empty($record->profilepicwidth) ? 'width:' . $record->profilepicwidth . 'px;' : '') . (!empty($record->profilepicheight) ? 'height:' . $record->profilepicheight . 'px;' : ''); ?>" >
                </a>
            </div>
            <div class="proplistitemname">
                <a href="<?php echo site_url('property/' . url_title($record->propname) . '/' . $record->propcode); ?>" class="proplistitemnamelink"><strong><?php echo $record->propname; ?></strong></a>
            </div>
            <div style="padding:0 5px;" align="left">
                <div class="proplistitemcategory">
                    <?php echo get_text_classification($record->classification); ?>
                </div>
                <div class="proplistitemprice"><?php echo money_symbol($record->priceunit) . format_money($record->pricemin) . ( !empty($record->pricemax) ? ' - ' . format_money($record->pricemax) : '' ); ?></div>
                <div class="clearfix"></div>
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
                    <a style="border:none;box-shadow:none;border-radius:0 0 4px 0" <?php echo $attr1; ?> class="pull-right btn btn-medium thumbs-down <?php echo $class; ?>" <?php echo $attr2; ?> href="#" data-url="<?php echo site_url('services/dislike-property/' . url_title($record->propname) . '/' . $record->propcode); ?>"><span><i class="icon-thumbs-down"></i> <span class="item-btns-thumbs"><?php echo ( !empty($record->numdislikes) ? $record->numdislikes : '' ); ?></span></span><span></span></a>
                    <a style="border:none;box-shadow:none;border-radius:0px;" <?php echo $attr1; ?> class="pull-right btn btn-medium thumbs-up <?php echo $class; ?>" <?php echo $attr2; ?> href="#" data-url="<?php echo site_url('services/like-property/' . url_title($record->propname) . '/' . $record->propcode); ?>"><span><i class="icon-thumbs-up"></i> <span class="item-btns-thumbs"><?php echo ( !empty($record->numlikes) ? $record->numlikes : '' ); ?></span></span><span></span></a>
                </div>
                <div class="numviews item-btns-mid" align="right"><?php echo format_number_whole($record->numviews) . ( $record->numviews == 1 ? ' view' : ' views' ); ?></div>
                <div class="clearfix"></div>
            </div>
            <?php
            $ulstr = '';
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
            <?php if($record->recstatus == PROPSTATUS_DRAFT) { ?>
            <div class="draft">I'm still a DRAFT!</div>
            <?php } ?>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="clearfix"></div>
</div>
<div class="spacer"></div>