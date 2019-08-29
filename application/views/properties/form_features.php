
<fieldset id="flsfeatures" class="profheading" style="<?php echo $display_featuresall; ?>">
    <h4>Features</h4>

    <div id="divfeatures1" class="ck-group" align="center" style="<?php echo $display_features1; ?>">
        <?php
        $tolitems = count($features_residentials);
        $percol = round( $tolitems / 4 );
        ?>
        <?php for($ctritems = 1; $ctritems <= $tolitems; ) { ?>
        <div data-toggle="buttons-checkbox" class="span2" style="margin-left:0px;width:162.50px;" align="left">
            <?php for($ctr = 1; $ctr <= $percol && $ctritems <= $tolitems; $ctr++, $ctritems++) { ?>
            <?php
            $key = key($features_residentials);
            next($features_residentials);
            ?>
            <button type="button" class="btn form-ck form-propfeatures1 <?php echo (isset($propfeatures1[$key]) ? 'active' : ''); ?>" data-mod="form-propfeatures1" data-value="<?php echo $key; ?>"><?php echo $features_residentials[$key]; ?></button>
            <input type="checkbox" id="form-propfeatures1-<?php echo $key; ?>" name="propfeatures1[]" value="<?php echo $key; ?>" <?php echo set_checkbox('propfeatures1[]', $key, (isset($propfeatures1[$key]) ? true: false ) ); ?> style="display:none;" />
            <div class="spacer-small"></div>
            <?php } ?>
        </div>
        <?php } ?>
    </div>

    <div id="divfeatures2" class="ck-group" align="center" style="<?php echo $display_features2; ?>">
        <?php
        $tolitems = count($features_commercials);
        $percol = round( $tolitems / 4 );
        ?>
        <?php for($ctritems = 1; $ctritems <= $tolitems; ) { ?>
        <div data-toggle="buttons-checkbox" class="span2" style="margin-left:0px;width:162.50px;" align="left">
            <?php for($ctr = 1; $ctr <= $percol && $ctritems <= $tolitems; $ctr++, $ctritems++) { ?>
            <?php
            $key = key($features_commercials);
            next($features_commercials);
            ?>
            <button type="button" class="btn form-ck form-propfeatures2 <?php echo (isset($propfeatures2[$key]) ? 'active' : ''); ?>" data-mod="form-propfeatures2" data-value="<?php echo $key; ?>"><?php echo $features_commercials[$key]; ?></button>
            <input type="checkbox" id="form-propfeatures2-<?php echo $key; ?>" name="propfeatures2[]" value="<?php echo $key; ?>" <?php echo set_checkbox('propfeatures2[]', $key, (isset($propfeatures2[$key]) ? true: false ) ); ?> style="display:none;" />
            <div class="spacer-small"></div>
            <?php } ?>
        </div>
        <?php } ?>
    </div>

    <div id="divfeatures3" class="ck-group" align="center" style="<?php echo $display_features3; ?>">
        <?php
        $tolitems = count($features_lands);
        $percol = round( $tolitems / 4 );
        ?>
        <?php for($ctritems = 1; $ctritems <= $tolitems; ) { ?>
        <div data-toggle="buttons-checkbox" class="span2" style="margin-left:0px;width:162.50px;" align="left">
            <?php for($ctr = 1; $ctr <= $percol && $ctritems <= $tolitems; $ctr++, $ctritems++) { ?>
            <?php
            $key = key($features_lands);
            next($features_lands);
            ?>
            <button type="button" class="btn form-ck form-propfeatures3 <?php echo (isset($propfeatures3[$key]) ? 'active' : ''); ?>" data-mod="form-propfeatures3" data-value="<?php echo $key; ?>"><?php echo $features_lands[$key]; ?></button>
            <input type="checkbox" id="form-propfeatures3-<?php echo $key; ?>" name="propfeatures3[]" value="<?php echo $key; ?>" <?php echo set_checkbox('propfeatures3[]', $key, (isset($propfeatures3[$key]) ? true: false ) ); ?> style="display:none;" />
            <div class="spacer-small"></div>
            <?php } ?>
        </div>
        <?php } ?>
    </div>

    <div id="divfeatures4" class="ck-group" align="center" style="<?php echo $display_features4; ?>">
        <?php
        $tolitems = count($features_hotels);
        $percol = round( $tolitems / 4 );
        ?>
        <?php for($ctritems = 1; $ctritems <= $tolitems; ) { ?>
        <div data-toggle="buttons-checkbox" class="span2" style="margin-left:0px;width:162.50px;" align="left">
            <?php for($ctr = 1; $ctr <= $percol && $ctritems <= $tolitems; $ctr++, $ctritems++) { ?>
            <?php
            $key = key($features_hotels);
            next($features_hotels);
            ?>
            <button type="button" class="btn form-ck form-propfeatures4 <?php echo (isset($propfeatures4[$key]) ? 'active' : ''); ?>" data-mod="form-propfeatures4" data-value="<?php echo $key; ?>"><?php echo $features_hotels[$key]; ?></button>
            <input type="checkbox" id="form-propfeatures4-<?php echo $key; ?>" name="propfeatures4[]" value="<?php echo $key; ?>" <?php echo set_checkbox('propfeatures4[]', $key, (isset($propfeatures4[$key]) ? true: false ) ); ?> style="display:none;" />
            <div class="spacer-small"></div>
            <?php } ?>
        </div>
        <?php } ?>
    </div>
</fieldset>