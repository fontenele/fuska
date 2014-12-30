define(['view'], function () {
    return {
        'request': {},
        'init': function (options) {
            $('#segunda-tela-main').render(this.request);
            if (Layout.get('left').hidden) {
                Layout.show('left');
            }
            return this;
        }
    };
});