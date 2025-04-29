<?php 
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use App\WebSocket\NotificationServer;

require dirname(__DIR__) . '/vendor/autoload.php';

$notificationServer = new NotificationServer();

$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            $notificationServer
        )
    ),
    8081 // Port WebSocket
);

$server->run();
