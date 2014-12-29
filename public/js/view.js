var Renderer;
define(['backbone', 'mustache', 'jquery'], function(Backbone, Mustache) {
    if (Renderer) {
        return Renderer;
    }
    Renderer = Mustache;
    $.fn.render = function(data) {
        var _tpl = this.html();
        Renderer.parse(_tpl);
        this.html(Renderer.render(_tpl, data));
    };
    return Renderer;
});