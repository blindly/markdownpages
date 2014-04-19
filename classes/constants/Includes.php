<?php

/** Include Constants **/
require_once('./classes/constants/Configuration.php');
require_once('./classes/constants/Constants.php');

/** Include Models **/
require_once('./classes/models/PageModel.class.php');

/** Include Presenters **/
require_once('./classes/presenters/iPresenter.class.php');
require_once('./classes/presenters/GenericPresenter.class.php');
require_once('./classes/presenters/LoginPresenter.class.php');
require_once('./classes/presenters/PagePresenter.class.php');


/** Include Result **/
require_once('./classes/results/GenericResult.class.php');
require_once('./classes/results/OutputWrapper.class.php');

/** Include utils **/
require_once('./classes/utils/FileHelper.class.php');
require_once('./classes/utils/LoginHelper.class.php');
require_once('./classes/utils/WebRequest.class.php');

/** Include View */
require_once('./classes/views/iGenericView.class.php');
require_once('./classes/views/SimpleView.class.php');

/** Markdown Library **/
require_once('./lib/markdown.php');
require_once('./lib/Parsedown.php');

?>