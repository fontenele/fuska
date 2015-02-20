define(['js/models/admin/Usuario', 'backbone'], function(Usuario, Backbone) {
    return {
        'request': {},
        'init': function(options) {
            var _gruposUsuariosTmp = this.request.gruposUsuarios, gruposUsuarios = [];
            $.each(_gruposUsuariosTmp, function(i, item) {
                gruposUsuarios[gruposUsuarios.length] = {id: item.id + "", text: item.nome};
            });
            if (w2ui['grid-relatorio-usuarios']) {
                w2ui['grid-relatorio-usuarios'].destroy();
            }
            $('#usuario-relatorio-main .grid').w2grid({
                name: 'grid-relatorio-usuarios',
                header: 'Relatório de Usuários',
                reorderColumns: false,
                show: {
                    header: true,
                    toolbar: true,
                    toolbarAdd: true,
                    toolbarEdit: true,
                    toolbarDelete: true,
                    footer: true,
                    lineNumbers: false,
                    selectColumn: false,
                    expandColumn: false
                },
                columns: [
                    {field: 'id', caption: 'ID', size: '5%', attr: "align=center", hidden: true},
                    {field: 'login', caption: 'Login', size: '20%'},
                    {field: 'nome', caption: 'Nome', size: '35%'},
                    {field: 'grupoUsuarios.id', hidden: true, caption: 'Grupo Usuários #', size: '20%'},
                    {field: 'grupoUsuarios.nome', caption: 'Grupo Usuários', size: '20%'},
                    {field: 'ultimoLogin', caption: 'Últ. Login', size: '20%', attr: "align=center",
                        render: function(item) {
                            return item.ultimoLogin;
                        }
                    }
                ],
                searches: [
                    {field: 'id', type: 'int', caption: 'ID'},
                    {field: 'login', type: 'text', caption: 'Login'},
                    {field: 'nome', type: 'text', caption: 'Nome'},
                    {field: 'grupoUsuarios.id', type: 'list', caption: 'Grupo Usuários', options: {
                            items: gruposUsuarios
                        }},
                    {field: 'senha', type: 'text', caption: 'Senha'},
                    {field: 'ultimoLogin', type: 'text', caption: 'Últ. Login'}
                ],
                records: this.request.list,
                onAdd: function(event) {
                    w2ui['menu-left'].click('admin/usuario/cadastro');
                },
                onEdit: function(event) {
                    w2ui['menu-left'].click('admin/usuario/cadastro', {
                        data: {id: event.recid}
                    });
                },
                onDelete: function(event) {
                    var selected = this.getSelection().shift();
                    event.onComplete = function(event) {
                        var usuario = new Usuario({id: selected});
                        usuario.delete({
                            success: function(model) {
                                w2ui['menu-left'].get('admin/usuario').count--;
                                w2ui['menu-left'].refresh();
                                w2alert('Usuário excluído com sucesso.', 'Sucesso!');
                            },
                            error: function(model, result) {
                                w2alert(result.responseText, 'Erro!');
                            }
                        });
                    };
                }
            });

            return this;
        }
    };
});