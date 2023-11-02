<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('user_module'))
{
    function user_module($access_key, $action)
    {
        $ci=& get_instance();
        $strReplace = str_replace("-", "_", $access_key);
        $actualAccessKey = $strReplace."_".$action;
        $moduleAccess = $ci->session->moduleAccess;
        //print_r($moduleAccess); die;
        if(in_array($actualAccessKey, $moduleAccess))
        {
            return true;
        }
        else
        {
            return false;    
        }
        
    }   
}


if ( ! function_exists('thousand_format'))
{
    function thousand_format($n) {
    /*$number = (int) preg_replace('/[^0-9]/', '', $number);
    if ($number >= 1000) {
        $rn = round($number);
        $format_number = number_format($rn);
        $ar_nbr = explode(',', $format_number);
        $x_parts = array('K', 'M', 'B', 'T', 'Q');
        $x_count_parts = count($ar_nbr) - 1;
        $dn = $ar_nbr[0] . ((int) $ar_nbr[1][0] !== 0 ? '.' . $ar_nbr[1][0] : '');
        $dn .= $x_parts[$x_count_parts - 1];

        return $dn;
    }
    return $number;*/

     if($n>1000000000000) return round(($n/1000000000000),1).'T';
        else if($n>1000000000) return round(($n/1000000000),1).'B';
        else if($n>100000000) return round(($n/100000000),1).'Cr';
        else if($n>1000000) return round(($n/1000000),1).'M';
        else if($n>1000) return round(($n/1000),1).'K';


}

}