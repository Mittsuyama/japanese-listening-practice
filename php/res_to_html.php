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
    // print_r($str . "<br>");
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

function isIgnore($word) {
    $str = getContFromPreg($word, "feature");
    if(strHas($str, "記号")) return true;
    if(strHas($str, "助詞")) return true;
    if(strHas($str, "BOS/EOS")) return true;
    return false;
}

function isAxVerb($word) {
    $str = getContFromPreg($word, "feature");
    if(strHas($str, "助動詞")) return true;
    if(strHas($str, "接尾")) return true;
    if(strHas($str, "接続助詞")) return true;
    if(strHas($str, "非自立") && strHas($str, "動詞")) return true;
    return false;
}

function resToHtml($str, $rate) {
    preg_match_all("/{[^}]+]}/", $str, $words);
    $ignoreNum = 0;
    $count = count($words[0]);
    foreach($words[0] as $word) {
        if(isIgnore($word)) $ignoreNum++;
    }
    $MAXRAND = 1000;
    $rate = (int)((1.0 - (float)$rate) * $MAXRAND);
    $word_count = count($words[0]);
    for($i = 0; $i < $word_count; $i++) {
        $word = $words[0][$i];

        # 助动词跳过
        if(isAxVerb($word)) continue;
        # 把动词后面所有的助动词全部接在后面
        $con = getContFromPreg($word, "surface");
        $pos = $i + 1;
        while($pos < $word_count && isAxVerb($words[0][$pos])) {
            $con .= getContFromPreg($words[0][$pos], "surface");
            $pos++;
        }
        if(strHas(getContFromPreg($word, "feature"), "BOS/EOS") === true) continue;
        # 随机是否变成空白
        $rand_num = rand(0, $MAXRAND);
        if($rand_num > $rate && isIgnore($word) === false) {
            echo '<span class = "blank-box"><input class = "blank" title = "' . $con . '"></span>';
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