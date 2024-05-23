<?php
session_start();
header('Content-Type: application/json');

$response = array('authenticated' => false);

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    $response['authenticated'] = true;
}

echo json_encode($response);
?>