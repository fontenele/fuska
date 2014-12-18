requirejs.config({
    'baseUrl': 'public',
    'urlArgs': "v=" + env,
    'theme': "./../themes/" + theme + "/js/theme",
    'paths': {
        'async': 'vendor/requirejs/async',
        'css': 'vendor/requirejs/css',
        'domReady': 'vendor/requirejs/domReady',
        'font': 'vendor/requirejs/font',
        'goog': 'vendor/requirejs/goog',
        'i18n': 'vendor/requirejs/i18n',
        'image': 'vendor/requirejs/image',
        'json': 'vendor/requirejs/json',
        'mdown': 'vendor/requirejs/mdown',
        'noext': 'vendor/requirejs/noext',
        'normalize': 'vendor/requirejs/normalize',
        'propertyParser': 'vendor/requirejs/propertyParser',
        'r': 'vendor/requirejs/r',
        'text': 'vendor/requirejs/text',
        'jquery': 'vendor/jquery/jquery.min',
        'bootstrap': 'vendor/bootstrap/js/bootstrap.min',
        'w2ui': 'vendor/w2ui/w2ui.min',
        'cssLoader': 'js/helper/CSSLoader'
    },
    'shim': {
        'w2ui': ['jquery', 'bootstrap'],
        'bootstrap': ['jquery'],
        'css': ['text', 'normalize'],
        'font': ['propertyParser'],
        'json': ['text'],
        'goog': ['async', 'propertyParser']
    }
});

requirejs.onError = function (err) {
    if (err.requireType === 'timeout') {
        console.log('modules: ' + err.requireModules);
    }
    console.warn('ERROR', err);
    //throw err;
};

require.onResourceLoad = function (context, map, i, j) {
};

var themeJsPath = "./../themes/" + theme + "/js/theme";

define([requirejs.s.contexts._.config.theme, 'jquery', 'cssLoader', 'w2ui', 'text', 'domReady', 'i18n', 'css'], function (theme, $, cssLoader) {
    var module = {
        'initEvents': function () {
            var that = this;
            $(document).on('click', '.link-ajax', function () {
                var target = $(this).data('target') ? $(this).data('target') : 'main';

                require(['text!' + basePath + $(this).attr('href') + '?type=html&t=' + (new Date()).getTime()], function (html) {
                    w2ui.layout.content(target, html);
                });
                require(['json!' + basePath + $(this).attr('href') + '?type=json&t=' + (new Date()).getTime()], function (result) {
                    for (var i = 0, l = result.files.js.length; i < l; i++) {
                        if (require.defined(result.files.js[i])) {
                            require.undef(result.files.js[i]);
                        }
                    }

                    $('head link[data-tela]').remove();
                    cssLoader.addCss(result.files.css);

                    require(result.files.js, function (objTela) {
                        if (objTela.init && typeof objTela.init === 'function') {
                            objTela.init();
                        }
                    });
                });
                return false;
            });
        }
    };
    
    theme.initLayout();
    module.initEvents();
});
