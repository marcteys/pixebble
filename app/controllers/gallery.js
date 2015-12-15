var Gallery = {
	
	getImages:function(user) {
		var  that = this;
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
	}
}