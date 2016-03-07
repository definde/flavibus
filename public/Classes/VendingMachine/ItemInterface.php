<?php

namespace Dba\Flavia\VendingMachine;

interface ItemInterface
{
    /**
     * @return mixed
     */
    public function getName();




    /**
     * @param mixed $name
     */
    public function setName($name);




    /**
     * @return mixed
     */
    public function getPrice();




    /**
     * @param mixed $price
     */
    public function setPrice($price);
}