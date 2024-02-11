<?php
require_once(__DIR__."/../variable_utils.php");
require_once(VarUtils::getDocumentRoot()."session.php");
Session::startSession();
Session::setSessionVar("errorMessage", "The page you are looking for does not exist");
Session::setSessionVar("errorCode", 404);
include_once(VarUtils::getDocumentRoot()."error/error_page.php");