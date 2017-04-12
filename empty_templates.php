<?php
/**
 * Created by PhpStorm.
 * User: yaseen
 * Date: 09/04/17
 * Time: 03:38 م
 */

ob_start();
session_start(); 

$title = '';

if(isset($_SESSION['username'])){

    include 'init.php';

    $do = isset($_GET['do']) ? $_GET['do'] : 'manage';

    if ($do == 'manage'){

        // manage page

    }elseif ($do == 'add'){

        // add page

    }elseif ($do == 'insert'){

        //insert page

    }elseif ($do == 'edit'){

        //edit page

    }elseif ($do == 'update'){

        // update page

    }elseif ($do == 'delete'){

        //delete page

    }elseif ($do == 'activate'){

        // activate page
    }
    include $tpl.'footer.php';


}else{
    header('location: index.php');

    exit();
}
ob_end_flush();
