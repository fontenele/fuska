var x, b;
define(['jquery'], function($) {
    if (x) {
        return x;
    }
    if (!window.console) {
        console = {
            log: function(args) {
                alert(args);
            },
            warn: function(args) {
                alert(args);
            },
            info: function(args) {
                alert(args);
            },
            debug: function(args) {
                alert(args);
            },
            error: function(args) {
                alert(args);
            },
            time: function(args) {
                alert(args);
            },
            timeEnd: function(args) {
                alert(args);
            }
        };
    }
    /**
     * Debug
     */
    $.log = function() {
        if (window['console'] && window['console'].log) {
            return console.log(arguments.length == 1 ? arguments[0] : arguments);
        } else {
            var args = '';
            for (x in arguments) {
                args += arguments[x] + ', ';
            }
            alert(args);
        }
    };
    $.debug = function() {
        if (window['console'] && window['console'].debug) {
            return console.debug(arguments.length == 1 ? arguments[0] : arguments);
        } else {
            var args = '';
            for (x in arguments) {
                args += arguments[x] + ',';
            }
            alert(args);
        }
    };
    $.info = function() {
        if (window['console'] && window['console'].info) {
            return console.info(arguments.length == 1 ? arguments[0] : arguments);
        } else {
            var args = '';
            for (x in arguments) {
                args += arguments[x] + ',';
            }
            alert(args);
        }
    };
    $.warn = function() {
        if (window['console'] && window['console'].warn) {
            return console.warn(arguments.length == 1 ? arguments[0] : arguments);
        } else {
            var args = '';
            for (x in arguments) {
                args += arguments[x] + ',';
            }
            alert(args);
        }
    };
    $.error = function() {
        if (window['console'] && window['console'].error) {
            return console.error(arguments.length == 1 ? arguments[0] : arguments);
        } else {
            var args = '';
            for (x in arguments) {
                args += arguments[x] + ',';
            }
            alert(args);
        }
    };
    $.debugStart = function(name) {
        $.warn('Iniciando debug: ' + name);
        console.time(name);
    };
    $.debugFinish = function(name) {
        console.group(name);
        $.warn('Debug: ' + name);
        console.trace();
        console.timeEnd(name);
        console.groupEnd();
    };
    $.debugProfileStart = function() {
        $.warn('Iniciando debug profile: ' + name);
        console.profile();
    };
    $.debugProfileFinish = function() {
        console.group(name);
        $.warn('Finalizado debug profile: ' + name);
        console.profileEnd(name);
        console.groupEnd();
    };
    x = Error;
    x.prototype.log = function() {
        var line = this.lineNumber ? this.lineNumber : this.stack;
        var stackContent = this.stack.split("\n")[0].split('@');
        stackContent[1] = stackContent[1].split(':');
        stackContent[1].pop();
        line = stackContent[1].pop();
        var file = stackContent[1].join(':');
        console.group('%c' + file + ' [' + line + ']' + (stackContent[0] ? ' %c' + stackContent[0] + '()' : ''), "color: green;", stackContent[0] ? "color: blue;" : ' ');
        var _args = $.map(arguments, function(value, index) {
            return [value];
        });
        if (_args.length) {
            $.log(_args);
        }
        console.groupEnd();
    };
    x.prototype.logWithTitle = function(title) {
        var line = this.lineNumber ? this.lineNumber : this.stack;
        var stackContent = this.stack.split("\n")[0].split('@');
        stackContent[1] = stackContent[1].split(':');
        stackContent[1].pop();
        line = stackContent[1].pop();
        var file = stackContent[1].join(':');
        console.groupCollapsed('%c' + title, "color: purple;");
        var _args = $.map(arguments, function(value, index) {
            return [value];
        });
        _args.shift();
        if (_args.length) {
            $.log(_args);
        }
        console.groupEnd();
    };

    return x;
});