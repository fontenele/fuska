define(function() {
    return {
        'name': 'fsk',
        'initLayout': function() {
            require(['cssLoader', 'router', 'layout'], function(cssLoader, router) {
                cssLoader.addCss([
                    jsBasePath + 'vendor/bootstrap/css/bootstrap.min.css',
                    //jsBasePath + 'vendor/fontawesome/css/font-awesome.min.css',
                    jsBasePath + 'vendor/w2ui/w2ui.min.css',
                    jsBasePath + 'css/app.css'
                ]);
                router.go('admin/index/index');
            });
        },
        'getName': function() {
            return this.name;
        }
    };
});