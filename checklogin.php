<?php

$sessionid = $_GET['sessionid'];
session_id($sessionid);

$output = array("result" => "");
session_start();

if (isset($_SESSION['userid']) && $_SESSION['isloggedin'] == true) {
    $output["result"] = true;
} else {
    $output["result"] = false;
}

echo json_encode($output);
?>