<?php declare(strict_types=1);

namespace Tpaksu\Robinhook;

use Laminas\Diactoros\ResponseFactory;
use League\Route\Router;
use League\Route\Strategy\JsonStrategy;
use Psr\Http\Message\ServerRequestInterface;
use WebSocket\Client;

class Robinhook
{
    public Router $router;
    public ResponseFactory $response_factory;

    public function __construct(Router $router)
    {
        $this->router = $router;
        $this->response_factory = new ResponseFactory();
        $this->router = $this->router->setStrategy(new JsonStrategy($this->response_factory));
    }

    public function initRoutes()
    {
        // map a route
        $this->router->map('POST', '/webhook', function (
            ServerRequestInterface $request
        ): array {
            $wsClient = new Client('ws://0.0.0.0:5501');
            $wsClient->send(json_encode(\Laminas\Diactoros\Request\ArraySerializer::toArray($request)));
            $wsClient->close();
            return ["[accepted]"];
        });
        $this->router->map("GET", "/", function () {
            return [
                "welcome to tpaksu's personal webhook redirector (robinhook)"
            ];
        });
    }
}
