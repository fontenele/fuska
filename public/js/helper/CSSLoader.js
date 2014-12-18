define(function () {
    var addCssFile = function (url) {
        var link = document.createElement("link");
        link.type = "text/css";
        link.rel = "stylesheet";
        link.href = url;
        $(link).attr('data-tela', true);
        document.head.appendChild(link);
    };

    var addCss = function (css) {
        if (typeof css === 'object') {
            $.each(css, function (i, _css) {
                addCssFile(_css);
            });
        } else {
            addCssFile(css);
        }
    };

    return {
        'addCss': addCss
    };
});