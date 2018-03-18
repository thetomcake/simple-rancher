<?php

namespace thetomcake\SimpleRancher\Traits;

use stdClass;
use thetomcake\SimpleRancher\Exceptions\InvalidHandlerException;
use thetomcake\SimpleRancher\Handlers\Interfaces\Handler;

trait FindsHandlers
{
    protected $handlers = [
        'collection' => \thetomcake\SimpleRancher\Handlers\Collection::class,
        'project' => \thetomcake\SimpleRancher\Handlers\Project::class,
        'stack' => \thetomcake\SimpleRancher\Handlers\Stack::class,
    ];
    
    protected $defaultHandler = \thetomcake\SimpleRancher\Handlers\Handler::class;
    
    public function getHandlerFromData(stdClass $data) : Handler
    {
        try {
            $handlerClass = $this->findHandlerClassFromData($data);
        } catch (InvalidHandlerException $e) {
            $handlerClass = $this->defaultHandler;
        }
        return new $handlerClass($data);
    }
    
    public function findHandlerClassFromData(stdClass $data) : string
    {
        if (!property_exists($data, 'type') || !isset($this->handlers[$data->type])) {
            throw new InvalidHandlerException('Cannot get valid handler from data');
        }
        
        return $this->handlers[$data->type];
    }
    
    public function findHandlerClassFromName(string $handler) : string
    {
        if (!isset($this->handlers[$handler])) {
            throw new InvalidHandlerException($handler . ' is not a valid handler');
        }
        
        return $this->handlers[$handler];
    }
    
}
