<?php
/**
 * Login Presenter
 */

class LoginPresenter extends GenericPresenter {

	/**
	 * Constructor
	 * Calls the super constructor
	 */
	function __construct($request) {
		 parent::__construct($request);
	}

	/**
	 * Handles the Logins and renders the view.
	 */
	protected function login($request) {
		$pass = $request->getValue(CONTROLLER_LOGIN_PASS);
		// We encode the entered Password in md5. Make sure the password in the configuration is also md5 encoded
		$pass = md5($pass); 
		if ($pass == USER_PASS && LoginHelper::isLocked() == false) {
			// Cookie (valid for session)
			$token = LoginHelper::getToken();
			$_SESSION[SESSION_TOKEN] = $token;
			$genericResult = new GenericResult(STATUS_OK);
			// Reset the login counter
			LoginHelper::updateLoginInfo($request, true);
		} else {
			$genericResult = new GenericResult(ERROR_LOGIN_INVALID);
			LoginHelper::updateLoginInfo($request, false);
			session_destroy();
		}	
		$view = new SimpleView($genericResult);
		$view->render();
	}
	
}
?>