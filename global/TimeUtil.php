<?php

function time_tran($the_time){
    $now_time = date("Y-m-d H:i:s",time());
    $now_time = strtotime($now_time);
    $show_time = strtotime($the_time);
    $dur = $now_time - $show_time;
    if ($dur < 0) {
        return $the_time;
    }
    else if ($dur < 60) {
        return $dur . "秒前";
    }
    else if ($dur < 3600) {
        return floor($dur / 60) . "分钟前";
    }
    else if ($dur < 86400) {
        return floor($dur / 3600) . "小时前";
    }
    else if ($dur < 2592000) {
        return floor($dur / 86400) . "天前";
    }
    else if ($dur < 31104000) {
        return floor($dur / 2592000) . "个月前";
    }
    else {
        return floor($dur / 31104000) . "年前";
    }
}