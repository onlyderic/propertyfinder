<div class="bannertop"></div>

<div class="container">
    
<div class="row">
    <div class="span3 propertyfinder-sidebar">
        <ul class="nav nav-list propertyfinder-sidenav">
            <li><a href="#settings"><i class="icon-chevron-right"></i> Settings</a></li>
            <li class="button"><a href="#" class="formsave"><i class="icon-circle-arrow-down"></i> <strong>Save</strong></a></li>
        </ul>
    </div>
    <div class="span9" align="left">
        <form action="<?php echo current_url(''); ?>" method="post" id="frmpropertyfinder" class="form-horizontal">
            
            <section id="settings">
            
                <?php if(!empty($message)) { ?><div class="alert alert-<?php echo $message_status; ?>"><?php echo $message; ?><a class="close" data-dismiss="alert" href="#">&times;</a></div><?php } ?>
                <?php
                $errs = validation_errors();
                if(!empty($errs)) {
                ?>
                    <div class="alert alert-error">There are errors on the form. Please correct and save again.<a class="close" data-dismiss="alert" href="#">&times;</a></div>
                <?php } ?>
                
                <h3>Settings</h3>

                <div style="padding-left:50px;">
                    <div class="control-group" style="margin-left:0px;padding-left:0px;">
                        <div class="controls" style="float:left;width:30px;margin-left:0px;">
                            <input type="checkbox" id="profsettings[NEWPOST]" name="profsettings[NEWPOST]" value="1" <?php echo set_checkbox('profsettings[NEWPOST]', '1', (isset($settings['NEWPOST']) ? true: false ) ); ?> />
                        </div>
                        <label class="control-label" for="profsettings[NEWPOST]" style="width:300px;text-align:left;float:left;">Email me on newly posted properties</label>
                    </div>
                    <div class="control-group" style="margin-left:0px;padding-left:0px;">
                        <div class="controls" style="float:left;width:30px;margin-left:0px;">
                            <input type="checkbox" id="profsettings[PROPCOMMENT]" name="profsettings[PROPCOMMENT]" value="1" <?php echo set_checkbox('profsettings[PROPCOMMENT]', '1', (isset($settings['PROPCOMMENT']) ? true: false ) ); ?> />
                        </div>
                        <label class="control-label" for="profsettings[PROPCOMMENT]" style="width:300px;text-align:left;float:left;">Email me on comments to my properties</label>
                    </div>
                    <div class="control-group" style="margin-left:0px;padding-left:0px;">
                        <div class="controls" style="float:left;width:30px;margin-left:0px;">
                            <input type="checkbox" id="profsettings[PROPRATE]" name="profsettings[PROPRATE]" value="1" <?php echo set_checkbox('profsettings[PROPRATE]', '1', (isset($settings['PROPRATE']) ? true: false ) ); ?> />
                        </div>
                        <label class="control-label" for="profsettings[PROPRATE]" style="width:300px;text-align:left;float:left;">Email me on rating of my properties</label>
                    </div>
                    <div class="control-group" style="margin-left:0px;padding-left:0px;">
                        <div class="controls" style="float:left;width:30px;margin-left:0px;">
                            <input type="checkbox" id="profsettings[PROPEDIT]" name="profsettings[PROPEDIT]" value="1" <?php echo set_checkbox('profsettings[PROPEDIT]', '1', (isset($settings['PROPEDIT']) ? true: false ) ); ?> />
                        </div>
                        <label class="control-label" for="profsettings[PROPEDIT]" style="width:300px;text-align:left;float:left;">Email me on edits of my properties</label>
                    </div>
                </div>
            </section>
            
        </form>
    </div>
</div>

</div> <!-- /container -->