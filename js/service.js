

var PageService = function(){
	var self = this;
	
	// Private Constructor
	var _construct = function(){
		
	};
	
	// Private
	var doGet = function(query, callback){
		var jqxhr = $.getJSON(mdp.Constants.PAGE_SERVICE_URL, query, function(data) {
			if (data.code == mdp.Constants.ERROR_SESSION_INVALID) {
				// Session invalid
				location.href = "./";
			} else {
				// Success or any other errors are passed to callback function
				callback(data);
			}
		});
	};
	
	var doPost = function(query, callback){
		var jqxhr = $.post(mdp.Constants.PAGE_SERVICE_URL, query, function(data) {
			if (data.code == mdp.Constants.ERROR_SESSION_INVALID) {
				// Session invalid
				location.href = "./";
			} else {
				// Success or any other errors are passed to callback function
				callback(data);
			}
		});
	};
	
	// Public
	self.getAllPages = function(callback){
		var query = {
			"action" : "getAllPages",
			"time" : Date.now()
		};
		doGet(query, callback);
	};
		
	// Public
	self.getRecentPages = function(callback){
		var query = {
			"action" : "getRecentPages",
			"time" : Date.now()
		};
		doGet(query, callback);
	};
	
		// Public
	self.viewPage = function(pageName, callback){
		var query = {
			"action" : "viewPage",
			"pagename" : pageName,
			"time" : Date.now()
		};
		doGet(query, callback);
	};
	
	self.savePage = function(pageName, pageContent, callback){
		var query = {
			"action" : "savePage",
			"pagename" : pageName,
			"pagecontent" : pageContent,
			"time" : Date.now()
		};
		doPost(query, callback);
	};
	
	self.newPage = function(pageName, callback){
		var query = {
			"action" : "newPage",
			"pagename" : pageName,
			"time" : Date.now()
		};
		doPost(query, callback);
	};
	
			// Public
	self.searchPage = function(searchString, callback){
		// Load Page or search
		var query = {
			"action" : "searchPage",
			"search" : searchString,
			"time" : Date.now()
		};
		doGet(query, callback);
	};
	
	self.getAttachments = function(pageName, callback){
		var query = {
			"action" : "getAttachments",
			"pagename" : pageName,
			"time" : Date.now()
		};
		doGet(query, callback);
	};
	
	_construct();
};
