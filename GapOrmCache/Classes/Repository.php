<?php
namespace GapOrmCache\Classes;

class Repository extends RepositoryCore
{
    /**
     * @param $pk
     * @return mixed
     */
    public function findByPK($pk){
        $this->startProfiling();

        $key  = $this->getModel()->table() . '_' . $pk;
        $data = $this->getDriver()->get($key);

        if($data){
            $this->endProfiling('findByPK', $key, $data);
        }
        else {
            $data = $this->getModel()->findByPK($pk);
            if(!is_null($data))
                $this->getDriver()->set($key, $data, 60*60*24);
        }

        return $data;
    }

    /**
     * Get data by fieldName
     *
     * @param $fieldName
     * @param array $fieldArray
     * @return array
     */
    public function beginAllInArray($fieldName, $fieldArray = array()){
        return $this->getModel()->beginAllInArray($fieldName, $fieldArray);
    }

    /**
     * Get all data from model
     *
     * @return array
     */
    public function beginAll(){
        return $this->getModel()->beginAll();
    }

    /**
     * Get once result
     *
     * @return object
     */
    public function beginOnce(){
        return $this->getModel()->beginOnce();
    }

    /**
     * Delete record
     *
     * @param $obj
     * @return bool
     */
    public function delete($obj){
        $key  = $this->getModel()->table() . '_' . $obj->{$this->getModel()->getPK()->identifier()};
        $this->getDriver()->remove($key);

        return $this->getModel()->delete($obj);
    }

    /**
     * RUN
     *
     * @param bool $oneRecord
     * @return array
     */
    public function run($oneRecord = false){
        return $this->getModel()->run($oneRecord);
    }

    /**
     * RUN Once
     *
     * @return array
     */
    public function runOnce(){
        return $this->getModel()->run(true);
    }

    /**
     * UPDATE & INSERT
     *
     * @param $obj
     * @param array $where
     * @param bool $isUpdate
     * @return bool
     */
    public function save($obj, $where = array(), $isUpdate = false){
        if(method_exists($this->getModel(), 'getPK')){
            $pk  = $obj->{$this->getModel()->getPK()->identifier()};
            $key = $this->getModel()->table() . '_' . $pk;
            $this->getDriver()->remove($key);
        }

        return $this->getModel()->save($obj, $where, $isUpdate);
    }
}