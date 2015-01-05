define(['view'], function () {
    return {
        'request': {},
        'init': function (options) {
            var that = this;
            $('#app-top').render(this.request);
            $('#app-main').render(this.request);
            Layout.show('top', true);
            Layout.show('left', true);

            //$('#some-input').w2tag('Short Message')
            if (w2ui['menu-left']) {
                w2ui['menu-left'].destroy();
            }
            $('#app-left').w2sidebar({
                name: 'menu-left',
                topHTML: '<a class="layout-toggle-top pull-right btn btn-default btn-xs" href="#">Mostrar/Esconder Topo</a>',
                nodes: [
                    {
                        id: 'admin',
                        text: 'Administração',
                        img: 'icon-folder',
                        expanded: true,
                        group: true,
                        nodes: [
                            {
                                id: 'admin/usuario',
                                text: 'Usuários',
                                img: 'icon-folder',
                                expanded: true,
                                count: this.request.totals.usuarios,
                                nodes: [
                                    {
                                        id: 'admin/usuario/cadastro',
                                        text: 'Cadastro',
                                        url: 'admin/usuario/cadastro',
                                        icon: 'fa fa-star-o'
                                    },
                                    {
                                        id: 'admin/usuario/relatorio',
                                        text: 'Relatório',
                                        icon: 'fa fa-star-o',
                                        url: 'admin/usuario/relatorio'
                                    }
                                ]
                            },
                            {
                                id: 'admin/grupo-usuarios',
                                text: 'Grupos de Usuários',
                                img: 'icon-folder',
                                expanded: true,
                                count: this.request.totals.grupoUsuarios,
                                nodes: [
                                    {
                                        id: 'admin/grupo-usuarios/cadastro',
                                        text: 'Cadastro',
                                        url: 'admin/grupo-usuarios/cadastro',
                                        icon: 'fa fa-star-o'
                                    },
                                    {
                                        id: 'admin/grupo-usuarios/relatorio',
                                        text: 'Relatório',
                                        url: 'admin/grupo-usuarios/relatorio',
                                        icon: 'fa fa-star-o'
                                    }
                                ]
                            }
                        ]
                    }
                ],
                onClick: function (event) {
                    if (event.node.url) {
                        var target, data = event.originalEvent && event.originalEvent.data ? event.originalEvent.data : {};
                        Router.go(event.node.url, target, data);
                    }
                }
            });
            return this;
        }
    };
});