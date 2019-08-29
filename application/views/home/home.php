<div class="bannertop"></div>

<div class="realtygusto homehead">
    <div class="container">
        <div class="home">
            <h1>Welcome to Property Gusto!</h1>
            <h4>Revolutionizing your property search</h4>
        </div>
    </div>
</div>

<div class="container">

    <div class="list">
    
        <div class="home-strip">
            <div class="container" style="width:80%;">
                <div class="navbar navbar-inverse">
                    <div class="nav-collapse collapse">
                        <ul class="nav-home" style="margin:0px;">
                            <li <?php echo ( empty($act) || $act == 'popular' ? 'class="active"' : '' ); ?>>
                                <a href="<?php echo site_url('properties'); ?>" class="popular">Popular</a>
                            </li>
                            <li <?php echo ( $act == 'newest' ? 'class="active"' : '' ); ?>>
                                <a href="<?php echo site_url('properties'); ?>" class="newest">Newest</a>
                            </li>
                            <li <?php echo ( $act == 'quicksearch' ? 'class="active"' : '' ); ?>>
                                <div>
                                    <form id="frmquicksearch" action="<?php echo current_url(); ?>" method="post">
                                        <div class="input-append" style="padding:5px 10px 0 10px;margin:0px;">
                                            <input class="span3" id="searchquickkeywords" name="searchkeywords" placeholder="Search by name" type="text">
                                            <button type="submit" class="btn quick-search"><span><i class="icon-search" style="opacity: .70;"></i></span><span></span></button>
                                        </div>
                                    </form>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <form id="frmsearch" action="<?php echo current_url(); ?>" method="post" style="margin:0px;">
                    <div class="search-form-button">
                        <button type="submit">&nbsp;</button>
                    </div>
                    <input type="hidden" id="searchkeywords" name="searchkeywords" value="<?php echo $searchkeywords; ?>" />
                    <input type="hidden" id="off" name="off" value="<?php echo $off; ?>" />
                    <input type="hidden" id="lmt" name="lmt" value="<?php echo $lmt; ?>" />
                    <input type="hidden" id="sort" name="sort" value="<?php echo $sort; ?>" />
                    <input type="hidden" id="ord" name="ord" value="<?php echo $ord; ?>" />
                    <input type="hidden" id="act" name="act" value="<?php echo $act; ?>" />
                    <input type="hidden" id="searchcountry" name="searchcountry" value="<?php echo $country; ?>" />
                </form>
            </div>
        </div>

        <div class="home">

            <div class="listing" align="center">   
                <div class="listsort" align="right">
                    <div class="btn-group">
                        <button class="btn btn-small dropdown-toggle" data-toggle="dropdown" type="button">
                            Sort <i class="icon-chevron-down" style="opacity:0.7;"></i>
                        </button>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="#" class="sort" data-mode="name">Name</a></li>
                            <li><a href="#" class="sort" data-mode="price">Price</a></li>
                            <li><a href="#" class="sort" data-mode="upload-date">Upload Date</a></li>
                            <li><a href="#" class="sort" data-mode="popularity">Popularity</a></li>
                            <li><a href="#" class="sort" data-mode="featured">Featured</a></li>
                        </ul>
                    </div>
                </div>
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
            </div>

        </div>
        
        <div class="spacer"></div>
        
    </div>

</div>

<?php if(isset($new_register) && !empty($new_register)) { ?>

<div id="modreg" class="modal hide fade">
  <div class="modal-header">
    <h3>Welcome to propertyfinder.com!</h3>
  </div>
  <div class="modal-body">
    <p>Thank you for creating an account with us.<br/><br/>You can now upload and market your properties on the most purposeful property portal ever. Experience easier, detailed and up-to-date online property searching!<br/><br/>Best of all, it's FREE! And we intend to put it that way forever.</p>
  </div>
  <div class="modal-footer">
    <a href="#" data-dismiss="modal" class="btn btn-primary">Let me get started now!</a>
  </div>
</div>

<script type="text/javascript">
head.ready(function() {
    $('#modreg').modal('show');
});
</script>
<?php } ?>

<script type="text/javascript">
var offp = 0, offn = 0;
head.ready(function() {
    objprof = {'n':'<?php echo LIMIT_NEWEST; ?>','p':'<?php echo LIMIT_POPULAR; ?>','h':<?php echo LIMIT_HOME; ?>};
    urlpaginate = baseurl+'properties/search_more';
});
</script>