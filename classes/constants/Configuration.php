<?php

// Configuration
 
// Path (absolute or relative) where the pages are stored on the server
define(PAGE_FOLDER_PATH, "./data/pages/");

 // Path (absolute or relative) where deleted pages are stored on the server
define(TRASH_FOLDER_PATH, "./data/trash/");


// Extension of the Page files. E.g .txt or .md
define(PAGE_FILE_EXT, ".txt");

// The default content for newly created pages
define(NEW_PAGE_CONTENT, "Title\n=====\n\nSub\n---\n");

// Password md5
define(USER_PASS, "fe01ce2a7fbac8fafaed7c982a04e229");

// Path (absolute or relative) where the logins are stored
define(LOGIN_CONTROL_FILE, "./data/logins.txt");

// Number of recent pages to be displayed
define(NUMBER_OF_RECENT_PAGES, 10);


// Password number of wrong attempts
define(USER_PASS_WRONG_COUNTER, 500);


?>