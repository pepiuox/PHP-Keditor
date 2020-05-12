<?php
require 'conn.php';
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
        <title>Content Editor</title>
        <link href="plugins/bootstrap-4.4.1/css/bootstrap.min.css" rel="stylesheet" type="text/css" data-type="keditor-style"/>
        <link rel="stylesheet" type="text/css" href="./plugins/font-awesome-4.7.0/css/font-awesome.min.css" data-type="keditor-style" />
    </head>
    <body>
        <?php
        //require 'navbar.php';
        ?>
        <div class='container'>
            <table class="table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Link</th>
                        <th>Parent</th>
                        <th>Active</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    function pparent($parent) {
                        global $conn;
                        $result = $conn->query("SELECT * FROM page");
                        echo '<select name="parent" id="parent">' . "\n";
                        echo '<option>Select a parent</option>' . "\n";
                        while ($row = $result->fetch_array()) {
                            $select = $parent == $row['id'] ? ' selected' : null;
                            echo '<option value="' . $row['id'] . '"' . $select . '>' . $row['title'] . '</option>' . "\n";
                        }
                        echo '</select>' . "\n";
                    }

                    function action($selected) {
                        $acti = array([0, 'NO'], [1, 'YES']);
                        foreach ($acti as list($key, $val)) {
                            $select = $selected == $key ? ' selected' : null;
                            echo '<option value="' . $key . '"' . $select . '>' . $val . '</option>' . "\n";
                        }
                    }

                    $result = $conn->query("SELECT * FROM page");
                    while ($row = $result->fetch_array()) {
                        echo '<tr><td>';
                        echo $row['title'];
                        echo '</td><td>' . "\n";
                        echo $row['link'];
                        echo '</td><td>' . "\n";
                        pparent($row['parent']);
                        echo '</td><td>' . "\n";
                        echo '<select name="active" id="active">' . "\n";
                        action($row['active']);
                        echo '</select>' . "\n";
                        echo '</td><td>' . "\n";
                        echo '<a href="builder.php?id=' . $row['id'] . '"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
                        echo '</td><td>' . "\n";
                        echo '<a href="list.php?id=' . $row['id'] . '"><i class="fa fa-trash-o" aria-hidden="true"></i></a>';
                        echo '</td></tr>';
                    }
                    ?>
                </tbody>
            </table>


        </div>
        <script src="plugins/jquery-3.5.1/jquery-3.5.1.min.js" type="text/javascript"></script>
        <script src="plugins/bootstrap-4.4.1/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="plugins/popper/popper.min.js" type="text/javascript"></script>
    </body>
</html>
