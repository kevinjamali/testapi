<?php
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;




$client = new GuzzleHttp\Client();

$request = $client->get('/API/jsonI.php?length=10&type=uint8');

$response = $request->send();

echo $body = $response->getBody(true);
class testapitest extends \PHPUnit\Framework\TestCase 
{
	
	
}