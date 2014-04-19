<?php header("Content-Type: application/json; charset=utf-8"); ?>
<?php
// Session
session_start();

require_once('./classes/constants/Includes.php');

$request = new WebRequest();
new LoginPresenter($request);
?>

