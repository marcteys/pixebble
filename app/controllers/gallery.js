var Gallery = {
	
	currentUser : null,

	getImages:function(user) {
		var  that = this;
		this.currentUser = user;
		$.ajax({
		   url:'app/controllers/users.json',
		   data: "user="+user,
		   method:'GET',
		   success:function(response){
		      that.insertImages(JSON.parse(response));
		   }
		  });
	},

	insertImages : function (response) {
		Pixebble.options.galleryContainer.html('');
		$.each(response, function(i,data) {
			if(data.name === null ) {
				Pixebble.options.galleryContainer.html("<p>There are no recent uplaods for user " + data.user + ".</p>");
			} else {
				var $galleryElement = $(Templates.get("galleryElement", data));
				Pixebble.options.galleryContainer.append($galleryElement);
			}
		});
	},

	deleteImage: function(imageName) {
		var that = this;
		if(confirm("Delete Image ?")) {
			$.ajax({
			   url:'app/controllers/delete_image.php',
			   type:'POST',
			   data: {name : imageName },
			   success:function(response){
			   	console.log("Gallery: Image deleted");
			   	that.getImages(that.currentUser);
			   }
			});	
		}
	}
}