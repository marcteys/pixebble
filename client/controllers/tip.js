var TipManager = {
	
	previousTip:null,

	createTip: function(data){
		var removeDelay = data.delay || 4500;
		if(this.previousTip !== null) this.previousTip.trigger("removeTip");
		this.addTip(removeDelay, $(Templates.get("tip", data)));
	},

	addTip: function(removeDelay, template) {
		var that = this;
		Pixebble.options.mainContainer.append(template);
		this.previousTip = template;
		setTimeout(function(){
			template.addClass("active");
			template.bind("removeTip", function() { that.removeTip(template); } );
			template.on("click", function() { that.removeTip(template); } );
			setTimeout(function(){
				template.trigger("removeTip");
			},removeDelay);
		},100);
	},

	removeTip:function(element) {
		element.removeClass("active");
		setTimeout(function() {
			element.unbind( "removeTip" );
			element.unbind( "click" );
		 	element.remove();
		}, 400);
	}
}