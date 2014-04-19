/**
 * Login Stuff
 */

// Namespace
var mdp = {};

// Constants
mdp.constants = {
	LOGIN_SERVICE_URL : "./login.php",
	LOGIN_ACTION : "login",
	VIEW_PAGE_URL : "./view.php"
};

// Model
LoginViewModel = function() {
	var self = this;
   	//self.pass = ko.observable(); --> Autocompletion for passwords doesn't work in Firefox!
    self.info = ko.observable();
    self.statusCode = ko.observable();

    self.doLogin = function() {
    	var pass = $('#password').val();
       	var query = {
			"action" : mdp.constants.LOGIN_ACTION,
			"pass" : pass,
			"time" : Date.now()
		};
		var jqxhr = $.getJSON(mdp.constants.LOGIN_SERVICE_URL, query, function(data) {
			if (data.code > 0) {
				// Correct Password
				self.info(data.result);
				self.statusCode(data.code);
				location.href = mdp.constants.VIEW_PAGE_URL;
			} else {
				// Wrong Password
				self.info(data.result);
				self.statusCode(data.code);
				$('#password').val('');
			}
		}).done(function() {
		}).fail(function(data) {
			// Failed
			self.info('');
			$('#password').val('');
		}).always(function() {
		});
    };    
};

// Activates knockout.js
ko.applyBindings(new LoginViewModel());


