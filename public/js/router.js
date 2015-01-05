var Router;
define(['backbone', 'cssLoader', 'jquery'], function(Backbone, cssLoader, $) {
    if (Router) {
        return Router;
    }

    var File = Backbone.Model.extend({});
    var fileCollection = Backbone.Collection.extend({
        model: File
    });
    var cssCollection = new fileCollection();
    cssCollection.on('remove', function(model, collection, options) {
//        $.log('remover css', Router.cache.css.length, collection.length);
        // Remover css do Head
        $.each($('head link[data-tela]'), function(i, item) {
            if ($(item).attr('href').replace('?v=' + version, '') == model.get('file')) {
                $(item).remove();
            }
        });
    });
    var jsCollection = new fileCollection();
    jsCollection.on('remove', function(model, collection, options) {
//        $.log('remover js', Router.cache.css.length, collection.length);
        // Remover js do Head
        require.undef(model.get('file'));
    });

    Router = {
        oldAction: '',
        action: '',
        cache: {
            css: cssCollection,
            js: jsCollection
        },
        go: function(url, target, data) {
            Router.oldAction = Router.action;
            Router.action = url;
            data = JSON.stringify(data ? data : {});
            var _data = encodeURIComponent(data);
            x().logWithTitle('Opening ' + url + (target ? " on " + target : "") + (data != '{}' ? ' [' + data + ']' : ''));
            require([
                'text!' + basePath + url + '?type=html&t=' + (new Date()).getTime(),
                'json!' + basePath + url + '?type=json&t=' + (new Date()).getTime() + '&d=' + _data
            ], function(html, json) {
                if (target) {
                    Layout.content(target, html);
                } else {
                    $('#cache .html').html(html);
                    $.each($('#cache .html').find('[data-block-target]'), function(i, item) {
                        var $html = $('<div>').append($(item)).removeAttr('data-block-target');
                        Layout.content($(item).data('block-target'), $html.html());
                    });
                    $('#cache .html').empty();
                }

                Router.destructOldJsAndCssFiles();
                Router.addCssFiles(json.files.css, url);
                Router.addJsFiles(json.files.js, json.result, url);
            });
        },
        addJsFiles: function(list, request, url) {
            $.each(list, function(i, item) {
                require([item], function(view) {
                    if (typeof view === 'object' && view.init && typeof view.init === 'function') {
                        view.request = request;
                        view.init();
                    }
                    Router.cache.js.add({
                        url: url,
                        file: item
                    });
                });
            });
        },
        addCssFiles: function(list, url) {
            $.each(list, function(i, item) {
                cssLoader.addCssFile(item, true);
                Router.cache.css.add({
                    url: url,
                    file: item
                });
            });
        },
        destructOldJsAndCssFiles: function() {
            var cssFiles = Router.cache.css.where({url: Router.oldAction});
            Router.cache.css.remove(cssFiles);
            var jsFiles = Router.cache.js.where({url: Router.oldAction});
            Router.cache.js.remove(jsFiles);
            Router.destructUnusedJsAndCssFiles();
        },
        destructUnusedJsAndCssFiles: function() {
//            $.each(Router.cache.css, function(i, item) {
//                $.info('cssFile', item);
//            });
//            $.each(Router.cache.js, function(i, item) {
//                $.info('jsFile', item);
//            });
            // js[arquivo.js][modulo/controler/action1]
            // js[arquivo.js][modulo/controler/action2]
            // verificar se nenhum esta sendo usado
        }
    };

    return Router;
});