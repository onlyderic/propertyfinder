<div class="bannertop"></div>

<div class="container">
    
    <div class="bg-container">
    
        <div class="bg-search-strip">
            <h3>Search for Agents & Brokers</h3>
        </div>
        
        <div class="bg-search-content">
            <form id="frmsearch" action="<?php echo site_url('agents/search'); ?>" method="post" accept-charset="UTF-8" class="form-horizontal">
                <div class="span4 form-inline">
                    <label for="searchkeywords" style="width:80px;">Keywords</label>
                    <input type="text" id="searchkeywords" name="searchkeywords" placeholder="Name, license number, company" value="<?php echo set_value('searchkeywords'); ?>">
                </div>
                <div class="span5 form-inline">
                    <label for="searchlocation" style="width:80px;">Location</label>
                    <input type="text" id="searchlocation" name="searchlocation" class="span2 inline" placeholder="City" value="<?php echo set_value('searchlocation'); ?>" />
                    <select id="searchcountry" name="searchcountry" class="span2 inline2" placeholder="Country">
                        <option value=""></option>
                        <?php foreach($countries as $key => $val) { ?>
                        <option value="<?php echo $key; ?>" <?php echo set_select('searchcountry', $key, ( $country == $key ? true : false ) ); ?> ><?php echo $val; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="clearfix"></div>
                <div class="spacer-small"></div>
                <div class="span6 form-inline">
                    <div class="btn-group" data-toggle="buttons-checkbox">
                        <button type="button" class="search-ck btn <?php echo ( isset($level[LEVEL_NEWBIE]) ? 'active' : '' ); ?>" data-mod="search-level" data-value="<?php echo LEVEL_NEWBIE; ?>">Newbies</button>
                        <button type="button" class="search-ck btn <?php echo ( isset($level[LEVEL_REGULAR]) ? 'active' : '' ); ?>" data-mod="search-level" data-value="<?php echo LEVEL_REGULAR; ?>">Regular Gusto</button>
                        <button type="button" class="search-ck btn <?php echo ( isset($level[LEVEL_MASTER]) ? 'active' : '' ); ?>" data-mod="search-level" data-value="<?php echo LEVEL_MASTER; ?>">Master Gusto</button>
                        <button type="button" class="search-ck btn <?php echo ( isset($level[LEVEL_PRIME]) ? 'active' : '' ); ?>" data-mod="search-level" data-value="<?php echo LEVEL_PRIME; ?>">Prime Gusto</button>
                    </div>
                </div>
                <div class="span2 form-inline" style="width:160px;margin-left:8px;">
                    <div class="btn-group" data-toggle="buttons-checkbox">
                        <button type="button" class="search-ck btn <?php echo ( $verified == YES ? 'active' : '' ); ?>" data-mod="search-verified" data-value="<?php echo YES; ?>"><i class="icon-ok-sign"></i> Verified Accounts</button>
                    </div>
                </div>
                <div class="span2 form-inline" style="width:160px;margin-left:8px;">
                    <div class="srater rater-big"></div>
                    <input type="hidden" id="searchrating" name="searchrating" value="<?php echo set_value('score', 0); ?>">
                </div>
                <div class="clearfix"></div>
                <div class="spacer"></div>
                <div align="center">
                    <span style="display:none;">
                       <input type="checkbox" id="search-level-<?php echo LEVEL_NEWBIE; ?>" name="searchlevel[]" value="<?php echo LEVEL_NEWBIE; ?>" <?php echo set_checkbox('searchlevel[]', LEVEL_NEWBIE, ( $level == LEVEL_NEWBIE ? true: false ) ); ?> />
                       <input type="checkbox" id="search-level-<?php echo LEVEL_REGULAR; ?>" name="searchlevel[]" value="<?php echo LEVEL_REGULAR; ?>" <?php echo set_checkbox('searchlevel[]', LEVEL_REGULAR, ( $level == LEVEL_REGULAR ? true: false ) ); ?> />
                       <input type="checkbox" id="search-level-<?php echo LEVEL_MASTER; ?>" name="searchlevel[]" value="<?php echo LEVEL_MASTER; ?>" <?php echo set_checkbox('searchlevel[]', LEVEL_MASTER, ( $level == LEVEL_MASTER ? true: false ) ); ?> />
                       <input type="checkbox" id="search-level-<?php echo LEVEL_PRIME; ?>" name="searchlevel[]" value="<?php echo LEVEL_PRIME; ?>" <?php echo set_checkbox('searchlevel[]', LEVEL_PRIME, ( $level == LEVEL_PRIME ? true: false ) ); ?> />
                       
                        <input type="checkbox" id="search-verified-Y" name="searchverified" value="<?php echo YES; ?>" <?php echo set_checkbox('searchverified', YES, ( $verified == YES ? true: false ) ); ?> /><span><i class="icon-ok-sign"></i> Verified Accounts</span>
                    </span>
                    <input type="hidden" id="off" name="off" value="<?php echo $off; ?>" />
                    <input type="hidden" id="lmt" name="lmt" value="<?php echo $lmt; ?>" />
                    <input type="hidden" id="sort" name="sort" value="<?php echo $sort; ?>" />
                    <input type="hidden" id="ord" name="ord" value="<?php echo $ord; ?>" />
                    <button type="submit" class="btn btn-large btn-primary" data-loading-text="Searching..."><i class="icon-search icon-white"></i> Search</button>
                </div>                            
                <div class="clearfix"></div>
            </form>
        </div>
    
        <hr/>
        <div class="spacer"></div>

        <div class="listing" align="center">    
            <?php if(isset($total_found) && !isset($default_list)) { ?>
            <?php if($total_found <= 0) { ?>
            <div class="alert alert-block alert-error" align="center">
                No matching agents were found. Modify your filters and search again.
                <a class="close" data-dismiss="alert" href="#">&times;</a>
            </div>
            <?php } else { ?>
            <div class="alert alert-block alert-success" align="center">
                Found <?php echo ( $total_found > 1 ? ' <strong>' . format_number_whole($total_found) . '</strong> agents that match' : 'an agent that matches' ); ?> your search!
                <a class="close" data-dismiss="alert" href="#">&times;</a>
            </div>
            <?php } ?>
            <?php } ?>
            <?php if(count($list) > 0) { ?>
            <div class="listsort" align="right">
                <div class="btn-group">
                    <button class="btn btn-small dropdown-toggle" data-toggle="dropdown" type="button">
                        Sort <i class="icon-chevron-down" style="opacity:0.7;"></i>
                    </button>
                    <ul class="dropdown-menu pull-right" style="text-align:left;">
                        <li><a href="#" class="sort" data-mode="name">Name</a></li>
                        <li><a href="#" class="sort" data-mode="date-joined">Date Joined</a></li>
                        <li><a href="#" class="sort" data-mode="popularity">Popularity</a></li>
                        <li><a href="#" class="sort" data-mode="level">Level</a></li>
                        <li><a href="#" class="sort" data-mode="verified">Verified</a></li>
                        <li><a href="#" class="sort" data-mode="featured">Featured</a></li>
                    </ul>
                </div>
            </div>
            <?php } ?>
            <div class="spacer"></div>
            <ul class="proplist">
                <?php
                foreach($list as $rec) {
                    $data['record'] = $rec;
                    echo '<li>';
                    $this->load->view('agents/item', $data);    
                    echo '</li>';
                }
                ?>
            </ul>
            <?php
            $count = count($list);
            if($count > 0 && $total_found > $count) {
            ?>
            <div class="loading"><img src="<?php echo $this->config->item('image_path'); ?>spinner.gif"></div>
            <?php } ?>
            <div class="nomoreresults"></div>
            <div class="spacer"></div>
        </div>
        
    </div>

    <div class="spacer"></div>
    <div class="spacer"></div>
    <div class="spacer"></div>

</div> <!-- /container -->

<script type="text/javascript">
head.ready(function() {
    urlpaginate = baseurl+'agents/search_more';
});
</script>