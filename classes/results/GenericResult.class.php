<?php
/**
 * Generic Result
 */
class GenericResult {
	private $resultCode;
	private $resultContent;

	/**
	 * Constructor
	 * @param code
	 * @param content (optional)
	 */
	function __construct($code, $content = null) {
		$this->resultCode = $code;
		$this->resultContent = $content;
	}

	/**
	 * Returns the code of the Result
	 * <code>define(STATUS_OK, 1);</code>
	 * <code>define(STATUS_UNKNOWN, 0);</code>
	 * <code>define(ERROR_UNKNOWN, -1);</code>
	 * All codes lower than 0 are errors.
	 * @return int
	 */
	public function getCode() {
		return $this->resultCode;
	}

	/**
	 * Returns the content
	 * @return String
	 */
	public function getContent() {
		return $this->resultContent;
	}

}
?>