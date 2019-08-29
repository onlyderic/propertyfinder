
<fieldset id="flsfurnishings" class="profheading" style="<?php echo $display_furnishingsall; ?>">
    <h4>Furnishings</h4>

    <?php $err = form_error('propfurnished[]'); ?>
    <div id="divpropfurnished" class="control-group <?php echo ($err != '' ? 'error' : ''); ?>">
        <label class="control-label" for="propfurnished">Furnished?</label>
        <div class="controls">
            <div data-toggle="buttons-radio">
                <button type="button" class="btn form-opt form-propfurnished <?php echo (isset($propfurnished['U']) ? 'active' : ''); ?>" data-mod="form-propfurnished" data-value="U">Unfurnished</button>
                <button type="button" class="btn form-opt form-propfurnished <?php echo (isset($propfurnished['P']) ? 'active' : ''); ?>" data-mod="form-propfurnished" data-value="P">Partially Furnished</button>
                <button type="button" class="btn form-opt form-propfurnished <?php echo (isset($propfurnished['F']) ? 'active' : ''); ?>" data-mod="form-propfurnished" data-value="F">Fully Furnished</button>
                <div style="display:none;">
                    <input type="radio" id="form-propfurnished-U" name="propfurnished[]" value="U" <?php echo set_radio('propfurnished[]', 'U', (isset($propfurnished['U']) ? true: false ) ); ?> />
                    <input type="radio" id="form-propfurnished-P" name="propfurnished[]" value="P" <?php echo set_radio('propfurnished[]', 'P', (isset($propfurnished['P']) ? true: false ) ); ?> />
                    <input type="radio" id="form-propfurnished-F" name="propfurnished[]" value="F" <?php echo set_radio('propfurnished[]', 'F', (isset($propfurnished['F']) ? true: false ) ); ?> />
                </div>
            </div>
        </div>
    </div>

    <hr class="soften">

    <div id="divfurnishings1" class="ck-group" align="center" style="<?php echo $display_furnishings1; ?>">
        <?php
        $tolitems = count($furnishings_residentials);
        $percol = round( $tolitems / 4 );
        ?>
        <?php for($ctritems = 1; $ctritems <= $tolitems; ) { ?>
        <div data-toggle="buttons-checkbox" class="span2" style="margin-left:0px;width:162.50px;" align="left">
            <?php for($ctr = 1; $ctr <= $percol && $ctritems <= $tolitems; $ctr++, $ctritems++) { ?>
            <?php
            $key = key($furnishings_residentials);
            next($furnishings_residentials);
            ?>
            <button type="button" class="btn form-ck form-propfurnish1 <?php echo (isset($propfurnish1[$key]) ? 'active' : ''); ?>" data-mod="form-propfurnish1" data-value="<?php echo $key; ?>"><?php echo $furnishings_residentials[$key]; ?></button>
            <input type="checkbox" id="form-propfurnish1-<?php echo $key; ?>" name="propfurnish1[]" value="<?php echo $key; ?>" <?php echo set_checkbox('propfurnish1[]', $key, (isset($propfurnish1[$key]) ? true: false ) ); ?> style="display:none;" />
            <div class="spacer-small"></div>
            <?php } ?>
        </div>
        <?php } ?>
    </div>

    <div id="divfurnishings2" class="ck-group" align="center" style="<?php echo $display_furnishings2; ?>">
        <?php
        $tolitems = count($furnishings_commercials);
        $percol = round( $tolitems / 4 );
        ?>
        <?php for($ctritems = 1; $ctritems <= $tolitems; ) { ?>
        <div data-toggle="buttons-checkbox" class="span2" style="margin-left:0px;width:162.50px;" align="left">
            <?php for($ctr = 1; $ctr <= $percol && $ctritems <= $tolitems; $ctr++, $ctritems++) { ?>
            <?php
            $key = key($furnishings_commercials);
            next($furnishings_commercials);
            ?>
            <button type="button" class="btn form-ck form-propfurnish2 <?php echo (isset($propfurnish2[$key]) ? 'active' : ''); ?>" data-mod="form-propfurnish2" data-value="<?php echo $key; ?>"><?php echo $furnishings_commercials[$key]; ?></button>
            <input type="checkbox" id="form-propfurnish2-<?php echo $key; ?>" name="propfurnish2[]" value="<?php echo $key; ?>" <?php echo set_checkbox('propfurnish2[]', $key, (isset($propfurnish2[$key]) ? true: false ) ); ?> style="display:none;" />
            <div class="spacer-small"></div>
            <?php } ?>
        </div>
        <?php } ?>
    </div>

    <div id="divfurnishings3" class="ck-group" align="center" style="<?php echo $display_furnishings3; ?>">
        <?php
        $tolitems = count($furnishings_lands);
        $percol = round( $tolitems / 4 );
        ?>
        <?php for($ctritems = 1; $ctritems <= $tolitems; ) { ?>
        <div data-toggle="buttons-checkbox" class="span2" style="margin-left:0px;width:162.50px;" align="left">
            <?php for($ctr = 1; $ctr <= $percol && $ctritems <= $tolitems; $ctr++, $ctritems++) { ?>
            <?php
            $key = key($furnishings_lands);
            next($furnishings_lands);
            ?>
            <button type="button" class="btn form-ck form-propfurnish3 <?php echo (isset($propfurnish3[$key]) ? 'active' : ''); ?>" data-mod="form-propfurnish3" data-value="<?php echo $key; ?>"><?php echo $furnishings_lands[$key]; ?></button>
            <input type="checkbox" id="form-propfurnish3-<?php echo $key; ?>" name="propfurnish3[]" value="<?php echo $key; ?>" <?php echo set_checkbox('propfurnish3[]', $key, (isset($propfurnish3[$key]) ? true: false ) ); ?> style="display:none;" />
            <div class="spacer-small"></div>
            <?php } ?>
        </div>
        <?php } ?>
    </div>

    <div id="divfurnishings4" class="ck-group" align="center" style="<?php echo $display_furnishings4; ?>">
        <?php
        $tolitems = count($furnishings_hotels);
        $percol = round( $tolitems / 4 );
        ?>
        <?php for($ctritems = 1; $ctritems <= $tolitems; ) { ?>
        <div data-toggle="buttons-checkbox" class="span2" style="margin-left:0px;width:162.50px;" align="left">
            <?php for($ctr = 1; $ctr <= $percol && $ctritems <= $tolitems; $ctr++, $ctritems++) { ?>
            <?php
            $key = key($furnishings_hotels);
            next($furnishings_hotels);
            ?>
            <button type="button" class="btn form-ck form-propfurnish4 <?php echo (isset($propfurnish4[$key]) ? 'active' : ''); ?>" data-mod="form-propfurnish4" data-value="<?php echo $key; ?>"><?php echo $furnishings_hotels[$key]; ?></button>
            <input type="checkbox" id="form-propfurnish4-<?php echo $key; ?>" name="propfurnish4[]" value="<?php echo $key; ?>" <?php echo set_checkbox('propfurnish4[]', $key, (isset($propfurnish4[$key]) ? true: false ) ); ?> style="display:none;" />
            <div class="spacer-small"></div>
            <?php } ?>
        </div>
        <?php } ?>
    </div>
</fieldset>  