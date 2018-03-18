<?php

namespace thetomcake\SimpleRancher\Handlers;

use thetomcake\SimpleRancher\Handlers\Interfaces\Handler as HandlerInterface;
use stdClass;

class Handler implements HandlerInterface
{
    protected $data;
    
    public function __construct(stdClass $data)
    {
        $this->data = $data;
    }
    
    public function data() : stdClass
    {
        return $this->data;
    }
    
    public function links() : stdClass
    {
        return $this->isCollection() ? new stdClass : $this->data->links;
    }
    
    public function link(string $link) : string
    {
        return property_exists($this->links(), $link) ? $this->links()->$link : '';
    }
    
    public function actions() : stdClass
    {
        return $this->isCollection() ? new stdClass : $this->data->actions;
        
    }
    
    public function action(string $action) : string
    {
        return property_exists($this->actions(), $action) ? $this->actions()->$action : '';
    }
    
    /**
     * @return string (or NULL if collection)
     */
    public function id()
    {
        return $this->isCollection() ? null : $this->data->id;
    }
    
    public function type() : string
    {
        return $this->data->type;
    }
    
    public function isCollection() : bool
    {
        return $this->type() === 'collection';
    }
    
    public function has(string $name)
    {
        return property_exists($this->data, $name);
    }
    
    public function __get($name)
    {
        return $this->data->$name;
    }
    
}
 