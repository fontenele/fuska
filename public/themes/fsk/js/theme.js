define(function() {
    return {
        'name': 'fsk',
        'initLayout': function() {
            require(['cssLoader', 'router', 'layout'], function(cssLoader) {
                cssLoader.addCss([
                    //jsBasePath + 'vendor/fontawesome/css/font-awesome.min.css',
                    jsBasePath + 'vendor/w2ui/w2ui.min.css',
                    jsBasePath + 'vendor/bootstrap/css/bootstrap.min.css',
                    jsBasePath + 'css/app.css'
                ]);
                Router.go('main/index/index');
            });
        },
        'getName': function() {
            return this.name;
        }
    };
});