define(['backbone'], function (Backbone) {
    var UserModel = Backbone.Model.extend({
        'urlRoot': 'admin/index/segunda-tela',
        'defaults': {
            'username': '',
            'password': '123456'
        }
    });
    return UserModel;
});