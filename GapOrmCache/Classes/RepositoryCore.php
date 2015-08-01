<?php
namespace GapOrmCache\Classes;

use GapOrm\Mapper\Model;
use Safan\Safan;

class RepositoryCore
{
    /**
     * @var
     */
    private $model;

    /**
     * @var
     */
    private $driver;

    /**
     * @param $model
     * @throws \RuntimeException
     */
    public function setModel($model){
        if($model instanceof Model)
            $this->model = $model;
        else
            throw new \RuntimeException('Wrong model and haven`t repository');
    }

    /**
     * @param $driver
     */
    public function setDriver($driver){
       $this->driver = $driver;
    }

    /**
     * @return mixed
     */
    public function getModel(){
        return $this->model;
    }

    /**
     * @return mixed
     */
    public function getDriver(){
        return $this->driver;
    }

    /**
     * Start profiling
     */
    protected function startProfiling(){
        $profiler = Safan::handler()->getObjectManager()->get('gapOrmProfiler');
        $profiler->getTimer()->start();
    }

    /**
     * @param $profilerType
     * @param $key
     * @param $result
     */
    protected function endProfiling($profilerType, $key, $result){
        $profiler = Safan::handler()->getObjectManager()->get('gapOrmProfiler');

        $profileOptions = [
            'type'        => 'cache_query',
            'time'        => $profiler->getTimer()->calculate(),
            'query'       => '',
            'queryType'   => $profilerType,
            'queryParams' => ['key' => $key],
            'result'      => $result
        ];

        $profiler->setOptions($profilerType . '_' . time(), $profileOptions);
    }
}