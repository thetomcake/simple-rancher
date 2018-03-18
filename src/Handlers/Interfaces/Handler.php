<?php

namespace thetomcake\SimpleRancher\Handlers\Interfaces;

use stdClass;

interface Handler {
    
    public function __construct(stdClass $data);
    
    public function links() : stdClass;
    
    public function link(string $link) : string;
    
    public function actions() : stdClass;
    
    public function action(string $action) : string;
    
    /**
     * @return string (or NULL if collection)
     */
    public function id();
    
    public function type() : string;
    
    public function isCollection() : bool;
    
    public function has(string $name);
    
    public function __get($name);
}