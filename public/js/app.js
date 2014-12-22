requirejs.config({
    'baseUrl': basePath + 'public',
    'urlArgs': "v=" + version,
    'theme': "./../themes/" + theme + "/js/theme",
    'paths': {
        'async': 'vendor/requirejs/async',
        'backbone': 'vendor/requirejs/backbone',
        'css': 'vendor/requirejs/css',
        'collection': 'js/helper/collection',
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
        'underscore': 'vendor/requirejs/underscore',
        'jquery': 'vendor/jquery/jquery.min',
        'bootstrap': 'vendor/bootstrap/js/bootstrap.min',
        'w2ui': 'vendor/w2ui/w2ui.min',
        'cssLoader': 'js/helper/CSSLoader',
        'layout': 'js/helper/layout',
        'router': 'js/router'
    },
    'shim': {
        'w2ui': ['jquery', 'bootstrap'],
        'bootstrap': ['jquery'],
        'css': ['text', 'normalize'],
        'font': ['propertyParser'],
        'json': ['text'],
        'goog': ['async', 'propertyParser'],
        'backbone': ['underscore'],
        'underscore': ['jquery'],
        'layout': ['w2ui'],
        'router': ['backbone']
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

define([requirejs.s.contexts._.config.theme, 'router', 'backbone'], function (theme, router) {
    $(document).on('click', '.link-ajax', function () {
        var url = $(this).attr('href');
        var target = $(this).data('target');
        router.go(url, target);
        return false;
    });

    theme.initLayout();
    return {};
});
