<?php

use KDuma\LPD\Client\DebugHandler\BasicDebugHandler;
use KDuma\LPD\Client\Exceptions\InvalidJobException;
use KDuma\LPD\Client\Exceptions\PrintErrorException;
use KDuma\LPD\Client\Configuration;
use KDuma\LPD\Client\Jobs\FileJob;
use KDuma\LPD\Client\Jobs\TextJob;
use KDuma\LPD\Client\PrintService;

set_time_limit(0);
error_reporting(E_ALL);

require '../vendor/autoload.php';

$configuration = Configuration::make('127.0.0.1');
$print_service = new PrintService($configuration);

$debug_handler = new BasicDebugHandler();
$print_service->setDebugHandler($debug_handler);

$jobs = [
    new TextJob("This is test!"),
    new FileJob(__FILE__),
];

foreach ($jobs as $job) {
    try {
        $print_service->sendJob($job);
        echo "Job Sent!\n";
    } catch (InvalidJobException | PrintErrorException $e) {
        echo sprintf("Error occured: %s\n", $e->getMessage());
    }
}

echo sprintf("\n--- DEBUG LOG ---\n\n%s", $debug_handler->getLog());
