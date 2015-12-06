var templates = {

    templates:{},

    loadTemplates:function (names, callback) {

        var that = this;

        var loadTemplate = function (index) {
            var name = names[index];
            $.get('app/templates/' + name + '.html', function (data) {
                that.templates[name] = data;
                console.log('Template: Loading template: ' + name);
                index++;
                if (index < names.length) {
                    loadTemplate(index);
                } else {
                   if(typeof callback !== "undefined") callback();
                }
            });
        }
        loadTemplate(0);
    },

    get:function (name, data) {
        var htmlTemplate = this.templates[name];

        // Inject template in {{}}
        if(typeof data !== 'undefined') {
            for(var key in data)
            {
              var attrName = key;
              var attrValue = data[key];
              if(typeof attrValue === 'string' || typeof attrValue === 'number') 
              {
                var reg = new RegExp('\{\{\\s*'+attrName+'\\s*\}\}', 'g');
                htmlTemplate = htmlTemplate.replace(reg, attrValue);
              }
            }
            //Remove all unused {{}}
            var reg = new RegExp('\{\{\\s*(.*)\\s*\}\}', 'g');
            htmlTemplate = htmlTemplate.replace(reg, '');
        }
        return htmlTemplate;
    },

};  


var GlobalDebug = (function () {
    var savedConsole = console;
    return function(debugOn,suppressAll){
        var suppress = suppressAll || false;
        if (debugOn === false) {
            console = {};
            console.log = function () { };
            if(suppress) {
                console.info = function () { };
                console.warn = function () { };
                console.error = function () { };
            } else {
                console.info = savedConsole.info;
                console.warn = savedConsole.warn;
                console.error = savedConsole.error;              
            }
        } else {
            console = savedConsole;
        }
    }
})();