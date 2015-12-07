var UsersManager = {

	options:null,

	init:function(settings) {
		this.options = settings;
		if(window.location.hash) {
			this.options.userIdInput.val(window.location.hash.substr(1));
			this.setLocalUserId(window.location.hash.substr(1));
		} else if(this.getLocalUserId()) {
			this.options.userIdInput.val(this.getLocalUserId());
		} else {
			this.makeUniqueUserId(this);
		}
		this.bindUserInput();
	},

	bindUserInput: function() {
		var that = this;
		this.options.userIdInput.bind("input",function(){that.changeUserIdInput(this, that)}, false);
		this.options.userIdNew.bind("click",function(){that.makeUniqueUserId(that)}, false);
	},

	changeUserIdInput:function(element, that) {
		$(element).parent().addClass('saved');
		setTimeout(function() { $(element).parent().removeClass('saved') }, 1500);
		that.setLocalUserId($(element).val());
	},

	makeUniqueUserId: function(that) {
		var unique = MakeUniqueId(6);
		console.log("Users: Make unique id " + unique);
		that.options.userIdInput.val(unique);
		this.options.userIdInput.trigger("input");
	},

	getLocalUserId: function() {
		if(localStorage.getItem('userId') !== null ){
			return localStorage.getItem('userId');
		}
		else return false;
	},

	setLocalUserId: function(userId) {
		console.log("Users: Set user id " + userId);
		localStorage.setItem('userId', userId);
	}
};