<?php

namespace thetomcake\SimpleRancher\Handlers;

use thetomcake\SimpleRancher\Handlers\Interfaces\Handler as HandlerInterface;
use thetomcake\SimpleRancher\Traits\FindsHandlers;

class Collection extends Handler
{
    use FindsHandlers;
    
    public function items() : array
    {
        return $this->data->data;
    }
    
    public function count() : int
    {
        return count($this->items());
    }
    
    /**
     * @return \thetomcake\SimpleRancher\Handlers\Interfaces\Handler or NULL if no items
     */
    public function first()
    {
        return !$this->count() ? null : $this->getHandlerFromData(array_values($this->items())[0]);
    }
    
    public function last()
    {
        return !$this->count() ? null : $this->getHandlerFromData(array_values($this->items())[count($this->items()) - 1]);
    }
    
}
