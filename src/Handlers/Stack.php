<?php

namespace thetomcake\SimpleRancher\Handlers;

use thetomcake\SimpleRancher\Rancher;
use thetomcake\SimpleRancher\Handlers\Interfaces\Handler as HandlerInterface;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Yaml\Exception\ParseException;

class Stack extends Handler
{
    protected $services;
    
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
    
    public function isActive() : bool
    {
        return $this->state() === 'active';
    }
    
    public function services(bool $noCache = false) : Collection
    {
        return $this->services === null || $noCache === true ? $this->services = Rancher::get($this->link('services')) : $this->services;
    }
    
    public function images(bool $noCache = false) : array
    {
        return array_filter(array_map(function($service) {
            return get_class($service) === Service::class ? $service->image() : '';
        }, $this->services($noCache)->items()));
    }
}
