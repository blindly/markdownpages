<?php

/**
 * Simple View
 * The view displays data (the model).
 */
class SimpleView implements iGenericView {

	private $genericResult;

	/**
	 * Constructor
	 * Keeps the GenericResult in the object
	 */
	function __construct($genericResult) {
		$this->genericResult = $genericResult;
	}

	/**
	 * Renders the view. Default method <code>render()</code>
	 * @see iGenericView.class.php
	 */
	public function render() {
		$this->renderJson();
	}

	/**
	 * Renders the view as Json
	 */
	public function renderJson() {
		$out = new OutputWrapper($this->genericResult);
		echo $out->toJson();
	}

	/**
	 * Renders the view as Object <code>print_r</code>
	 */
	public function renderObject() {
		print_r($this->genericResult);
	}
	
	/**
	 * Sends Redirect Header
	 * @param locationUrl
	 */
	public function sendRedirect($locationUrl) {
		header("Location: ".$locationUrl);
	}

}
?>
