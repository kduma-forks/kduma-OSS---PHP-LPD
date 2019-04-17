<?php

use KDuma\LPD\Server\Server;

set_time_limit(0);
error_reporting(E_ALL);

require '../vendor/autoload.php';

try {
    
    (new Server())
        ->setAddress('127.0.0.1')
        ->setPort(Server::LPD_DEFAULT_PORT)
        ->setMaxConnections(5)
        ->setHandler(function ($data, $ctrl) {
            echo $data;
            file_put_contents(dirname(__FILE__) . '/dump.txt', $data);
        })
        ->run();
    
} catch (Exception $e) {
    echo sprintf("Error occured: %s", $e->getMessage());
}
