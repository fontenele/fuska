define(['js/models/admin/Usuario', 'backbone'], function (Usuario, Backbone) {
//    var File = Backbone.Model.extend({});
//    var fileCollection = Backbone.Collection.extend({
//        model: File
//    });
//    var cssCollection = new fileCollection();
//    cssCollection.on('remove', function (model, collection, options) {
//        if(collection.where({file: model.get('file')}).length === 0) {
//            
//        }
//        $.log('REMOVER!!! ', collection.length);
//
//    });
//    // Router.go('admin/index/index')
//    cssCollection.add([
//        {url: 'admin/index/index', file: 'arquivo1.css'},
//        {url: 'admin/index/index', file: 'arquivo4.css'},
//        {url: 'admin/index/index', file: 'arquivo6.css'}
//    ]);
//    // Router.go('admin/usuario/index')
//    cssCollection.add([
//        {url: 'admin/usuario/index', file: 'arquivo1.css'},
//        {url: 'admin/usuario/index', file: 'arquivo4.css'},
//        {url: 'admin/usuario/index', file: 'arquivo5.css'}
//    ]);
//
//
//
//    $.log(cssCollection, cssCollection.remove(cssCollection.where({url: 'admin/usuario/index'})));


    return {
        'request': {},
        'init': function (options) {
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
                    {field: 'login', caption: 'Login', size: '75%'},
                    {field: 'ultimoLogin', caption: 'Últ. Login', size: '20%', attr: "align=center", render: 'datetime'}
                ],
                searches: [
                    {type: 'int', field: 'id', caption: 'ID'},
                    {type: 'text', field: 'login', caption: 'Login'},
                    {type: 'text', field: 'senha', caption: 'Senha'},
                    {type: 'text', field: 'ultimoLogin', caption: 'Últ. Login'}
                ],
                records: this.request.list,
                onAdd: function (event) {
                    w2ui['menu-left'].click('admin/usuario/cadastro');
                },
                onEdit: function (event) {
                    w2ui['menu-left'].click('admin/usuario/cadastro', {
                        data: {id: event.recid}
                    });
                    $.info('ABRIR EDIÇÃO/CADASTRO', event.recid);
                },
                onDelete: function (event) {
                    var selected = this.getSelection().shift();
                    event.onComplete = function (event) {
                        var usuario = new Usuario({id: selected});
                        $.info('APAGAR DO BANCO', usuario);
                        usuario.delete({
                            success: function (model) {
                                w2ui['menu-left'].get('admin/usuario').count--;
                                w2ui['menu-left'].refresh();
                                w2alert('Usuário excluído com sucesso.', 'Sucesso!');
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