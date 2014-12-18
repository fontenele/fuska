define(function () {
    return {
        'name': 'fsk',
        'initLayout': function () {
            // mudar essa requisição
            require(['css!./../vendor/bootstrap/css/bootstrap', 'css!./../vendor/w2ui/w2ui.min'], function () {
                $('#layout').w2layout({
                    'name': 'layout',
                    'padding': 4,
                    'panels': [
                        {'type': 'left', 'size': 150, 'resizable': true}
                    ]
                });
                //w2ui.layout.content('left', '<div><button class="btn">Teste de botão</button></div>');
            });
        },
        'loadCss': function (url) {
            var link = document.createElement("link");
            link.type = "text/css";
            link.rel = "stylesheet";
            link.href = url;
            $(link).attr('data-tela', true);
            document.getElementsByTagName("head")[0].appendChild(link);
        },
        'getName': function () {
            return this.name;
        }
    };
});