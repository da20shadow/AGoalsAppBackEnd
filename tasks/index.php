<?php
require_once('TasksHandler.php');
header("Content-Type: application/json");

$url = str_replace('AGoalsAppBackEnd/',
    '',$_SERVER['REQUEST_URI']);

$inputData = json_decode(file_get_contents('php://input'), true);

$apuHandler = new TasksHandler();
$apuHandler->processRequest($url,$inputData);
