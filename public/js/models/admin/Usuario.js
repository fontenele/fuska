define(['model'], function(Model) {
    var UsuarioModel = Model.extend({
        'urlRoot': 'admin/usuario/salvar',
        defaults: {
            'logado': false
        },
        'attributes': {
            'id': '',
            'login': '',
            'senha': '',
            'ultimoLogin': ''
        },
        'autenticar': function() {
            var that = this;
            $.ajax({
                url: basePath + "admin/index/autenticar?type=json",
                async: false,
                dataType: 'json',
                data: this.toJSON(),
                success: function(result) {
                    that.set('logado', result.result.logado);
                    return true;
                },
                error: function(result) {
                    that.set('logado', false);
                    return false;
                }
            });
            return this.get('logado');
        }
    });

    return UsuarioModel;
});