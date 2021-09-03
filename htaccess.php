<?php
$file = '.htaccess';

if (isset($_POST['submit'])) {
    $ppath = $_POST['ppath'];
    $uripath = $_POST['uripath'];
    if ($ppath === 'yes') {
        if (!empty($uripath)) {
            $upath = "RewriteCond %{REQUEST_URI} !/" . $uripath . "/.* [NC]" . "\n";
        } else {
            $upath = "";
            $alert = '<div class="alert alert-danger" role="alert">
            The field is empty, it is necessary to put a folder name
            </div>';
        }
    }
    $filecontent = "<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteBase /

    RewriteCond %{REQUEST_FILENAME} !-f    
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule (.*) index.php?/$1 [QSA,L]   

    RewriteCond %{THE_REQUEST} ^GET.*index\.php [NC]" . "\n";
    $filecontent .= $upath . "\n";
    $filecontent .= "RewriteRule (.*?)index\.php/*(.*) /$1$2 [R=301,NE,L]
          
</IfModule>";
    file_put_contents($file, $filecontent);
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
                <div class="col-md-12 py-4">
                    <div id="resp"></div>

                    <form method="post">
                        <div class="form-group row">
                            <div class="col-8">
                                <h3>Creates your beauty url with .htaccess</h3>
                            </div>
                        </div>
                        <h5>This option creates the database with the tables</h5>
                        <div class="form-group row">
                            <label for="ppath" class="col-4 col-form-label">You want to create a path for your folder on your system</label> 
                            <div class="col-8">
                                <input id="ppath" name="ppath" type="checkbox" value="yes" class="form-control mx-2">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="uripath" class="col-4 col-form-label">Uri Path</label> 
                            <div class="col-8">
                                <input id="uripath" name="uripath" type="text" class="form-control">
                            </div>
                        </div>
                        <?php
                        if (isset($alert)) {
                            echo $alert;
                        }
                        ?>
                        <div class="form-group row">
                            <div class="offset-4 col-8">
                                <button name="submit" type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </body>
</html>