<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
if (!isset($_SESSION)) {
    session_start();
}
$file = 'conn.php';
if (file_exists($file)) {
    require 'conn.php';
    $result = $conn->query("SELECT * FROM page");
    $nump = $result->num_rows;
    if ($nump > 0) {
        include 'start.php';
    } else {
        header('Location: list.php');
        exit();
    }
} else {
    header('Location: config.php');
    exit();
}
?>
