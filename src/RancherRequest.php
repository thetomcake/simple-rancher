<?php

namespace thetomcake\SimpleRancher;

use GuzzleHttp\Client;
use thetomcake\SimpleRancher\Handlers\Interfaces\Handler;

class RancherRequest
{
    private $connection;
    
    public function __construct(RancherConnection $connection)
    {
        $this->connection = $connection;
    }
    
    public function get(string $uri, array $params = []) : Handler
    {
        return $this->request('get', $uri, ['query' => $params]);
    }
    
    public function put(string $uri, array $params = [], array $getParams = []) : Handler
    {
        return $this->request('put', $uri, ['form_params' => $params, 'query' => $getParams]);
    }
    
    public function post(string $uri, array $params = [], array $getParams = []) : Handler
    {
        return $this->request('post', $uri, ['form_params' => $params, 'query' => $getParams]);
    }
    
    public function delete(string $uri, array $params = []) : Handler
    {
        return $this->request('delete', $uri, $params);
    }
    
    public function jsonPut(string $uri, array $params = [], array $getParams = []) : Handler
    {
        return $this->request('put', $uri, ['json' => $params, 'query' => $getParams]);
    }
    
    public function jsonPost(string $uri, array $params = [], array $getParams = []) : Handler
    {
        return $this->request('post', $uri, ['json' => $params, 'query' => $getParams]);
    }
    
    protected function request(string $method, string $uri, array $options = []) : Handler
    {
        $client = new Client;
        
        $parsedUrl = parse_url($uri); //if it's a full url with a scheme and host we want to strip them out and use the connection
        if (isset($parsedUrl['host'], $parsedUrl['scheme'], $parsedUrl['path'])) {
            $uri = $parsedUrl['path'];
        }
        
        $authOption = ['auth' => [$this->connection->accessToken(), $this->connection->secret()]];

        $guzzleResponse = $client->$method($this->connection->baseUrl() . '/' . ltrim($uri, '/'), array_merge($options, $authOption));
        $rancherResponse = new RancherResponse($guzzleResponse);
        
        return $rancherResponse->getHandler();
    }
    
}
