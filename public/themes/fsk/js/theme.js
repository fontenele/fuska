define(function() {
    return {
        'name': 'fsk',
        'initLayout': function() {
            require(['cssLoader', 'layout'], function(cssLoader) {
                cssLoader.addCss([
                    jsBasePath + 'vendor/bootstrap/css/bootstrap.min.css',
                    jsBasePath + 'vendor/w2ui/w2ui.min.css'
                ]);
            });
        },
        'getName': function() {
            return this.name;
        }
    };
});