define(['view'], function () {
    return {
        'request': {},
        'init': function (options) {
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
                nodes: [
                    {
                        id: 'level-1',
                        text: 'Home',
                        img: 'icon-folder',
                        expanded: true,
                        group: true,
                        nodes: [
                            {
                                id: 'level-1-1',
                                text: 'Segunda Tela',
                                icon: 'fa fa-home',
                                url: 'admin/index/segunda-tela'
                            },
                            {
                                id: 'level-1-2',
                                text: 'Terceira Tela',
                                icon: 'fa fa-star',
                                url: 'admin/index/terceira-tela'
                            }
                        ]
                    },
                    {
                        id: 'level-2',
                        text: 'Level 2',
                        img: 'icon-folder',
                        expanded: true,
                        group: true,
                        nodes: [
                            {
                                id: 'level-2-1',
                                text: 'Level 2.1',
                                img: 'icon-folder',
                                count: 3,
                                nodes: [
                                    {
                                        id: 'level-2-1-1',
                                        text: 'Level 2.1.1',
                                        icon: 'fa fa-star-o'
                                    },
                                    {
                                        id: 'level-2-1-2',
                                        text: 'Level 2.1.2',
                                        icon: 'fa fa-star-o',
                                        count: 67
                                    },
                                    {
                                        id: 'level-2-1-3',
                                        text: 'Level 2.1.3',
                                        icon: 'fa fa-star-o'
                                    }
                                ]
                            },
                            {
                                id: 'level-2-2',
                                text: 'Level 2.2',
                                icon: 'fa fa-star-o'
                            },
                            {
                                id: 'level-2-3',
                                text: 'Level 2.3',
                                icon: 'fa fa-star-o'
                            }
                        ]
                    }
                ],
                onClick: function (event) {
                    if(event.node.url) {
                        Router.go(event.node.url);
                    }
                }
            });
            return this;
        }
    };
});