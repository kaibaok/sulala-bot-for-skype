<?php 

// $content = "the gioi cua chung ta";

// $arr = explode(" ", $content);

// $keyword = "chung";
// $keyword2 = "chung ta";
// $keyword3 = "chung ta la";

// $saveKey = "";

// foreach ($arr as $key => $value) {
//     if(trim($value) == $keyword) {
//         $saveKey = trim($value);
//     }
//      else if($saveKey. " ". trim($value) == $keyword2) {
//         $saveKey .= " ". trim($value);
//     } else if($saveKey != '' && $saveKey. " ". trim($value) != $keyword3) {
//         break;
//     }
// }

// var_dump($saveKey);
// die;

require("vendor/autoload.php");
require("bot.php");

use GuzzleHttp\Client;
use Doctrine\DBAL\DriverManager;
// use BotMan\BotMan\BotMan;
// use BotMan\BotMan\BotManFactory;
// use BotMan\BotMan\Drivers\DriverManager as BotDriverManager;

// BotDriverManager::loadDriver(\BotMan\Drivers\Web\WebDriver::class);

// // Create an instance
// $botman = BotManFactory::create(["driver" => "web"]);

// $botman->hears($_POST['message'], function (BotMan $bot) {
//     var_dump($bot);die;
//     // $bot->reply('Hello yourself.');

// });

// $botman->listen();




$appConfig = require('config.php');

$channel  = (isset($_GET['channel'])) ? $_GET['channel'] : $appConfig['channel'];

$botConfig = new BOT($appConfig);

$bot = $botConfig->getBot($channel);

if(!empty($bot) && $_POST && !empty($_POST)) {

    $username = $_POST['user_name'];
    $message = $_POST['text'];

    if($username != $appConfig['botname'] && $message != "") {

        $arrKeywords = explode(' ', $message);

        $configMessage = searchKeyword($arrKeywords, $botConfig);

        $replyMessage = $botConfig->getMessageReply($configMessage);

        if($replyMessage) {
            $client = new Client(['verify' => false]);
            $res = $client->request("POST", $appConfig['hook'], ["form_params" => [
                "payload" =>  json_encode([
                    "username" => $appConfig['botname'],
                    "icon_emoji" => $bot['icon'],
                    "icon_url" => $bot['icon_url'],
                    "text" => $replyMessage['reply']
                ])
            ]]);
        }
    }
}



function searchKeyword($arrKeywords, $botConfig) {
    $configMessage = "";
    $keyword = "";

    foreach ($arrKeywords as $key => $value) {
        if(!$configMessage) {
            $reply = $botConfig->getMessageReply($value);
            if(!$reply) {
                continue;
            } else {
                $configMessage = $value;
            }
        } else {
            $configMessage .= ' '. $value;
            $reply = $botConfig->getMessageReply($configMessage);
            if(!$reply) {
                continue;
            } else {
                $keyword = $configMessage;
            }            
        }
    }
    return $keyword;
}

