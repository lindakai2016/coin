<?php
require_once("../../global/config.php");

//登录检查
session_start();
if(!isset($_SESSION["login"])){
    die_json(["msg"=>"用户未登录"]);
}
$vid=$_SESSION["login"]["id"];
//ac_pass1
if(!isset($_REQUEST["ac_pass1"])){
    die_json(["msg"=>"缺少参数"]);
}
$ac_pass1=$_REQUEST["ac_pass1"];
//ac_pass2
if(!isset($_REQUEST["ac_pass2"])){
    die_json(["msg"=>"缺少参数"]);
}
$ac_pass2=$_REQUEST["ac_pass2"];
if(!preg_match("/^[0-9a-zA-Z._-]{6,15}$/",$ac_pass2)){
    die_json(["msg"=>"密码不符合规则"]);
}
//密码是否正确
if($ac_pass1!=$_SESSION["login"]["ac_pass"]){
    die_json(["msg"=>"密码不正确"]);
}
//
$conn = new mysqli($mysql["host"], $mysql["user"], $mysql["password"], $mysql["database"]);
$conn->set_charset("utf8");
//更新实名信息
$stmt=$conn->prepare("update user_infos set ac_pass=? where vid=?");
$stmt->bind_param("si",$ac_pass2,$vid);
$stmt->execute();
$stmt->close();
//更新session
$_SESSION["login"]["ac_pass"]=$ac_pass2;
//结束
die_json(["ok"=>"ok","data"=>""]);
