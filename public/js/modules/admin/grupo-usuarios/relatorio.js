define(['js/models/admin/GrupoUsuarios', 'backbone'], function (GrupoUsuarios, Backbone) {
    return {
        'request': {},
        'init': function (options) {
            if (w2ui['grid-relatorio-grupo-usuarios']) {
                w2ui['grid-relatorio-grupo-usuarios'].destroy();
            }
            $('#grupo-usuarios-relatorio-main .grid').w2grid({
                name: 'grid-relatorio-grupo-usuarios',
                header: 'Relatório de Grupos de Usuários',
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
                    {field: 'nome', caption: 'Nome', size: '75%'},
                    {field: 'status', caption: 'Status', size: '20%', attr: "align=center"}
                ],
                searches: [
                    {type: 'int', field: 'id', caption: 'ID'},
                    {type: 'text', field: 'nome', caption: 'Nome'},
                    {type: 'text', field: 'status', caption: 'Status'}
                ],
                records: this.request.list,
                onAdd: function (event) {
                    w2ui['menu-left'].click('admin/grupo-usuarios/cadastro');
                },
                onEdit: function (event) {
                    w2ui['menu-left'].click('admin/grupo-usuarios/cadastro', {
                        data: {id: event.recid}
                    });
                },
                onDelete: function (event) {
                    var selected = this.getSelection().shift();
                    event.onComplete = function (event) {
                        var usuario = new GrupoUsuarios({id: selected});
                        usuario.delete({
                            success: function (model) {
                                w2ui['menu-left'].get('admin/grupo-usuarios').count--;
                                w2ui['menu-left'].refresh();
                                w2alert('Grupo de Usuários excluído com sucesso.', 'Sucesso!');
                            },
                            error: function (model, result) {
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