<?php

/**
 * FileHelper
 */

class FileHelper {
	/**
	 * Loads a Page and returns the content of the pagefile or null if file doesn't exist.
	 * @param pageName The name of the Page.
	 * @return GenericResult 
	 */
	public static function loadPage($pageName) {
		// Check PageName is not empty	
		if (empty($pageName)) {
			return new GenericResult(ERROR_FILE_NAME_INVALID);;
		}
		$filename = PAGE_FOLDER_PATH . $pageName . PAGE_FILE_EXT;
		if (file_exists($filename)) {
			$output = file_get_contents($filename);
			//Touch file to see recently viewed pages
			touch($filename);
			return new GenericResult(STATUS_OK, $output);
		} else {
			$output = null;
			return new GenericResult(ERROR_FILE_NOT_FOUND, $output);
		}
	}

	/**
	 * Saves the Page
	 * Error-Code (1 for OK)
	 * @param pageName The name of the Page.
	 * @return GenericResult
	 */
	public static function savePage($pageName, $content) {
		$filename = PAGE_FOLDER_PATH . $pageName . PAGE_FILE_EXT;
		$content = stripslashes($content);
		if (empty($content)) {
			return new GenericResult(ERROR_FILE_CANNOT_WRITE);		
		}
		$success = @file_put_contents($filename, $content, LOCK_EX);
		if ($success > 0) {// Number of bytes written
			return new GenericResult(STATUS_OK);
		} else {
			return new GenericResult(ERROR_FILE_CANNOT_WRITE);
		}
	}
	
	
	/**
	 * Delete the Page
	 * Actually the file will not be deleted, just moved to the trash folder.
	 * Error-Code (1 for OK)
	 * @param pageName The name of the Page.
	 * @return GenericResult
	 */
	public static function deletePage($pageName) {
		$filename = PAGE_FOLDER_PATH . $pageName . PAGE_FILE_EXT;
		$timeStamp = date("Ymd-Gis");
		// Make unique Filename including delete-time
		$trashFilename = TRASH_FOLDER_PATH . $timeStamp . "_" . $pageName . PAGE_FILE_EXT;
		$success = rename($filename, $trashFilename);
		if ($success == true) {// Number of bytes written
			return new GenericResult(STATUS_OK);
		} else {
			return new GenericResult(ERROR_FILE_CANNOT_WRITE);
		}
	}

	/**
	 * Creates the Page with default content
	 * Error-Code (1 for OK)
	 * @param $pageName The name of the Page.
	 * @return GenericResult
	 */
	public static function createPage($pageName) {
		// Stop if $pageName is null or an empty string
		if (empty($pageName)) {
			return new GenericResult(ERROR_FILE_NAME_INVALID);;
		}
		// Make first Letter always upercase
		$pageName = ucfirst($pageName);
		// Remove spaces
		$pageName = str_replace(' ', '_', $pageName);
		// Replace Slashes
		$pageName = str_replace('/', '_', $pageName);
		// this should be the complete Filename including extension.
		$filename = PAGE_FOLDER_PATH . $pageName . PAGE_FILE_EXT;
		// Check if file already exists
		if (file_exists($filename)) {
			return new GenericResult(ERROR_FILE_EXISTS);
		}
		$success = @file_put_contents($filename, NEW_PAGE_CONTENT, LOCK_EX);
		if ($success > 0) {// Number of bytes written
			return new GenericResult(STATUS_OK);
		} else {
			// Returns Error-Code
			return new GenericResult(ERROR_FILE_CANNOT_WRITE);
		}
	}

	/**
	 * Gets all files (no folders) from PAGE_FOLDER_PATH
	 * List containing all filepaths
	 * @return array 
	 */
	private static function getFolderFilePathAsArray() {
		$filePathArray = array();
		$fileArray = @scandir(PAGE_FOLDER_PATH);
		if (is_array($fileArray)) {
			foreach ($fileArray as $file) {
				if (!is_dir(PAGE_FOLDER_PATH . $file)) {
					array_push($filePathArray, PAGE_FOLDER_PATH . $file);
				}
			}
			return $filePathArray;
		} else {
			die("Probable Configuration error (PAGE_FOLDER_PATH) is wrong: " . PAGE_FOLDER_PATH);
		}
	}

	/**
	 * Converts FilePath to PageNames
	 * List containing all PageNames
	 * @param array fileArray
	 * @return array 
	 */
	private static function convertFileToPageArray($fileArray) {
		$pageArray = array();
		foreach ($fileArray as $file) {
			$fileName = basename($file, PAGE_FILE_EXT);
			array_push($pageArray, $fileName);
		}
		return $pageArray;
	}

	/**
	 * PageNames without the fileextension
	 * as array containing all PageNames in PAGE_FOLDER_PATH
	 * @return GenericResult
	 */
	public static function getPageNames() {
		$fileArray = self::getFolderFilePathAsArray();
		$pageArray = self::convertFileToPageArray($fileArray);
		sort($pageArray);
		return new GenericResult(STATUS_OK, $pageArray);

	}
	
	/**
	 * Get recent n PageNames without the fileextension
	 * as array containing all PageNames in PAGE_FOLDER_PATH ordered by modification time
	 * @return GenericResult
	 */
	public static function getRecentPageNames() {
		$fileArray = self::getFolderFilePathAsArray();
		$assocFileArray = array();
		foreach ($fileArray as $file) {
			$fileName = basename($file, PAGE_FILE_EXT);
			$assocFileArray[filemtime($file)] = $fileName;
		}
	    ksort($assocFileArray);
	    $fileArray = array_values($assocFileArray);
		$fileArray = array_reverse($fileArray);
		$pageArray = self::convertFileToPageArray($fileArray);
		// Only the top n Pages
		$pageArray = array_slice($pageArray, 0, NUMBER_OF_RECENT_PAGES);
		return new GenericResult(STATUS_OK, $pageArray);

	}

	/** Searches in Files
	 * To improve performance the search continues to the next file after first occourence.
	 * All matching PageNames in PAGE_FOLDER_PATH as array
	 * @param $searchString The needle / Haystack is all files in PAGE_FOLDER_PATH (no subfolders)
	 * @return GenericResult
	 */
	public static function searchPageFiles($searchString) {
		$folderPath = PAGE_FOLDER_PATH;
		$fileArray = scandir($folderPath);
		$resultArray = array();

		foreach ($fileArray as $file) {
			$handle = fopen($folderPath . $file, "r");
			if ($handle) {
				while (($buffer = fgets($handle)) !== false) {
					$pos = strpos(strtolower($buffer), strtolower($searchString));
					if ($pos >= 0 && $pos !== false) {
						$fileName = explode(PAGE_FILE_EXT, $file);
						array_push($resultArray, $fileName[0]);
						break;
					}
				}
				if (!feof($handle)) {
					// return null; //"Error: unexpected fgets() fail\n";
				}
				fclose($handle);
			}
		}
		return new GenericResult(STATUS_OK, $resultArray);
	}
	
	/**
	 * Gets attachments in the page folder
	 * List containing all filepaths
	 * @param $pageName The name of the Page.
	 * @return array 
	 */
	public static function getAttachmentsForPage($pageName) {
		$filePathArray = array();
		$attachmentFolderPath = PAGE_FOLDER_PATH.$pageName."/";
		$fileArray = @scandir($attachmentFolderPath);
		if (is_array($fileArray)) {
			foreach ($fileArray as $file) {
				if (!is_dir($attachmentFolderPath.$file)) {
					$obj["filename"] = $file;
					$obj["path"] = $attachmentFolderPath.$file;
					array_push($filePathArray, $obj);
				}
			}
			return new GenericResult(STATUS_OK, $filePathArray);
		} else {
			return new GenericResult(ERROR_FILE_NOT_FOUND);
		}
	}



}
?>