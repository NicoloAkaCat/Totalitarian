<?php
    require_once(__DIR__."/../variable_utils.php");
    require_once(VarUtils::getDocumentRoot()."session.php");
    Session::startSession();
    Session::setSessionVar("errorMessage", "Error with your Javascript, try cleaning your localstorage");
    Session::setSessionVar("errorCode", 500);
    include_once(VarUtils::getDocumentRoot()."error/error_page.php");