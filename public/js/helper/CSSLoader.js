var cssLoader;
define(function () {
    var addCssFile = function (url, cssDeTela) {
        var link = document.createElement("link");
        link.type = "text/css";
        link.rel = "stylesheet";
        link.href = url + "?v=" + version;
        if (cssDeTela === true) {
            $(link).attr('data-tela', true);
        }
        document.head.appendChild(link);
    };

    var addCss = function (css, cssDeTela) {
        if (typeof css === 'object') {
            $.each(css, function (i, _css) {
                addCssFile(_css, cssDeTela);
            });
        } else {
            addCssFile(css, cssDeTela);
        }
    };
    
    cssLoader = {
            addCss: addCss,
            addCssFile: addCssFile
    };

    return cssLoader;
});