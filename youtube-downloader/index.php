<?php

use Symfony\Component\Console\Application;
use YouTubeDownloader\Commands\Download;

require_once "vendor/autoload.php";

$app = new Application();
$app->add(new Download());
$app->run();
