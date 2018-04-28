<?php

namespace thetomcake\SimpleRancher\Handlers;

use stdClass;
use thetomcake\SimpleRancher\Rancher;

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
    
    public function environment() : stdClass
    {
        return isset($this->data->launchConfig->environment) ? $this->data->launchConfig->environment : new stdClass;
    }
    
    public function commands() : array
    {
        return isset($this->data->launchConfig->command) ? $this->data->launchConfig->command : [];
    }
    
    public function command() : string
    {
        return implode(' ', $this->commands());
    }
    
    public function restart()
    {
        return Rancher::jsonPost($this->action('restart'), [
            'rollingRestartStrategy' => [
                'batchSize' => 1,
                'intervalMillis' => 2000
            ]
        ]);
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
