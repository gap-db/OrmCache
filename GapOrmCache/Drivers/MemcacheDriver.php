<?php
/**
 * This file is part of the Safan package.
 *
 * (c) Harut Grigoryan <ceo@safanlab.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace GapOrmCache\Drivers;

use Safan\Safan;

class MemcacheDriver
{
    /**
     * @var string
     */
    private $prefix = 'memcache_driver';

    /**
     * @var \Memcache
     */
    private $memcache;

    /**
     * @param $prefix
     */
    public function __construct($prefix){
        $this->prefix   = $prefix;
        $this->memcache = Safan::handler()->getObjectManager()->get('memcache');
    }

    /**
     * @param $key
     * @return array|bool|string
     */
    public function get($key){
        return ($this->memcache) ? $this->memcache->get($this->prefix . '_' . $key) : false;
    }

    /**
     * Set Memcache
     *
     * @param $key
     * @param $object
     * @param int $timeout
     * @return bool
     */
    public function set($key, $object, $timeout = 86400){
        return ($this->memcache) ? $this->memcache->set($this->prefix . '_' . $key, $object, $timeout) : false;
    }

    /**
     * Remove Memcache key
     *
     * @param $key
     * @return bool
     */
    public function remove($key){
        return ($this->memcache) ? $this->memcache->remove($this->prefix . '_' . $key) : false;
    }
}