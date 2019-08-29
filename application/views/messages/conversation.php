<h4><?php echo $userfullname; ?></h4>
<div>
    <?php if($conversationcount > count($list)) { ?>
    <div align="center"><a href="#" class="loadmore-msg" data-url="<?php echo site_url('messages/load/' . url_title($userfullname) . '/' . $otherguy_usercode); ?>">Load previous messages...</a><span></span></div>
    <?php } ?>
    <div class="spacer"></div>
    <div class="msgitems">
        <?php
        foreach($list as $rec) {
            $data['record'] = $rec;
            $this->load->view('messages/item', $data); 
        }
        ?>
    </div>
</div>
<div class="spacer"></div>
<div align="center">
    <form id="frmreply" action="<?php echo site_url('messages/send_reply'); //Unused ?>" method="post" accept-charset="UTF-8">
        <textarea id="newmsg" name="newmsg" class="newmsg span6"></textarea>
    </form>
    <div align="right">
        <button type="button" class="btn reply" data-url="<?php echo site_url('messages/reply/' . url_title($userfullname) . '/' . $otherguy_usercode); ?>">Reply</button><span></span>
    </div>
    <div class="clearfix"></div>
</div>
<input type="hidden" id="off" name="off" value="<?php echo $off; ?>" />
<input type="hidden" id="lmt" name="lmt" value="<?php echo $lmt; ?>" />