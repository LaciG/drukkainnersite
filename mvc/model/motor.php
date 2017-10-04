<?php
include_once 'model.php';

session_set_cookie_params(86400, "/", "", false, false);
session_start();

function array_to_json($array) {
    $json = json_encode($array, JSON_PARTIAL_OUTPUT_ON_ERROR);
    return $json;
}

function json_to_array($json) {
    $array = json_decode($json);
    return $array;
}

function undefined_type() {
    return array_to_json(["status" => 0, "message" => "Undefined API type"]);
}
?>