var ImagesUpload = {

	dropzone: null,
	activeWatch: null,

	init: function(){
		this.initDropzone();
	},

	initDropzone: function() {
		console.log("Dropzone: init");
		var that = this;
		var dropzoneOptions = {
			previewTemplate: '<div class="dz-image-preview"><img data-dz-thumbnail src="" /></div>',
			thumbnailWidth: 180,
			thumbnailHeight: 180,
			maxFilesize: 1,
			parallelUploads: 1,
			clickable: '.trigger',
			dictDefaultMessage: "Drop ici mec",
			url: "server/controllers/upload.php", 
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
					console.log("Dropzone: Remove file (image ratio is " + imageRatio +" instead of "+ targetRadio + ")");
					TipManager.createTip({type:"error",icon:"×",text:"The image must be "+this.options.thumbnailWidth+"×"+this.options.thumbnailHeight+" or an equivalent ratio"});
					this.removeFile(file);
				} else {
					that.imageProcess(file);
				}
				return resizeInfo;
			}
		};

		this.dropzone = new Dropzone(".dropzone", dropzoneOptions);
		this.dropzone.previewsContainer = this.activeWatch.find(".preview-zone")[0];
		this.bindDropZoneEvents();
	},

	bindDropZoneEvents: function() {
		var that = this;
		this.dropzone.on("drop", function(file) {
			console.log("Dropzone: drop");
			$('.dropzone').css({"z-index": "3" });
			that.activeWatch.find('.preview-zone').removeClass('active');
		});
		this.dropzone.on("dragenter", function() {
			console.log("Dropzone: dragenter");
			$('.dropzone').css({"z-index": "10" });
			that.activeWatch.find('.preview-zone').addClass('active');
		});
		this.dropzone.on("dragleave", function() {
			console.log("Dropzone: dragleave");
			$('.dropzone').css({"z-index": "3" });
			that.activeWatch.find('.preview-zone').removeClass('active');
		});
		this.dropzone.on("canceled", function() {
			console.log("Dropzone: canceled");
		});
		this.dropzone.on("error", function() {
			console.log("Dropzone: Error when adding file");
		});
		this.dropzone.on("complete", function(file) { //addedfile or //complete
			console.log("Dropzone: File added with the status", file.status);
		});
	},

	imageProcess: function(file) {
		var that = this;
		var returnedElem = $(file.previewElement);
		 if($(that.dropzone.previewsContainer).children().length > 1)
			$(that.dropzone.previewsContainer).children().first().remove()

		var ditherOptions = {
			"step": 1,
			"algorithm": Pixebble.options.ditherAlgorithmSelect.val(),
			"className": "dithered",
			"palette": pebbleColors()
		};
		if(that.activeWatch.data('title') == "pog") ditherOptions.palette = [[0,0,0],[255,255,255]];
		that.ditherImage(returnedElem.find('img'), ditherOptions);
		TipManager.createTip({type:"success",icon:"&#10004;",text:"Image uploaded", delay: 1500});
	},

	clickWatch: function(event, element) {
		if(this.activeWatch.get(0) === $(element).get(0)) $('.trigger').click();
		this.activeWatch.removeClass("active");
		$(element).addClass('active');
		this.activeWatch = $(element);

		if(this.dropzone !== null) {
			this.dropzone.previewsContainer = this.activeWatch.find(".preview-zone")[0];
			this.dropzone.options.thumbnailWidth = parseInt(this.activeWatch.data("thumbnail-width"));
			this.dropzone.options.thumbnailHeight = parseInt(this.activeWatch.data("thumbnail-height"));
		} 
	},

	ditherImage: function(element, ditherOptions) {
		var that = this;
		new DitherJS(element.get(0), ditherOptions, function(dataUrl){
			that.postImage(dataUrl, that);
		});
	},

	postImage: function(dataUrl, that) {
		$.ajax({
			  type: "POST",
			  url: "server/controllers/upload.php",
			  data: { 
				 imgBase64: dataUrl,
				 userId: UsersManager.getLocalUserId(),
				 width: that.dropzone.options.thumbnailWidth,
				 height: that.dropzone.options.thumbnailHeight,
			  },
			  success : function(response) {
			  	Gallery.addImage(JSON.parse(response));
			  }
			});
	}
};