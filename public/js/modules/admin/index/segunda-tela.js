define(['view'], function() {
    return {
        'request': {},
        'init': function(options) {
            $('#segunda-tela').render(this.request);
            //console.log(this.request.dadosPessoais);
            return this;
        }
    };
});