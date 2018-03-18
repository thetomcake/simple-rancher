<?php

namespace thetomcake\SimpleRancher;

use Exception;
use GuzzleHttp\Psr7\Response;
use stdClass;
use thetomcake\SimpleRancher\Exceptions\InvalidResponseException;
use thetomcake\SimpleRancher\Traits\FindsHandlers;

class RancherResponse
{
    use FindsHandlers;
    
    private $response;
    private $data;
    
    public function __construct(Response $reponse)
    {
        $this->response = $reponse;
        $this->data = $this->getResponseData();
    }
    
    private function getResponseData() {
        try {
            $data = json_decode($this->response->getBody(), false);
        } catch (Exception $e) {
            throw new InvalidResponseException('Data provided to RancherResponse caused an exception: ' . $e->getMessage());
        }
        
        if ($data === null) {
            throw new InvalidResponseException('Data provided to RancherResponse was invalid.');
        }
        
        return $data;
    }
    
    public function getData() : stdClass
    {
        return $this->data;
    }
    
    public function getResponse() : Response
    {
        return $this->response;
    }
    
    public function getHandler() 
    {
        return $this->getHandlerFromData($this->getData());
    }
    
}
