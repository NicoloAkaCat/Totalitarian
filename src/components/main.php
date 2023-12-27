<?php
    require_once(__DIR__."/../variable_utils.php");
    require_once(VarUtils::getDocumentRoot()."session.php");
    
    Session::startSession();
?>
<main>
<?php
    if(!VarUtils::checkIsSetInArray($_SESSION, "UID")){
        echo '<h1 class="text-large">Sito privato, registrati</h1>';
    }else{
        echo '<h1 class="text-large">Benvenuto</h1>';
        echo '<h2 class="text-small">Questa è la tua email: '.htmlspecialchars(Session::getSessionVar('email'))."</h2>";
    }
?>
</main>