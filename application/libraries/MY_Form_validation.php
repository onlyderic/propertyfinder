<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Form_validation extends CI_Form_validation {
    
    function MY_Form_validation( $config = array() ) {
        parent::__construct($config);
    }

    function valid_url_fb($url) {
        $pattern = "/(?:(?:http|https):\/\/)?(?:www\.)?facebook\.com\/?((?:profile\.php\?id=[0-9]*)|(?:(?!(profile|pages))[a-zA-Z0-9\.]{5,})|(?:pages\/[a-zA-Z0-9\.\-]+\/[0-9]+))/i";
        return (bool) preg_match($pattern, $url);
    }

    function valid_url_twitter($url) {
        $pattern = "/(?:(?:http|https):\/\/)?twitter\.com\/(#!\/)?[a-zA-Z0-9_]+/i";
        return (bool) preg_match($pattern, $url);
    }

    function valid_url_googleplus($url) {
        $pattern = "/(?:(?:http|https):\/\/)?plus\.google\.com\/u\/?[0]+\/?[0-9]+/i";
        return (bool) preg_match($pattern, $url);
    }

    function valid_url_linkedin($url) {
        $pattern = "/(?:(?:http|https):\/\/)?(?:www\.|[a-zA-Z]{,2}\.)?linkedin\.com\/?((?:in\/[a-zA-Z0-9]{5,30})|(?:profile\/view\?id=(?=\d.*)))/i";
        return (bool) preg_match($pattern, $url);
    }

    function valid_url_video($url) {
        $pattern1 = "/(?:(?:http|https):\/\/)?(((?:www\.)?youtube\.com\/watch\?v=(?:[a-zA-Z0-9\-_]{11,11}))|((?:www\.)?youtube\.com\/embed\/?(?:[a-zA-Z0-9\-_]{11,11})))/i";
        $pattern2 = "/(?:(?:http|https):\/\/)?(((?:www\.)?vimeo\.com\/?(?:[0-9]{8,8}))|(?:player\.vimeo\.com\/?(?:video\/(?:[0-9]{8,8}))))/i";
        if(preg_match($pattern1, $url)) {
            return true;
        } elseif(preg_match($pattern2, $url)) {
            return true;
        }
        return false;
    }
    
    function alpha_dash_space($str) {
        return ( ! preg_match("/^([-a-z0-9_ ])+$/i", $str)) ? FALSE : TRUE;
    }
}