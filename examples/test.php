<?php

  $hostlk = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
        $lpath = "https";
    } else {
        $lpath = "http";
    }
    $lpath .= "://";
    $lpath .= $_SERVER['HTTP_HOST'];
    $lpath .= $_SERVER['PHP_SELF'];

    $fileName = basename($_SERVER['PHP_SELF']);
    $fl = $hostlk . $fileName;

    $path = basename($_SERVER['REQUEST_URI']);
    $file = basename($path);

    if ($file == $fileName) {
        header("Location: test.php?w=select");
    }

$url = $_SERVER['REQUEST_URI']; //returns the current URL
$parts = explode('/',$url);
$dir = $_SERVER['HTTP_HOST'];
for ($i = 0; $i < count($parts) - 1; $i++) {
 $dir .= $parts[$i] . "/";
}
echo $dir;
