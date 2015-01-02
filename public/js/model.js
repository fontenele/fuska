define(['backbone'], function(Backbone) {
    var Model = Backbone.Model.extend({
        'el': null,
        'urlRoot': null,
        'delete': function(options) {
            var _url = this.urlRoot;
            this.urlRoot+= '/id/';
            this.destroy(options);
            this.urlRoot = _url;
        }
    });
    return Model;
});