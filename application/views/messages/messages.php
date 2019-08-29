<div class="wrapper">
    
<div class="bannertop"></div>

<div class="container">
    
    <div class="bg-container">
        
        <div class="bg-message-content">
                
            <div class="message-detail">
                
                <table cellpadding="0" cellmargin="0">
                    <tr>
                        <td class="message-container-left">

                            <h4>Inbox <span class="msgcount"><?php echo ( !empty($msgcount) ? '(' . $msgcount . ')' : '' ); ?></span></h4>
                            
                            <?php if(count($summary) <= 0) { ?>

                            <div class="alert alert-info">You have no messages yet.</div>

                            <?php } else { ?>

                            <div class="messagesearch" align="center">
                                <input type="text" class="span4" id="search" />
                            </div>
                            <div class="msgsumitems">
                                <?php foreach($summary as $msgsum) { ?>
                                    <div class="msgsumitem" data-url="<?php echo site_url('messages/read/' . url_title($msgsum['userfullname']) . '/' . $msgsum['ucode']); ?>" data-name="<?php echo $msgsum['userfullname']; ?>">
                                        <div class="msgsumitemuserthumb">
                                            <img src="<?php echo site_url(). ( empty($msgsum['profilepic']) ? ( $msgsum['usertype'] == USERTYPE_COMPANY ? 'assets/img/company50.png' : 'assets/img/agent50.png' ) : ( $msgsum['usertype'] == USERTYPE_COMPANY ? 'realties/' : 'profiles/' ) . $msgsum['profilepic'] ); ?>" width="50" title="<?php echo $msgsum['userfullname']; ?>" class="img-polaroid" />
                                        </div>
                                        <div class="msgsumitemuser <?php echo $msgsum['readstatusclass']; ?>">
                                            <strong><?php echo $msgsum['userfullname']; ?></strong>
                                            <br/>
                                            <small class="muted"><?php echo $msgsum['msgdate']; ?></small>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                <?php } ?>
                            </div>

                            <?php } ?>
            
                            <div class="spacer"></div>
                        </td>
                        <td class="message-container-right">

                            <div class="spacer-small"></div>
                            
                            <div class="conversation-box">
                                <div class="msgbox">
                                    <div class="alert">Please select a conversation.</div>
                                </div>
                                <div></div>
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