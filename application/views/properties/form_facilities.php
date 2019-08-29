
<fieldset id="flsfacilities" class="profheading" style="<?php echo $display_facilitiesall; ?>">
    <h4>Facilities</h4>

    <div id="divfacilities1" class="ck-group" align="center" style="<?php echo $display_facilities1; ?>">
        <?php
        $tolitems = count($facilities_residentials);
        $percol = round( $tolitems / 4 );
        ?>
        <?php for($ctritems = 1; $ctritems <= $tolitems; ) { ?>
        <div data-toggle="buttons-checkbox" class="span2" style="margin-left:0px;width:162.50px;" align="left">
            <?php for($ctr = 1; $ctr <= $percol && $ctritems <= $tolitems; $ctr++, $ctritems++) { ?>
            <?php
            $key = key($facilities_residentials);
            next($facilities_residentials);
            ?>
            <button type="button" class="btn form-ck form-propfacilities1 <?php echo (isset($propfacilities1[$key]) ? 'active' : ''); ?>" data-mod="form-propfacilities1" data-value="<?php echo $key; ?>"><?php echo $facilities_residentials[$key]; ?></button>
            <input type="checkbox" id="form-propfacilities1-<?php echo $key; ?>" name="propfacilities1[]" value="<?php echo $key; ?>" <?php echo set_checkbox('propfacilities1[]', $key, (isset($propfacilities1[$key]) ? true: false ) ); ?> style="display:none;" />
            <div class="spacer-small"></div>
            <?php } ?>
        </div>
        <?php } ?>
    </div>

    <div id="divfacilities2" class="ck-group" align="center" style="<?php echo $display_facilities2; ?>">
        <?php
        $tolitems = count($facilities_commercials);
        $percol = round( $tolitems / 4 );
        ?>
        <?php for($ctritems = 1; $ctritems <= $tolitems; ) { ?>
        <div data-toggle="buttons-checkbox" class="span2" style="margin-left:0px;width:162.50px;" align="left">
            <?php for($ctr = 1; $ctr <= $percol && $ctritems <= $tolitems; $ctr++, $ctritems++) { ?>
            <?php
            $key = key($facilities_commercials);
            next($facilities_commercials);
            ?>
            <button type="button" class="btn form-ck form-propfacilities2 <?php echo (isset($propfacilities2[$key]) ? 'active' : ''); ?>" data-mod="form-propfacilities2" data-value="<?php echo $key; ?>"><?php echo $facilities_commercials[$key]; ?></button>
            <input type="checkbox" id="form-propfacilities2-<?php echo $key; ?>" name="propfacilities2[]" value="<?php echo $key; ?>" <?php echo set_checkbox('propfacilities2[]', $key, (isset($propfacilities2[$key]) ? true: false ) ); ?> style="display:none;" />
            <div class="spacer-small"></div>
            <?php } ?>
        </div>
        <?php } ?>
    </div>

    <div id="divfacilities3" class="ck-group" align="center" style="<?php echo $display_facilities3; ?>">
        <?php
        $tolitems = count($facilities_lands);
        $percol = round( $tolitems / 4 );
        ?>
        <?php for($ctritems = 1; $ctritems <= $tolitems; ) { ?>
        <div data-toggle="buttons-checkbox" class="span2" style="margin-left:0px;width:162.50px;" align="left">
            <?php for($ctr = 1; $ctr <= $percol && $ctritems <= $tolitems; $ctr++, $ctritems++) { ?>
            <?php
            $key = key($facilities_lands);
            next($facilities_lands);
            ?>
            <button type="button" class="btn form-ck form-propfacilities3 <?php echo (isset($propfacilities3[$key]) ? 'active' : ''); ?>" data-mod="form-propfacilities3" data-value="<?php echo $key; ?>"><?php echo $facilities_lands[$key]; ?></button>
            <input type="checkbox" id="form-propfacilities3-<?php echo $key; ?>" name="propfacilities3[]" value="<?php echo $key; ?>" <?php echo set_checkbox('propfacilities3[]', $key, (isset($propfacilities3[$key]) ? true: false ) ); ?> style="display:none;" />
            <div class="spacer-small"></div>
            <?php } ?>
        </div>
        <?php } ?>
    </div>

    <div id="divfacilities4" class="ck-group" align="center" style="<?php echo $display_facilities4; ?>">
        <?php
        $tolitems = count($facilities_hotels);
        $percol = round( $tolitems / 4 );
        ?>
        <?php for($ctritems = 1; $ctritems <= $tolitems; ) { ?>
        <div data-toggle="buttons-checkbox" class="span2" style="margin-left:0px;width:162.50px;" align="left">
            <?php for($ctr = 1; $ctr <= $percol && $ctritems <= $tolitems; $ctr++, $ctritems++) { ?>
            <?php
            $key = key($facilities_hotels);
            next($facilities_hotels);
            ?>
            <button type="button" class="btn form-ck form-propfacilities4 <?php echo (isset($propfacilities4[$key]) ? 'active' : ''); ?>" data-mod="form-propfacilities4" data-value="<?php echo $key; ?>"><?php echo $facilities_hotels[$key]; ?></button>
            <input type="checkbox" id="form-propfacilities4-<?php echo $key; ?>" name="propfacilities4[]" value="<?php echo $key; ?>" <?php echo set_checkbox('propfacilities4[]', $key, (isset($propfacilities4[$key]) ? true: false ) ); ?> style="display:none;" />
            <div class="spacer-small"></div>
            <?php } ?>
        </div>
        <?php } ?>
    </div>
</fieldset>