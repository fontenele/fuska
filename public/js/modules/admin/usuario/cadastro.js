define(['js/models/admin/Usuario'], function(Usuario) {
    return {
        'request': {},
        'init': function(options) {
            var that = this;
            if (w2ui['form-cadastro-usuario']) {
                w2ui['form-cadastro-usuario'].destroy();
            }
            $('#usuario-cadastro-main .form').w2form({
                name: 'form-cadastro-usuario',
                header: 'Cadastro de Usuário',
                formHTML: '',
                isGenerated: true,
                fields: [
                    {name: 'login', type: 'text', required: true},
                    {name: 'senha', type: 'password', required: true}
                ],
                actions: {
                    'salvar': function(e) {
                        var erros = this.validate();
                        if (erros.length > 0) {
                            return;
                        }
                        var voUsuario = new Usuario(this.record);
                        voUsuario.save(null, {
                            error: function(model, result) {
                                w2alert(result.responseText, 'Erro!');
                            },
                            success: function(model) {
                                if (!that.request.usuario) {
                                    w2ui['menu-left'].get('admin/usuario').count++;
                                    w2ui['menu-left'].refresh();
                                }
                                w2ui['menu-left'].click('admin/usuario/relatorio');
                                w2alert('Usuário ' + model.get('login') + ' salvo com sucesso.', 'Sucesso!');
                            }
                        });
                    }
                }
            });

            if (that.request.usuario) {
                w2ui['form-cadastro-usuario'].record = that.request.usuario;
                w2ui['form-cadastro-usuario'].refresh();
            }

            $('#usuario-cadastro-main .form').removeClass('w2ui-reset');

            return this;
        }
    };
});