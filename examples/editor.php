<?php
    $content = '';
    $title = '';
    if (isset($_GET['id'])) {
        $id = $_GET["id"];
        $sql = "SELECT * FROM page WHERE id='$id'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $title = $row['title'];
        $content = html_entity_decode($row['content']);
    }  else {
        header('Location: ' . $system);
        exit();
    }
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Content Editor</title>
<link rel="stylesheet" type="text/css"
	href="../css/theme.css"
	data-type="keditor-style" />
<link rel="stylesheet" type="text/css"
	href="plugins/font-awesome-4.7.0/css/font-awesome.min.css"
	data-type="keditor-style" />
<!-- Start of KEditor styles -->
<link rel="stylesheet" type="text/css" href="css/keditor.css"
	data-type="keditor-style" />
<link rel="stylesheet" type="text/css" href="css/keditor-components.css"
	data-type="keditor-style" />
<!-- End of KEditor styles -->
<link rel="stylesheet" type="text/css"
	href="plugins/code-prettify/src/prettify.css" />
<link rel="stylesheet" type="text/css" href="css/examples.css" />
<script type="text/javascript"
	src="plugins/jquery-1.11.3/jquery-1.11.3.min.js"></script>
<script type="text/javascript"
	src="plugins/bootstrap-3.4.1/js/bootstrap.min.js"></script>
<script type="text/javascript">
            var bsToolip = $.fn.tooltip;
            var bsButton = $.fn.button;
        </script>
<script type="text/javascript"
	src="plugins/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
<script type="text/javascript">
            $.widget.bridge('uitooltip', $.ui.tooltip);
            $.widget.bridge('uibutton', $.ui.button);
            $.fn.tooltip = bsToolip;
            $.fn.button = bsButton;
        </script>
<script type="text/javascript" src="plugins/ckeditor-4.11.4/ckeditor.js"></script>
<script type="text/javascript"
	src="plugins/formBuilder-2.5.3/form-builder.min.js"></script>
<script type="text/javascript"
	src="plugins/formBuilder-2.5.3/form-render.min.js"></script>
<script type="text/javascript"
	src="plugins/code-prettify/src/prettify.js"></script>
<script type="text/javascript"
	src="plugins/js-beautify-1.7.5/js/lib/beautify.js"></script>
<script type="text/javascript"
	src="plugins/js-beautify-1.7.5/js/lib/beautify-html.js"></script>
<script type="text/javascript" src="js/examples.js"></script>
<!-- Start of KEditor scripts -->
<script type="text/javascript" src="js/keditor.js"></script>
<script type="text/javascript" src="js/keditor-components.js"></script>
<!-- End of KEditor scripts -->
<script type="text/javascript"
	src="plugins/jquery.nicescroll-3.7.6/jquery.nicescroll.js"></script>
<script type="text/javascript">
            $(document).ready(function () {
                $(".toolbar").prepend('<a type="button" title="Clear" id="clear" name="clear" class="clear-content"><i class="fa fa-trash-o" aria-hidden="true"></i> Clear</a>');
                $(".toolbar").prepend('<a type="button" title="Save" id="save" name="save" class="save-content"><i class="fa fa-fw fa-save"></i> Save</a>');

                //$('<a type="button" title="Clear" id="clear" name="clear" class="clear-content"><i class="fa fa-trash-o" aria-hidden="true"></i> Clear</a>').appendTo(".toolbar");

            /* Save content DIV */

                $('#save').click(function () {
                    // Get edit field value
                	$.urlParam = function(name){
            		    var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
            		    return results[1] || 0;
            		}
                    var id = $.urlParam('id');
                    var content = $('#content-area').keditor('getContent');
                    $.ajax({
                        url: 'savecontent.php',
                        type: 'post',
                        data: {id: id, content: content},
                        datatype: 'html',
                        success: function (rsp) {
                            alert(rsp);
                        }
                    });
                });
                $('#clear').click(function () {
                    var clear = 'clear';
                    $.ajax({
                        url: 'clearcontent.php',
                        type: 'post',
                        data: {clear: clear},
                        datatype: 'html',
                        success: function (rsp) {
                            $('#result').php(rsp);
                        }
                    });
                });
                //$('#menu').load("menu_list.php");
            });

            $(function () {

                $("body").niceScroll();
            });

        </script>
</head>
<body>

	<div data-keditor="html">
		<div id="content-area">
                <?php
    echo $content;
    ?>
            </div>
	</div>
	<div id="result"></div>
	<script type="text/javascript" data-keditor="script">
            $(function () {
                $('#content-area').keditor({
                    extraTopbarItems: {
                        pageSetting: {
                            html: '<a href="editor.php" class="btn-back-setting" data-extra-setting="backSetting"><i class="fa fa-tachometer" aria-hidden="true"></i></a><a href="javascript:void(0);" class="btn-page-setting" data-extra-setting="pageSetting"><i class="fa fa-fw fa-cog"></i></a>'
                        }
                    },
                    extraSettings: {
                        pageSetting: {
                            title: 'Page Settings',
                            trigger: '.btn-page-setting',
                            settingInitFunction: function (form, keditor) {
                                form.append('<div><label>Page title: </lavel> <input type="text" id="title" value="<?php echo $title; ?>"></div><hr /><div id="menu"></div>');
                            },
                            settingShowFunction: function (form, container, keditor) {
                                form.append('<p><a href="javascript:void(0);">This content is added when showing setting</a></p><br />');
                            }
                        }
                    },
                    onSave: function onSave(content) {

                        $.ajax({
                            type: 'post',
                            data: {action: "send-content",
                                content: $('#content-area').keditor('getContent')
                            },
                            success: function (data) {
                                console.log(data);
                            },
                            error: function (data) {
                                console.log(data);
                            }
                        });
                        console.log($('#content-area').keditor('getContent'));
                    },
                });
            });
        </script>

</body>
</html>
