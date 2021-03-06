var u1={};
u1.inputs={
    coin:$("#coin"),
    price:$("#price"),
    num:$("#num"),
    pay_method:$("#pay_method"),
    remake:$("#remake"),
    ac_pass:$("#ac_pass"),
    notice:$("#notice"),
    submitBtn:$("#submit")
};
u1.widges={
    cur_price:$("#wd-15m-price"),
    sell_price:$("#wd-sell-price"),
    buy_price:$("#wd-buy-price"),
    coin:$("#wd-coin"),
    num:$("#wd-num"),
    lockNum:$("#wd-lockNum"),
    availNum:$("#wd-availNum")
};
u1.log=function(msg){
    alert(msg);
};
u1.init=function(){
    var _this=this;
    //opt
    $(".opt-btn").click(function(){
        $(this).find(".select").toggle();
        return false;
    });
    $(".option").hover(function(){
        $(this).parent().find(".option").removeClass("hover");
        $(this).addClass("hover");
    }).click(function(){
        var val=$(this).text();
        $(this).parents(".opt-btn").prev("input").val(val);
    });
    $(document).click(function(){
        $(".select").hide();
    });
    _this.drawWidgesBtc();
    //
    _this.inputs.submitBtn.click(function(){
        _this.sendBtc();
    });
};
u1.buffer={
    btc:{num:0,lockNum:0,availNum:0,flag1:0,price:0,buyPrice:0,sellPrice:0,flag2:0}
};
u1.drawWidgesBtc=function(){
    var _this=this;
    if(_this.buffer.btc.flag2){
        _this.widges.cur_price.text(_this.buffer.btc.price);
        _this.widges.sell_price.text(_this.buffer.btc.sellPrice);
        _this.widges.buy_price.text(_this.buffer.btc.buyPrice);
    }else{
        ajaxForm.action(null,{
            type:"get",
            url:"/action/account/btc/ticker.php",
            success:function(data){
                if(data.ok){
                    data=data.data;
                    _this.buffer.btc.flag2=1;
                    _this.buffer.btc.price=data["CNY"]["15m"];
                    _this.buffer.btc.sellPrice=data["CNY"]["sell"];
                    _this.buffer.btc.buyPrice=data["CNY"]["buy"];
                    _this.widges.cur_price.text(_this.buffer.btc.price);
                    _this.widges.sell_price.text(_this.buffer.btc.sellPrice);
                    _this.widges.buy_price.text(_this.buffer.btc.buyPrice);
                }
            }
        });
    }
    if(_this.buffer.btc.flag1){
        _this.widges.num.text(_this.buffer.btc.num);
        _this.widges.lockNum.text(_this.buffer.btc.lockNum);
        _this.widges.availNum.text(_this.buffer.btc.availNum);
        _this.inputs.num.val(_this.buffer.btc.availNum);
    }else{
        ajaxForm.action(null,{
            type:"get",
            url:"/action/account/btc/check.php",
            success:function(data){
                if(data.ok){
                    _this.buffer.btc.flag1=1;
                    _this.buffer.btc.num=data.data["btcNum"];
                    _this.buffer.btc.lockNum=data.data["btcLock"];
                    _this.buffer.btc.availNum=data.data["btcNum"]-data.data["btcLock"];
                    _this.widges.num.text(_this.buffer.btc.num);
                    _this.widges.lockNum.text(_this.buffer.btc.lockNum);
                    _this.widges.availNum.text(_this.buffer.btc.availNum);
                    _this.inputs.num.val(_this.buffer.btc.availNum);
                }
            }
        });
    }
};
u1.sendBtc=function(){
    var _this=this;
    var coin=_this.inputs.coin.val();
    var price=parseFloat(_this.inputs.price.val());
    var pay_method=_this.inputs.pay_method.val();
    var num=parseFloat(_this.inputs.num.val());
    var remake=_this.inputs.remake.val();
    var ac_pass=md5(_this.inputs.ac_pass.val());
    var notice=_this.inputs.notice.is(":checked")?1:0;
    if(coin!="BTC"){
        _this.log("不支持此货币");
        return;
    }
    if(isNaN(price)||price<=0){
        _this.log("价格不正确");
        return;
    }
    if(isNaN(num)||num<=0){
        _this.log("数量不正确");
        return;
    }
    if(num>_this.buffer.btc.availNum){
        _this.log("您的可用货币数量不足");
        return;
    }
    if(!/^\S{2,15}$/.test(pay_method)){
        _this.log("付款方式不正确");
        return;
    }
    if(remake.length>100){
        _this.log("备注不超过100个字符");
        return;
    }
    ajaxForm.action(_this.inputs.submitBtn,{
        type:"post",
        url:"/action/sell/u1_btc.php",
        data:{coin:coin,price:price,num:num,pay_method:pay_method,remake:remake,ac_pass:ac_pass,notice:notice},
        success:function(data){
            if(data.ok){
                location.href="/web/userhome/iframe/sell/sell.php";
            }else if(data.msg){
                _this.log(data.msg);
            }
        }
    });
};
u1.init();