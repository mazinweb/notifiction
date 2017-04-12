<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 01/04/17
 * Time: 02:36 م
 */
session_start();   // session start
session_unset();  // session unset =>  empty of session
session_destroy();  //  session destroy =>  broken the session

header('location: index.php');

exit();