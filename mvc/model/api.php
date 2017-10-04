<?php
require_once 'motor.php';

header("Content-Type: application/json", true);
        
$postdata = json_decode($_POST["json"]);

switch ($postdata["type"]) {
    case "":
        
        break;
    default:
        echo undefined_type();
        break;
}

?>