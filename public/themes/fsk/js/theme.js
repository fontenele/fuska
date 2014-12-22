define(function () {
    return {
        'name': 'fsk',
        'initLayout': function () {
            require(['cssLoader', 'layout'], function (cssLoader) {
                cssLoader.addCss([
                    basePath + 'public/vendor/bootstrap/css/bootstrap.min.css',
                    basePath + 'public/vendor/w2ui/w2ui.min.css'
                ]);
            });
        },
        'getName': function () {
            return this.name;
        }
    };
});