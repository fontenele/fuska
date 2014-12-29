var Renderer;
define(['backbone', 'mustache', 'jquery'], function(Backbone, Mustache) {
    if (Renderer) {
        return Renderer;
    }
    Renderer = Mustache;
    $.fn.render = function(data) {
        this.html(Renderer.render(this.html(), data));
    };
    return Renderer;
});