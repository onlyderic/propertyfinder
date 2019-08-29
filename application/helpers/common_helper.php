<?php

//P-Properties, A-Agents, C-Companies
function generate_code($type = CODE_PROPERTY) {
    switch($type) {
        case CODE_PROPERTY: $prefix = rand(0, 9) . '1'; $suffix = ''; break;
        case CODE_AGENT: $prefix = rand(0, 9) . '2'; $suffix = ''; break;
        case CODE_COMPANY: $prefix = rand(0, 9) . '3'; $suffix = ''; break;
        case 'PROPTRX': 
            return strtoupper(random_string('alnum', 10));
        case 'USERTRX': 
            return strtoupper(random_string('alnum', 10));
        case 'PWD': 
            return random_string('alnum', 20);
        default: $prefix = ''; $suffix = '';
    }
    return $prefix . random_string('alnum', 14) . $suffix;
}

function gettext_profile_level($var, $addbadge = true) {
    switch($var) {
        case LEVEL_NEWBIE: return ( $addbadge ? '<span class="badge badge-success">' : '' ) . '' . ( $addbadge ? '</span>' : '' );
        case LEVEL_REGULAR: return ( $addbadge ? '<span class="badge badge-info">' : '' ) . '' . ( $addbadge ? '</span>' : '' );
        case LEVEL_MASTER: return ( $addbadge ? '<span class="badge badge-warning">' : '' ) . '' . ( $addbadge ? '</span>' : '' );
        case LEVEL_PRIME: return ( $addbadge ? '<span class="badge badge-important">' : '' ) . '' . ( $addbadge ? '</span>' : '' );
        case LEVEL_MODERATOR: return ( $addbadge ? '<span class="badge">' : '' ) . '' . ( $addbadge ? '</span>' : '' );
        default: return '';
    }
}

function get_text_posting($var) {
    switch($var) {
        case PROPPOST_RENT: return 'Rent';
        case PROPPOST_SALE: return 'Sale';
        case PROPPOST_OWN: return 'Rent to Own';
        default: return '';
    }
}

function get_text_category($var) {
    switch($var) {
        case PROPCATEGORY_RESIDENTIAL: return 'Residential';
        case PROPCATEGORY_COMMERCIAL: return 'Commercial';
        case PROPCATEGORY_LAND: return 'Land';
        case PROPCATEGORY_HOTEL: return 'Hotels/Resorts';
        default: return '';
    }
}

function get_text_subcategory($var) {
    switch($var) {
        case PROPSUBCATEGORY_R_CONDOMINIUM: return 'Condominium';
        case PROPSUBCATEGORY_R_HOUSEANDLOT: return 'House and Lot';
        case PROPSUBCATEGORY_R_APARTMENT: return 'Apartment';
        case PROPSUBCATEGORY_R_HDB: return 'HDB';
        case PROPSUBCATEGORY_R_BOARDINGHOUSE: return 'Boarding House';
        case PROPSUBCATEGORY_C_OFFICE: return 'Office';
        case PROPSUBCATEGORY_C_SOHO: return 'SOHO';
        case PROPSUBCATEGORY_C_RETAIL: return 'Reatil';
        case PROPSUBCATEGORY_C_INDUSTRIAL: return 'Industrial';
        case PROPSUBCATEGORY_L_LANDONLY: return 'Land only';
        case PROPSUBCATEGORY_L_LANDWITHSTRUCTURE: return 'Land with structure';
        case PROPSUBCATEGORY_L_FARM: return 'Farm';
        case PROPSUBCATEGORY_L_BEACH: return 'Beach';
        case PROPSUBCATEGORY_H_HOTELRESORT: return 'Hotel/Resort';
        case PROPSUBCATEGORY_H_PENSIONINN: return 'Pension Inn';
        case PROPSUBCATEGORY_H_CONVENTIONCENTER: return 'Convention Center';
        default: return '';
    }
}

function get_text_classification($var) {
    switch($var) {
        case PROPCLASS_R_CONDOMINIUM: return 'Condominium';
        case PROPCLASS_R_CONDOMINIUMHOTEL: return 'Condominium-Hotel';
        case PROPCLASS_R_PENTHOUSE: return 'Penthouse';
        case PROPCLASS_R_DETACHEDSINGLE: return 'Single Storey / Detached';
        case PROPCLASS_R_DETACHEDMULTI: return 'Multi-Storey / Detached';
        case PROPCLASS_R_DUPLEX: return 'Duplex / Semi-attached';
        case PROPCLASS_R_TOWNHOUSE: return 'Townhouse / Attached';
        case PROPCLASS_R_MANSIONETTE: return 'Mansionette';
        case PROPCLASS_R_MANSION: return 'Mansion';
        case PROPCLASS_R_APARTMENT: return 'Apartment';
        case PROPCLASS_R_BACHELORSPAD: return 'Bachelor\'s Pad';
        case PROPCLASS_R_ROOM: return 'Room';
        case PROPCLASS_R_BED: return 'Bed';
        case PROPCLASS_R_HDB: return 'HDB';
        case PROPCLASS_C_OFFICE: return 'Office';
        case PROPCLASS_C_BUSINESSPARK: return 'Business Park';
        case PROPCLASS_C_SOHO: return 'SOHO';
        case PROPCLASS_C_MALL: return 'Mall';
        case PROPCLASS_C_SHOP: return 'Shop';
        case PROPCLASS_C_OTHER: return 'Other retail';
        case PROPCLASS_C_FACTORY: return 'Factory';
        case PROPCLASS_C_WAREHOUSE: return 'Warehouse';
        case PROPCLASS_L_LANDONLY: return 'Land only';
        case PROPCLASS_L_LANDWITHSTRUCTURE: return 'Land with structure';
        case PROPCLASS_L_FARM: return 'Farm';
        case PROPCLASS_L_BEACH: return 'Beach';
        case PROPCLASS_H_HOTEL: return 'Hotel';
        case PROPCLASS_H_HOTELANDRESORT: return 'Hotel and Resort';
        case PROPCLASS_H_RESORT: return 'Resort';
        case PROPCLASS_H_BACKPACKER: return 'Back-packer';
        case PROPCLASS_H_PENSIONINN: return 'Pension Inn';
        case PROPCLASS_H_CONVENTIONCENTER: return 'Convention Center';
        default: return '';
    }
}

function get_text_room($var) {
    if($var == 'S') return "Studio/Bachelor's Pad";
    return $var;
}

function get_text_financing($var) {
    switch($var) {
        case PROPFINANCING_CASH: return 'Cash';
        case PROPFINANCING_BANK: return 'Bank';
        case PROPFINANCING_PAGIBIG: return 'Government Loans';
        default: return '';
    }
}

function get_text_tenure($var) {
    switch($var) {
        case TENURE_FREEHOLD: return 'Freehold';
        case TENURE_LEASEHOLD: return 'Leasehold';
        case TENURE_1YEAR: return '1 year';
        case TENURE_2YEARS: return '2 years';
        case TENURE_3UP: return '3 years up';
        case TENURE_FLEXIBLE: return 'Flexible';
        case TENURE_SHORTTERM: return 'Short Term';
        default: return '';
    }
}

function get_text_foreclosure($var) {
    switch($var) {
        case 'A': return 'Not Applicable';
        case YES: return 'Foreclosed';
        case NO: return 'Not Foreclosed';
        default: return '';
    }
}

function get_text_resale($var) {
    switch($var) {
        case YES: return 'Yes';
        case NO: return 'No';
        default: return '';
    }
}

function get_text_occupancy($var) {
    switch($var) {
        case YES: return 'Yes';
        case NO: return 'No';
        default: return '';
    }
}

function get_text_furnished($var) {
    switch($var) {
        case 'U': return 'Unfurnished';
        case 'P': return 'Partially Furnished';
        case 'F': return 'Fully Furnished';
        default: return '';
    }
}

function get_text_furnishing($var) {
    $ci =& get_instance();
    $arr_residentials = $ci->config->item('furnishings_residentials');
    $arr_commercials = $ci->config->item('furnishings_commercials');
    $arr_hotels = $ci->config->item('furnishings_hotels');
    //Land has no furnishings
    if(isset($arr_residentials[$var])) {
        return $arr_residentials[$var];
    } elseif(isset($arr_commercials[$var])) {
        return $arr_commercials[$var];
    } elseif(isset($arr_hotels[$var])) {
        return $arr_hotels[$var];
    }
    return '';
}

function get_text_facility($var) {
    $ci =& get_instance();
    $arr_residentials = $ci->config->item('facilities_residentials');
    $arr_commercials = $ci->config->item('facilities_commercials');
    $arr_hotels = $ci->config->item('facilities_hotels');
    //Land has no facility
    if(isset($arr_residentials[$var])) {
        return $arr_residentials[$var];
    } elseif(isset($arr_commercials[$var])) {
        return $arr_commercials[$var];
    } elseif(isset($arr_hotels[$var])) {
        return $arr_hotels[$var];
    }
    return '';
}

function get_text_feature($var) {
    $ci =& get_instance();
    $arr1 = $ci->config->item('features_residentials');
    $arr2 = $ci->config->item('features_lands');
    if(isset($arr1[$var])) { //Residential, Commercial, and Hotel/Resort uses similar list
        return $arr1[$var];
    } elseif(isset($arr2[$var])) {
        return $arr2[$var];
    }
    return '';
}

function get_text_paid($var) {
    switch($var) {
        case PAYSTATUS_PAID: return 'Paid';
        case PAYSTATUS_UNPAID: return 'No';
        default: return '';
    }
}

function money_symbol($var) {
    $ci =& get_instance();
    $arr = $ci->config->item('currencies');
    return ( isset($arr[$var]) ? $arr[$var] : '' );
}

function get_text_country($var) {
    $ci =& get_instance();
    $arr = $ci->config->item('countries');
    return ( isset($arr[$var]) ? $arr[$var] : '' );
}

function shorten_text($str, $length = 20, $ending = '...', $showend = false) {
    if( !$showend ) {
        if(strlen($str) > $length) { 
            $ret = substr($str, 0, $length - strlen($ending)) . $ending;
        } else { 
            $ret = $str;
        }   
    } else {
        if(strlen($str) > $length) { 
            $ret = $ending . substr(rtrim($str), ( ( $length - strlen($ending) ) * -1 ) );
        } else { 
            $ret = $str;
        }
    }
    return $ret;
}

function format_number_whole($number) {
    try {
        $number = trim($number);
        if (strpos($number, ",") === FALSE && $number != "") {
            if (is_numeric($number)) {
                if ($number > 0 && $number < 1) {
                    $number = intval( str_replace('.', '', ($number * 100) ) ) . $symbol;
                } else if ($number < 0) {
                    $number = "-" . number_format(abs($number), 0, '.', ',');
                } else {
                    $number = number_format($number, 0, '.', ',');
                }
            }
        }
        if ($number != '') {
            return $number;
        } else {
            return $number;
        }
    } catch (Exception $e) {
        return $number;
    }
}

function format_money($number) {
    try {
        $number = trim($number);
        if (strpos($number, ",") === FALSE && $number != "") {
            if (is_numeric($number)) {
                if ($number < 0) {
                    $number = "-" . number_format(abs($number), 2, '.', ',');
                } else {
                    $number = number_format($number, 2, '.', ',');
                }
            }
        }
        if ($number != '') {
            return $number;
        } else {
            return $number;
        }
    } catch (Exception $e) {
        return $number;
    }
}

function time_elapsed($fromtime) {
    $fromtime = strtotime($fromtime);
    $elapsedtime = time() - $fromtime;
    if($elapsedtime < 1) {
        return 'Just now';
    }
    
    $times = array (
        31536000 => 'year', //12 * 30 * 24 * 60 * 60
        2592000 => 'month', //30 * 24 * 60 * 60
        604800 => 'week',
        86400 => 'day', //24 * 60 * 60
        3600 => 'hour', //60 * 60
        60 => 'minute', //60
        1 => 'second' //1
    );
    
    foreach($times as $secs => $str) {
        $d = $elapsedtime / $secs;
        if($d >= 1) {
            $r = round($d);
            return $r . ' ' . $str . ($r > 1 ? 's' : '') . ' ago';
        }
    }
}

function convert_amount($amount) {
    $code = substr(trim($amount), -1);
    $code = strtolower($code);
    $convertednum = $amount;
    if($code == 'k' || $code == 'm') {
        $numpart = substr($amount, 0, strlen($amount) - 1);
        $numpart = str_replace(',', '', $numpart);
        if($code == 'k') {
            $convertednum = doubleval($numpart) * 1000.00;
        }
        if($code == 'm') {
            $convertednum = doubleval($numpart) * 1000000.00;
        }
    }
    return $convertednum;
}

function send_email($to = '', $toname = '', $from = '', $fromname = '', $subject = '', $message = '') {
    $CI = & get_instance();
    $CI->load->helper('phpmailer');
    $mail = new PHPMailer();

    $mail->IsSMTP();
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = "";
    $mail->Host = $CI->config->item('smtp_host');
    $mail->Port = $CI->config->item('smtp_port');
    $mail->Username = $CI->config->item('smtp_user');
    $mail->Password = $CI->config->item('smtp_pass');

    $mail->From = $from;
    $mail->FromName = $fromname;
    $mail->Subject = $subject;
    $mail->Body = $message;
    $mail->AltBody = $message;
    $mail->IsHTML(true);
    $mail->AddAddress($to);

    if (!$mail->Send()) {
        return false;
    } else {
        return true;
    }
}