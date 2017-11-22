<?php
    require_once("../../../../global/config.php");
    require_once("../../../../global/TimeUtil.php");
    include("../../../../global/checkLogin.php");

    $vid=$_SESSION["login"]["id"];
    //数据库操作
    $conn = new mysqli($mysql["host"], $mysql["user"], $mysql["password"], $mysql["database"]);
    $conn->set_charset("utf8");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>我的账户-淘币客</title>
    <link href="/web/layout/img/logo.png" rel="icon" type="image/x-icon" />
    <link rel="stylesheet" type="text/css" href="/web/layout/css/layout.css">
    <link rel="stylesheet" type="text/css" href="/web/userhome/left/css/left.css">
    <link rel="stylesheet" type="text/css" href="/web/userhome/iframe/account/css/account.css">
</head>
<body>
<?php include("../../../layout/top.php") ?>
<div class="layout">
    <div class="main">
        <?php include("../../left/left.php") ?>
        <div class="right">
            <div class="h3">账户信息</div>
            <div class="s1">
                <table>
                    <colgroup>
                        <col style="width:100px">
                        <col style="width:300px">
                        <col style="width:100px">
                        <col style="width:100px">
                        <col style="width:100px">
                        <col style="width:140px">
                    </colgroup>
                    <thead>
                        <tr><th>虚拟货币</th><th>钱包地址</th><th>数量</th><th>锁定</th><th>可用</th><th></th></tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><div class="img-g"><img src="/web/userhome/iframe/account/img/btc.png">BTC</div></td>
                            <td>1HKdWCuKn9YPGXZFKevTTHojUFx8ztct5d</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>
                                <a href="/web/userhome/iframe/account/btc_in.php">转入</a>
                                <a href="/web/userhome/iframe/account/btc_out.php">转出</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php include("../../../layout/footer.php") ?>
</div>
<script>left.activeItem("account");</script>
</body>
</html>