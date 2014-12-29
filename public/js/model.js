define(['backbone'], function(Backbone) {
    var Model = Backbone.Model.extend({
        'el': null,
        'urlRoot': null
    });
    return Model;
});