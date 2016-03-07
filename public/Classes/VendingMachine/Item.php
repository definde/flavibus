<?php

namespace Dba\Flavia\VendingMachine;

class Item implements ItemInterface
{
    protected $name;


    /**
     * @var Int
     */
    protected $price;




    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }




    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }




    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }




    /**
     * @param mixed $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }
}