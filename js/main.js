/**
 * Model
 */


PageViewModel = function(pageService) {
	var self = this;
	var service = pageService;
	
	self.pageName = ko.observable();
	
	// List of all existing Pages
	self.allPagesArray = ko.observableArray([]);
	
	// Search Results to be displayed
	self.searchResultArray = ko.observableArray([]);
	
	// List of Recent Pages
	self.recentPagesArray = ko.observableArray([]);
	
	// Represents a single list entry (for Search Results or Recent Pages)
	self.ListEntry = function(item) {
    	this.pageName = ko.observable(item);
	};
	
	// List of attachments for Page
	self.attachmentsArray = ko.observableArray([]);
	
	// The Page HTML
	self.pageHTML =  ko.observable();
	
	// The Page Markup
	self.pageMarkup =  ko.observable();
	
	// Search Input
	self.searchInput = ko.observable();
	
	// EditMode --> Default is false (means ViewMode)
	self.editMode = ko.observable(false);
	
	
	// Modal
	// Search Input
	self.createPageInput = ko.observable();
	self.createPageInfo = ko.observable();
	
	/**
	 * Loads the initial list of recent Pages
	 */
	self.updateRecentPages = function() {
		service.getRecentPages(function(data){
			if (!mdp.ResultHelper.hasError(data)){
				var mappedPages = $.map(data.result, function(item) {
					return new self.ListEntry(item);
				});
				self.recentPagesArray(mappedPages);
			} else {
				alert(mdp.ResultHelper.getErrorText(data));
			}
		});
	}; 
	
	self.getAllPages = function() {
		service.getAllPages(function(data){
			if (!mdp.ResultHelper.hasError(data)){
				self.allPagesArray(data.result);
				self.updateTypeAhead();
			} else {
				alert(mdp.ResultHelper.getErrorText(data));
			}
		});
	}; 
	
	self.getAttachments = function(pageName) {
		service.getAttachments(pageName, function(data){
			if (!mdp.ResultHelper.hasError(data)){
				self.attachmentsArray(data.result);
			} else {
				// Clear the attachments
				self.attachmentsArray([]);
			}
		});
	};
	/**
	 * Init TypeAhead for Search-Field
	 */
	self.updateTypeAhead = function() {
		var pages = self.allPagesArray();
		var options = mdp.TypeAheadHelper.getOptions(pages);
		// Init Typeahead SearchField
		$('#fld_search').typeahead('destroy');
		$('#fld_search').typeahead(options);
	}; 
	
	
	
	/**
	 * DoSearch
	 */
	self.doSearch = function(){
		var searchInput = $('#fld_search').val();
		self.searchInput(searchInput);
		var searchString = self.searchInput();
		//
		var isSearchInputEmpty = mdp.SearchHelper.isSearchInputEmpty(searchString);
		var isExistingPage = mdp.SearchHelper.isExistingPage(searchString, self.allPagesArray());
		
		if (isSearchInputEmpty) {
			self.searchResultArray([]);
			var mappedPages = $.map(self.allPagesArray(), function(item) {
				return new self.ListEntry(item);
			}); 
			self.searchResultArray(mappedPages);
		} else if (isExistingPage) {
			self.viewPage(searchString);
			self.resetPage();
		} else {
			var needle = $.trim(searchString);
			service.searchPage(needle, function(data){
				if ($.isArray(data.result)) {
					self.searchResultArray([]);
					var mappedPages = $.map(data.result, function(item) {
						return new self.ListEntry(item);
					}); 
					self.searchResultArray(mappedPages);
				}
			});
		}
	};
	
	/**
	 */
	self.resetPage = function(){
		// Reset Search
		self.resetSearch();
		// Reset Attachments
		self.attachmentsArray([]);
	};


	/**
	 */
	self.resetSearch = function(){
		// Reset Search Input
		self.searchInput('');
		self.searchResultArray([]);
		$('#fld_search').focus();
	};
	
	/**
	 * View Page by clicking on an entry in the search results
	 */
	self.viewPageByListEntry = function(entry){
		var pageName = entry.pageName(); 
		self.viewPage(pageName);
	};
	
	
	/**
	 * View Page
	 * @param pageName
	 */
	self.viewPage = function(pageName) {
		service.viewPage(pageName, function(data){
			if (!mdp.ResultHelper.hasError(data)){
				self.resetPage();
				self.pageName(pageName);	
				self.pageHTML(data.result.html);
				self.pageMarkup(data.result.markup);
				self.updateRecentPages();
				self.getAttachments(pageName);
			} else {
				alert(mdp.ResultHelper.getErrorText(data));
			}
		});
    };
    
    
    /**
	 * Save Page
	 */
	self.savePage = function() {
		var pageName = self.pageName();
		var pageContent = self.pageMarkup();
		service.savePage(pageName, pageContent, function(data){
			if (!mdp.ResultHelper.hasError(data)){
				self.setViewMode();
				self.viewPage(pageName);
			} else {
				alert(mdp.ResultHelper.getErrorText(data));
			}
		});
    };
    
    /**
     * New Page
     */
    
	self.newPage = function() {
		var createPageInput = self.createPageInput();
		var newPageName = mdp.SearchHelper.createNewFileName(createPageInput);
		// Set the corrected new PageName
		self.createPageInput(newPageName);
		service.newPage(newPageName, function(data){
			if (!mdp.ResultHelper.hasError(data)){
				self.setEditMode();
				self.viewPage(newPageName);
				self.getAllPages();
				$('#modalBox').modal('hide');
			} else {
				//alert(mdp.ResultHelper.getErrorText(data));
			}
			self.createPageInfo(data.result);
		});
    };
    
    self.initModalBox = function() {
    	// Set Default PageName to the search input
    	self.createPageInput(self.searchInput());
    	// clear page info
    	self.createPageInfo('');
    };
    

	
	self.getEditMode = function() {
		return self.editMode();
    };
    
	self.setEditMode = function() {
		self.editMode(true);
		window.onbeforeunload = function () {
			return false;   
		};
    };
	self.setViewMode = function() {
		self.editMode(false);
		window.onbeforeunload = null;
    };
    
    
    /**
     * Init Events
     */
    
    // Loads all Filenames from existing Pages
    self.getAllPages();
	
	// Update the list of recent pages
	self.updateRecentPages();
	
	// Load the Default Page
	self.viewPage(mdp.Constants.WELCOME_PAGE_NAME);
}; 


var pageService = new PageService();

// Activates knockout.js
ko.applyBindings(new PageViewModel(pageService));



 