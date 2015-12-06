var templates = {

    templates:{},

    loadTemplates:function (names, callback) {

        var that = this;

        var loadTemplate = function (index) {
            var name = names[index];
            $.get('app/templates/' + name + '.html', function (data) {
                that.templates[name] = data;
                console.log('Loading template: ' + name);
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

        if(typeof data !== 'undefined') {
          for(var i=0;i<data.length;i++){
            var obj = data[i];
            //extract each value and attribute the 
            for(var key in obj)
            {
              var attrName = key;
              var attrValue = obj[key];
         
              if(typeof attrValue === 'string')  // if it's a single element (update the home page etc)
              {
                var reg = new RegExp('\{\{\\s*'+attrName+'\\s*\}\}', 'g');
               // htmlTemplate = reg.exec(htmlTemplate, attrValue);
                htmlTemplate = htmlTemplate.replace(reg, attrValue);
              }
            }

              var reg = new RegExp('\{\{\\s*.\\s*\}\}', 'g');
               // htmlTemplate = reg.exec(htmlTemplate, attrValue);
                htmlTemplate = htmlTemplate.replace(reg, attrValue);
          }
        }

        return htmlTemplate;
    }

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