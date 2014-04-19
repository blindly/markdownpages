<?php
/**
 * Page Presenter
 * Caution: All public or protected Methods are callable via the action-parameter in the url.
 */


class PagePresenter extends GenericPresenter {

	/**
	 * Constructor
	 * Checks if we have a valid session and then calls the super constructor.
	 */
	function __construct($request) {
		// Check if session is valid
		if (LoginHelper::checkSession() == true) {
			parent::__construct($request);
		} else {
			// Session is not valid
			$genericResult = new GenericResult(ERROR_SESSION_INVALID);
			$view = new SimpleView($genericResult);
			$view->render();
			session_destroy();
			die();
		}
	}

	/**
	 * Gets a list of all Pages and renders the view.
	 * Method is called by <code>dispatchAction()</code> in GenericPresenter.
	 */
	protected function getAllPages($request) {
		$model = new PageModel();
		$genericResult = $model->getAllPagesAsArray();
		$view = new SimpleView($genericResult);
		$view->render();
	}
	
	/**
	 * Gets a list of all Pages and renders the view.
	 * Method is called by <code>dispatchAction()</code> in GenericPresenter.
	 */
	protected function getRecentPages($request) {
		$model = new PageModel();
		$genericResult = $model->getRecentPagesAsArray();
		$view = new SimpleView($genericResult);
		$view->render();

	}

	/**
	 * Parses the Markdown of the Page and renders the view.
	 * Method is called by <code>dispatchAction()</code> in GenericPresenter.
	 */
	protected function viewPage($request) {
		$model = new PageModel();
		$pageName = $request->getValue(CONTROLLER_PAGE_NAME);
		$genericResult = $model->viewPage($pageName);

		// Make sure we have no errors reading the file and then transform Markdown to HTML.
		if ($genericResult->getCode() == STATUS_OK) {
			//$html = Markdown($genericResult->getContent());
			$parser = Parsedown::instance();
			$parser->set_breaks_enabled(true);
			$html = $parser->parse($genericResult->getContent());
			// Create a new Result object to pass to OutputWrapper
			$obj["html"] = $html;
			$obj["markup"] = $genericResult->getContent();
			$genericResult = new GenericResult(STATUS_OK, $obj);
		}
		$view = new SimpleView($genericResult);
		$view->render();

	}

	/**
	 * Saves an existing Page and renders the view.
	 * Method is called by <code>dispatchAction()</code> in GenericPresenter.
	 */
	protected function savePage($request) {
		$model = new PageModel();
		$pageName = $request->getValue(CONTROLLER_PAGE_NAME);
		$pageContent = $request->getValue(CONTROLLER_PAGE_CONTENT);
		if (empty($pageContent)) {
			// If content is empty, delete the page
			$genericResult = $model->deletePage($pageName);
		} else {
			// If we have some content, then save it!
			$genericResult = $model->savePage($pageName, $pageContent);
		}
		
		$view = new SimpleView($genericResult);
		$view->render();
	}

	/**
	 * Creates a new Page and renders the view.
	 * Method is called by <code>dispatchAction()</code> in GenericPresenter.
	 */
	protected function newPage($request) {
		$model = new PageModel();
		$newPageName = $request->getValue(CONTROLLER_PAGE_NAME);
		$genericResult = $model->createPage($newPageName);
		$view = new SimpleView($genericResult);
		$view->render();
	}
	
	/**
	 * Searches within Pages for SearchString (Needle)
	 * Method is called by <code>dispatchAction()</code> in GenericPresenter.
	 */
	protected function searchPage($request) {
		$model = new PageModel();
		$searchString = $request->getValue(CONTROLLER_SEARCH_STRING);
		$genericResult = $model->searchPage($searchString);
		$view = new SimpleView($genericResult);
		$view->render();
	}
	
	/**
	 * Gets attachment files for page
	 * Method is called by <code>dispatchAction()</code> in GenericPresenter.
	 */
	protected function getAttachments($request) {
		$model = new PageModel();
		$pageName = $request->getValue(CONTROLLER_PAGE_NAME);
		$genericResult = $model->getAttachmentsForPage($pageName);
		$view = new SimpleView($genericResult);
		$view->render();
	}
	

}
?>