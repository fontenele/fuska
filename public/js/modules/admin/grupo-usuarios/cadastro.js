define(['js/models/admin/GrupoUsuarios', 'form'], function(GrupoUsuarios, Form) {
    return {
        'request': {},
        'form': null,
        'init': function(options) {
            var that = this;
            that.form = new Form({
                el: $('#grupo-usuarios-cadastro-main .form'),
                data: that.request.grupoUsuarios,
                items: [
                    {
                        name: 'id',
                        el: $(':input[name=id]'),
                        type: 'hidden'
                    },
                    {
                        name: 'nome',
                        label: 'Nome',
                        el: $(':input[name=nome]'),
                        type: 'text',
                        required: true
                    },
                    {
                        name: 'status',
                        label: 'Status',
                        el: $(':input[name=status]'),
                        type: 'select',
                        required: true,
                        options: [
                            {id: 1, label: 'Ativo'},
                            {id: 2, label: 'Inativo'}
                        ]
                    }
                ],
                submit: function() {
                    if (this.validate()) {
                        var voGrupoUsuarios = new GrupoUsuarios(this.items.toJSON());
                        voGrupoUsuarios.save(null, {
                            error: function(model, result) {
                                w2alert(result.responseText, 'Erro!');
                            },
                            success: function(model) {
                                if (!that.request.grupoUsuarios) {
                                    w2ui['menu-left'].get('admin/grupo-usuarios').count++;
                                    w2ui['menu-left'].refresh();
                                }
                                w2ui['menu-left'].click('admin/grupo-usuarios/relatorio');
                                w2alert('Grupo de Usuários ' + model.get('nome') + ' salvo com sucesso.', 'Sucesso!');
                            }
                        });
                    }
                }
            });

            return that;
        }
    };
});