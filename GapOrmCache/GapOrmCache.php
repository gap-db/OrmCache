<?php
namespace GapOrmCache;

use GapOrmCache\DependencyInjection\Configuration;
use Safan\GlobalExceptions\FileNotFoundException;
use Safan\Safan;

/**
 * Class GapOrmCache
 * @package GapOrmCache
 */
class GapOrmCache
{
    /**
     * Available cache drivers
     *
     * @var array
     */
    private $drivers = array(
        'memcache' => 'GapOrmCache\Drivers\MemcacheDriver'
    );

    /**
     * @var
     */
    private $config;

    /**
     * @param $params
     * @throws \Safan\GlobalExceptions\FileNotFoundException
     */
    public function init($params){
        // build config parameters
        $config = new Configuration();

        // check driver
        if(!isset($this->drivers[$params['driver']]))
            throw new FileNotFoundException($params['driver']);

        $params['driver'] = new $this->drivers[$params['driver']]($config);
        $config->buildConfig($params);

        $this->config = $config;

        // set to object manager
        $om = Safan::handler()->getObjectManager();
        $om->setObject('gapOrmCache', $this);
    }

    /**
     * @param $model
     * @return mixed
     */
    public function getRepository($model){
        $modelObj = $model::instance();

        if(method_exists($modelObj, 'getRepository'))
            $repository = $modelObj->getRepository();
        else
            $repository = 'GapOrmCache\Classes\Repository';

        try {
            $repositoryObj = new $repository;
            $repositoryObj->setModel($modelObj);
            $repositoryObj->setDriver($this->config->getDriver());
        }
        catch(FileNotFoundException $e){
            throw new $e($model . ' repository not found');
        }

        return $repositoryObj;
    }
}