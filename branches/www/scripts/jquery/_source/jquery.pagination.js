var page = {
    perpage : 10,
    current : 1,
    element : null,
    target : null,
    count : function(){
        return (page.element) ? page.element.length : 0;
    },
    pageCount : function(){
        return (page.element) ? Math.ceil(page.count() / page.perpage) : 0;
    },
    _html : function(){

        var html = '';
        var current = page.current;
        var pageCount = page.pageCount();

        function _item(p){
            if (page.current == p) {
                return '<span class="pageCurrentItem" title="当前第 ' + p + ' 页">' + p + '</span>\n';
            } else {
                return '<a href="javascript:page.show(' + p + ');" class="pageItem" title=\"前往第 ' + p + ' 页\">' + p +  '</a>\n';
            }
        }

        function _nextMore(p) {
            var html = '';
            if (p < pageCount) {
                html += '<span class="pageNextMore">...</span>\n';
                if (p < pageCount - 1) {
                    html += _item(pageCount - 1);
                }
                html += _item(pageCount);
            }
            return html;
        }

        function _prevMore(p) {
            var html = '';
            if (p > 1) {
                html += (p > 2) ? _item(1) + _item(2) : _item(1);
                html += "<span class=\"pagePrevMore\">...</span>\n";
            }
            return html;
        }

        if (pageCount > 1) {
            if (page.current > 1) {
                html += '<a href="javascript:page.previous();" class="pagePrev" title="前往上一页">&laquo; 上一页</a>\n';
            }

            if (page.current < 6 || pageCount < 10) {
                var i = 1;
                for (i; i<10; i++) {
                    html += _item(i);
                    if (i >= pageCount) { break; }
                }
                html += _nextMore(i);
            } else if (current > 5 && current < pageCount - 4) {
                html += _prevMore(current - 4);
                var i = current - 4;
                for (i; i < current + 5; i++) {
                    html += _item(i);
                    if (i >= pageCount) { break; }
                }
                html += _nextMore(i);
            } else if (current + 5 > pageCount) {
                html += _prevMore(pageCount - 8);
                for (i = pageCount - 8; i < pageCount + 1; i++) {
                    if (i > 1) { html += _item(i); }
                }
            }

            if (pageCount > 1 && page.current != pageCount) {
                html += '<a href="javascript:page.next();" class="pageNext" title="前往下一页">下一页 &raquo;</a>\n';
            }
        }

        return html;
    },
    show : function(p){
        if (isNaN(p) || !page.element) {
            return ;
        }
        page.current = (p < 1) ? 1 : ((p > page.pageCount()) ? page.pageCount() : p);
        $(page.element).hide().slice((page.current * page.perpage) - page.perpage, (page.current * page.perpage)).show();
        if (page.target) {
            $(page.target).html(page._html());
        }
    },
    first : function(){
        this.show(1);
    },
    previous : function(){
        if (page.current <= 1) {
            alert('已经是最前一页了');
        }
        this.show(parseInt(page.current) - 1);
    },
    next : function(){
        if (page.current == page.pageCount()) {
            alert('已经是最后一页了');
        }
        this.show(parseInt(page.current) + 1);
    },
    last : function(){
        this.show(parseInt(page.pageCount()));
    },
    start : function(){
        this.show(parseInt(page.current));
    }
};

$.fn.pagination = function(params){

    var options = {
        segment  : 'p',
        perpage  : 10,
        target   : null
    };
    $.extend(options, params);

    this.getParam = function(seg, def) {
        var oRegex = new RegExp('&?' + seg + '=([^&]+)', 'i');
        var oMatch = oRegex.exec(window.location.hash) ;
        return oMatch && oMatch.length > 1 ? oMatch[1] : def;
    };

    page.perpage = options.perpage;
    page.element = this;
    page.target  = options.target;
    page.current = this.getParam(options.segment, 1);
    page.start();

    return this;
};