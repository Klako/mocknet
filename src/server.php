<?php

$ds = DIRECTORY_SEPARATOR;

require __DIR__ . "..{$ds}vendor{$ds}autoload.php";

use Scouterna\ScoutnetMock\ServerApp;

$dbFile = __DIR__ . "{$ds}membernet.db";

ServerApp::run($dbFile);