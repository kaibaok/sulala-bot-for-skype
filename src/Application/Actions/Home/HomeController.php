<?php
namespace App\Application\Actions\Home;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Log\LoggerInterface;
use GuzzleHttp\Client;
// use GuzzleHttp\ClientInterface;

class HomeController 
{
   private $container;
     /**
     * @var LoggerInterface
     */
    protected $logger;

    private $token = "xoxb-1563412321988-1560979488099-lBNzrDoaArlXwnJZd6Zrvv9w";
    
    private $hook = "https://hooks.slack.com/services/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";
    
    private $endPoint = "https://slack.com/api";
    
    private $channelID = "C01FYEYDCLF";
    
    private $actions = [
        "postMessage" => "chat.postMessage",
        "conversations" => "conversations.list"
        
    ];
    
    // constructor receives container instance
    public function __construct(ContainerInterface $container, LoggerInterface $logger)
    {
       $this->container = $container;
       $this->logger = $logger;
    }


    public function __invoke(Request $request, Response $response, $agrs)
    {
        // $result = $this->getConversations();
        $result = $this->postMessage("Hellloooooo");
        // $this->logger->info(var_export($listChannel,true));
        // // $json = json_encode(['asdasd'=> 'asdasd'], JSON_PRETTY_PRINT);
        $response->getBody()->write($result);
        return $response->withAddedHeader('Content-Type', 'application/json');
    }
    
    protected function getConversations() 
    {
        $client = new Client([
            'headers' => [
                'Authorization' => "Bearer ".$this->token,
                 'Accept'     => 'application/json',
            ],
            'verify' => false
        ]);
        $response = $client->request('GET', 
            $this->endPoint."/".$this->actions['conversations']            
        );
        return $response->getBody()->getContents();
    }
    
    protected function postMessage($text) 
    {
         $client = new Client([
            'headers' => [
                'Authorization' => "Bearer ".$this->token,
                 'Accept'     => 'application/x-www-form-urlencoded',
            ],
            'verify' => false
        ]);
        
        $response = $client->request('POST', 
            $this->endPoint."/".$this->actions['postMessage'],
            [
                \GuzzleHttp\RequestOptions::JSON => ["channel" => $this->channelID,
                "text" => $text
            ]   
                
            ]
        );
        
        return $response->getBody()->getContents();
    }
}