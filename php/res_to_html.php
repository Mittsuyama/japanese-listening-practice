<?php
function getTransfer($str) {
    if($str == null) return 0;
    return (int)$str;
}

function getTexts($path, $str) {
    $file = fopen(getFileDir($path, $str), "r");
    $texts = array();
    while(!feof($file)) {
        $get_str = fgets($file);
        if(strlen($get_str) < 1) continue;
        array_push($texts, $get_str);
    }
    fclose($file);
    return $texts;
} 

function getContFromPreg($str, $form) {
    $temp = array();
    if($form == "surface")
        preg_match("/\(.*\)/", $str, $temp);
    else
        preg_match("/\[.*\]/", $str, $temp);
    return substr($temp[0], 1, -1);
}

function strHas($str, $modle) {
    if(strstr($str, $modle) !== false) return true;
    return false;
}

function isIgnore($str) {
    if(strHas($str, "記号")) return true;
    if(strHas($str, "助詞")) return true;
    if(strHas($str, "BOS/EOS")) return true;
    return false;
}

function resToHtml($str, $rate) {
    preg_match_all("/{[^}]+]}/", $str, $words);
    $ignoreNum = 0;
    $count = count($words[0]);
    foreach($words[0] as $word) {
        // print_r(getContFromPreg($word, "feature") . "<br>");
        if(isIgnore(getContFromPreg($word, "feature"))) $ignoreNum++;
    }
    $MAXRAND = 1000;
    $rate = (int)((1.0 - (float)$rate) * $MAXRAND);
    foreach($words[0] as $word) {
        $rand_num = rand(0, $MAXRAND);
        $con = getContFromPreg($word, "surface");
        if(strHas(getContFromPreg($word, "feature"), "BOS/EOS") === true) continue;
        if($rand_num > $rate && isIgnore(getContFromPreg($word, "feature")) === false) {
            echo '<span class = "blank-box"><input class = "blank" cor = "' . $con . '"></span>';
        }
        else {
            echo '<span class = "not-blank">' . $con . '</span>';
        }
    }
}

function getFileDir($path, $str) {
    return $path . "/" . $str . "/res.txt";
}

function getMusicDir($path, $str, $order) {
    return $path . "/" . $str . "/" . $order . ".mp3";
}