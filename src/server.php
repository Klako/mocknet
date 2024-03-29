<?php

$ds = DIRECTORY_SEPARATOR;

$vendor = $_ENV['MOCKNET_VENDOR_FOLDER'];
require "$vendor{$ds}autoload.php";

use Scouterna\Mocknet\ServerApp;

$dbParamsB64 = $_ENV['MOCKNET_DBPARAMS'];
$dbParams = json_decode(base64_decode($dbParamsB64), true);

$groupId = $_ENV['MOCKNET_GROUP_ID'];
$apiKey = $_ENV['MOCKNET_API_KEY'];

ServerApp::run($dbParams, $groupId, $apiKey);
