<?php
/**
 * Login Helper
 */

class LoginHelper {
	
	/**
	 * Read and write (update) the Login Infofile. 
	 * @param request WebRequest
	 * @param isLoginOK Defines if we should reset the counters 
	 */
	public static function updateLoginInfo($request, $isLoginOK){
		$loginFile = file_get_contents(LOGIN_CONTROL_FILE);
		$loginObj = json_decode($loginFile, true);
		$counter = (int)$loginObj["counter"];
		$counter++;
		$locked = ($counter > USER_PASS_WRONG_COUNTER) ? true : false;
		
		$obj["time"] = date("m.d.Y-G:i:s");
		if ($isLoginOK) {
			$obj["pass"] = "*****";
			$obj["counter"] = 0;
			$obj["locked"] = false;
			
		} else {
			$obj["pass"] = $request->getValue(CONTROLLER_LOGIN_PASS);
			$obj["counter"] = $counter;
			$obj["locked"] = $locked;
		}
		$obj["ip"] = $_SERVER['REMOTE_ADDR'];

		$json = json_encode($obj);
		file_put_contents(LOGIN_CONTROL_FILE, $json);
	}

	/**
	 * isLocked means Locked = true / Unlocked = false
	 * @return boolean 
	 */
	public static function isLocked(){
		$loginFile = file_get_contents(LOGIN_CONTROL_FILE);
		$loginObj = json_decode($loginFile, true);
		$locked = $loginObj["locked"];
		return $locked;
	}

	/**
	 * MD5 Token for session validation
	 * @return String 
	 */
	public static function getToken() {
		$stringForToken = date("Ymd")."-".$_SERVER['REMOTE_ADDR']."-".$_SERVER['HTTP_USER_AGENT'];
		$token = md5($stringForToken);
		return $token;
	}
	
	/**
	 * Checks the session against the token
	 * @return boolean 
	 */
	public static function checkSession() {
		$token = self::getToken();
		if ($_SESSION[SESSION_TOKEN] == $token) {
			return true;
		} else {
			return false;
		}		
	}

}
?>