<?php

$ds = DIRECTORY_SEPARATOR;

require __DIR__ . "..{$ds}vendor{$ds}autoload.php";

use Scouterna\Mocknet\ServerApp;

$dbFile = __DIR__ . "{$ds}membernet.db";

ServerApp::run($dbFile);