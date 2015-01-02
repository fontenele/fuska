define(['model'], function(Model) {
    var UsuarioModel = Model.extend({
        'urlRoot': 'admin/usuario/salvar',
        'attributes': {
            'id': '',
            'login': '',
            'senha': '',
            'ultimoLogin': ''
        }
    });

    return UsuarioModel;
});