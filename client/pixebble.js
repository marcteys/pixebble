var Pixebble = {

	options : null,

	init: function(settings) {
		GlobalDebug(settings.debug);
		console.log("Pixebble: init");
		var that = this;
		this.options = settings;
		Templates.loadTemplates(['watch', 'tip', 'galleryElement', 'help'], function() {
			that.addTemplate();
			Gallery.getImages(UsersManager.getLocalUserId());
			UsersManager.init();
		});
	},

	addTemplate: function() {
		var that = this;
		this.options.watches.forEach(function(data, index) {
			console.log("Template: Set template for element '" + data.name + "'");
			var $watchTemplate = $(Templates.get("watch", data));
			if(data.active) ImagesUpload.activeWatch = $watchTemplate;
			that.options.watchzone.append($watchTemplate);
			$watchTemplate[0].addEventListener("click", function() {
				ImagesUpload.clickWatch(event, this);
			}, false);
		});
		ImagesUpload.init();
		Help.init(".corner-info");
	},

};