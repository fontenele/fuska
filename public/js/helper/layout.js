var Layout;
define(function () {
    if (Layout) {
        return Layout;
    }
    
    w2utils.locale(jsBasePath + 'vendor/w2ui/locale/pt-br.json')

    var pstyle = 'border: 1px solid #dfdfdf; padding: 6px;';
    $('#layout').w2layout({
        name: 'layout',
        panels: [
            {type: 'top', size: '66px', resizable: false, hidden: true, style: pstyle, content: ''},
            {type: 'left', size: '20%', resizable: true, hidden: true, style: pstyle, content: ''},
            {type: 'main', style: pstyle, hidden: true, content: ''},
            {type: 'preview', size: '50%', resizable: true, hidden: true, style: pstyle, content: ''},
            {type: 'right', size: '20%', resizable: true, hidden: true, style: pstyle, content: ''},
            {type: 'bottom', size: '0%', resizable: true, hidden: true, style: pstyle, content: ''}
        ]
    });
    
    $(document).on('click', '.layout-toggle-left', function() {
        w2ui.layout.toggle('left');
        return false;
    });
    $(document).on('click', '.layout-toggle-top', function() {
        w2ui.layout.toggle('top');
        return false;
    });

    Layout = w2ui.layout;
    return Layout;
});