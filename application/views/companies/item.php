
<?php $userfullname = $record->companyname; ?>
<?php $userlink = site_url('company/' . url_title($userfullname) . '/' . $record->compcode); ?>
<div class="companylistitem">
    <div class="userthumb">
        <a href="<?php echo $userlink; ?>" title="<?php echo $userfullname; ?>">
            <img src="<?php echo site_url(). ( empty($record->profilepic) ? 'assets/img/company150.png' : 'realties/' . $record->profilepic ); ?>" style="height:100px;max-height:100px;max-width:150px;">
        </a>
    </div>
    <div class="companylistitemsum<?php echo ( $record->featured == YES ? '-featured' : '' ); ?>">
        <a href="<?php echo $userlink; ?>"><?php echo $userfullname; ?></a><br/>
        <?php $location = ( !empty($record->city) ? $record->city : '' ) . ( !empty($record->city) && !empty($record->country) ? ', ' : '' ) . ( !empty($record->country) ? get_text_country($record->country) : '' ); ?>
        <div><?php echo ( !empty($location) ? $location : '&nbsp;' ); ?></div>
        <div class="spacer"></div>
        <div class="spacer"></div>
        <div class="clearfix"></div>
        <div>
            <?php
            $class = ( $userlogin ? '' : 'tooltip-propertyfinder' );
            $attr = ( $userlogin ? ' data-urate="' . $record->useragentrating . '"' : ' data-placement="top" data-title="Please login"' );
            ?>
            <div class="crater pull-right <?php echo ( isset($appended) ? 'appendedrater' : '' ); ?> <?php echo $class; ?>" <?php echo $attr; ?> data-url="<?php echo site_url('services/rate-company/' . url_title($userfullname) . '/' . $record->compcode); ?>" data-qstring="<?php echo $record->compcode; ?>" data-orate="<?php echo $record->rating; ?>" data-nrate="<?php echo $record->numrating; ?>"></div>
            <div class="rated rated-right pull-right"></div>
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="clearfix"></div>
</div>
<div class="spacer"></div>