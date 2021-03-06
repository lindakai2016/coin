<?php
require_once("../../../global/config.php");
require_once("../../../global/wallet/btc.php");

//登录检查
session_start();
if(!isset($_SESSION["login"])){
    die_json(["msg"=>"用户未登录"]);
}
$vid=$_SESSION["login"]["id"];
//
//check
if(!isset($_REQUEST["check"])){
    die_json(["msg"=>"缺少参数"]);
}
$check=$_REQUEST["check"];
if(!isset($_SESSION["checkPhone_account"])||$check!=$_SESSION["checkPhone_account"]){
    die_json(["msg"=>"手机验证码不正确"]);
}
//addr
if(!isset($_REQUEST["addr"])){
    die_json(["msg"=>"缺少参数"]);
}
$addr=$_REQUEST["addr"];
if(!preg_match("/\S+/",$addr)){
    die_json(["msg"=>"转出地址不正确"]);
}
//num
if(!isset($_REQUEST["num"])){
    die_json(["msg"=>"缺少参数"]);
}
$num=$_REQUEST["num"];
if(!is_numeric($num)||$num<=0){
    die_json(["msg"=>"转出数量不正确"]);
}
//fee
if(!isset($_REQUEST["fee"])){
    die_json(["msg"=>"缺少参数"]);
}
$fee=$_REQUEST["fee"];
if(!is_numeric($fee)||$fee<=0){
    die_json(["msg"=>"交易手续费不正确"]);
}
//ac_pass
if(!isset($_REQUEST["ac_pass"])){
    die_json(["msg"=>"缺少参数"]);
}
$ac_pass=$_REQUEST["ac_pass"];

//检查是否实名认证，及手机验证
if(!$_SESSION["login"]["phone"]){
    die_json(["msg"=>"手机未验证"]);
}
if(!$_SESSION["login"]["idcard"]||!$_SESSION["login"]["fullname"]){
    die_json(["msg"=>"未实名认证"]);
}
if(!$_SESSION["login"]["ac_pass"]){
    die_json(["msg"=>"未设置交易密码"]);
}

//资金密码是否正确
if($ac_pass!=md5($_SESSION["login"]["ac_pass"])){
    die_json(["msg"=>"资金密码不正确"]);
}

//数据库操作
$conn = new mysqli($mysql["host"], $mysql["user"], $mysql["password"], $mysql["database"]);
$conn->set_charset("utf8");
//查询账户
$stmt=$conn->prepare("select btcNum,btcLock from user_wallets_btc where vid=?");
$stmt->bind_param("i",$vid);
$stmt->execute();
$result=$stmt->get_result();
$wallet=$result->fetch_all(MYSQLI_ASSOC)[0];
$stmt->close();
//核对账户
$btcNum=$wallet["btcNum"];
$btcLock=$wallet["btcLock"];
if($btcLock<0||$btcLock>$btcNum){
    die_json(["msg"=>"账户异常"]);
}
if($num>$btcNum-$btcLock){
    die_json(["msg"=>"您的可用余额不足"]);
}
//转出

die_json(["ok"=>"ok","data"=>""]);
