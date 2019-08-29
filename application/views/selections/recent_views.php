<div class="bannertop"></div>

<div class="container">
    
    <div class="bg-container">
    
        <div class="bg-search-strip">
            <h3>My Recent Views</h3>
        </div>
        
        <div class="bg-search-content">
            <form id="frmsearch" action="<?php echo site_url('recent_views'); ?>" method="post" accept-charset="UTF-8" class="form-horizontal">
                <div class="span4 form-inline">
                    <label for="searchkeywords" style="width:80px;">Keywords</label>&nbsp;
                    <input type="text" id="searchkeywords" name="searchkeywords" placeholder="Name" value="<?php echo set_value('searchkeywords'); ?>">
                </div>
                <div class="span5 form-inline">
                    <label for="searchlocation" style="width:80px;">Location</label>&nbsp;
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
                <div class="span4 form-inline" align="center">
                    <div class="btn-group" data-toggle="buttons-checkbox">
                        <button type="button" class="search-ck btn <?php echo ( isset($proppost['R']) ? 'active' : '' ); ?>" data-mod="search-post" data-value="R">Rent</button>
                        <button type="button" class="search-ck btn <?php echo ( isset($proppost['S']) ? 'active' : '' ); ?>" data-mod="search-post" data-value="S">Sale</button>
                        <button type="button" class="search-ck btn <?php echo ( isset($proppost['O']) ? 'active' : '' ); ?>" data-mod="search-post" data-value="O">Rent to Own</button>
                    </div>
                </div>
                <div class="span5 form-inline">
                    <label for="searchpricemin" style="width:80px;">Price</label>
                    <input type="text" id="searchpricemin" name="searchpricemin" placeholder="Minimum" class="input-small" value="<?php echo set_value('searchpricemin'); ?>">
                    <input type="text" id="searchpricemax" name="searchpricemax" placeholder="Maximum" class="input-small" value="<?php echo set_value('searchpricemax'); ?>">
                    <select id="searchpriceunit" name="searchpriceunit" class="input-small">
                        <?php foreach($currencies as $key => $val) { ?>
                        <option value="<?php echo $key; ?>" <?php echo set_select('searchpriceunit', $key, ($searchpriceunit == $key ? true : false) ); ?> ><?php echo $key; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="clearfix"></div>
                <div class="spacer-small"></div>
                <div class="span4 form-inline" align="center">
                    <div class="btn-group" data-toggle="buttons-checkbox">
                        <button type="button" class="search-ck btn <?php echo ( isset($proptype[PROPCATEGORY_RESIDENTIAL]) ? 'active' : '' ); ?>" data-mod="search-proptype" data-value="<?php echo PROPCATEGORY_RESIDENTIAL; ?>">Residential</button>
                        <button type="button" class="search-ck btn <?php echo ( isset($proptype[PROPCATEGORY_COMMERCIAL]) ? 'active' : '' ); ?>" data-mod="search-proptype" data-value="<?php echo PROPCATEGORY_COMMERCIAL; ?>">Commercial</button>
                        <button type="button" class="search-ck btn <?php echo ( isset($proptype[PROPCATEGORY_LAND]) ? 'active' : '' ); ?>" data-mod="search-proptype" data-value="<?php echo PROPCATEGORY_LAND; ?>">Land</button>
                        <button type="button" class="search-ck btn <?php echo ( isset($proptype[PROPCATEGORY_HOTEL]) ? 'active' : '' ); ?>" data-mod="search-proptype" data-value="<?php echo PROPCATEGORY_HOTEL; ?>">Hotel/Resort</button>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="spacer"></div>
                <div align="center">
                    <span style="display:none;">
                        <input type="checkbox" id="search-post-R" name="searchproppost[]" value="R" <?php echo set_checkbox('searchproppost[]', 'R'); ?> /><span>Rent</span>
                        <input type="checkbox" id="search-post-S" name="searchproppost[]" value="S" <?php echo set_checkbox('searchproppost[]', 'S'); ?> /><span>Sale</span>
                        <input type="checkbox" id="search-post-O" name="searchproppost[]" value="O" <?php echo set_checkbox('searchproppost[]', 'O'); ?> /><span>Rent to Own</span>

                        <input type="checkbox" id="search-proptype-<?php echo PROPCATEGORY_RESIDENTIAL; ?>" name="searchproptype[]" value="<?php echo PROPCATEGORY_RESIDENTIAL; ?>" <?php echo set_checkbox('searchproptype[]', PROPCATEGORY_RESIDENTIAL); ?> />
                        <input type="checkbox" id="search-proptype-<?php echo PROPCATEGORY_COMMERCIAL; ?>" name="searchproptype[]" value="<?php echo PROPCATEGORY_COMMERCIAL; ?>" <?php echo set_checkbox('searchproptype[]', PROPCATEGORY_COMMERCIAL); ?> />
                        <input type="checkbox" id="search-proptype-<?php echo PROPCATEGORY_LAND; ?>" name="searchproptype[]" value="<?php echo PROPCATEGORY_LAND; ?>" <?php echo set_checkbox('searchproptype[]', PROPCATEGORY_LAND); ?> />
                        <input type="checkbox" id="search-proptype-<?php echo PROPCATEGORY_HOTEL; ?>" name="searchproptype[]" value="<?php echo PROPCATEGORY_HOTEL; ?>" <?php echo set_checkbox('searchproptype[]', PROPCATEGORY_HOTEL); ?> />
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

        <div class="listing" align="center">    
            <?php if(count($list) <= 0) { ?>
            <div class="alert alert-block alert-error" align="center">
                <?php if($insearch) { ?>
                No matching properties were found on your recent views. Modify your filters and search again.
                <?php } else { ?>
                You have not viewed any property profiles yet.
                <?php } ?>
                <a class="close" data-dismiss="alert" href="#">&times;</a>
            </div>
            <?php } ?>
            <?php if(count($list) > 0) { ?>
            <div class="listsort" align="right">
                <div class="btn-group">
                    <button class="btn btn-small dropdown-toggle" data-toggle="dropdown" type="button">
                        Sort <i class="icon-chevron-down" style="opacity:0.7;"></i>
                    </button>
                    <ul class="dropdown-menu pull-right" style="text-align:left;">
                        <li><a href="#" class="sort" data-mode="name">Name</a></li>
                        <li><a href="#" class="sort" data-mode="price">Price</a></li>
                        <li><a href="#" class="sort" data-mode="upload-date">Upload Date</a></li>
                        <li><a href="#" class="sort" data-mode="popularity">Popularity</a></li>
                        <li><a href="#" class="sort" data-mode="featured">Featured</a></li>
                    </ul>
                </div>
            </div>
            <?php } ?>
            <div class="spacer"></div>
            <ul class="proplist">
                <?php
                $data['recentviews'] = true;
                foreach($list as $rec) {
                    $data['record'] = $rec;
                    echo '<li>';
                    $this->load->view('properties/item', $data);  
                    echo '</li>';  
                }
                ?>
            </ul>
            <?php if(count($list) > 0) { ?>
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
    urlpaginate = baseurl+'recent_views/search_more';
});
</script>