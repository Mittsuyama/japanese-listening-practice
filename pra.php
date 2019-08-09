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
        <link rel = "stylesheet" href = "css/pra.css" />
    </head>
    <body>
        <?php
            include "php/res_to_html.php";
            const RATE = "0.5";
            $q_id = getTransfer(htmlspecialchars($_GET["id"]));
            $q_page = getTransfer(htmlspecialchars($_GET["page"]));
            $path = "res";
            $file_dir = opendir($path);
            $dirs = array();
            while(($dir = readdir($file_dir)) !== false) {
                if(file_exists(getFileDir($path, $dir))) {
                    array_push($dirs, $dir);
                }
            }
            sort($dirs);
            $cons = getTexts($path, $dirs[$q_id]);
        ?>
        <div class = "main-container">
            <?php
                if($q_page >= count($cons)) {
                    echo "已经全部完成，";
                    echo '<a href = "index.php">点击回到目录</a>';
                }
                else {
                    echo '<div class = "finish-box">完成: ' . $q_page . ' / ' . count($cons) . '：</div>';
                    echo '<audio src = "' . getMusicDir($path, $dirs[$q_id], $q_page) . '" id = "bgaudio" hidden = "true"></audio>';
                    resToHtml($cons[$q_page], RATE);
                    echo '<div class = "info">下一个空：正确后空格　|　下一句：全部正确后回车　|　再放一遍听力：数字 0　|　获取提示：鼠标悬停</div>';
                }
            ?>
        </div>
    </bdoy>
    <script src="js/jquery-3.4.1.min.js"></script>
    <script src = "js/pra.js"></script>
</html>