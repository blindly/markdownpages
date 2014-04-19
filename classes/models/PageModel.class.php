<?php

/**
 * Page Model
 * The model defining the data to be displayed.
 */
class PageModel {

	/**
	 * List of all Pages
	 * @return GenericResult
	 */
	public function getAllPagesAsArray() {
		$genericResult = FileHelper::getPageNames();
		return $genericResult;
	}

	/**
	 * List of recently viewed Pages
	 * @return GenericResult
	 */
	public function getRecentPagesAsArray() {
		$genericResult = FileHelper::getRecentPageNames();
		return $genericResult;
	}

	/**
	 * Saves an existing Page file
	 * @param pageName Name of the existing Page
	 * @param pageContent Markup-Content of the page
	 * @return GenericResult
	 */
	public function savePage($pageName, $pageContent) {
		$genericResult = FileHelper::savePage($pageName, $pageContent);
		return $genericResult;
	}
	
	/**
	 * Deletes an existing Page file
	 * @param pageName Name of the existing Page
	 * @return GenericResult
	 */
	public function deletePage($pageName) {
		$genericResult = FileHelper::deletePage($pageName);
		return $genericResult;
	}

	/**
	 * Creates a new Page file
	 * @param pageName Name of the new Page
	 * @return GenericResult
	 */
	public function createPage($newPageName) {
		$genericResult = FileHelper::createPage($newPageName);
		return $genericResult;
	}

	/**
	 * Loads a Page file
	 * @param pageName Name of the Page
	 * @return GenericResult
	 */
	public function viewPage($pageName) {
		$genericResult = FileHelper::loadPage($pageName);
		return $genericResult;
	}
	
	/**
	 * Search in Pages for searchString
	 * @param SearchString Needle
	 * @return GenericResult
	 */
	public function searchPage($searchString) {
		$genericResult = FileHelper::searchPageFiles($searchString);
		return $genericResult;
	}
	
	/**
	 * All attachment files for page
	 * @param pageName Name of the Page
	 * @return GenericResult
	 */
	public function getAttachmentsForPage($pageName) {
		$genericResult = FileHelper::getAttachmentsForPage($pageName);
		return $genericResult;
	}
	
	

}
?>
