
<?php
$userfullname = $record->fname . ' ' . $record->lname;
if($record->usertype == USERTYPE_COMPANY) {
    $userlink = site_url('company/' . url_title($userfullname) . '/' . $record->bycode);
    $imagelink = site_url() . ( empty($record->profilepic) ? 'assets/img/company50.png' : 'realties/' . $record->profilepic );
} else {
    $userlink = site_url('agent/' . url_title($userfullname) . '/' . $record->bycode);
    $imagelink = site_url() . ( empty($record->profilepic) ? 'assets/img/agent50.png' : 'profiles/' . $record->profilepic );
}
?>
<div>
    <div class="notify-header" align="center">
        <a href="<?php echo $userlink; ?>" class="userthumblink" title="<?php echo $userfullname; ?>">
            <img src="<?php echo $imagelink; ?>" class="userthumblink-img">
        </a>
    </div>
    <div class="notify-content">
        <?php
            switch($record->notifytype) {
                case 'O': 
                case 'P': 
                    echo '<img src="../../assets/img/star-on.png" width="10">'; break;
                case 'U': echo '<i class="icon-thumbs-up"></i>'; break;
                case 'D': echo '<i class="icon-thumbs-down"></i>'; break;
                case 'M': echo '<i class="icon-envelope"></i>'; break;
            }
        ?>
        <a href="<?php echo $userlink; ?>"><?php echo ( $usercode == $record->bycode ? 'You' : $userfullname ); ?></a><?php
            switch($record->notifytype) {
                case 'O': echo '&nbsp;rated your profile'; break;
                case 'P': echo '&nbsp;rated'; break;
                case 'U': echo '&nbsp;liked'; break;
                case 'D': echo '&nbsp;disliked'; break;
                case 'M': echo '&nbsp;sent you a <a href="' . site_url('messages') . '">message</a>'; break;
            }
        ?>
        <?php if(!empty($record->propcode) && $record->notifytype != 'O' && $record->notifytype != 'M') { ?>
        <a href="<?php echo site_url('property/' . url_title($record->propname) . '/' . $record->propcode); ?>"><?php echo $record->propname; ?></a>
        <?php } ?>
        <span class="notify-content-date"><?php echo time_elapsed($record->datecreated); ?></span>
    </div>
    <div class="clearfix"></div>
</div>
<div class="spacer-small"></div>