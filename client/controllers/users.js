var UsersManager = {

	init:function(settings) {
		this.bindUserInput();
		if(window.location.hash && this.userCharactersCorrect(window.location.hash.substr(1))) {
			this.setLocalUserId(window.location.hash.substr(1));
			console.log("Users: Get username from hash");
		} else if(this.getLocalUserId()) {
			Pixebble.options.userIdInput.val(this.getLocalUserId());
		} else {
			this.makeUniqueUserId(this);
			console.log("Users: Create makeUniqueUserId");
		}
	},

	bindUserInput: function() {
		var that = this;
		Pixebble.options.userIdInput.bind("input",function(){that.changeUserIdInput(this, that)}, false);
		Pixebble.options.userIdNew.bind("click",function(){that.makeUniqueUserId(that)}, false);
	},

	changeUserIdInput:function(element, that) {
		if(that.setLocalUserId($(element).val())) {
			$(element).parent().addClass('saved');
			setTimeout(function() { $(element).parent().removeClass('saved') }, 1500);
		} else {
			console.log("Users: Must be letters only");
			$(element).parent().addClass('error');
			$('.user-id-container-error-text').addClass('active');
			setTimeout(function() {
				$(element).parent().removeClass('error');
				$('.user-id-container-error-text').removeClass('active');
			}, 1500);
			$(element).val(that.removeAllNonAlphanumeric($(element).val()));
		}
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
		if(!this.userCharactersCorrect(userId)) {
			console.log("Users: Problem : user name contain invalid characters");
			return false;
		}
		console.log("Users: Save user id " + userId.toUpperCase());
		Pixebble.options.userIdInput.val(userId);
		localStorage.setItem('userId', userId.toUpperCase());
		Gallery.getImages(userId);
		return true;
	},

	userCharactersCorrect: function(userString) {
		return /^[a-zA-Z]+$/.test(userString);
	},

	removeAllNonAlphanumeric: function(str) {
		return str.replace(/\s+/g, '').replace(/[^a-zA-Z-]/g, '').replace('-', '').toUpperCase();
	}
};