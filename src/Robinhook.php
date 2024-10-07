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
        foreach([
            "/adyen/account/webhook",
            "/adyen/dispute/webhook",
            "/adyen/payment_processing/webhook",
            "/adyen/transfer/webhook"
        ] as $target){
            // map a route
            $this->router->map('POST', $target, function (ServerRequestInterface $request) {
                return $this->redirectRequest($request);    
            });
        }
        
        $this->router->map("GET", "/",  function(){
            return [
                "welcome to tpaksu's personal webhook redirector (robinhook)"
            ];
        });
    }

    public function redirectRequest($request) {
        $wsClient = new Client('ws://0.0.0.0:5501');
        $wsClient->send(json_encode(\Laminas\Diactoros\Request\ArraySerializer::toArray($request)));
        $wsClient->close();
        
        return new \Laminas\Diactoros\Response\TextResponse( "[accepted]", 200, ['Content-Type' => ['application/json']] );
    }
}
