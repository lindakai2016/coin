<script> if(!isLogin) location.href="/web/login/signin.php"; </script>
<?php if(!$isLogin) die("用户未登录"); ?>
<div class="left">
    <div class="ul">
        <a href="/web/userhome/iframe/usered/usered.php" ><i class="icon usered"></i>个人中心</a>
        <a href="/web/userhome/iframe/account/account.php"><i class="icon account"></i>我的账户</a>
        <a href="/web/userhome/iframe/tx/tx.php"><i class="icon tx"></i>我的交易</a>
        <a href="/web/userhome/iframe/sell/sell.php" ><i class="icon sell"></i>我的卖单</a>
        <a href="/web/userhome/iframe/ad/ad.php" ><i class="icon ad"></i>我的广告</a>
        <a href="/web/userhome/iframe/msg/msg.php" ><i class="icon msg"></i>消息<label id="left_msgL"></label></a>
    </div>
</div>
<script> var login=<?php echo json_encode($_SESSION["login"]) ?>;</script>
<script src="/web/userhome/left/js/left.js"></script>
