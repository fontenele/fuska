define(['js/models/admin/GrupoUsuarios'], function(GrupoUsuarios) {
    return {
        'request': {},
        'init': function(options) {
            var that = this;
            if (w2ui['form-cadastro-grupo-usuarios']) {
                w2ui['form-cadastro-grupo-usuarios'].destroy();
            }
            $('#grupo-usuarios-cadastro-main .form').w2form({
                name: 'form-cadastro-grupo-usuarios',
                header: 'Cadastro de Grupo de Usuários',
                formHTML: '',
                isGenerated: true,
                fields: [
                    {name: 'nome', type: 'text', required: true},
                    {name: 'status', type: 'text', required: true}
                ],
                actions: {
                    'salvar': function(e) {
                        var erros = this.validate();
                        if (erros.length > 0) {
                            return;
                        }
                        var voGrupoUsuarios = new GrupoUsuarios(this.record);
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

            if (that.request.grupoUsuarios) {
                w2ui['form-cadastro-grupo-usuarios'].record = that.request.grupoUsuarios;
                w2ui['form-cadastro-grupo-usuarios'].refresh();
            }

            $('#usuario-cadastro-main .form').removeClass('w2ui-reset');

            return this;
        }
    };
});