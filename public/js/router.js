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
    cssCollection.on('remove', function(model, collection) {
        if (collection.where({file: model.get('file')}).length > 0) {
            return;
        }
        // Remover css do Head
        $.each($('head link[data-tela]'), function(i, item) {
            if ($(item).attr('href').replace('?v=' + version, '') == model.get('file')) {
                $(item).remove();
            }
        });
    });
    var jsCollection = new fileCollection();
    jsCollection.on('remove', function(model, collection, options) {
        if (collection.where({file: model.get('file')}).length > 0) {
            return;
        }
        // Remover js do Head
        require.undef(model.get('file'));
    });

    Router = {
        oldAction: '',
        action: '',
        logged: logado,
        cache: {
            css: cssCollection,
            js: jsCollection
        },
        refresh: function() {
            return Router.go(Router.action);
        },
        go: function(url, target, data) {
            if (target) {
                Layout.showLoading(target, 'Aguarde...');
            } else {
                Layout.showLoading('main', 'Aguarde...');
            }
            Router.oldAction = Router.action;
            if (!this.verifyIsLogged()) {
                url = 'admin/index/autenticacao';
            }
            Router.action = url;
            data = JSON.stringify(data ? data : {});
            var _data = encodeURIComponent(data);
            console.info('Opening ' + url + (target ? " on " + target : "") + (data != '{}' ? ' [' + data + ']' : ''));
            require([
                'text!' + basePath + url + '?type=html&t=' + (new Date()).getTime(),
                'json!' + basePath + url + '?type=json&t=' + (new Date()).getTime() + '&d=' + _data
            ], function(html, json) {
                var targets = [];
                if (target) {
                    Layout.content(target, html);
                    targets.push(target);
                } else {
                    $('#cache .html').html(html);
                    $.each($('#cache .html').find('[data-block-target]'), function(i, item) {
                        var _target = $(item).data('block-target');
                        var $html = $('<div>').append($(item)).removeAttr('data-block-target');
                        Layout.content(_target, $html.html());
                        targets.push(_target);
                    });
                    $('#cache .html').empty();
                }
                
                Router.destructOldJsAndCssFiles(targets); // Vem antes ou depois de adicionar?
                Router.addCssFiles(json.files.css, url, targets);
                Router.addJsFiles(json.files.js, json.result, url, targets);
                if (target) {
                    Layout.hideLoading(target);
                } else {
                    Layout.hideLoading('main');
                }
                if (Router.oldAction === Router.action) {
                    return;
                }
            });
        },
        /**
         * Carrega arquivos JS
         * @param Array list
         * @param String request
         * @param String url
         * @param Array targets
         */
        addJsFiles: function(list, request, url, targets) {
            $.each(list, function(i, item) {
                require([item], function(view) {
                    if (typeof view === 'object' && view.init && typeof view.init === 'function') {
                        view.request = request;
                        view.init();
                    }
                    Router.cache.js.add({
                        url: url,
                        file: item,
                        target: targets,
                        time: new Date()
                    });
                });
            });
        },
        /**
         * Carrega arquivos CSS
         * @param Array list
         * @param String url
         * @param Array targets
         */
        addCssFiles: function(list, url, targets) {
            $.each(list, function(i, item) {
                cssLoader.addCssFile(item, true);
                Router.cache.css.add({
                    url: url,
                    file: item,
                    target: targets,
                    time: new Date()
                });
            });
        },
        destructOldJsAndCssFiles: function(targets) {
            var jsFiles = Router.cache.js.map(function(item) {
                $.each(targets, function(i, target) {
                    if(item.get('target').lastIndexOf(target) >= 0) {
                        item.get('target').splice(item.get('target').lastIndexOf(target), 1);
                        if(item.get('target').length == 0) {
                            // Remover arquivo pois era de TARGET e ele não está mais ativo
                            Router.cache.js.remove(item);
                        }
                    }
                });
            });
            var cssFiles = Router.cache.css.map(function(item) {
                $.each(targets, function(i, target) {
                    if(item.get('target').lastIndexOf(target) >= 0) {
                        item.get('target').splice(item.get('target').lastIndexOf(target), 1);
                        if(item.get('target').length == 0) {
                            // Remover arquivo pois era de TARGET e ele não está mais ativo
                            Router.cache.css.remove(item);
                        }
                    }
                });
            });
        },
        verifyIsLogged: function() {
            return this.logged;
        }
    };

    return Router;
});