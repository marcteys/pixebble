var Pixebble = {

	options : null,
	dropzone: null,
	activeWatch : null,
	ditherAlgorithm : "nearest",

	init: function(settings) {
		GlobalDebug(settings.debug);
		console.log("Pixebble: init");
		var that = this;
		this.options = settings;
		templates.loadTemplates(['watch'], function() {
			that.addTemplate();
		});
	},

	addTemplate: function(){
		var that = this;
		this.options.watches.forEach(function(data, index) {
			console.log("Template: Set template for element '" + data.name + "'");
			var $watchTemplate = $(templates.get("watch", data));
			if(data.active) activeWatch = $watchTemplate;
			that.options.watchzone.append($watchTemplate);
			$watchTemplate[0].addEventListener("click", function() {
				that.clickWatch(event, this);
			}, false);
		});
		this.initDropzone();
	},

	clickWatch: function(event, element) {
		if(activeWatch.get(0) === $(element).get(0)) $('.trigger').click();
		activeWatch.removeClass("active");
		$(element).addClass('active');
		activeWatch = $(element);

		if(this.dropzone !== null) {
			this.dropzone.previewsContainer = activeWatch.find(".preview-zone")[0];
			this.dropzone.options.thumbnailWidth = parseInt(activeWatch.data("thumbnail-width"));
			this.dropzone.options.thumbnailHeight = parseInt(activeWatch.data("thumbnail-height"));
		} 
	},

	initDropzone : function() {
		console.log("Dropzone: init");
		var that = this;
		var dropzoneOptions = {
			previewTemplate : '<div class="dz-image-preview"><img data-dz-thumbnail src="" /></div>',
			thumbnailWidth : 180,
			thumbnailHeight : 180,
			maxFilesize : 1,
			parallelUploads : 1,
			clickable : '.trigger',
			dictDefaultMessage : "Drop ici mec",
			url: "app/controllers/upload.php", 
			resize: function(file) {
				var resizeInfo = {
					srcX: 0,
					srcY: 0,
					trgX: 0,
					trgY: 0,
					srcWidth: file.width,
					srcHeight: file.height,
					trgWidth: this.options.thumbnailWidth,
					trgHeight: parseInt(this.options.thumbnailWidth * file.height / file.width)
				};

				var imageRatio = file.width / file.height;
				var targetRadio = this.options.thumbnailWidth / this.options.thumbnailHeight;
				if(imageRatio !== targetRadio) {
					console.log("dropzone: remove file", imageRatio, targetRadio);
					file.status = "lol";
					this.removeFile(file);
				}
				return resizeInfo;
			}
		};

		this.dropzone = new Dropzone(".dropzone", dropzoneOptions);
		this.dropzone.previewsContainer = activeWatch.find(".preview-zone")[0];
		this.bindDropZoneEvents();
	},

	bindDropZoneEvents : function() {
		var that = this;
		this.dropzone.on("drop", function(file) {
			console.log("Dropzone: drop");
			$('.dropzone').css({"z-index": "3" });
			activeWatch.find('.preview-zone').removeClass('active');
		});
		this.dropzone.on("dragenter", function() {
			console.log("Dropzone: dragenter");
			$('.dropzone').css({"z-index": "10" });
			activeWatch.find('.preview-zone').addClass('active');
		});
		this.dropzone.on("dragleave", function() {
			console.log("Dropzone: dragleave");
			$('.dropzone').css({"z-index": "3" });
			activeWatch.find('.preview-zone').removeClass('active');
		});
		this.dropzone.on("canceled", function() {
			console.log("Dropzone: canceled");
		});
		this.dropzone.on("error", function() {
			console.log("Dropzone: Error when adding file");
		});
		this.dropzone.on("complete", function() {
			console.log("Dropzone: Upload successfull");
		});
		this.dropzone.on("sending", function(file) { //addedfile or //complete
			console.log("Dropzone: File added with the status ", file.status);
			 if(file.status === "error") {
			 	return;
			 }
			 var returnedElem = $(file.previewElement);
			 if($(that.dropzone.previewsContainer).children().length > 1)
				$(that.dropzone.previewsContainer).children().first().remove()
			var options = {
				"step": 1,
				"algorithm": that.ditherAlgorithm, // nearest // ordered // atkinson // errorDiffusion
				"className": "dithered",
				"palette": pebbleColors()
			};
			if(activeWatch.data('title') == "pog") options.palette = [[0,0,0],[255,255,255]];
			that.ditherImage(returnedElem.find('img'), options);
		});
	},

	ditherImage : function(element, options) {
		var that = this;
		new DitherJS(element.get(0), options, that.postImage);
	},

	postImage: function(dataUrl) {
		$.ajax({
			  type: "POST",
			  url: "app/controllers/upload.php",
			  data: { 
				 imgBase64: dataUrl
			  }
			});
	}

};