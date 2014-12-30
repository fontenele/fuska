var Router;
define(['backbone'], function (Backbone) {
    if (Router) {
        return Router;
    }

    Router = {
        go: function (url, target) {
            x().logWithTitle('Opening ' + url + (target ? " on " + target : ""));
            require([
                'text!' + basePath + url + '?type=html&t=' + (new Date()).getTime(),
                'json!' + basePath + url + '?type=json&t=' + (new Date()).getTime(),
                'cssLoader'
            ], function (html, json, cssLoader) {
                if (target) {
                    Layout.content(target, html);
                } else {
                    $('#cache .html').html(html);
                    $.each($('#cache .html').find('[data-block-target]'), function (i, item) {
                        var $html = $('<div>').append($(item)).removeAttr('data-block-target');
                        Layout.content($(item).data('block-target'), $html.html());
                    });
                    $('#cache .html').empty();
                }
                for (var i = 0, l = json.files.js.length; i < l; i++) {
                    if (require.defined(json.files.js[i])) {
                        require.undef(json.files.js[i]);
                    }
                }

                $('head link[data-tela]').remove();
                cssLoader.addCss(json.files.css, true);

                require(json.files.js, function (objTela) {
                    if (typeof objTela === 'object' && objTela.init && typeof objTela.init === 'function') {
                        objTela.request = json.result;
                        objTela.init();
                    }
                });
            });
        }
    };

//    var go = function(url, target) {
//        x().logWithTitle('Opening ' + url + (target ? " on " + target : ""));
//        require([
//            'text!' + basePath + url + '?type=html&t=' + (new Date()).getTime(),
//            'json!' + basePath + url + '?type=json&t=' + (new Date()).getTime(),
//            'cssLoader'
//        ], function (html, json, cssLoader) {
//            if (target) {
//                Layout.content(target, html);
//            } else {
//                $('#cache .html').html(html);
//                $.each($('#cache .html').find('[data-block-target]'), function (i, item) {
//                    var $html = $('<div>').append($(item)).removeAttr('data-block-target');
//                    Layout.content($(item).data('block-target'), $html.html());
//                });
//                $('#cache .html').empty();
//            }
//            for (var i = 0, l = json.files.js.length; i < l; i++) {
//                if (require.defined(json.files.js[i])) {
//                    require.undef(json.files.js[i]);
//                }
//            }
//
//            $('head link[data-tela]').remove();
//            cssLoader.addCss(json.files.css, true);
//
//            require(json.files.js, function (objTela) {
//                if (typeof objTela === 'object' && objTela.init && typeof objTela.init === 'function') {
//                    objTela.request = json.result;
//                    objTela.init();
//                }
//            });
//        });
//    };
//
//    return {
//        'go': go
//    };

    return Router;

});