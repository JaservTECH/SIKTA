<?php
    class LoadMod {}
    $rest = require_once "JModel/vendor/autoload.php";
    Model\Core::Initialize();
    if($rest){
        //Model\Core::Initialize();
        return true;
    }else return false;