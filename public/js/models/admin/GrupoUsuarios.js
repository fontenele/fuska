define(['model'], function(Model) {
    var GrupoUsuariosModel = Model.extend({
        'urlRoot': 'admin/grupo-usuarios/salvar',
        'attributes': {
            'id': '',
            'nome': '',
            'status': ''
        }
    });

    return GrupoUsuariosModel;
});