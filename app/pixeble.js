var Pixeble = {

	options : null,
	dropzone: null,

	init: function(settings) {
		GlobalDebug(settings.debug);
		console.log("Pixeble init() ");
		var that = this;
		this.options = settings;
		templates.loadTemplates(['watch'], function() {
			that.addTemplate();
		});
	},

	addTemplate: function(){
		var that = this;
		this.options.watches.forEach(function(element, index) {
			console.log("addTemplate to page : " + element);
			var watchTemplate = templates.get("watch", [{"name":element}]);
			that.options.watchzone.append(watchTemplate);
		});
	},

	bind: function() {

	}

};