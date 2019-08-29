<div class="bannertop"></div>

<div class="container">
    
    <div class="bg-container">
    
        <div class="bg-search-strip">
            <h3>My Properties</h3>
        </div>
        
        <div class="bg-search-content">
            <form id="frmsearch" action="<?php echo site_url('company/my-properties'); ?>" method="post" accept-charset="UTF-8" class="form-horizontal">
                <div class="span4 form-inline">
                    <label for="searchkeywords">Keywords</label>&nbsp;
                    <input type="text" id="searchkeywords" name="searchkeywords" placeholder="Name" value="<?php echo set_value('searchkeywords'); ?>">
                </div>
                <div class="span5 form-inline">
                    <label for="searchlocation">Location</label>&nbsp;
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
                <div class="span10 form-inline">
                    <div class="btn-group" data-toggle="buttons-checkbox">
                        <button type="button" class="search-ck btn <?php echo ( isset($proppost['R']) ? 'active' : '' ); ?>" data-mod="search-post" data-value="R">Rent</button>
                        <button type="button" class="search-ck btn <?php echo ( isset($proppost['S']) ? 'active' : '' ); ?>" data-mod="search-post" data-value="S">Sale</button>
                        <button type="button" class="search-ck btn <?php echo ( isset($proppost['O']) ? 'active' : '' ); ?>" data-mod="search-post" data-value="O">Rent to Own</button>
                    </div>
                    <div class="btn-group" data-toggle="buttons-checkbox">
                        <button type="button" class="search-ck btn <?php echo ( isset($proptype[PROPCATEGORY_RESIDENTIAL]) ? 'active' : '' ); ?>" data-mod="search-proptype" data-value="<?php echo PROPCATEGORY_RESIDENTIAL; ?>">Residential</button>
                        <button type="button" class="search-ck btn <?php echo ( isset($proptype[PROPCATEGORY_COMMERCIAL]) ? 'active' : '' ); ?>" data-mod="search-proptype" data-value="<?php echo PROPCATEGORY_COMMERCIAL; ?>">Commercial</button>
                        <button type="button" class="search-ck btn <?php echo ( isset($proptype[PROPCATEGORY_LAND]) ? 'active' : '' ); ?>" data-mod="search-proptype" data-value="<?php echo PROPCATEGORY_LAND; ?>">Land</button>
                        <button type="button" class="search-ck btn <?php echo ( isset($proptype[PROPCATEGORY_HOTEL]) ? 'active' : '' ); ?>" data-mod="search-proptype" data-value="<?php echo PROPCATEGORY_HOTEL; ?>">Hotel/Resort</button>
                    </div>
                    <div class="btn-group" data-toggle="buttons-checkbox">
                        <button type="button" class="search-ck btn <?php echo ( isset($propstate['A']) ? 'active' : '' ); ?>" data-mod="search-propstate" data-value="A">Published</button>
                        <button type="button" class="search-ck btn <?php echo ( isset($propstate['D']) ? 'active' : '' ); ?>" data-mod="search-propstate" data-value="D">Drafted</button>
                    </div>
                    <div class="btn-group" data-toggle="buttons-checkbox">
                        <button type="button" class="search-ck btn <?php echo ( isset($propavail['A']) ? 'active' : '' ); ?>" data-mod="search-propavail" data-value="A">Active</button>
                        <button type="button" class="search-ck btn <?php echo ( isset($propavail['S']) ? 'active' : '' ); ?>" data-mod="search-propavail" data-value="S">Sold Out</button>
                        <button type="button" class="search-ck btn <?php echo ( isset($propavail['C']) ? 'active' : '' ); ?>" data-mod="search-propavail" data-value="C">Closed</button>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="spacer"></div>
                <div align="center">
                    <span style="display:none;">
                        <input type="checkbox" id="search-propstate-A" name="searchpropstate[]" value="A" <?php echo set_checkbox('searchpropstate[]', 'A', ( isset($propstate[PROPSTATUS_ACTIVE]) ? true: false ) ); ?> />
                        <input type="checkbox" id="search-propstate-D" name="searchpropstate[]" value="D" <?php echo set_checkbox('searchpropstate[]', 'D', ( isset($propstate[PROPSTATUS_DRAFT]) ? true: false ) ); ?> />

                        <input type="checkbox" id="search-post-R" name="searchproppost[]" value="R" <?php echo set_checkbox('searchproppost[]', PROPPOST_RENT, ( isset($proppost[PROPPOST_RENT]) ? true: false ) ); ?> />
                        <input type="checkbox" id="search-post-S" name="searchproppost[]" value="S" <?php echo set_checkbox('searchproppost[]', PROPPOST_SALE, ( isset($proppost[PROPPOST_SALE]) ? true: false ) ); ?> />
                        <input type="checkbox" id="search-post-O" name="searchproppost[]" value="O" <?php echo set_checkbox('searchproppost[]', PROPPOST_OWN, ( isset($proppost[PROPPOST_OWN]) ? true: false ) ); ?> />

                        <input type="checkbox" id="search-proptype-R" name="searchproptype[]" value="<?php echo PROPCATEGORY_RESIDENTIAL; ?>" <?php echo set_checkbox('searchproptype[]', PROPCATEGORY_RESIDENTIAL); ?> />
                        <input type="checkbox" id="search-proptype-C" name="searchproptype[]" value="<?php echo PROPCATEGORY_COMMERCIAL; ?>" <?php echo set_checkbox('searchproptype[]', PROPCATEGORY_COMMERCIAL); ?> />
                        <input type="checkbox" id="search-proptype-L" name="searchproptype[]" value="<?php echo PROPCATEGORY_LAND; ?>" <?php echo set_checkbox('searchproptype[]', PROPCATEGORY_LAND); ?> />
                        <input type="checkbox" id="search-proptype-H" name="searchproptype[]" value="<?php echo PROPCATEGORY_HOTEL; ?>" <?php echo set_checkbox('searchproptype[]', PROPCATEGORY_HOTEL); ?> />
                        
                        <input type="checkbox" id="search-propavail-A" name="searchpropavail[]" value="A" <?php echo set_checkbox('searchpropavail[]', 'A', ( isset($propavail['A']) ? true: false ) ); ?> />
                        <input type="checkbox" id="search-propavail-S" name="searchpropavail[]" value="S" <?php echo set_checkbox('searchpropavail[]', 'S', ( isset($propavail['S']) ? true: false ) ); ?> />
                        <input type="checkbox" id="search-propavail-C" name="searchpropavail[]" value="C" <?php echo set_checkbox('searchpropavail[]', 'C', ( isset($propavail['C']) ? true: false ) ); ?> />
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

        <div class="listing" align="center" onmouseover="$(this).find('div.listsort').show();" onmouseout="$(this).find('div.listsort').hide();">    
            <?php if(count($list) <= 0) { ?>
            <div class="alert alert-block alert-error" align="center">
                <?php if($insearch) { ?>
                No matching properties were found on your properties list. Modify your filters and search again.
                <?php } else { ?>
                You have not yet uploaded any property record.
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
                foreach($list as $rec) {
                    $data['record'] = $rec;
                    echo '<li>';
                    $this->load->view('properties/item_myproperties_company', $data); 
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
    urlpaginate = baseurl+'company/search_more';
});
</script>