<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 31/03/17
 * Time: 04:30 م
 */

function lang( $phrase ) {
    static $lang = array(
        'admin-home'      => 'Home',
        'CATEGORIES'      => 'Categories',
        'ITEMS'           => 'Items',
        'MEMBERS'         => 'Members',
        'STATISTICS'      => 'Statistics',
        'LOGS'            => 'Logs',
        '' => '',




    );

    return $lang[$phrase];
}