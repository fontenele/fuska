define(['backbone', 'collection', 'js/models/User'], function (Backbone, Collection, UserModel) {
    
    
    var go = function (url, target) {
        require([
            'text!' + basePath + url + '?type=html&t=' + (new Date()).getTime(),
            'json!' + basePath + url + '?type=json&t=' + (new Date()).getTime(),
            'cssLoader'
        ], function (html, json, cssLoader) {
            if (target) {
                Layout.content(target, html);
            } else {
                var _user = new UserModel;
                var _user1 = new UserModel;
                var _user2 = new UserModel;
                _user2.set('username', 'xereka');
                _user2.set('password', 444);
//                console.info('antes fetch');
//                _user2.save();
//                console.info('depois fetch');

//                var _users = Collection.initWithModel(UserModel);
//                _users.comparator = function (post) {
//                    return post.get('username');
//                };
//                _users.add([{'username': 'Guilherme Fontenele', 'password': '12121212'}, {'username': 'Calixto Jorge', 'password': '121234324231212'}, {'username': 'Lucas Euripedes', 'password': '654654645'}]);
//                var _pluck = _users.pluck('password');
//                console.log(_users.toJSON());
                
                
                
                
                var _users = Collection.initWithModel(UserModel);
                _users.create(_user2);
                //console.log(_users, _users.toJSON());
                //_users.add({'teste': 124});
                //console.log('1212',Collection, _users, JSON.stringify(_users));
//                $('#cache .html').html(html);
//                $.each($('#cache .html').find('[data-block-target]'), function () {
//                    Layout.content($(this).data('block-target'), $(this).html());
//                });
//                $('#cache .html').empty();
            }
            for (var i = 0, l = json.files.js.length; i < l; i++) {
                if (require.defined(json.files.js[i])) {
                    require.undef(json.files.js[i]);
                }
            }

            $('head link[data-tela]').remove();
            cssLoader.addCss(json.files.css, true);

            require(json.files.js, function (objTela) {
                if (objTela.init && typeof objTela.init === 'function') {
                    objTela.init();
                }
            });
        });
    };

    return {
        'go': go
    };

});