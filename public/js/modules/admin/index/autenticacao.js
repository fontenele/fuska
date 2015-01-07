define(['js/models/admin/Usuario'], function(Usuario) {
    return {
        'request': {},
        'init': function(options) {
            var that = this;
            Layout.hide('left');
            Layout.hide('top');
            Layout.hide('right');
            Layout.hide('bottom');
            if (w2ui['form-admin-index-autenticacao']) {
                w2ui['form-admin-index-autenticacao'].destroy();
            }
            $('#admin-index-autenticacao-main .form').w2form({
                name: 'form-admin-index-autenticacao',
                header: 'Faça o login',
                formHTML: '',
                isGenerated: true,
                fields: [
                    {name: 'login', type: 'text', required: true},
                    {name: 'senha', type: 'password', required: true}
                ],
                actions: {
                    'enviar': function(e) {
                        var erros = this.validate();
                        if (erros.length > 0) {
                            return;
                        }
                        var voUsuario = new Usuario(this.record);
                        if(voUsuario.autenticar()) {
                            Router.logged = true;
                            Router.go('main/index/index');
                        } else {
                            w2alert('Usuário/Login inválido.', 'Falha na autenticação!');
                        }
                    }
                }
            });

            if (that.request.usuario) {
                w2ui['form-admin-index-autenticacao'].record = that.request.usuario;
                w2ui['form-admin-index-autenticacao'].refresh();
            }

            $('#admin-index-autenticacao-main .form').removeClass('w2ui-reset');

            return this;
        }
    };
});