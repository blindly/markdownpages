/**
 * Stuff
 */

// Namespace
var mdp = {};

mdp.Constants = {
	LOGIN_SERVICE_URL : "./login.php",
	PAGE_SERVICE_URL : "./service.php",
	VIEW_PAGE_URL : "./view.php",
	WELCOME_PAGE_NAME : "Default",
	ERROR_FILE_NOT_FOUND : -24,
	ERROR_SESSION_INVALID : -31
};

mdp.TypeAheadHelper = function() {
	var getOptions = function(items) {
		var options = {
			source : items,
			matcher : function(item) {
				var reg = new RegExp('^' + this.query, 'i');
				return (item.match(reg)) ? true : false;
			},
			updater : function(item) {
				//self.doSearch(item);
				return item;
			},
			minLength : 1,
			items : 10
		};
		return options;
	}; 

	// Public Methods
	return {
		getOptions : getOptions
	};
}();


mdp.SearchHelper = function() {

	
	var isExistingPage = function(searchString, allPagesArray) {
		if ($.inArray(searchString, allPagesArray) >= 0) {
			return true;
		} else {
			return false;
		}
	}; 

	
	var isSearchInputEmpty = function(searchInput) {
		var trimmed = $.trim(searchInput);
		if (trimmed.length == 0) {
			return true;
		} else {
			return false;
		}
	}; 
	
	var createNewFileName = function(createPageInput) {
		var newFileName = createPageInput;
		// Make first Letter always upercase
		var ucFirst = function capitaliseFirstLetter(str){
    		return str.charAt(0).toUpperCase() + str.slice(1);
		};
		newFileName = ucFirst(newFileName);
		// Remove spaces
		newFileName = newFileName.replace(/\s/g,"_"); 
		// Replace Slashes
		newFileName = newFileName.replace(/\//g,"_"); 
		
		return newFileName;
	}; 
	
	// Public Methods
	return {
		isExistingPage : isExistingPage,
		isSearchInputEmpty : isSearchInputEmpty,
		createNewFileName : createNewFileName
	};
}();

mdp.ResultHelper = function() {
	var hasError = function(data) {
		if (data.code >= 0) {
			// No Errors
			return false;
		} else {
			// Has errors
			return true;
		}
	}; 

	var getErrorText = function(data) {
		if (data.code >= 0) {
			// No Errors
			return "";
		} else {
			// Has errors
			var errorText = data.result;
			return errorText;
		}
	}; 

	// Public Methods
	return {
		hasError : hasError,
		getErrorText : getErrorText
	};
}();


 