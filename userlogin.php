<?php

require_once './init.php';

use Orchestrators\UserLoginOrchestrator;

$userOrch = new UserLoginOrchestrator();
$result   = $userOrch->build($_POST['email'], $_POST['password']);

header("Content-Type: application/json");
echo json_encode($result);