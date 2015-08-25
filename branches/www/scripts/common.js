/**
 * 站点通用脚本
 *
 * @author     zhongyy <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2010
 */

/**
 * 格式化数字字符，保留小数位
 */
String.prototype.numberFormat = function(decimals){
    if (isNaN(this)) { return 0; };
    if (this == '') { return 0; };
    var sec = this.split('.');
    var whole = parseFloat(sec[0]);
    var result = '';
    if (sec.length > 1) {
        var dec = new String(sec[1]);
        dec = String(parseFloat(sec[1]) / Math.pow(10, (dec.length - decimals)));
        dec = String(whole + Math.round(parseFloat(dec)) / Math.pow(10, decimals));
        var dot = dec.indexOf('.');
        if (dot == -1) {
            dec += '.';
            dot = dec.indexOf('.');
        }
        while (dec.length <= dot + decimals) { dec += '0'; }
        result = dec;
    } else {
        var dot;
        var dec = new String(whole);
        dec += '.';
        dot = dec.indexOf('.');
        while (dec.length <= dot + decimals) { dec += '0'; }
        result = dec;
    }
    return result;
};

/**
 * 反转 PHP 的 nl2br
 */
String.prototype.br2nl = function(){
     var re = /(<br\/>|<br>|<BR>|<BR\/>)/g;
     return this.replace(re, "\n");
}

/**
 * 根据下标移除数组元素
 */
Array.prototype.remove = function(index){
    if (isNaN(index) || index > this.length) { return false; }
    for (var i = 0, n = 0; i < this.length; i++) {
        if (this[i] != this[index]) {
            this[n++] = this[i];
        }
    }
    this.length -= 1;
}

/**
 * bgiframe
 */
$.fn.bgiframe = function(s) {
    // This is only for IE6
    if ( $.browser.msie && /6.0/.test(navigator.userAgent) ) {
        s = $.extend({
            top     : 'auto', // auto == .currentStyle.borderTopWidth
            left    : 'auto', // auto == .currentStyle.borderLeftWidth
            width   : 'auto', // auto == offsetWidth
            height  : 'auto', // auto == offsetHeight
            opacity : true,
            src     : 'javascript:false;'
        }, s || {} );
        var prop = function(n){ return n&&n.constructor == Number?n + 'px' : n; },
            html = '<iframe class="bgiframe" frameborder="0" tabindex="-1" src="' + s.src + '"' +
                       'style="display:block;position:absolute;z-index:-1;' +
                           (s.opacity !== false ? 'filter:Alpha(Opacity=\'0\');' : '') +
                           'top:' + (s.top=='auto' ? 'expression(((parseInt(this.parentNode.currentStyle.borderTopWidth)||0)*-1)+\'px\')' : prop(s.top)) + ';' +
                           'left:' + (s.left=='auto' ? 'expression(((parseInt(this.parentNode.currentStyle.borderLeftWidth)||0)*-1)+\'px\')' : prop(s.left)) + ';' +
                           'width:' + (s.width=='auto' ? 'expression(this.parentNode.offsetWidth+\'px\')' : prop(s.width)) + ';' +
                           'height:' + (s.height=='auto' ? 'expression(this.parentNode.offsetHeight+\'px\')' : prop(s.height)) + ';' +
                    '"/>';
        return this.each(function() {
            if ( $('> iframe.bgiframe', this).length == 0 )
                this.insertBefore(document.createElement(html), this.firstChild );
        });
    }
    return this;
};

/**
 * 为对像绑定下拉菜单
 */
$.fn.bindDropMenu = function(target, offsetX, offsetY){
    var offset = false;
    var show = function(){
        if (!offset) {
            offsetX = isNaN(offsetX) ? 0 : parseInt(offsetX);
            offsetY = isNaN(offsetY) ? 0 : parseInt(offsetY);
            $(target).css('left', $(this).offset().left + offsetX)
                     .css('top', $(this).offset().top + $(this).height() + offsetY);
            offset = true;
        }
        $(target).show().bgiframe();
    };
    var hide = function(){$(target).hide();};
    $(this).each(function(){
        $(this).hover(show, hide);});
    $(target).hover(show, hide);
};

/**
 * TABS 效果
 */
$.fn.tabs = function(event, elements){
    event = (event == 'click') ? 'click' : 'mouseover';
    $(this).each(function(){
        var eles = [];
        if (!elements) {
            $(this).find('li').each(function(){
                eles.push($($(this).find('a').attr('href')));
            });
        }
        $(this).find('li').bind(event, function(){
            (!elements) ?
                $.each(eles, function(i){eles[i].css('height', '0px').hide()})
                : $(elements).css('height', '0px').hide();
            $($(this).find('a').attr('href')).css('height', 'auto').show();
            $(this).parent().find('li').removeClass('current');
            $(this).addClass('current');
            $(this).find('a').blur();
            return false;
        }).unbind(event == 'click' ? 'mouseover' : 'click');
    });
};

/**
 * 加入收藏夹
 */
function addFavorites(sTitle, sUrl) {
    if ($.browser.msie) {
        try {
          window.external.addFavorite(sUrl, sTitle);
        } catch (e) {
            alert("加入收藏失败，有劳您按 Ctrl + D 手动将本页加入收藏夹。");
        }
    } else if (window.sidebar) {
        window.sidebar.addPanel(sTitle, sUrl, "");
    }
}
//省份切换
function changeProvince(pid) {
    var html = '';
        if (pid > 0) {
        $.post('/ajax/returnCity',{'pid' : pid},function(data){
            $('select[name=city_id]').html(data);
            $('select[name=city_id]').attr('disabled', '');
        });
    }
}

/**
 * 将指定元素创建为对话框
 */
$.fn.dialog = function(o){
    var p = {title : '', modal : true};
    $.extend(p, o);
    return this.each(function(){
        if ($(this).find('.jqmMain').length == 0) {
            $(this).wrapInner('<div class="jqmMain"></div>');
            if (p.title.length > 0) {

               $(this).prepend('<div class="jqmTop"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td><h4>' + p.title + '</h4></td><td width="60" align="center" ><a href="javascript:void(0);" title="关闭" class="jqmClose">关闭</a></td></tr></table></div>');
            } else {
                p.modal = false;
            }
        }
        $(this).addClass('jqmWindow').jqm(p).jqDrag('.jqmTop').jqmShow();
    });
};

/**
 * 用户登录/退出处理
 */
var auth = {
    init : function(){
        auth = $.extend(auth, {logined : false, uid : 0, username : null, nickname : null, email : null,  avatar : null});
    },
    set : function(data){
        auth = $.extend(auth, data);
        auth.refreshNew();
    },
    loginSuccess : function(){},
    login : function() {
        var html = '<form method="post" action="/default/user/login">'
                 + '<input type="hidden" name="ajax" value="1" />'
                 + '<div class="message"></div>'
                 + '<table width="100%" border="0" cellspacing="5" cellpadding="0">'
                 + '<tr><td align="right">用户名/邮箱：</td>'
                 + '<td align="left"><input type="text" name="username" size="25" maxlength="60" class="text" tabindex="1" />'
                 + '&nbsp;<a href="http://login.99longbi.com/user/register" target="_parent">我还没有注册</a></td></tr>'
                 + '<tr><td align="right">登录密码：</td>'
                 + '<td align="left"><input type="password" name="password" size="25" maxlength="50" class="text" tabindex="2" />'
                 + '&nbsp;<a href="http://login.99longbi.com/user/forget" target="_parent">忘记密码了？</a></td></tr>'
                 + '<tr><td align="right">&nbsp;</td>'
                 + '<td align="left"><input name="lifetime" id="lifetime" type="checkbox" value="2592000" checked="checked" tabindex="3" />'
                 + '<label for="lifetime">保存密码(下次自动登录)</label></td></tr>'
                 + '<tr><td align="right">&nbsp;</td>'
                 + '<td align="left"><input type="submit" value="登 录" class="btn-1" tabindex="4" />'
                 + '<input type="button"value="取 消" class="btn-3 jqmClose" tabindex="5" /></td></tr>'
                 + '</table></form>';
        var dialog = $('<div id="login-dialog"></div').prependTo(document.body).html(html).dialog({title:'注册会员登录'});
        dialog.find('form').submit(function(){
            var $this = $(this);
            $this.find('.message').addClass('loading').html('登录请求处理中...').show();
            $this.ajaxSubmit({
                dataType : 'json',
                success : function(json){
                    $this.find('.loading').hide();
                    if (json.logined) { //登录成功
                        dialog.jqmHide();
                        auth.set(json);
                        $('#auth .center').prevAll('li').remove();
                        $('#welcome').html(
                            '<li class="nick"><img src="' + json.avatar + '" width="16" height="16" align="absmiddle" />' +
                            ' 欢迎回来，<a href="http://login.99longbi.com/user/profile" title="修改个人资料">' + json.nickname + '</a></li><li class="sep"></li>' +
                            '<li class="msg"><a href="http://login.99longbi.com/msg/list" title="0 条新消息">短消息</a></li>'
                        );
                        $('#topbar .msg').bindDropMenu('#topbar ul.msg-menu', -10, -5);
                        if (json.admin) {
                            $('#auth .center').after('<li class="sep"></li><li class="admin"><a href="http://admin.99longbi.com/" title="进入管理后台">管理后台</a></li>');
                        }
                        $('#auth .help').after('<li class="sep"></li><li class="logout"><a href="http://login.99longbi.com/user/logout" title="退出登录" onclick="return auth.logout();">退出</a></li>');
                        auth.loginSuccess();
                    } else {
                        $this.find('.message').removeClass('loading').html(json.message).show();
                        $this.find('input[name=username]').focus();
                    }
                }
            });
            return false;
        });
        return false;
    },
    logoutSuccess : function(){},
    logout : function(){ //退出登录
        $.get('/default/user/logout', function(){
            auth.init();
            $('#auth .center').before(
                '<li>您好，请 <a href="http://login.99longbi.com/user/login" title="注册会员请点击登录" class="login" onclick="return auth.login();">登录</a> 或 ' +
                '<a href="http://login.99longbi.com/user/register" title="还没有注册？前往注册页面" class="register">注册</a></li><li class="sep"></li>'
            );
            $('#auth .admin').next().remove();
            $('#auth .admin').remove();
            $('#auth .help').nextAll('li').remove();
            $('#welcome').html('');
            alert('您已经成功退出会员系统！');
            auth.logoutSuccess();
        });
        return false;
    },
    refreshNew : function() { //刷新短消息数量
        if (auth.logined) {
            $.getJSON('/default/ajax/newCount', function(json){
                $('#welcome .msg').nextAll('li').remove();
                if (parseInt(json.msg) > 0) {
                    $('#welcome .msg').html('<a href="http://login.99longbi.com/msg/list" title="' + json.msg + ' 条新消息">短消息</a><span>(<font color=red>' + json.msg + '</font>)</span>');
                } else {
                    $('#welcome .msg').html('<a href="http://login.99longbi.com/msg/list" title="0 条新消息">短消息</a>');
                }
                if (parseInt(json.notice) > 0) {
                    $('#welcome').append('<li class="sep"></li><li class="notice"><a href="http://login.99longbi.com/notice/list" title="' + json.notice + ' 条新通知">' + json.notice + '</a></li>');
                }
            });
        }
        setTimeout(auth.refreshNew, 10000);
    }
};

/**
 * DOM Ready !
 */
$(document).ready(function(){
    //绑定顶部工具条事件
    $('#topbar .center').bindDropMenu('#topbar ul.center-menu', -10, -5);
    $('#topbar .msg').bindDropMenu('#topbar ul.msg-menu', -10, -5);

    //样式修正，兼容 IE6-
    $('input.text').hover(function(){$(this).addClass('texthover');}, function(){$(this).removeClass('texthover');});
    $('input.button').hover(function(){$(this).addClass('buttonhover');}, function(){$(this).removeClass('buttonhover');});
    $('textarea').hover(function(){$(this).addClass('textareahover');}, function(){$(this).removeClass('textareahover');});

    //修正邮件链接
    $('a.mailto').each(function(){
        this.innerHTML = this.innerHTML.replace(/_@_/, '@');
        this.href = "mailto:" + this.innerHTML;
    });

    //绑定 TABS 效果
    $('.jquery-tabs').tabs();

    $('a.delete').click(function(){return confirm('一旦删除将无法恢复，您确认要删除该记录吗？')});
});
