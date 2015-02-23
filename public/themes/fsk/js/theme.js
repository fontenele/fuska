define(function() {
    return {
        'name': 'fsk',
        'initLayout': function() {
            require([
                'cssLoader',
                'js/models/admin/Usuario',
                'router',
                'layout'
//                'font!' + jsBasePath + 'fontawesome/fonts/fontawesome-webfont.ttf'
            ], function(cssLoader, Usuario) {
                $(document).on('click', '.system-logout', function() {
                    var _usuario = new Usuario();
                    _usuario.sair();
                    return false;
                });
                cssLoader.addCss([
//                    jsBasePath + 'vendor/fontawesome/css/font-awesome.min.css',
                    jsBasePath + 'vendor/w2ui/w2ui-1.4.2.min.css',
                    jsBasePath + 'vendor/bootstrap/dist/css/bootstrap.min.css',
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