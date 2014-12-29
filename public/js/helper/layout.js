var Layout;
define(function() {
    if (Layout) {
        return Layout;
    }
    $.fn.screen = function() {
        var css = {
            'top': '0px',
            'left': '0px',
            'position': 'fixed'
        };
        $.each($('.screen'), function() {
            var $this = $(this);
            $(window).on('resize', function() {
                var conf = {
                    'height': $(window).height(),
                    'width': $(window).width()
                };
                $this.css($.extend(css, conf));
            }).trigger('resize');
        });
    };

    var pstyle = 'border: 1px solid #dfdfdf; padding: 6px;';
    var options = {
        name: 'layout',
        panels: [
            {type: 'top', resizable: true, hidden: true, style: pstyle, content: 'top'},
            {type: 'left', size: '20%', resizable: true, hidden: false, style: pstyle, content: 'left'},
            {type: 'main', style: pstyle, hidden: true, content: 'main'},
            {type: 'preview', size: '50%', resizable: true, hidden: true, style: pstyle, content: 'preview'},
            {type: 'right', size: '20%', resizable: true, hidden: true, style: pstyle, content: 'right'},
            {type: 'bottom', size: '3%', resizable: true, hidden: true, style: pstyle, content: 'bottom'}
        ],
        tradeCache: function(panel) {
            var $bubble = $('.cache').find('.bubble');
            $bubble.html('');
            $bubble.append(this.container(panel).children());
            this.container(panel).append(this.cache(panel).children());
            this.cache(panel).append($bubble.children());
        },
        toCache: function(panels) {
            panels = panels || ['top', 'left', 'right', 'preview', 'bottom', 'main'];
            for (var i in panels) {
                this.cache(panels[i]).append(this.container(panels[i]).children());
            }
        },
        loadCache: function(panels) {
            panels = panels || ['top', 'left', 'right', 'preview', 'bottom', 'main'];
            for (var i in panels) {
                this.container(panels[i]).html('');
                this.container(panels[i]).append(this.cache(panels[i]).children());
            }
        },
        useContainers: function(arShow) {
            var panels = ['top', 'left', 'right', 'preview', 'bottom'];
            var arHide = $.grep(panels, function(i) {
                return $.inArray(i, arShow) < 0;
            });

            for (i in arHide) {
                this.hide(arHide[i]);
            }
            for (i in arShow) {
                if (!this.container(arShow[i]).is(':visible')) {
                    this.show(arShow[i]);
                }
            }
        },
        container: function(panel) {
            return $(this.el(panel));
        },
        cache: function(panel) {
            return $('.cache').find('.tela-' + panel);
        },
        tradeContent: function(panel1, panel2) {
            var $bubble = $('.cache').find('.bubble');
            $bubble.html('');
            $bubble.append(this.container(panel1).children());
            this.container(panel1).append(this.container(panel2).children());
            this.container(panel2).append($bubble.children());
        },
        tradeView: function(panel1, panel2) {
            this.tradeContent(panel1, panel2);
            this.toggle(panel1);
            this.toggle(panel2);
        }
    };

    //$().screen();
    $('#layout').w2layout(options);

    Layout = w2ui.layout;
    return Layout;
});