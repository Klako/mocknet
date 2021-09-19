<?php

$ds = DIRECTORY_SEPARATOR;

require __DIR__ . "..{$ds}vendor{$ds}autoload.php";

use Scouterna\Mocknet\ServerApp;

$dbParamsB64 = $_ENV['MOCKNET_DBPARAMS'];
$dbParams = json_decode(base64_decode($dbParamsB64), true);

$groupId = $_ENV['GROUP_ID'];
$apiKey = $_ENV['API_KEY'];

ServerApp::run($dbParams, $groupId, $apiKey);
