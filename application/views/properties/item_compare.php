<?php 

$profilecontroller = ( $record->ownerusertype == USERTYPE_COMPANY ? 'company' : 'agent' );

$propurl = site_url('property/' . url_title($record->propname) . '/' . $record->propcode);
$userurl = site_url($profilecontroller . '/' . url_title($record->ownername) . '/' . $record->ownercode);
$compurl = site_url('company/' . url_title($record->companyname) . '/' . $record->companycode);

$sourcewidth = (!empty($record->profilepicwidth) ? $record->profilepicwidth : '0');
$sourceheight = (!empty($record->profilepicheight) ? $record->profilepicheight : '0');

if( ( $sourcewidth > PROPPROFILEPIC_MAXWIDTH || $sourceheight > PROPPROFILEPIC_MAXHEIGHT ) &&
    $sourcewidth != 0 && $sourcewidth != 0 ) {

    $targetwidth = PROPPROFILEPIC_MAXWIDTH - 50;
    $targetheight = PROPPROFILEPIC_MAXHEIGHT - 50;

    $sourceratio = $sourcewidth / $sourceheight;
    $targetratio = $targetwidth / $targetheight;

    if ( $sourceratio < $targetratio ) {
        $scale = $sourcewidth / $targetwidth;
    } else {
        $scale = $sourceheight / $targetheight;
    }

    $sourcewidth = (int)($sourcewidth / $scale);
    $sourceheight = (int)($sourceheight / $scale);
}

$postingarr = str_split($record->posting);
foreach($postingarr as $k => $v) {
    $postingarr[$k] = get_text_posting($v);
}
$posting = implode(' / ', $postingarr);

$financingarr = str_split($record->financing);
foreach($financingarr as $k => $v) {
    $financingarr[$k] = get_text_financing($v);
}
$financing = implode(', ', $financingarr);

$price = money_symbol($record->priceunit) . format_money($record->pricemin) . ( !empty($record->pricemax) ? ' <span style="color:#000;font-weight:normal;">to</span> ' . format_money($record->pricemax) : '' );
$price .= ( $record->pricenegotiable == YES ? ' <small style="font-weight:normal;">(negotiable)</small>' : ( $record->pricenegotiable == NO ? ' <small style="font-weight:normal;">(not negotiable)</small>' : '' ) );
$location = $record->city . ( !empty($record->city) && !empty($record->country) ? ', ' : '' ) . ( !empty($record->country) ? get_text_country($record->country) : '' );

$numrating = ( $record->numrating > 0 ? '&nbsp;&nbsp;<span style="font-size:small;">(' . $record->numrating . ')</span>' : '' );

$tenure = ( $record->tenure == TENURE_FREEHOLD || $record->tenure == TENURE_LEASEHOLD ? $record->tenureyr . '-years ' : '' ) . get_text_tenure($record->tenure);
$unitsnum = $record->unitsnum . ( !empty($record->unitsnum) ? ( $record->unitsnum == 1 ? ' unit' : ' units' ) : '' );

$foreclosure = get_text_foreclosure($record->foreclosure);
$resale = get_text_resale($record->resale);

$months = array(1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December');

$featured = '';
if($record->featured == YES) {
    $featured = ' <span class="badge badge-warning tooltip-propertyfinder" data-toggle="tooltip" data-placement="top" title="Featured property!"><i class="icon-certificate"></i></span>';
}

//Fields that might not contain values:

$pricereserve = $record->pricereserve;
$pricedown = $record->pricedown;
$pricediscount = $record->pricediscount;
    
if($record->category == PROPCATEGORY_LAND) {
    $rooms = '<span class="disabled">NA</span>';
    $toilets = '<span class="disabled">NA</span>';
    $area = '<span class="disabled">NA</span>';
    $garages = '<span class="disabled">NA</span>';
    $furnishings = '<span class="disabled">NA</span>';
    $features = '<span class="disabled">NA</span>';
    $construction = '<span class="disabled">NA</span>';
    $completion = '<span class="disabled">NA</span>';
    $floorsnum = '<span class="disabled">NA</span>';
    $occupancy = '<span class="disabled">NA</span>';
    $furnished = '<span class="disabled">NA</span>';
} else {
    $rooms = ( !empty($record->roomsmin) ? get_text_room($record->roomsmin) . ( !empty($record->roomsmax) ? ' to ' . $record->roomsmax . ' rooms' : '' ) : '' );
    $toilets = ( !empty($record->toiletmin) ? $record->toiletmin . ( !empty($record->toiletmax) ? ' to ' . $record->toiletmax : '' ) : '' );
    $area = ( !empty($record->areamin) ? format_number_whole($record->areamin) . ( !empty($record->areamax) ? ' to ' . format_number_whole($record->areamax) : '' ) . ' ' . $record->areaunit : '' );
    $garages = ( !empty($record->garagemin) ? $record->garagemin . ( !empty($record->garagemax) ? ' to ' . $record->garagemax : '' ) : '' );

    $construction = ( empty($record->construction) || $record->construction == -5 ? '' : ( $record->construction == 100 ? 'Complete' : $record->construction . '%' ) );
    $completion = ( $record->construction != 100 ? ( !empty($record->completionmo) ? $months[$record->completionmo] . ' ' : '' ) . $record->completionyr : '' );
    $floorsnum = $record->floorsnum . ( !empty($record->floorsnum) ? ( $record->floorsnum == 1 ? ' storey' : ' storeys' ) : '' );
            
    $occupancy = get_text_occupancy($record->occupancy);
    $furnished = get_text_furnished($record->furnished);

    $furnishingsarr = explode(',', $record->furnishings);
    foreach($furnishingsarr as $k => $v) {
        $furnishingsarr[$k] = get_text_furnishing($v);
    }
    $furnishings = implode(', ', $furnishingsarr);
    $furnishings = ( empty($furnishings) ? '<span class="disabled">Not specified</span>' : $furnishings );

    $featuresarr = explode(',', $record->features);
    foreach($featuresarr as $k => $v) {
        $featuresarr[$k] = get_text_feature($v);
    }
    $features = implode(', ', $featuresarr);
    $features = ( empty($features) ? '<span class="disabled">Not specified</span>' : $features );
}
    
$garagelabel = ( $record->category == PROPCATEGORY_RESIDENTIAL ? 'Garage' : 'Parking' );
$garagelabel = ( $record->subcategory == PROPSUBCATEGORY_R_CONDOMINIUM ? 'Parking' : $garagelabel );
$companyname = ( !empty($record->companyname) ? '<a href="' . $compurl . '" title="' . $record->companyname . '">' . $record->companyname . '</a>' : '' );
            
?>

<div class="compareleft">
    <div class="propitem">
        
        <div class="propitemimg" style="height:<?php echo PROPPROFILEPIC_MAXHEIGHT + 10; ?>px;" align="center">
            <a href="<?php echo $propurl; ?>" class="proplistitemimglink">
                <img src="<?php echo site_url('photos/' . $record->propcode . '/thumbs/' . $record->profilepic); ?>" style="<?php echo (!empty($sourcewidth) ? 'width:' . $sourcewidth . 'px;' : '') . (!empty($sourceheight) ? 'height:' . $sourceheight . 'px;' : ''); ?>" class="img-polaroid" >
            </a>
        </div>
        
        <div class="propitemdtl">
            
            <h4><a href="<?php echo $propurl; ?>" class="proplistitemnamelink"><?php echo shorten_text($record->propname, 50); ?></a><?php echo $featured; ?></h4>
            
            <table class="table table-condensed table-striped">
                <tr>
                    <th class="propitem-label">Posting</th>
                    <td><?php echo $posting; ?></td>
                </tr>
                <tr>
                    <th class="propitem-label">Type</th>
                    <td><?php echo get_text_classification($record->classification); ?></td>
                </tr>
                <tr>
                    <th class="propitem-label">Price</th>
                    <td><?php echo $price; ?></td>
                </tr>
                <tr>
                    <th class="propitem-label">Financing</th>
                    <td><?php echo $financing; ?></td>
                </tr>
                <tr>
                    <th class="propitem-label">Developer</th>
                    <td><?php echo $companyname; ?></td>
                </tr>
                <tr>
                    <th class="propitem-label">Location</th>
                    <td><?php echo $location; ?></td>
                </tr>
                <tr>
                    <th class="propitem-label">Rooms</th>
                    <td><?php echo $rooms; ?></td>
                </tr>
                <tr>
                    <th class="propitem-label">Toilets</th>
                    <td><?php echo $toilets; ?></td>
                </tr>
                <tr>
                    <th class="propitem-label"><?php echo $garagelabel; ?></th>
                    <td><?php echo $garages; ?></td>
                </tr>
                <tr>
                    <th class="propitem-label">Area</th>
                    <td><?php echo $area; ?></td>
                </tr>
            </table>
                
            <div class="spacer"></div>

            <table class="table table-condensed table-striped">
                <tr>
                    <th class="propitem-label">Reservation</th>
                    <td><?php echo $pricereserve; ?></td>
                </tr>
                <tr>
                    <th class="propitem-label">Down Payment</th>
                    <td><?php echo $pricedown; ?></td>
                </tr>
                <tr>
                    <th class="propitem-label">Discount</th>
                    <td><?php echo $pricediscount; ?></td>
                </tr>
            </table>
                
            <div class="spacer"></div>

            <table class="table table-condensed table-striped">
                <tr>
                    <th class="propitem-label">Floors</th>
                    <td><?php echo $floorsnum; ?></td>
                </tr>
                <tr>
                    <th class="propitem-label">Units</th>
                    <td><?php echo $unitsnum; ?></td>
                </tr>
                <tr>
                    <th class="propitem-label">Tenure</th>
                    <td><?php echo $tenure; ?></td>
                </tr>
                <tr>
                    <th class="propitem-label">Construction</th>
                    <td><?php echo $construction; ?></td>
                </tr>
                <tr>
                    <th class="propitem-label">Completion</th>
                    <td><?php echo $completion; ?></td>
                </tr>
                <tr>
                    <th class="propitem-label">Foreclosure</th>
                    <td><?php echo $foreclosure; ?></td>
                </tr>
                <tr>
                    <th class="propitem-label">Resale?</th>
                    <td><?php echo $resale; ?></td>
                </tr>
                <tr>
                    <th class="propitem-label">Ready for Occupancy</th>
                    <td><?php echo $occupancy; ?></td>
                </tr>
            </table>
                
            <div class="spacer"></div>

            <table class="table table-condensed table-striped">
                <tr>
                    <th class="propitem-label">Date Posted</th>
                    <td><?php echo $record->fdatepublished; ?></td>
                </tr>
                <tr>
                    <th class="propitem-label">Posted By</th>
                    <td><a href="<?php echo $userurl; ?>"><?php echo $record->ownername; ?></a></td>
                </tr>
            </table>
                
            <div class="spacer"></div>

            <table class="table table-condensed table-striped">
                <tr>
                    <th class="propitem-label">Ratings</th>
                    <td>
                        <?php for($ctr = 0; $ctr < $record->rating; $ctr++) { ?>
                        <img src="<?php echo $this->config->item('image_path'); ?>star-on.png" alt="1">
                        <?php } ?>
                        <?php for(; $ctr < 5; $ctr++) { ?>
                        <img src="<?php echo $this->config->item('image_path'); ?>star-off.png" alt="1">
                        <?php } ?>
                        <?php echo $numrating; ?>
                    </td>
                </tr>
                <tr>
                    <th class="propitem-label">Likes</th>
                    <td><i class="icon-thumbs-up"></i> <?php echo $record->numlikes; ?></td>
                </tr>
                <tr>
                    <th class="propitem-label">Dislikes</th>
                    <td><i class="icon-thumbs-down"></i> <?php echo $record->numdislikes; ?></td>
                </tr>
                <tr>
                    <th class="propitem-label">Views</th>
                    <td><?php echo $record->numviews; ?></td>
                </tr>
            </table>
                
            <div class="spacer"></div>

            <table class="table table-condensed table-striped">
                <tr>
                    <th class="propitem-label">Furnish</th>
                    <td><?php echo $furnished; ?></td>
                </tr>
                <tr>
                    <th class="propitem-label" colspan="2">Furnishings</th>
                </tr>
                <tr>
                    <td colspan="2"><?php echo $furnishings; ?></td>
                </tr>
                <tr>
                    <th class="propitem-label" colspan="2">Features</th>
                </tr>
                <tr>
                    <td colspan="2"><?php echo $features; ?></td>
                </tr>
            </table>
            
            <div class="spacer"></div>
            <div class="spacer"></div>
            <div class="spacer"></div>
        </div>
    </div>
    <div class="proptool-compare">
        <span><span><span><span><a href="#" class="btn btn-small remove compare tooltip-propertyfinder" title="Remove" data-toggle="tooltip" data-placement="left" role="button" data-type="<?php echo $record->propcode; ?>" data-url="<?php echo site_url('comparisons/remove/' . url_title($record->propname) . '/' . $record->propcode); ?>"><span><i class="icon-remove-sign" style="opacity: .80;"></i></span><span></span></a></span></span></span></span>
    </div>
</div>