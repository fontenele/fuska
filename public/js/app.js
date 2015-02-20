requirejs.config({
    'baseUrl': jsBasePath,
    'urlArgs': "v=" + version,
    'theme': "./../themes/" + theme + "/js/theme.js",
    'paths': {
        'async': 'vendor/requirejs/async',
        'backbone': 'vendor/requirejs/backbone',
        'bootstrap': 'vendor/bootstrap/js/bootstrap.min',
        'collection': 'js/helper/collection',
        'css': 'vendor/requirejs/css',
        'cssLoader': 'js/helper/CSSLoader',
        'debug': 'js/debug',
        'domReady': 'vendor/requirejs/domReady',
        'font': 'vendor/requirejs/font',
        'form': 'js/helper/form',
        'goog': 'vendor/requirejs/goog',
        'i18n': 'vendor/requirejs/i18n',
        'image': 'vendor/requirejs/image',
        'jquery': 'vendor/jquery/jquery.min',
        'json': 'vendor/requirejs/json',
        'layout': 'js/helper/layout',
        'mdown': 'vendor/requirejs/mdown',
        'model': 'js/model',
        'mustache': 'vendor/mustache',
        'mk': 'vendor/matreshka',
        'noext': 'vendor/requirejs/noext',
        'normalize': 'vendor/requirejs/normalize',
        'propertyParser': 'vendor/requirejs/propertyParser',
        'r': 'vendor/requirejs/r',
        'router': 'js/router',
        'text': 'vendor/requirejs/text',
        'transport': 'js/helper/transport',
        'underscore': 'vendor/requirejs/underscore',
        'view': 'js/view',
        //'w2ui': 'vendor/w2ui/w2ui.min'
        'w2ui': 'vendor/w2ui/w2ui'
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
