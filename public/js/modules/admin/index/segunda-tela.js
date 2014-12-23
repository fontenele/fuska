define(['view', 'mustache'], function (View, Mustache) {
    var view = View.extend({
        el: $('#segunda-tela'),
        template: $('#segunda-tela').html(),
        initialize: function () {
            this.render();
        },
        render: function () {
            $(this.el).html(Mustache.to_html(this.template, {'name': 'Teste', 'input-type': 'text', 'input-name': 'nm-usuario'}));
        }
    });

    return {
        'view': new view,
        'init': function (options) {
            return this;
        }
    };
});