/**
 * jQuery tips 效果
 *
 * @author     Akon(番茄红了) <aultoale@gmail.com>
 * @copyright  Copyright (c) 2008 (http://www.tblog.com.cn)
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 *
 * $('*').tips();
 */
$.fn.tips = function(params){

    var css = {
        'background'  : '#000000',
        'color'       : '#FFFFFF',
        'border'      : '1px solid #AAA',
        'padding'     : '5px 10px',
        'min-width'   : '50px',
        'text-align'  : 'left',
        'position'    : 'absolute',
        'z-index'     : '9999',
        'opacity'     : '0.7'
    };
    $.extend(css, params);

    $(this).each(function(){
        var title = alt = '';
        $(this).hover(function(e){
            var html = '';
            if (this.title) {
                html = title = this.title; this.title = '';
            } else if (this.alt) {
                html = alt = this.alt; this.alt = '';
            }
            if (html != '') {
                $("#__tips").css({top:e.pageY, left:e.pageX}).html(html).fadeIn();
            }
        },
        function(){
            $("#__tips").hide();
            this.title = title; this.alt = alt;
        });
        $(this).mousemove(function(e){
            $("#__tips").css({top:e.pageY, left:e.pageX});
        });
    });

    $(document.body).append('<p id="__tips"></p>');
    $("#__tips").hide();
    $.each(css, function(name, value){
        $("#__tips").css(name, value);
    });
};
$().ready(function(){$('.tips').tips();});