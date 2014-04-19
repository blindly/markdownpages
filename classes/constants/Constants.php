<?php
/**
 * Constants
 */

/**
 * Page action parameter 
 */
define(ACTION, "action");

/**
 * Other URL parameters
 */
define(CONTROLLER_PAGE_NAME, "pagename");
define(CONTROLLER_PAGE_CONTENT, "pagecontent");
define(CONTROLLER_SEARCH_STRING, "search");
define(CONTROLLER_LOGIN_PASS, "pass");

/**
 * Status
 */
define(STATUS_OK, 1);
define(STATUS_UNKNOWN, 0);
define(ERROR_UNKNOWN, -1);

/**
 * File handling Errors
 */
define(ERROR_FILE_CANNOT_WRITE, -21);
define(ERROR_FILE_EXISTS, -22);
define(ERROR_FILE_NAME_INVALID, -23);
define(ERROR_FILE_NOT_FOUND, -24);

/**
 * Session handling and Errors
 */
define(ERROR_SESSION_INVALID, -31);
define(SESSION_TOKEN, "mdp_session_token");

/**
 * Login
 */
define(ERROR_LOGIN_INVALID, -41);

/**
 * Name of generic Result Class
 */
define(RESULT_CLASS, "GenericResult");

?>