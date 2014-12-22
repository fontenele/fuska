define(['backbone'], function (Backbone) {
    return {
        'initWithModel': function (model) {
            var _tmp = new model;
            var _collection = Backbone.Collection.extend({
                model: model,
                url: _tmp.urlRoot
            });
            delete(_tmp);
            return new _collection;
        }
    };
});