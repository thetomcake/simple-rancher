<?php

namespace thetomcake\SimpleRancher\Handlers;

use thetomcake\SimpleRancher\Rancher;
use thetomcake\SimpleRancher\Handlers\Interfaces\Handler as HandlerInterface;
use Symfony\Component\Yaml\Yaml;

class Stack extends Handler
{
    public function name() : string
    {
        return $this->data->name;
    }
    
    public function state() : string
    {
        return $this->data->state;
    }
    
    public function healthState() : string
    {
        return $this->data->healthState;
    }
    
    public function dockerCompose() : array
    {
        return Yaml::parse($this->data->dockerCompose);
    }
    
    public function rancherCompose() : array
    {
        return Yaml::parse($this->data->rancherCompose);
    }
    
    public function isHealthy() : bool
    {
        return $this->healthState() === 'healthy';
    }
    
    public function isDegraded() : bool
    {
        return $this->healthState() === 'degraded';
    }
    
    public function isUnhealthy() : bool
    {
        return $this->healthState() === 'unhealthy';
    }
    
    public function isInitializing() : bool
    {
        return $this->healthState() === 'initializing';
    }
    
    public function services()
    {
        return Rancher::get($this->link('services'));
    }
    
    public function images() : array
    {
        $images = [];
        foreach ($this->dockerCompose()['services'] as $serviceCompose) {
            if (!in_array($serviceCompose['image'], $images)) {
                $images[] = $serviceCompose['image'];
            }
        }
        return $images;
    }
}
