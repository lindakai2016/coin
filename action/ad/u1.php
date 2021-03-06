<?php
require_once("../../global/config.php");

//登录检查
session_start();
if(!isset($_SESSION["login"])){
    die_json(["msg"=>"用户未登录"]);
}
$vid=$_SESSION["login"]["id"];
$nick=$_SESSION["login"]["nick"];
//flag
if(!isset($_REQUEST["flag"])){
    die_json(["msg"=>"缺少参数"]);
}
$flag=$_REQUEST["flag"];
if($flag!="0"&&$flag!="1"){
    die_json(["msg"=>"请选择广告类型"]);
}
//coin
if(!isset($_REQUEST["coin"])){
    die_json(["msg"=>"缺少参数"]);
}
$coin=$_REQUEST["coin"];
if(!preg_match("/^[a-zA-Z]{2,15}$/",$coin)) {
    die_json(["msg" => "货币类型不正确"]);
}
//price
if(!isset($_REQUEST["price"])){
    die_json(["msg"=>"缺少参数"]);
}
$price=$_REQUEST["price"];
if(!is_numeric($price)||$price<=0){
    die_json(["msg"=>"价格不正确"]);
}
//minNum
if(!isset($_REQUEST["minNum"])){
    die_json(["msg"=>"缺少参数"]);
}
$minNum=$_REQUEST["minNum"];
if(!is_numeric($minNum)||$minNum<0){
    die_json(["msg"=>"最小交易量不正确"]);
}
//maxNum
if(!isset($_REQUEST["maxNum"])){
    die_json(["msg"=>"缺少参数"]);
}
$maxNum=$_REQUEST["maxNum"];
if(!is_numeric($maxNum)||$maxNum<$minNum||$maxNum<=0){
    die_json(["msg"=>"最大交易量不正确"]);
}
//method
if(!isset($_REQUEST["method"])){
    die_json(["msg"=>"缺少参数"]);
}
$method=$_REQUEST["method"];
if(!preg_match("/^\S+$/",$method) || mb_strlen($method)>15 || mb_strlen($method)<2) {
    die_json(["msg" => "交易方式不正确"]);
}
//remake
if(!isset($_REQUEST["remake"])){
    die_json(["msg"=>"缺少参数"]);
}
$remake=$_REQUEST["remake"];
if(mb_strlen($remake)>100){
    die_json(["msg"=>"备注不超过100个字符"]);
}

//检查是否实名认证，及手机验证
if(!$_SESSION["login"]["phone"]){
    die_json(["msg"=>"未验证手机"]);
}
if(!$_SESSION["login"]["fullname"]||!$_SESSION["login"]["idcard"]){
    die_json(["msg"=>"未完成实名认证"]);
}

//数据库操作
$conn = new mysqli($mysql["host"], $mysql["user"], $mysql["password"], $mysql["database"]);
$conn->set_charset("utf8");
//发布广告
$stmt=$conn->prepare("insert into ads(vid,nick,flag,coin,price,method,minNum,maxNum,remake,time) values(?,?,?,?,?,?,?,?,?,?)");
$time=(new DateTime())->format("Y-m-d H:i:s");
$stmt->bind_param("isisdsddss",$vid,$nick,$flag,$coin,$price,$method,$minNum,$maxNum,$remake,$time);
$stmt->execute();
$stmt->close();
//
die_json(["ok"=>"ok","data"=>""]);
