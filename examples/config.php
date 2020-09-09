<?php
$file = 'conn.php';
$nclose = '';

$url = $_SERVER['REQUEST_URI']; //returns the current URL
$parts = explode('/', $url);
$folder = $_SERVER['HTTP_HOST'];
for ($i = 0; $i < count($parts) - 1; $i++) {
    $folder .= $parts[$i] . "/";
}

//$folder = basename(dirname(__FILE__));
if (isset($_POST['submit'])) {

    $handle = fopen($file, 'w') or die('Cannot open file:  ' . $file);
    $actual = file_get_contents($file);

    $db_host = $_POST['host'];
    $db_user = $_POST['user'];
    $db_password = $_POST['password'];
    $db_name = $_POST['dbname'];
    $createdb = $_POST['cdbn'];
    if ($createdb === 'yes') {

        $mkdb = new mysqli($db_host, $db_user, $db_password);
        // Check connection
        if ($mkdb->connect_error) {
            die("Connection failed: " . $mkdb->connect_error);
        }

        // Create database
        $sql = "CREATE DATABASE " . $db_name;
        if ($mkdb->query($sql) === TRUE) {
            echo "Database created successfully";
        } else {
            echo "Error creating database: " . $mkdb->error;
        }

        $mkdb->close();
        // Name of the file
        $filename = 'sql/sql.sql';
        $mktbs = new mysqli($db_host, $db_user, $db_password, $db_name);

        // Check connection
        if ($mktbs->connect_errno) {
            echo "Failed to connect to MySQL: " . $mktbs->connect_errno;
            echo "<br/>Error: " . $mktbs->connect_error;
        }

        // Temporary variable, used to store current query
        $templine = '';
        // Read in entire file
        $lines = file($filename);
        // Loop through each line
        foreach ($lines as $line) {
            // Skip it if it's a comment
            if (substr($line, 0, 2) == '--' || $line == '') {
                continue;
            }
            // Add this line to the current segment
            $templine .= $line;
            // If it has a semicolon at the end, it's the end of the query
            if (substr(trim($line), -1, 1) == ';') {
                // Perform the query
                $mktbs->query($templine) or print('Error performing query \'<strong>' . $templine . '\': ' . $mktbs->error() . '<br /><br />');
                // Reset temp variable to empty
                $templine = '';
            }
        }
        echo "Tables imported successfully";
        $mktbs->close();
    }
    $filecontent = '';
    $filecontent .= '<?php' . "\n\n";
    $filecontent .= "define('DBHOST', '" . $db_host . "');" . "\n";
    $filecontent .= "define('DBUSER', '" . $db_user . "');" . "\n";
    $filecontent .= "define('DBPASS', '" . $db_password . "');" . "\n";
    $filecontent .= "define('DBNAME', '" . $db_name . "');" . "\n";
    $filecontent .= '$conn = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);' . "\n";
    $filecontent .= "
    /* If connection fails for some reason */
    if (\$conn->connect_error) {
        die('Error, Database connection failed: (' . \$conn->connect_errno . ') ' . \$conn->connect_error);
    }" . "\n";
    if (!empty($folder)) {
        $filecontent .= "\$base = 'http://'" . $folder . "';" . "\n";
    } else {
        $filecontent .= "\$base = 'http://'.\$_SERVER['HTTP_HOST'].'/" . "\n";
    }

    $filecontent .= "
    ?>
    ";
    file_put_contents($file, $filecontent);
    header('Location: index.php?view=select');
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />      
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
        <title>PHP Keditor</title>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-12 py-4"><h2>PHP Keditor</h2>
                    <p>The simple and practical tool to build your website.
                        Create, update and delete without the need to create forms.</p>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-12 py-4">
                    <div id="resp"></div>
                    <?php
                    if (file_exists($file)) {
                        ?>
                        <div class="modal fade in" id="myModal">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header" >
                                        <h5 class="modal-title">File already exists</h5> <button type="button" class="close" data-dismiss="modal"> <span>×</span> </button>
                                    </div>
                                    <div class="modal-body">
                                        <p>The configuration file already exists.</p>
                                        <button class="btn btn-primary" name="edit" id="edit">Edit DB config file</button>
                                        <button class="btn btn-secondary" name="check" id="check">Check DB connection</button> 
                                        <button class="btn btn-info" name="install" id="install">Install tables</button>
                                    </div>
                                    <div class="modal-footer"> <a href="index.php?view=select" class="btn btn-primary" name="edit" id="edit">Go to page list</a> <button type="button" name="close" id="close" class="btn btn-secondary" data-dismiss="modal">Close</button> </div>
                                </div>
                            </div>
                        </div>
                    <?php } else {
                        ?>     
                        <form method="post">
                            <div class="form-group row">
                                <div class="col-8">
                                    <h2> Save your setting for DB</h2>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="host" class="col-4 col-form-label">Database Host</label> 
                                <div class="col-8">
                                    <input id="host" name="host" type="text" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="user" class="col-4 col-form-label">Database Username</label> 
                                <div class="col-8">
                                    <input id="user" name="user" type="text" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="password" class="col-4 col-form-label">Database Password</label> 
                                <div class="col-8">
                                    <input id="password" name="password" type="text" class="form-control">
                                </div>
                            </div> 
                            <div class="form-group row">
                                <label for="dbname" class="col-4 col-form-label">Database Name</label> 
                                <div class="col-8">
                                    <input id="dbname" name="dbname" type="text" class="form-control">
                                </div>
                            </div>
                            <hr>
                            <h5>This option creates the database with the tables</h5>
                            <div class="form-group row">
                                <label for="dbname" class="col-4 col-form-label">You have a database or do you need create one</label> 
                                <div class="col-8">
                                    <input id="cdbn" name="cdbn" type="checkbox" value="yes" class="form-control mx-2">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="offset-4 col-8">
                                    <button name="submit" type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </form>
                    <?php } ?>
                </div>
            </div>
        </div>


        <script type="text/javascript">
            $(window).on('load', function () {
                $('#myModal').modal('show');
            });
            $('#edit').click(function () {
                $('#myModal').modal('toggle');
                var edit = 1;
                $.ajax({
                    type: 'POST',
                    url: 'editconf.php',
                    data: {edit: edit}
                }).done(function (rsp) {
                    $('#resp').html(rsp);
                });
            });
            $('#check').click(function () {
                $('#myModal').modal('toggle');
                var check = 1;
                $.ajax({
                    type: 'POST',
                    url: 'checkconf.php',
                    data: {check: check}
                }).done(function (rsp) {
                    $('#resp').html(rsp);
                });
            });
            $('#install').click(function () {
                var install = 1;
                $.ajax({
                    type: 'POST',
                    url: 'installtables.php',
                    data: {install: install}
                }).done(function (rsp) {
                    $('#resp').html(rsp);
                });
            });
        </script>
    </body>
</html>