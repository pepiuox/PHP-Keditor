<?php

session_start();
include 'conn.php';

function protect($str) {
    global $conn;
    $str = trim($str);
    $str = stripslashes($str);
    $str = htmlentities($str, ENT_QUOTES);
    $str = mysqli_real_escape_string($conn, $str);
    return $str;
}

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    $sql = "UPDATE page SET title='" . protect($title) . "', content='" . protect($content) . "' WHERE id='$id'";
    if ($conn->query($sql) === TRUE) {
        echo "Page : Updated";
    } else {
        echo "Failed";
    }
}
?>
