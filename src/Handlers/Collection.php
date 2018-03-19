<?php

namespace thetomcake\SimpleRancher\Handlers;

use thetomcake\SimpleRancher\Handlers\Interfaces\Handler as HandlerInterface;
use thetomcake\SimpleRancher\Traits\FindsHandlers;
use Iterator;
use stdClass;

class Collection extends Handler implements Iterator
{
    use FindsHandlers;
    
    protected $items;
    protected $key = 0;
    
    public function __construct(stdClass $data)
    {
        parent::__construct($data);
        $this->items = $this->makeItems();
    }
    
    public function items()
    {
        return $this->items;
    }
        
    public function count() : int
    {
        return count($this->data()->data);
    }
    
    /**
     * Allows (callable $callable) and (string $field, string $value) and (string $field, string $value, bool $strict) formats
     * @param mixed $where
     * @param string $value optional
     * @param bool $strict optional
     */
    public function where($where, string $value = null, bool $strict = true)
    {
        $callable = is_callable($where) ? $where : function($item) use ($where, $value, $strict) {
            return $strict ? $item->$where === $value : $item->$where == $value;
        };
        
        $newData = clone $this->data;
        $newData->data = array_filter($this->data()->data, $callable);
        
        return $this->getHandlerFromData($newData);
    }
    
    /**
     * @return \thetomcake\SimpleRancher\Handlers\Interfaces\Handler or NULL if no items
     */
    public function first()
    {
        return !$this->count() ? null : $this->getHandlerFromData(array_values($this->data()->data)[0]);
    }
    
    public function last()
    {
        return !$this->count() ? null : $this->getHandlerFromData(array_values($this->data()->data)[count($this->data()->data) - 1]);
    }
    
    public function current()
    {
        return $this->items()[$this->key()];
    }

    public function key()
    {
        return $this->key;
    }

    public function next() : void
    {
        $this->key++;
    }

    public function rewind() : void
    {
        $this->key = 0;
    }

    public function valid() : bool
    {
        return isset($this->items()[$this->key()]);
    }
    
    protected function makeItems() : array
    {
        return array_values(array_map(function($item) {
            return $this->getHandlerFromData($item);
        }, $this->data->data));
    }


}
