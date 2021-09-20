<?php

$ds = DIRECTORY_SEPARATOR;

$vendor = $_ENV['MOCKNET_VENDOR_FOLDER'];
require "$vendor{$ds}autoload.php";

use Scouterna\Mocknet\Database\DbGenerator;

$dbParamsB64 = $_ENV['MOCKNET_DBPARAMS'];
$dbParams = json_decode(base64_decode($dbParamsB64), true);

$groupId = $_ENV['MOCKNET_GROUP_ID'];
$apiKey = $_ENV['MOCKNET_API_KEY'];

$generator = new DbGenerator($dbParams);
$entityManager = $generator->generateDb();
$entityManager->flush();
