var Pixebble = {

	options : null,

	init: function(settings) {
		GlobalDebug(settings.debug);
		console.log("Pixebble: init");
		var that = this;
		this.options = settings;
		Templates.loadTemplates(['watch', 'tip'], function() {
			that.addTemplate();
		});
		UsersManager.init();
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
	},

	displayTip: function(data) {
		var removeDelay = data.delay || 4500;
		var $tipTemplate = $(Templates.get("tip", data));
		this.options.mainContainer.append($tipTemplate);

		$tipTemplate.click(function() {
			$tipTemplate.removeClass("active");
				setTimeout(function(){
					$tipTemplate.remove();
				},400);
		});
		setTimeout(function(){
			$tipTemplate.addClass("active");
			setTimeout(function(){
				$tipTemplate.removeClass("active");
				setTimeout(function(){
					$tipTemplate.remove();
				},400);
			},removeDelay);
		},100);
	}
};