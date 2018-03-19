<?php

namespace thetomcake\SimpleRancher\Handlers;

class Service extends Handler
{
    public function name() : string
    {
        return $this->data->name;
    }
    
    public function currentScale() : int
    {
        return $this->data->currentScale;
    }   

    public function image() : string
    {
        return isset($this->data->launchConfig->imageUuid) ? $this->data->launchConfig->imageUuid : '';
    }
    
    public function healthState() : string
    {
        return $this->data->healthState;
    }
    
    public function isHealthy() : bool
    {
        return $this->healthState() === 'healthy';
    }
    
    public function state() : string
    {
        return $this->data->state;
    }
    
    public function isActive() : bool
    {
        return $this->state() === 'active';
    }
}
