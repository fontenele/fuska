define(['mk'], function(mk) {
    if (!MK) {
        MK = mk;
    }

    var form = Backbone.Model.extend({
        el: null,
        items: new MK(),
        mapItems: new Backbone.Collection(),
        submitButton: null,
        action: basePath,
        method: 'POST',
        data: {},
        constructor: function(options) {
            var that = this;
            that.el = options.el;
            that.action = options.action ? options.action : that.action;
            that.method = options.method ? options.method : that.method;
            that.submit = options.submit ? options.submit : that.submit;
            that.mapItems = new Backbone.Collection();
            that.data = options.data ? options.data : that.data;
            that.items = new MK();
            that.items.toJSON = function() {
                var json = {};
                that.mapItems.each(function(item) {
                    json[item.get('name')] = that.items.get(item.get('name'));
                });
                return json;
            };
            if (typeof (options.items) === 'object') {
                $.each(options.items, function(i, item) {
                    that.createItem(item);
                });
            }
            $.each(that.data, function(i, item) {
                that.items.set(i, item);
            });
            that.el.on('submit', function() {
                that.submit();
                return false;
            });
            that.el.find('[data-form-submit]').on('click', function() {
                that.submit();
                return false;
            });
        },
        validate: function() {
            var that = this;
            var success = true;
            var msgError = '';
            that.mapItems.each(function(item) {
                var _item = that.items.bound(item.get('name'));
                var _val = that.items.get(item.get('name'));
                if (item.get('required') === true && _val === '') {
                    $(_item).closest('.form-item').addClass('has-error');
                    success = false;
                    msgError+= '<strong>' + item.get('label') + '</strong>: Campo obrigatório<br />';
                } else {
                    $(_item).closest('.form-item').removeClass('has-error');
                }
            });
            
            if(msgError !== '') {
                w2alert('<h4>Atenção!</h4>' + msgError, 'Erro!');
            }
            return success;
        },
        submit: function() {
            if (this.validate()) {
                $.log('submit');
            }
        },
        success: function() {
            $.log('success');
        },
        error: function() {
            $.log('error');
        },
        createItem: function(item) {
            var that = this;
            switch (item.type) {
                case 'text':
                case 'hidden':
                    that.items.unbindElement(item.name, item.el);
                    that.items.bindElement(item.name, item.el);
                    break;
                case 'select':
                case 'combo':
                    item.el.empty().append('<option value="">Selecione</option>');
                    $.each(item.options, function(i, option) {
                        item.el.append('<option value="' + option.id + '">' + option.label + '</option>');
                    });
                    that.items.unbindElement(item.name, item.el);
                    that.items.bindElement(item.name, item.el);
                    break;
            }
            that.mapItems.add(item);
        }
    });

    return form;
});