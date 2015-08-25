/**
 * 搜索关键字高亮
 *
 * @author     hyperjiang <hyperjiang@gmail.com>
 * @copyright  Copyright (c) 2008-2009 (http://mydraft.cn/)
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 *
 * @example $('p').highlight('searchTerm');
 */

$.fn.highlight = function(searchTerm) {
    doHighlight = function(bodyText, searchTerm) {
        highlightStartTag = "<span class=highlight>";
        highlightEndTag = "</span>";
        var newText = "";
        var i = -1;
        var lcSearchTerm = searchTerm.toLowerCase();
        var lcBodyText = bodyText.toLowerCase();

        while (bodyText.length > 0) {
            i = lcBodyText.indexOf(lcSearchTerm, i+1);
            if (i < 0) {
                newText += bodyText;
                bodyText = "";
            } else {
                // 忽略 HTML 标签里面的内容
                if (bodyText.lastIndexOf(">", i) >= bodyText.lastIndexOf("<", i)) {
                    // 忽略 javascript 内容
                    if (lcBodyText.lastIndexOf("/script>", i) >= lcBodyText.lastIndexOf("<script", i)) {
                        newText += bodyText.substring(0, i) + highlightStartTag + bodyText.substr(i, searchTerm.length) + highlightEndTag;
                        bodyText = bodyText.substr(i + searchTerm.length);
                        lcBodyText = bodyText.toLowerCase();
                        i = -1;
                    }
                }
            }
        }
        return newText;
    };

    $(this).each(function() {
        $(this).html(doHighlight($(this).html(), searchTerm));
    });

    return this;
};