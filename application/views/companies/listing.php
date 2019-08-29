<div class="bannertop"></div>

<div class="container">
    
    <div class="bg-container">
    
        <div class="bg-search-strip">
            <h3>Search for Companies</h3>
        </div>
        
        <div class="bg-search-content">
            <form id="frmsearch" action="<?php echo site_url('companies/search'); ?>" method="post" accept-charset="UTF-8" class="form-horizontal">
                <div class="span4 form-inline" style="width:320px;">
                    <label for="searchkeywords">Keywords</label>
                    <input type="text" id="searchkeywords" name="searchkeywords" placeholder="Name, license number, company" value="<?php echo set_value('searchkeywords'); ?>">
                </div>
                <div class="span5 form-inline" style="width:430px;margin-left:8px;">
                    <label for="searchlocation">Location</label>
                    <input type="text" id="searchlocation" name="searchlocation" class="span2 inline" placeholder="City" value="<?php echo set_value('searchlocation'); ?>" />
                    <select id="searchcountry" name="searchcountry" class="span2 inline2" placeholder="Country">
                        <option value=""></option>
                        <?php foreach($countries as $key => $val) { ?>
                        <option value="<?php echo $key; ?>" <?php echo set_select('searchcountry', $key, ( $country == $key ? true : false ) ); ?> ><?php echo $val; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="span1 form-inline" style="width:160px;margin-left:8px;">
                    <div class="srater rater-big"></div>
                    <input type="hidden" id="searchrating" name="searchrating" value="<?php echo set_value('score', 0); ?>">
                </div>
                <div class="clearfix"></div>
                <div class="spacer"></div>
                <div align="center">
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
                No matching companies were found. Modify your filters and search again.
                <a class="close" data-dismiss="alert" href="#">&times;</a>
            </div>
            <?php } else { ?>
            <div class="alert alert-block alert-success" align="center">
                Found <?php echo ( $total_found > 1 ? ' <strong>' . format_number_whole($total_found) . '</strong> companies that match' : 'a company that matches' ); ?> your search!
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
                        <li><a href="#" class="sort" data-mode="popularity">Popularity</a></li>
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
                    $this->load->view('companies/item', $data);    
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
    urlpaginate = baseurl+'companies/search_more';
});
</script>