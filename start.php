<?php
if ($url === $base) {
    $rs = $conn->query("SELECT * FROM page WHERE starpage='1' AND active='1'");
    $numr = $rs->num_rows;
    $rpx = $rs->fetch_assoc();

    header('Location: ' . $base . 'index.php?page=' . $rpx['id']);
} else if (isset($basename) && !empty($basename)) {
    $rs = $conn->query("SELECT * FROM page WHERE link='$basename' AND active='1'");
    $numr = $rs->num_rows;
    $rpx = $rs->fetch_assoc();
} else if (isset($_GET['page']) && !empty($_GET['page'])) {
    $id = (int) $_GET['page'];
    $rs = $conn->query("SELECT * FROM page WHERE id='$id' AND active='1'");
    $numr = $rs->num_rows;
    $rpx = $rs->fetch_assoc();
} else {
    $rs = $conn->query("SELECT * FROM page WHERE starpage='1' AND active='1'");
    $numr = $rs->num_rows;
    $rpx = $rs->fetch_assoc();
    header('Location: index.php?page=' . $rpx['id']);
}

if ($numr > 0) {

    $bid = $rpx['id'];
    $title = $rpx['title'];
    $plink = $rpx['link'];
    $keyword = $rpx['keyword'];
    $classification = $rpx['classification'];
    $description = $rpx['description'];
    $cont = $rpx['type'];
    $men = $rpx['menu'];
    $content = $rpx['content'];
    $style = $rpx['style'];
    $prnt = $rpx['parent'];
    $lng = $rpx['language'];

    $_SESSION["language"] = $lng;
    $language = $_SESSION["language"];
    ?>
    <!doctype html>
    <html lang="en">
        <head>
            <meta charset="utf-8"/>
            <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
            <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
            <?php if (empty($description)) { ?>
                <meta name="description" content="<?php echo $description; ?>" />
            <?php } if (empty($keyword)) { ?>
                <meta name="keywords" content="<?php echo $keyword; ?>" />
            <?php } if (empty($classification)) { ?>
                <meta name="classification" content="<?php echo $classification; ?>" />
            <?php } ?>
            <title><?php
            echo $title;
            ?></title>
            <link href="<?php echo $base; ?>plugins/bootstrap-4.5.2/css/bootstrap.min.css" rel="stylesheet" type="text/css" data-type="keditor-style"/>
            <link href="<?php echo $base; ?>plugins/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" data-type="keditor-style" />
            <style>
    <?php
    echo html_entity_decode($style);
    ?>
            </style>
        </head>
        <body>
            <?php
            require 'navbar.php';
            ?>
            <div class='container'>
                <?php
                echo html_entity_decode($content) . "\n";
                ?>
            </div>
            <script src="<?php echo $base; ?>plugins/jquery-3.5.1/jquery.min.js" type="text/javascript"></script>
            <script src="<?php echo $base; ?>plugins/bootstrap-4.5.2/js/bootstrap.min.js" type="text/javascript"></script>
            <script src="<?php echo $base; ?>plugins/popper/popper.min.js" type="text/javascript"></script> 
        </body>
    </html>
    <?php
}
?>

