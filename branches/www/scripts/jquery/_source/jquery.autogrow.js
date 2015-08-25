/**
 * textarea 自动变长
 *
 * @author     Akon(番茄红了) <aultoale@gmail.com>
 * @copyright  Copyright (c) 2008 (http://www.tblog.com.cn)
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 *
 * $('textarea').autogrow();
 *
 * @params {minLines, lineHeight, overflow, restore}
 * minLines   : 最少显示的行数
 * lineHeight : 行高
 * overflow   : 超出部分的显示方式
 * restore    : 失去焦点时是否恢复高度
 */
$.fn.autogrow = function(params) {

    this.filter('textarea').each(function() {
        var options = {
            minLines    : $(this).attr('rows'),
            lineHeight  : 18,
            overflow    : 'hidden',
            restore     : true
        };
        $.extend(options, params);

        if (isNaN(options.minLines) || options.minLines < 1) {
            options.minLines = 10;
        }

        var minHeight = options.lineHeight * options.minLines;
        if ($.browser.msie) {
            minHeight = parseInt(minHeight) - 1;
        }

        $(this).height(minHeight).css('overflow', options.overflow).css('lineHeight', options.lineHeight + 'px');

        var dummy = $('<div></div>').css({
            'fontSize'   : $(this).css('fontSize'),
            'fontFamily' : $(this).css('fontFamily'),
            'lineHeight' : options.lineHeight + 'px',
            'width'      : this.clientWidth,
            'overflowX'  : 'hidden',
            'position'   : 'absolute',
            'top'        : 0,
            'left'       : -9999
        }).appendTo('body');

        var update = function(){
            dummy.html($(this).val().replace(/(<|>)/g, '').replace(/\n/g, '<br />new'));
            $(this).height(Math.max(minHeight, parseInt(dummy.height())));
        };

        $(this).change(update).keyup(update).keydown(update).click(update);

        if (options.restore) {
            $(this).blur(function(){$(this).css('height', minHeight)});
        }

    });

    return this;

};