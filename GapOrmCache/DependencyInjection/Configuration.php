<?php
namespace GapOrmCache\DependencyInjection;

class Configuration
{
    /**
     * @var string
     */
    private $keyPrefix = 'gapOrmCache';

    /**
     * @var
     */
    private $driver;

    /**
     * @param $params
     */
    public function buildConfig($params){
        if(isset($params['prefix']) && strlen($params['prefix']) > 0)
            $this->keyPrefix = hash('sha256', $this->keyPrefix . $params['prefix']);
        if(isset($params['driver']))
            $this->driver = new $params['driver']($this->keyPrefix);
    }

    /**
     * @return string
     */
    public function getKeyPrefix(){
        return $this->keyPrefix;
    }

    /**
     * @return string
     */
    public function getDriver(){
        return $this->driver;
    }
}