    <div class="msgdetail-box">
        <div class="msgitemuserthumb">
            <a href="<?php echo site_url( ( $record->usertype == USERTYPE_COMPANY ? 'company' : 'agent' ) . '/' . url_title($record->fname . ' ' . $record->lname) . '/' . url_title($record->fromcode) ); ?>">
                <img src="<?php echo site_url(). ( empty($record->profilepic) ? ( $record->usertype == USERTYPE_COMPANY ? 'assets/img/company50.png' : 'assets/img/agent50.png' ) : ( $record->usertype == USERTYPE_COMPANY ? 'realties/' : 'profiles/' ) . $record->profilepic ); ?>" width="50" title="<?php echo $record->fname . ' ' . $record->lname; ?>" class="img-rounded" />
            </a>
        </div>
        <div class="msgdetail-info">
            <div class="msgdetail-name">
                <a href="<?php echo site_url( ( $record->usertype == USERTYPE_COMPANY ? 'company' : 'agent' ) . '/' . url_title($record->fname . ' ' . $record->lname) . '/' . url_title($record->fromcode) ); ?>" style="color:#333333;">
                    <strong><?php echo $record->fname . ' ' . $record->lname; ?></strong>
                </a>
            </div>
            <div class="msgdetail-date"><small class="muted"><?php echo $record->msgdate; ?></small></div>
            <div class="clearfix"></div>
            <div class="msgdetail-msg">
                <?php echo nl2br($record->message); ?>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>