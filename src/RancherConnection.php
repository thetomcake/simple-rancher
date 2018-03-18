<?php

namespace thetomcake\SimpleRancher;

use GuzzleHttp\Client;

class RancherConnection
{
    private $baseUrl;
    private $accessToken;
    private $secret;
    
    public function __construct(string $baseUrl, string $accessToken, string $secret)
    {
        $this->baseUrl = rtrim($baseUrl, '/');;
        $this->accessToken = $accessToken;
        $this->secret = $secret;
    }
    
    public function baseUrl() : string
    {
        return $this->baseUrl;
    }
    
    public function accessToken() : string
    {
        return $this->accessToken;
    }
    
    public function secret() : string
    {
        return $this->secret;
    }
    
}
