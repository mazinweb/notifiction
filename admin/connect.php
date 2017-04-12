<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 31/03/17
 * Time: 06:42 م
 */
$dsn = 'mysql:host=localhost;dbname=shop';
$user = 'root';
$pass = 'yaseen';
$option = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
);

try {
    $con = new PDO($dsn,$user,$pass,$option);
    $con->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION );

}
catch ( PDOException $e) {
    echo 'error connection '.$e->getMessage();
}