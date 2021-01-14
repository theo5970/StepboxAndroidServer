<?php

$sessionid = $_GET['sessionid'];
session_id($sessionid);

$output = array("result" => "");

session_start();
if (session_destroy()) {
    $output["result"] = "success";
} else {
    $output["result"] = "fail";
}

echo json_encode($output);
?>
