<?php 

require("vendor/autoload.php");

use GuzzleHttp\Client;

$username = "Sulala Bot";
$icon = ":ghost:";
$channel ="#young-buffalo";
$hook = "https://hooks.slack.com/services/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";

if($_POST) {
    $message = $_POST['text'];
    // $userPostMessage = $_POST['username'];
    $client = new Client(['verify' => false]);

    // $res = $client->request("POST", $hook, ["form_params" => [
    //     "payload" =>  json_encode(["text" => "bot reply" . $message])
    // ]]);

}



