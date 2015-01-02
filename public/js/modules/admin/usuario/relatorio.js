define(['js/models/admin/Usuario'], function(Usuario) {
    return {
        'request': {},
        'init': function(options) {
            if (w2ui['grid-relatorio-usuarios']) {
                w2ui['grid-relatorio-usuarios'].destroy();
            }
            $('#usuario-relatorio-main .grid').w2grid({
                name: 'grid-relatorio-usuarios',
                header: 'Relatório de Usuários',
                reorderColumns: true,
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
                    {field: 'login', caption: 'Login', size: '40%'},
                    {field: 'senha', caption: 'Senha', size: '30%'},
                    {field: 'ultimoLogin', caption: 'Últ. Login', size: '120px', attr: "align=center", render: 'date'}
                ],
                searches: [
                    {type: 'int', field: 'id', caption: 'ID'},
                    {type: 'text', field: 'login', caption: 'Login'},
                    {type: 'text', field: 'senha', caption: 'Senha'},
                    {type: 'date', field: 'ultimoLogin', caption: 'Últ. Login'}
                ],
                records: this.request.list,
                onAdd: function(event) {
                    w2ui['menu-left'].click('admin/usuario/cadastro');
                },
                onEdit: function(event) {
                    w2ui['menu-left'].click('admin/usuario/cadastro', {
                        data: {id: event.recid}
                    });
                    $.info('ABRIR EDIÇÃO/CADASTRO', event.recid);
                },
                onDelete: function(event) {
                    var selected = this.getSelection().shift();
                    event.onComplete = function(event) {
                        var usuario = new Usuario({id: selected});
                        $.info('APAGAR DO BANCO', usuario);
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