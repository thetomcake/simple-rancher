<?php

namespace thetomcake\SimpleRancher\Handlers;

use thetomcake\SimpleRancher\Rancher;
use thetomcake\SimpleRancher\Handlers\Interfaces\Handler as HandlerInterface;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Yaml\Exception\ParseException;

class Container extends Handler
{
    public function state() : string
    {
        return $this->data->state;
    }
    
    public function healthState() : string
    {
        return $this->data->healthState;
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
    
    public function isRunning() : bool
    {
        return $this->state() === 'running';
    }
    
    public function delete()
    {
        return Rancher::delete($this->link('self'));
    }
    
    public function images(bool $noCache = false) : array
    {
        return array_map(function($service) {
            return $service->image();
        }, $this->services($noCache)->items());
    }
}
