
<?php $userfullname = $record->fname . ' ' . $record->lname; ?>
<?php $userlink = site_url('agent/' . url_title($userfullname) . '/' . $record->usercode); ?>
<div class="agentlistitem">
    <div class="userthumb">
        <a href="<?php echo $userlink; ?>" title="<?php echo $userfullname; ?>">
            <img src="<?php echo site_url(). ( empty($record->profilepic) ? 'assets/img/agent150.png' : 'profiles/' . $record->profilepic ); ?>" style="height:100px;max-height:100px;max-width:150px;">
        </a>
    </div>
    <div class="agentlistitemsum<?php echo ( $record->featured == YES ? '-featured' : '' ); ?>">
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
            <div class="profposterrate">
                <?php
                $class = ( $userlogin ? '' : 'tooltip-propertyfinder' );
                $attr = ( $userlogin ? ' data-urate="' . $record->useragentrating . '"' : ' data-placement="top" data-title="Please login"' );
                ?>
                <div class="arater pull-right <?php echo ( isset($appended) ? 'appendedrater' : '' ); ?> <?php echo $class; ?>" <?php echo $attr; ?> data-url="<?php echo site_url('services/rate-agent/' . url_title($userfullname) . '/' . $record->usercode); ?>" data-qstring="<?php echo $record->usercode; ?>" data-orate="<?php echo $record->rating; ?>" data-nrate="<?php echo $record->numrating; ?>"></div>
                <div class="rated rated-right pull-right"></div>
                <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="clearfix"></div>
</div>
<div class="spacer"></div>