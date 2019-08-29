<div class="wrapper">
    
<div class="bannertop"></div>

<div class="container">
    
    <div class="bg-strip">
        <h3>My Comparisons</h3>
    </div>
    <div class="bg-container-full">
        <div class="spacer"></div>
        <div class="bg-container">
            
            <span class="comparemsg">
            <?php
            $count = count($list);
            if($count <= 0) {
            ?>
            <div class="alert alert-block alert-info" align="center">
                Please select at least two properties to compare.
            </div>
            <?php } elseif($count == 1) { ?>
            <div class="alert alert-block alert-info" align="center">
                Please select another property to compare this record with.
            </div>
            <?php } ?>
            </span>

            <?php if($count > 0) { ?>
            <div style="width:1010px;" align="left">

                <?php if($count > 2) { ?>
                <button class="btn btn-large btn-inverse prev"><i class="icon-chevron-left icon-white"></i></button>
                <button class="btn btn-large btn-inverse next"><i class="icon-chevron-right icon-white"></i></button>
                <?php } ?>

                <div class="easycompare">
                    <ul>
                        <?php
                        foreach($list as $rec) {
                            $data['record'] = $rec;
                            echo '<li>';
                            $this->load->view('properties/item_compare', $data);  
                            echo '</li>';  
                        }
                        ?>
                    </ul>
                </div>

            </div>
            <?php } ?>
            
            <div class="spacer"></div>
        </div>
    </div>

    <div class="spacer"></div>
    <div class="push"></div>

</div> <!-- /container -->

</div> <!-- /wrapper -->

<?php $this->load->view('footer_summary'); ?>

<?php if($count > 0) { ?>
<script type="text/javascript">
head.ready(function() {
    head.js("<?php echo site_url(); ?>assets/js/jcarousellite.min.js");
    head.ready(function() {
        load_comparisons();
    });
});
</script>
<?php } ?>