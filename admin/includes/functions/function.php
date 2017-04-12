<?php

//************** function Title ***************************************************************************************
function getTitle(){
    global $title;

    if (isset($title))
    {
        echo $title;
    }else{
        echo 'Default';
    }
}


//************************ function Redirect ***************************************************************************


function redirectHome($msg, $url = null, $second = 1){
    if ($url === null){

        $url = 'index.php';
    }else{
        $url = isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== ""?$_SERVER['HTTP_REFERER']:'index.php';

    }

    echo $msg;
    header("refresh:$second;url=$url");
    exit();
}
//*************** function Check Item Exist already *******************************************************************

function checkItem($select, $from, $value){
    global $con;
    $stmt = $con->prepare("SELECT $select FROM $from WHERE $select = ? ");
    $stmt->execute(array($value));
    $count = $stmt->rowCount();
    return $count;
}

//***************** function Count Items *******************************************************************************

function countItem($item, $table){
    global $con;
    $stmt = $con->prepare("SELECT count($item) FROM $table");
    $stmt->execute();
    return $stmt->fetchColumn();
}
//*************** // get latest **********************************************

function getLatest($select, $table, $order, $limit = 5){
    global $con;
    $stmt = $con->prepare("SELECT $select FROM $table ORDER BY $order DESC LIMIT $limit");
    $stmt->execute();
    $row = $stmt->fetchAll();
    return $row;
}