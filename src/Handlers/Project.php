<?php

namespace thetomcake\SimpleRancher\Handlers;

use thetomcake\SimpleRancher\Handlers\Interfaces\Handler as HandlerInterface;
use thetomcake\SimpleRancher\Rancher;

class Project extends Handler
{
    public function name() : string
    {
        return $this->data->name;
    }
    
    public function stacks() : HandlerInterface
    {
        return Rancher::get($this->link('stacks'));
    }
}
