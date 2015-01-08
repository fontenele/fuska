define(['model', 'js/models/admin/GrupoUsuarios'], function(Model, GrupoUsuarios) {
    var UsuarioModel = Model.extend({
        'urlRoot': 'admin/usuario/salvar',
        defaults: {
            'logado': false
        },
        'attributes': {
            'recid': '',
            'id': '',
            'login': '',
            'logado': false,
            'senha': '',
            'status': '',
            'ultimoLogin': '',
            'grupoUsuarios': ''
        },
        initialize: function() {
            var _grupoUsuarios = this.get('grupoUsuarios');
//            if (typeof (_grupoUsuarios) === 'object') {
//                this.set('grupoUsuarios', new GrupoUsuarios(_grupoUsuarios));
//            }
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