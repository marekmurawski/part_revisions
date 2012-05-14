<?php
/**
 * JavaScript Pretty Date
 * Copyright (c) 2008 John Resig (jquery.com)
 * Licensed under the MIT license.
 *
 * Ported to PHP >= 5.1 by Zach Leatherman (zachleat.com)
 * Slight modification denoted below to handle months and years.
 * http://www.zachleat.com/web/2008/02/10/php-pretty-date/
 *
 */
  
class DateDifference
{
    public static function getStringResolved($date, $compareTo = NULL)
    {
        if(!is_null($compareTo)) {
            $compareTo = new DateTime($compareTo);
        }
        return self::getString(new DateTime($date), $compareTo);
    }

    public static function getString(DateTime $date, DateTime $compareTo = NULL)
    {
        if(is_null($compareTo)) {
            $compareTo = new DateTime('now');
        }
        $diff = $compareTo->format('U') - $date->format('U');
        $dayDiff = floor($diff / 86400);

        if(is_nan($dayDiff) || $dayDiff < 0) {
            return '';
        }
                
        if($dayDiff == 0) {
            if($diff < 60) {
                return __('Just now');
            } elseif($diff < 120) {
                return __('1 minute ago');
            } elseif($diff < 3600) {
                return floor($diff/60) . __(' minutes ago');
            } elseif($diff < 7200) {
                return __('1 hour ago');
            } elseif($diff < 86400) {
                return floor($diff/3600) . __(' hours ago');
            }
        } elseif($dayDiff == 1) {
            return __('Yesterday');
        } elseif($dayDiff < 7) {
            return $dayDiff . __(' days ago');
        } elseif($dayDiff == 7) {
            return __('1 week ago');
        } elseif($dayDiff < (7*6)) { // Modifications Start Here
            // 6 weeks at most
            return ceil($dayDiff/7) . __(' weeks ago');
        } elseif($dayDiff < 365) {
            return ceil($dayDiff/(365/12)) . __(' months ago');
        } else {
            $years = round($dayDiff/365);
            return $years . __(' year') . ($years != 1 ? 's' : '') . __(' ago');
        }
    }
}