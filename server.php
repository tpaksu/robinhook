<?php
use Tpaksu\Robinhook\Websocket;

require 'vendor/autoload.php';

$server = new Websocket();
$server->startServer(5501);
