<?php

/**
 * Generic Presenter
 * The presenter acts upon the model and the view. It retrieves data from the model and handles it to display in the view.
 */

class GenericPresenter implements iPresenter {

	/**
	 * Constructor
	 * Calls Dispatcher-Action
	 */
	function __construct($request) {
		$this->dispatchAction($request);
	}

	/**
	 * Dispatcher for Action Methods
	 * Calls the method from the Presenter.
	 */
	public function dispatchAction($request) {
		// get the Action Method from the request.
		$controllerAction = $request->getAction();
		if ($controllerAction != null && method_exists($this, $controllerAction)) {
			// Call action method
			$this->$controllerAction($request);
		} else {
			die("Invalid method call");
		}

	}

}
?>