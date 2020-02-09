<?php
session_start();
include 'conn.php';

function protect($str)
{
    global $conn;
    $str = trim($str);
    $str = stripslashes($str);
    $str = htmlentities($str, ENT_QUOTES);
    $str = mysqli_real_escape_string($conn, $str);
    return $str;
}
if (isset($_POST['id'])) {
    $content = $_POST['content'];
    $id = $_POST['id'];
    $sql = "UPDATE page SET content='" . protect($content) . "' WHERE id='$id'";
    if ($conn->query($sql) === TRUE) {
        echo "Page : Updated";
    } else {
        echo "Failed";
    }
} else {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $sql = "INSERT INTO page (title, content) VALUES ('" . protect($title) . "', '" . protect($content) . "')";
    if ($conn->query($sql) === TRUE) {
        $last_id = $conn->insert_id;
        $_SESSION["title"] = $title;
        $_SESSION["page"] = $last_id;
        echo "Page " . $title . " : Created ";
    } else {
        echo "Failed";
    }
}

?>
