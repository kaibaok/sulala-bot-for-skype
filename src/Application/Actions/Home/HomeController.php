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

    private $token = "Bearer xoxb-1563412321988-1557488026931-K8y2MYGAG2iHnXECdusa42K6";
    
    private $endPoint = "https://slack.com/api";
    
    private $actions = [
        "postMessage" => "",
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
        $listChannel = $this->getConversations();
        
        $this->logger->info(var_export($listChannel,true));
        // $json = json_encode(['asdasd'=> 'asdasd'], JSON_PRETTY_PRINT);
        // $response->getBody()->write($json);
        return $response->withAddedHeader('Content-Type', 'application/json');
    }
    
    protected function getConversations() {
        $client = new Client([
            'headers' => [
                'Authorization' => $this->token,
                 'Accept'     => 'application/json',
            ],
            'verify' => false
        ]);
        $response = $client->request('GET', 
            $this->endPoint."/".$this->actions['conversations']            
        );
        return $response->getBody()->getContents();
    }
}