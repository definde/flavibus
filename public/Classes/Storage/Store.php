<?php

namespace Dba\Flavia\Storage;

class Store
{
    public $adapter;




    public function __construct(\Dba\Flavia\Storage\StorageInterface $adapter)
    {
        if (null != $adapter) {
            $this->setAdapter($adapter);
        }
    }




    /**
     * @return mixed
     */
    public function getAdapter()
    {
        return $this->adapter;
    }




    /**
     * @param mixed $adapter
     */
    public function setAdapter(\Dba\Flavia\Storage\StorageInterface $adapter)
    {
        $this->adapter = $adapter;
    }




    public function get($key)
    {
        return $this->getAdapter()->get($key);
    }




    public function set($key, $value)
    {
        $this->getAdapter()->set($key, $value);
    }
}