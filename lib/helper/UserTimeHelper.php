<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
    function user_time($time)
    {
        if(!isset($_COOKIE['offset']))
            $_COOKIE['offset'] = 0;
        return strftime('%H:%M:%S; %d %b %Y', strtotime($time)+$_COOKIE['offset']*3600 - date('Z'));
    }
?>
