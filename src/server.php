<?php

$ds = DIRECTORY_SEPARATOR;

require __DIR__ . "..{$ds}vendor{$ds}autoload.php";

use Scouterna\Mocknet\ServerApp;

$dbParamsB64 = $_ENV['MOCKNET_DBPARAMS'];
$dbParams = json_decode(base64_decode($dbParamsB64), true);

ServerApp::run($dbParams);
