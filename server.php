<?php
use Tpaksu\Robinhook\Websocket;

require 'vendor/autoload.php';

$server = new Websocket();

try {
    $server->startServer(5501);
}catch(RuntimeException $ex){
    echo $ex->getMessage();
}
