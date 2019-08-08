<!DOCTYPE HTML>
<html lang = "zh-CN">
    <head>
        <meta charset = "utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <meta name = "keyword" content = "mitsuyama,日语,Japanese,listening,听力" />
        <meta name = "description" content = "Mitsuyama的日语听力练习" />
        <title>MITSUYAMA | Listening</title>
        <link rel = "icon" type = "image/x-icon" href = "icon/favicon.ico" />
        <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
        <link rel = "stylesheet" href = "css/index.css" />
    </head>
    <body>
        <?php
            const RATE = "0.2";
            include "php/res_to_html.php";
            $path = "res";
            $file_dir = opendir($path);
            $dirs = array();
            while(($dir = readdir($file_dir)) !== false) {
                if(file_exists(getFileDir($path, $dir))) {
                    array_push($dirs, $dir);
                }
            }
            sort($dirs);
            // print_r($dirs);
        ?>
        <div class = "container">
            <?php
                echo '<div class = "con-title">目录:</div>';
                echo '<ul>';
                $count = count($dirs);
                for($i = 0; $i < $count; $i++) {
                    echo '<li><a = href = "pra.php?id=' . $i . '&page=0" class = "selink">' . $dirs[$i] . '</a></li>';
                }
                echo '</ul>';
            ?>
        </div>
    </bdoy>
</html>