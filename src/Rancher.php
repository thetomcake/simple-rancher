<?php

namespace thetomcake\SimpleRancher;

use GuzzleHttp\Client;
use thetomcake\SimpleRancher\Exceptions\InvalidConnectionException;

class Rancher
{
    private static $connections = [];
    
    public static function newConnection(string $name, string $baseUrl, string $accessToken, string $secret)
    {
        return self::addConnection($name, new RancherConnection($baseUrl, $accessToken, $secret));
    }
    
    public static function addConnection(string $name, RancherConnection $connection)
    {
        self::$connections[$name] = $connection;
    }
    
    public static function removeConnection(string $name)
    {
        unset(self::$connections[$name]);
    }
    
    public static function connection(string $name)
    {
        if (!isset(self::$connections[$name])) {
            throw new InvalidConnectionException('No connection of name ' . $name . ' is available');
        }
        
        return new RancherRequest(self::$connections[$name]);
    }
    
    public static function projects(string $connectionName = null)
    {
        return $connectionName === null ? self::get('/v2-beta/projects') : self::connection($connectionName)->get('/v2-beta/projects');
    }
    
    public static function __callStatic(string $name, array $params)
    {
        if (!count(self::$connections)) {
            throw new InvalidConnectionException('No connections available');
        }
        
        $request = new RancherRequest(array_values(self::$connections)[0]);
        
        return call_user_func_array([$request, $name], $params);
    }
   
}
