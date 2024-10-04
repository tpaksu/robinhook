<?php
use Tpaksu\Robinhook\Webhooks;

require 'vendor/autoload.php';

$server = new Webhooks();

try {
    $server->startServer(5501);
}catch(RuntimeException $ex){
    echo $ex->getMessage();
}
