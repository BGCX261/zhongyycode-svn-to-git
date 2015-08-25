/**
 * 网站首页脚本
 */
$.fn.slider = function() {
    var stop = false;
    var slider = $(this);
    var img = slider.find('.slide-list > li');
    var trigger = slider.find('.slide-trigger > li');
    var count = img.length; //图片数目
    if (count <= 1) { //只有一个不轮播
        return;
    }

    //绑定事件
    $(this).hover(function(){stop = true;}, function(){stop = false;});
    trigger.mouseover(function() {
        if (!$(this).is('.current')) {
            $(slider).find('.slide-trigger > li.current').removeClass('current');
            $(this).addClass('current');
            $(slider).find('.slide-list > li.current').removeClass('current').hide();
            img.eq(trigger.index(this)).addClass('current').show();
        }
    });

    //轮播
    function slide() {
        if (stop) { return; }

        var fEle = img.eq(0); //第一项
        var sEle = $(slider).find('.slide-list > li.current'); //当前选项
        if (sEle.length == 0) { sEle = fEle; }
        sEle.removeClass('current').hide();
        var nEle = sEle.next(); //下一个选项
        if (nEle.length == 0) { nEle = fEle; }
        nEle.addClass('current').show();

        $(slider).find('.slide-trigger > li.current').removeClass('current');
        trigger.eq(img.index(nEle)).addClass('current');
    }


    setInterval(slide, 10000);
};
$(document).ready(function() {
    $('.slide').slider();
    $('#userlogin').submit(function(){
        var username = $('input[name=username]').val();
        if (username == '' || username == '请输入用户名') {
            alert('请输入用户名');
            return false;
        }
        var password = $('input[name=password]').val();
        if (password == '' || password == '请输入密码') {
            alert('请输入密码');
            return false;
        }
    });
});