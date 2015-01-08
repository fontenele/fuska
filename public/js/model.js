define(['backbone'], function(Backbone) {
    var Model = Backbone.Model.extend({
        'el': null,
        'urlRoot': null,
        'json': function() {
            var that = this;
            $.each(this.attributes, function(index, val) {
                if (val && typeof (val) === 'object' && val.toJSON && typeof (val.toJSON) === 'function') {
                    that.set(index, val.toJSON());
                }
            });
            return this.toJSON();
        },
        'delete': function(options) {
            var _url = this.urlRoot;
            this.urlRoot += '/id/';
            this.destroy(options);
            this.urlRoot = _url;
        }
    });
    return Model;
});