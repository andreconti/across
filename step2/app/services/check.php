<?php
include_once '../system/config.php';
include_once '../system/autoloader.php';

if(isset($_POST["sWord"])){ //vari altri controlli autenticazione

    $classApplication    = classApplication::getInstance();
    
    $classApplication->initApp($_POST["sWord"]);
    $classApplication->checkLength();
    $classApplication->checkToken();
    $classApplication->checkPalindrom();
}else{
    http_response_code(404);
    die();
}
?>