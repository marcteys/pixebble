var UsersManager = {

	init:function(settings) {
		if(window.location.hash) {
			Pixebble.options.userIdInput.val(window.location.hash.substr(1));
			this.setLocalUserId(window.location.hash.substr(1));
		} else if(this.getLocalUserId()) {
			Pixebble.options.userIdInput.val(this.getLocalUserId());
		} else {
			this.makeUniqueUserId(this);
		}
		this.bindUserInput();
	},

	bindUserInput: function() {
		var that = this;
		Pixebble.options.userIdInput.bind("input",function(){that.changeUserIdInput(this, that)}, false);
		Pixebble.options.userIdNew.bind("click",function(){that.makeUniqueUserId(that)}, false);
	},

	changeUserIdInput:function(element, that) {
		$(element).parent().addClass('saved');
		setTimeout(function() { $(element).parent().removeClass('saved') }, 1500);
		that.setLocalUserId($(element).val());
	},

	makeUniqueUserId: function(that) {
		var unique = MakeUniqueId(6).toUpperCase();
		console.log("Users: Make unique id " + unique);
		Pixebble.options.userIdInput.val(unique);
		Pixebble.options.userIdInput.trigger("input");
	},

	getLocalUserId: function() {
		if(localStorage.getItem('userId') !== null ){
			return localStorage.getItem('userId');
		}
		else return false;
	},

	setLocalUserId: function(userId) {
		console.log("Users: Save user id " + userId.toUpperCase());
		localStorage.setItem('userId', userId.toUpperCase());
	}
};