<?php

$_SESSION['language'] = '';

$url = "http://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";

$escaped_url = htmlspecialchars($url, ENT_QUOTES, 'UTF-8');
$url_path = parse_url($escaped_url, PHP_URL_PATH);
$basename = pathinfo($url_path, PATHINFO_FILENAME);
$indexname = pathinfo(basename($_SERVER['SCRIPT_NAME']), PATHINFO_FILENAME); // get file name without extension

$file = 'conn.php';
if (file_exists($file)) {
    require 'conn.php';
    $result = $conn->query("SELECT * FROM page");
    $nump = $result->num_rows;
    if ($nump > 0) {
        include 'start.php';
    } else {
        header('Location: list.php');
    }
} else {
    header('Location: config.php');
}
?>