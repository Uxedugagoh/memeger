<?php
    $connect = new mysqli('MySQL-8.0', 'root', '', 'cybersport_sim');

    if (!$connect) {
        die('Error connect to DataBase');
    }
?>