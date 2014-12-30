var Layout;
define(function () {
    if (Layout) {
        return Layout;
    }

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

    Layout = w2ui.layout;
    return Layout;
});