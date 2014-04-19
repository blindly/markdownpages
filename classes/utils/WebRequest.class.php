<?php
/**
 * WebRequest
 * Handles all the Requests ($_GET and $_POST)
 */

class WebRequest {
	private $requestParams;

	/**
	 * Constructor
	 * Maps GET and POST
	 */
	function __construct() {
		if (!empty($_GET)) {
			$this->requestParams = $_GET;
		} else {
			$this->requestParams = $_POST;
		}
	}

	/** Returns the name of the method to be called in the presenter
	 * @return String actionMethod 
	 */
	public function getAction() {
		if (!empty($this->requestParams[ACTION])) {
			return $this->requestParams[ACTION];
		} else {
			return null;
		}
	}

	/** Returns the value of a request parameter
	 * @return String 
	 */
	public function getValue($paramName) {
		if (!isset($this->requestParams[$paramName])){
			// Unknown parameter
			die ("Missing request parameter: ".$paramName);
		} else if (!empty($this->requestParams[$paramName])) {
			// Ok, we have the Parameter and its not empty
			return $this->requestParams[$paramName];
		} else {
			// We have the parameter, but its empty
			return null;
		}
	}

	/** Returns the referer
	 * @return String 
	 */
	public function getReferer() {
		$referer = $_SERVER["HTTP_REFERER"];
		if (!empty($referer)) {
			return $referer;
		} else {
			return null;
		}
	}

}
?>