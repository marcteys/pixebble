var Help = {

	currentHelp : null,
	corner : ".corner",
	cornerInfo : null,

	init : function(div) {
		var that = this;
		this.cornerInfo = div;
		$(div).click(function() {
			if(that.currentHelp === null) that.display();
			else that.remove();
		});
	},

	display : function() {
		var that = this;
		var data = {id : UsersManager.getLocalUserId().toLowerCase() };
		console.log(data);
		this.currentHelp = $(Templates.get("help", data));
		$(".content").append(this.currentHelp);
		$(this.corner).addClass('active');
		this.currentHelp.find("button").click(function() {
			that.remove();
		});
		$(this.cornerInfo).html("&#215;");
	},

	remove : function() {
		$(this.currentHelp).remove();
		$(this.corner).removeClass('active');
				$(this.cornerInfo).html("?");

		this.currentHelp = null;
	}
	
};