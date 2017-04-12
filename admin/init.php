<?php
/**
 * Created by yaseen.
 * User: yaseen
 * Date: 31/03/17
 * Time: 04:09 م
 */

//route

include 'connect.php';

   $tpl    = "includes/templates/";
   $lan    = "includes/languages/";
   $func   = "includes/functions/";
   $css    = "statics/css/";
   $js     = "statics/js/";

// important file
include $lan.'english.php';
include $func.'function.php';
include $tpl.'header.php';

 // include navbar page on all pages else page contain variable $nonavbar

if (!isset($nonavbar)) { include $tpl.'navbar.php'; }

