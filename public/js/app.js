requirejs.config({
    'baseUrl': jsBasePath,
    'urlArgs': "v=" + version,
    'theme': "./../themes/" + theme + "/js/theme.js",
    'paths': {
        'async': 'vendor/requirejs-plugins/src/async',
        'backbone': 'vendor/backbone/backbone',
        'bootstrap': 'vendor/bootstrap/dist/js/bootstrap.min',
        'collection': 'js/helper/collection',
        'css': 'vendor/require-css/css',
        'cssLoader': 'js/helper/CSSLoader',
        'debug': 'js/debug',
        'depend': 'vendor/requirejs-plugins/src/depend',
        'domReady': 'vendor/requirejs-domready/domReady',
        'font': 'vendor/requirejs-plugins/src/font',
        'form': 'js/helper/form',
        'goog': 'vendor/requirejs-plugins/src/goog',
        'i18n': 'vendor/requirejs-i18n/i18n',
        'image': 'vendor/requirejs-plugins/src/image',
        'jquery': 'vendor/jquery/dist/jquery.min',
        'json': 'vendor/requirejs-plugins/src/json',
        'layout': 'js/helper/layout',
        'maskMoney': 'vendor/jquery.maskmoney/dist/jquery.maskMoney.min',
        'mdown': 'vendor/requirejs-plugins/src/mdown',
        'mk': 'vendor/matreshka/matreshka',
        'model': 'js/model',
        'mustache': 'vendor/mustache/mustache.min',
        'noext': 'vendor/requirejs-plugins/src/noext',
        'normalize': 'vendor/require-css/normalize',
        'propertyParser': 'vendor/requirejs-plugins/src/propertyParser',
        'r': 'vendor/r.js/dist/r',
        'router': 'js/router',
        'text': 'vendor/requirejs-text/text',
        'transport': 'js/helper/transport',
        'underscore': 'vendor/underscore/underscore-min',
        'view': 'js/view',
        'w2ui': 'vendor/w2ui/w2ui-1.4.2.min'
    },
    'shim': {
        'backbone': ['underscore'],
        'bootstrap': ['jquery'],
        'css': ['text', 'normalize'],
        'font': ['propertyParser'],
        'goog': ['async', 'propertyParser'],
        'json': ['text'],
        'layout': ['w2ui'],
        'router': ['backbone'],
        'underscore': ['jquery'],
        'view': ['mustache'],
        'w2ui': ['jquery', 'bootstrap']
    }
});

//requirejs.onError = function(err) {
//    if (err.requireType === 'timeout') {
//        console.log('modules: ' + err.requireModules);
//    }
//    //console.warn('ERROR', err);
//    throw err;
//};

//require.onResourceLoad = function(context, map, i, j) {
//};

define([requirejs.s.contexts._.config.theme, 'transport', 'router', 'backbone', 'debug'], function(theme) {
    $(document).on('click', '.link-ajax', function() {
        var url = $(this).attr('href');
        var target = $(this).data('target');
        Router.go(url, target);
        return false;
    });

    theme.initLayout();
    return {};
});
