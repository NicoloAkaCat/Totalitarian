<?php
    require_once(__DIR__."/../variable_utils.php");
    require_once(VarUtils::getDocumentRoot()."session.php");
    
    Session::startSession();
    Session::destroySession();
    header("Location: /Totalitarian/src/index.php");
    exit(0);
?>