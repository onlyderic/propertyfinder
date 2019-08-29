<div class="bannertop"></div>

<div class="container">
    
    <div class="bg-container">
    
        <div class="bg-search-strip">
            <h3>Search for Properties</h3>
        </div>
        
        <div class="bg-search-content">
            <form id="frmsearch" action="<?php echo site_url('properties/search'); ?>" method="post" accept-charset="UTF-8" class="form-horizontal">
                <div class="span4 form-inline">
                    <label for="searchkeywords" style="width:80px;">Keywords</label>
                    <input type="text" id="searchkeywords" name="searchkeywords" placeholder="Name" value="<?php echo set_value('searchkeywords'); ?>">
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
                <div class="span4 form-inline">
                    <label for="searchroommin" style="width:80px;">Rooms</label>
                    <input type="text" id="searchroommin" name="searchroommin" placeholder="Minimum" class="input-small" value="<?php echo set_value('searchroommin'); ?>">
                    <input type="text" id="searchroommax" name="searchroommax" placeholder="Maximum" class="input-small" value="<?php echo set_value('searchroommax'); ?>">
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
                <div class="span2 form-inline" align="center">
                    <div class="btn-group" data-toggle="buttons-checkbox">
                        <button type="button" class="search-ck btn <?php echo ( isset($proppost['R']) ? 'active' : '' ); ?>" data-mod="search-post" data-value="R">Rent</button>
                        <button type="button" class="search-ck btn <?php echo ( isset($proppost['S']) ? 'active' : '' ); ?>" data-mod="search-post" data-value="S">Sale</button>
                        <button type="button" class="search-ck btn <?php echo ( isset($proppost['O']) ? 'active' : '' ); ?>" data-mod="search-post" data-value="O">Rent to Own</button>
                    </div>
                </div>
                <div class="span2 form-inline" align="center">
                    <div class="srater rater-big"></div>
                    <input type="hidden" id="searchrating" name="searchrating" value="<?php echo set_value('score', 0); ?>">
                </div>
                <div class="span5 form-inline">
                    <label for="searchareamin" style="width:80px;">Area</label>
                    <input type="text" id="searchareamin" name="searchareamin" placeholder="Minimum" class="input-small" value="<?php echo set_value('searchareamin'); ?>">
                    <input type="text" id="searchareamax" name="searchareamax" placeholder="Maximum" class="input-small" value="<?php echo set_value('searchareamax'); ?>">
                    <select id="searchareaunit" name="searchareaunit" class="input-small">
                        <option value="sqm" <?php echo set_select('searchareaunit', 'sqm', ($searchareaunit == 'sqm' ? true : false) ); ?> >sqm</option>
                        <option value="sqf" <?php echo set_select('searchareaunit', 'sqf', ($searchareaunit == 'sqf' ? true : false) ); ?> >sqf</option>
                        <option value="ha" <?php echo set_select('searchareaunit', 'ha', ($searchareaunit == 'ha' ? true : false) ); ?> >hectares</option>
                    </select>
                </div>
                <div class="clearfix"></div>
                <div class="spacer"></div>
                <div class="span3 form-inline" align="center">
                    <div class="btn-group" data-toggle="buttons-checkbox">
                        <button type="button" class="search-ck btn btn-large btn-info <?php echo ( isset($proptype[PROPCATEGORY_RESIDENTIAL]) ? 'active' : '' ); ?>" data-mod="search-proptype" data-value="<?php echo PROPCATEGORY_RESIDENTIAL; ?>">Residential</button>
                    </div>
                    <div class="clearfix"></div>
                    <div class="spacer-small"></div>
                    <div data-toggle="buttons-checkbox">
                        <button type="button" class="search-ck btn btn-small <?php echo ( isset($propclass[PROPSUBCATEGORY_R_CONDOMINIUM]) ? 'active' : '' ); ?>" data-mod="search-propclass" data-value="<?php echo PROPSUBCATEGORY_R_CONDOMINIUM; ?>">Condominiums</button>
                        <button type="button" class="search-ck btn btn-small <?php echo ( isset($propclass[PROPSUBCATEGORY_R_HOUSEANDLOT]) ? 'active' : '' ); ?>" data-mod="search-propclass" data-value="<?php echo PROPSUBCATEGORY_R_HOUSEANDLOT; ?>">House and Lots</button>
                        <button type="button" class="search-ck btn btn-small <?php echo ( isset($propclass[PROPSUBCATEGORY_R_HDB]) ? 'active' : '' ); ?>" data-mod="search-propclass" data-value="<?php echo PROPSUBCATEGORY_R_HDB; ?>">HDB</button>
                        <div class="clearfix"></div>
                        <div class="spacer-small"></div>
                        <button type="button" class="search-ck btn btn-small <?php echo ( isset($propclass[PROPSUBCATEGORY_R_APARTMENT]) ? 'active' : '' ); ?>" data-mod="search-propclass" data-value="<?php echo PROPSUBCATEGORY_R_APARTMENT; ?>">Apartments</button>
                        <button type="button" class="search-ck btn btn-small <?php echo ( isset($propclass[PROPSUBCATEGORY_R_BOARDINGHOUSE]) ? 'active' : '' ); ?>" data-mod="search-propclass" data-value="<?php echo PROPSUBCATEGORY_R_BOARDINGHOUSE; ?>">Boarding Houses</button>
                    </div>
                </div>
                <div class="span2 form-inline" align="center" style="width:180px;margin-left:8px;">
                    <div class="btn-group" data-toggle="buttons-checkbox">
                        <button type="button" class="search-ck btn btn-large btn-info <?php echo ( isset($proptype[PROPCATEGORY_COMMERCIAL]) ? 'active' : '' ); ?>" data-mod="search-proptype" data-value="<?php echo PROPCATEGORY_COMMERCIAL; ?>">Commercial</button>
                    </div>
                    <div class="clearfix"></div>
                    <div class="spacer-small"></div>
                    <div data-toggle="buttons-checkbox">
                        <button type="button" class="search-ck btn btn-small <?php echo ( isset($propclass[PROPSUBCATEGORY_C_OFFICE]) ? 'active' : '' ); ?>" data-mod="search-propclass" data-value="<?php echo PROPSUBCATEGORY_C_OFFICE; ?>">Offices</button>
                        <button type="button" class="search-ck btn btn-small <?php echo ( isset($propclass[PROPSUBCATEGORY_C_RETAIL]) ? 'active' : '' ); ?>" data-mod="search-propclass" data-value="<?php echo PROPSUBCATEGORY_C_RETAIL; ?>">Retail Shops</button>
                        <div class="clearfix"></div>
                        <div class="spacer-small"></div>
                        <button type="button" class="search-ck btn btn-small <?php echo ( isset($propclass[PROPSUBCATEGORY_C_SOHO]) ? 'active' : '' ); ?>" data-mod="search-propclass" data-value="<?php echo PROPSUBCATEGORY_C_SOHO; ?>">SOHO</button>
                        <button type="button" class="search-ck btn btn-small <?php echo ( isset($propclass[PROPSUBCATEGORY_C_INDUSTRIAL]) ? 'active' : '' ); ?>" data-mod="search-propclass" data-value="<?php echo PROPSUBCATEGORY_C_INDUSTRIAL; ?>">Industrials</button>
                    </div>
                </div>
                <div class="span2 form-inline" align="center" style="width:200px;margin-left:8px;">
                    <div class="btn-group" data-toggle="buttons-checkbox">
                        <button type="button" class="search-ck btn btn-large btn-info <?php echo ( isset($proptype[PROPCATEGORY_LAND]) ? 'active' : '' ); ?>" data-mod="search-proptype" data-value="<?php echo PROPCATEGORY_LAND; ?>">Land</button>
                    </div>
                    <div class="clearfix"></div>
                    <div class="spacer-small"></div>
                    <div data-toggle="buttons-checkbox">
                        <button type="button" class="search-ck btn btn-small <?php echo ( isset($propclass[PROPSUBCATEGORY_L_LANDONLY]) ? 'active' : '' ); ?>" data-mod="search-propclass" data-value="<?php echo PROPSUBCATEGORY_L_LANDONLY; ?>">Land only</button>
                        <button type="button" class="search-ck btn btn-small <?php echo ( isset($propclass[PROPSUBCATEGORY_L_FARM]) ? 'active' : '' ); ?>" data-mod="search-propclass" data-value="<?php echo PROPSUBCATEGORY_L_FARM; ?>">Farms</button>
                        <button type="button" class="search-ck btn btn-small <?php echo ( isset($propclass[PROPSUBCATEGORY_L_BEACH]) ? 'active' : '' ); ?>" data-mod="search-propclass" data-value="<?php echo PROPSUBCATEGORY_L_BEACH; ?>">Beach</button>
                        <div class="clearfix"></div>
                        <div class="spacer-small"></div>
                        <button type="button" class="search-ck btn btn-small <?php echo ( isset($propclass[PROPSUBCATEGORY_L_LANDWITHSTRUCTURE]) ? 'active' : '' ); ?>" data-mod="search-propclass" data-value="<?php echo PROPSUBCATEGORY_L_LANDWITHSTRUCTURE; ?>">Land with structure</button>
                    </div>
                </div>
                <div class="span2 form-inline" align="center" style="width:220px;margin-left:8px;">
                    <div class="btn-group" data-toggle="buttons-checkbox">
                        <button type="button" class="search-ck btn btn-large btn-info <?php echo ( isset($proptype[PROPCATEGORY_HOTEL]) ? 'active' : '' ); ?>" data-mod="search-proptype" data-value="<?php echo PROPCATEGORY_HOTEL; ?>">Hotels/Resorts</button>
                    </div>
                    <div class="clearfix"></div>
                    <div class="spacer-small"></div>
                    <div data-toggle="buttons-checkbox">
                        <button type="button" class="search-ck btn btn-small <?php echo ( isset($propclass[PROPCLASS_H_HOTEL]) ? 'active' : '' ); ?>" data-mod="search-propclass" data-value="<?php echo PROPCLASS_H_HOTEL; ?>">Hotels</button>
                        <button type="button" class="search-ck btn btn-small <?php echo ( isset($propclass[PROPCLASS_H_RESORT]) ? 'active' : '' ); ?>" data-mod="search-propclass" data-value="<?php echo PROPCLASS_H_RESORT; ?>">Resorts</button>
                        <div class="clearfix"></div>
                        <div class="spacer-small"></div>
                        <button type="button" class="search-ck btn btn-small <?php echo ( isset($propclass[PROPSUBCATEGORY_H_PENSIONINN]) ? 'active' : '' ); ?>" data-mod="search-propclass" data-value="<?php echo PROPSUBCATEGORY_H_PENSIONINN; ?>">Pension Inns</button>
                        <button type="button" class="search-ck btn btn-small <?php echo ( isset($propclass[PROPSUBCATEGORY_H_CONVENTIONCENTER]) ? 'active' : '' ); ?>" data-mod="search-propclass" data-value="<?php echo PROPSUBCATEGORY_H_CONVENTIONCENTER; ?>">Convention Centers</button>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="spacer"></div>
                <div align="center">
                    <span style="display:none;">
                        <input type="checkbox" id="search-post-R" name="searchproppost[]" value="R" <?php echo set_checkbox('searchproppost[]', 'R'); ?> />
                        <input type="checkbox" id="search-post-S" name="searchproppost[]" value="S" <?php echo set_checkbox('searchproppost[]', 'S'); ?> />
                        <input type="checkbox" id="search-post-O" name="searchproppost[]" value="O" <?php echo set_checkbox('searchproppost[]', 'O'); ?> />

                        <input type="checkbox" id="search-proptype-<?php echo PROPCATEGORY_RESIDENTIAL; ?>" name="searchproptype[]" value="<?php echo PROPCATEGORY_RESIDENTIAL; ?>" <?php echo set_checkbox('searchproptype[]', PROPCATEGORY_RESIDENTIAL, ( isset($proptype[PROPCATEGORY_RESIDENTIAL]) ? true: false ) ); ?> />
                        <input type="checkbox" id="search-propclass-<?php echo PROPSUBCATEGORY_R_CONDOMINIUM; ?>" name="searchpropclass[]" value="<?php echo PROPSUBCATEGORY_R_CONDOMINIUM; ?>" <?php echo set_checkbox('searchpropclass[]', PROPSUBCATEGORY_R_CONDOMINIUM, ( isset($propclass[PROPSUBCATEGORY_R_CONDOMINIUM]) ? true: false ) ); ?> />
                        <input type="checkbox" id="search-propclass-<?php echo PROPSUBCATEGORY_R_APARTMENT; ?>" name="searchpropclass[]" value="<?php echo PROPSUBCATEGORY_R_APARTMENT; ?>" <?php echo set_checkbox('searchpropclass[]', PROPSUBCATEGORY_R_APARTMENT, ( isset($propclass[PROPSUBCATEGORY_R_APARTMENT]) ? true: false ) ); ?> />
                        <input type="checkbox" id="search-propclass-<?php echo PROPSUBCATEGORY_R_HDB; ?>" name="searchpropclass[]" value="<?php echo PROPSUBCATEGORY_R_HDB; ?>" <?php echo set_checkbox('searchpropclass[]', PROPSUBCATEGORY_R_HDB, ( isset($propclass[PROPSUBCATEGORY_R_HDB]) ? true: false ) ); ?> />
                        <input type="checkbox" id="search-propclass-<?php echo PROPSUBCATEGORY_R_HOUSEANDLOT; ?>" name="searchpropclass[]" value="<?php echo PROPSUBCATEGORY_R_HOUSEANDLOT; ?>" <?php echo set_checkbox('searchpropclass[]', PROPSUBCATEGORY_R_HOUSEANDLOT, ( isset($propclass[PROPSUBCATEGORY_R_HOUSEANDLOT]) ? true: false ) ); ?> />
                        <input type="checkbox" id="search-propclass-<?php echo PROPSUBCATEGORY_R_BOARDINGHOUSE; ?>" name="searchpropclass[]" value="<?php echo PROPSUBCATEGORY_R_BOARDINGHOUSE; ?>" <?php echo set_checkbox('searchpropclass[]', PROPSUBCATEGORY_R_BOARDINGHOUSE, ( isset($propclass[PROPSUBCATEGORY_R_BOARDINGHOUSE]) ? true: false ) ); ?> />

                        <input type="checkbox" id="search-proptype-<?php echo PROPCATEGORY_COMMERCIAL; ?>" name="searchproptype[]" value="<?php echo PROPCATEGORY_COMMERCIAL; ?>" <?php echo set_checkbox('searchproptype[]', PROPCATEGORY_COMMERCIAL, ( isset($proptype[PROPCATEGORY_COMMERCIAL]) ? true: false ) ); ?> />
                        <input type="checkbox" id="search-propclass-<?php echo PROPSUBCATEGORY_C_OFFICE; ?>" name="searchpropclass[]" value="<?php echo PROPSUBCATEGORY_C_OFFICE; ?>" <?php echo set_checkbox('searchpropclass[]', PROPSUBCATEGORY_C_OFFICE, ( isset($propclass[PROPSUBCATEGORY_C_OFFICE]) ? true: false ) ); ?> />
                        <input type="checkbox" id="search-propclass-<?php echo PROPSUBCATEGORY_C_RETAIL; ?>" name="searchpropclass[]" value="<?php echo PROPSUBCATEGORY_C_RETAIL; ?>" <?php echo set_checkbox('searchpropclass[]', PROPSUBCATEGORY_C_RETAIL, ( isset($propclass[PROPSUBCATEGORY_C_RETAIL]) ? true: false ) ); ?> />
                        <input type="checkbox" id="search-propclass-<?php echo PROPSUBCATEGORY_C_INDUSTRIAL; ?>" name="searchpropclass[]" value="<?php echo PROPSUBCATEGORY_C_INDUSTRIAL; ?>" <?php echo set_checkbox('searchpropclass[]', PROPSUBCATEGORY_C_INDUSTRIAL, ( isset($propclass[PROPSUBCATEGORY_C_INDUSTRIAL]) ? true: false ) ); ?> />
                        <input type="checkbox" id="search-propclass-<?php echo PROPSUBCATEGORY_C_SOHO; ?>" name="searchpropclass[]" value="<?php echo PROPSUBCATEGORY_C_SOHO; ?>" <?php echo set_checkbox('searchpropclass[]', PROPSUBCATEGORY_C_SOHO, ( isset($propclass[PROPSUBCATEGORY_C_SOHO]) ? true: false ) ); ?> />

                        <input type="checkbox" id="search-proptype-<?php echo PROPCATEGORY_LAND; ?>" name="searchproptype[]" value="<?php echo PROPCATEGORY_LAND; ?>" <?php echo set_checkbox('searchproptype[]', PROPCATEGORY_LAND, ( isset($proptype[PROPCATEGORY_LAND]) ? true: false ) ); ?> />
                        <input type="checkbox" id="search-propclass-<?php echo PROPSUBCATEGORY_L_LANDONLY; ?>" name="searchpropclass[]" value="<?php echo PROPSUBCATEGORY_L_LANDONLY; ?>" <?php echo set_checkbox('searchpropclass[]', PROPSUBCATEGORY_L_LANDONLY, ( isset($propclass[PROPSUBCATEGORY_L_LANDONLY]) ? true: false ) ); ?> />
                        <input type="checkbox" id="search-propclass-<?php echo PROPSUBCATEGORY_L_FARM; ?>" name="searchpropclass[]" value="<?php echo PROPSUBCATEGORY_L_FARM; ?>" <?php echo set_checkbox('searchpropclass[]', PROPSUBCATEGORY_L_FARM, ( isset($propclass[PROPSUBCATEGORY_L_FARM]) ? true: false ) ); ?> />
                        <input type="checkbox" id="search-propclass-<?php echo PROPSUBCATEGORY_L_BEACH; ?>" name="searchpropclass[]" value="<?php echo PROPSUBCATEGORY_L_BEACH; ?>" <?php echo set_checkbox('searchpropclass[]', PROPSUBCATEGORY_L_BEACH, ( isset($propclass[PROPSUBCATEGORY_L_BEACH]) ? true: false ) ); ?> />
                        <input type="checkbox" id="search-propclass-<?php echo PROPSUBCATEGORY_L_LANDWITHSTRUCTURE; ?>" name="searchpropclass[]" value="<?php echo PROPSUBCATEGORY_L_LANDWITHSTRUCTURE; ?>" <?php echo set_checkbox('searchpropclass[]', PROPSUBCATEGORY_L_LANDWITHSTRUCTURE, ( isset($propclass[PROPSUBCATEGORY_L_LANDWITHSTRUCTURE]) ? true: false ) ); ?> />

                        <input type="checkbox" id="search-proptype-<?php echo PROPCATEGORY_HOTEL; ?>" name="searchproptype[]" value="<?php echo PROPCATEGORY_HOTEL; ?>" <?php echo set_checkbox('searchproptype[]', PROPCATEGORY_HOTEL, ( isset($proptype[PROPCATEGORY_HOTEL]) ? true: false ) ); ?> />
                        <input type="checkbox" id="search-propclass-<?php echo PROPCLASS_H_HOTEL; ?>" name="searchpropclass[]" value="<?php echo PROPCLASS_H_HOTEL; ?>" <?php echo set_checkbox('searchpropclass[]', PROPCLASS_H_HOTEL, ( isset($propclass[PROPCLASS_H_HOTEL]) ? true: false ) ); ?> />
                        <input type="checkbox" id="search-propclass-<?php echo PROPCLASS_H_RESORT; ?>" name="searchpropclass[]" value="<?php echo PROPCLASS_H_RESORT; ?>" <?php echo set_checkbox('searchpropclass[]', PROPCLASS_H_RESORT, ( isset($propclass[PROPCLASS_H_RESORT]) ? true: false ) ); ?> />
                        <input type="checkbox" id="search-propclass-<?php echo PROPSUBCATEGORY_H_PENSIONINN; ?>" name="searchpropclass[]" value="<?php echo PROPSUBCATEGORY_H_PENSIONINN; ?>" <?php echo set_checkbox('searchpropclass[]', PROPSUBCATEGORY_H_PENSIONINN, ( isset($propclass[PROPSUBCATEGORY_H_PENSIONINN]) ? true: false ) ); ?> />
                        <input type="checkbox" id="search-propclass-<?php echo PROPSUBCATEGORY_H_CONVENTIONCENTER; ?>" name="searchpropclass[]" value="<?php echo PROPSUBCATEGORY_H_CONVENTIONCENTER; ?>" <?php echo set_checkbox('searchpropclass[]', PROPSUBCATEGORY_H_CONVENTIONCENTER, ( isset($propclass[PROPSUBCATEGORY_H_CONVENTIONCENTER]) ? true: false ) ); ?> />
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
                No matching properties were found. Modify your filters and search again.
                <a class="close" data-dismiss="alert" href="#">&times;</a>
            </div>
            <?php } else { ?>
            <div class="alert alert-block alert-success" align="center">
                Found <strong><?php echo format_number_whole($total_found); ?></strong> <?php echo ( $total_found > 1 ? 'properties' : 'property' ); ?> matching your search!
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
                    $this->load->view('properties/item', $data);    
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
    urlpaginate = baseurl+'properties/search_more';
});
</script>