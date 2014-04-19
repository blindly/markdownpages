<?php
/**
 * OutPutWrapper
 */

class OutputWrapper {
	var $code;
	var $result;

	/**
	 * @param output Result
	 */
	function __construct($output) {
		
		// Check if its an Object from Class Result
		if (get_class($output) == RESULT_CLASS) {
			$this->code = $output->getCode();
			$this->result = $output->getContent();

			// Put Error-Message-Text in Output if result content is empty
			if (empty($this->result)) {
				switch ($output->getCode()) {
					case STATUS_OK :
						$this->result = "Success";
						break;
					case STATUS_UNKNOWN :
						$this->result = "Unknown Status.";
						break;
					case ERROR_FILE_CANNOT_WRITE :
						$this->result = "Failed to write content to file. Check permissions";
						break;
					case ERROR_FILE_EXISTS :
						$this->result = "File already exists";
						break;
					case ERROR_FILE_NAME_INVALID :
						$this->result = "Invalid Filename";
						break;
					case ERROR_FILE_NOT_FOUND :
						$this->result = "File not found";
						break;
					case ERROR_SESSION_INVALID :
						$this->result = "Session invalid";
						break;
					case ERROR_LOGIN_INVALID :
						$this->result = "Login invalid";
						break;
					default :
						$this->result = "Empty Result Content.";
				}
			}

		} else {
			$this->code = STATUS_UNKNOWN;
			$this->result = $output;
		}
	}

	/**
	 * Result as Json
	 * @return Json
	 */
	public function toJson() {
		$obj["time"] = date("m.d.Y-G:i:s");
		$obj["code"] = $this->code;
		$obj["result"] = $this->result;
		$json = json_encode($obj);
		return $json;
	}

	/**
	 * Result as String
	 * @return String
	 */
	public function toString() {
		return $this->code . ":" . $this->result;
	}

}
?>