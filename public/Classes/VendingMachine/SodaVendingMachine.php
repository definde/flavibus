<?php

namespace Dba\Flavia\VendingMachine;

class SodaVendingMachine implements VendingMachineInterface
{
    protected $slots = array();


    protected $itemsPerSlot;


    protected $numberOfSlots;


    protected $maxItemsPerSlot;


    protected $availableChangeMoney = array(
        10 => 10,
        20 => 10,
        50 => 10,
        100 => 10,
        200 => 10
    );


    protected $availableDrinks = array(
        array(
            "name" => "coke",
            "price" => 1
        ),
        array(
            "name" => "sprite",
            "price" => 2
        ),
        array(
            "name" => "water",
            "price" => 4
        ),
        array(
            "name" => "icetea",
            "price" => 1.5
        )
    );




    /**
     * @return array
     */
    public function getAvailableChangeMoney()
    {
        return $this->availableChangeMoney;
    }




    /**
     * @param array $availableChangeMoney
     */
    public function setAvailableChangeMoney($availableChangeMoney)
    {
        $this->availableChangeMoney = $availableChangeMoney;
    }




    /**
     * @return mixed
     */
    public function getMaxItemsPerSlot()
    {
        return $this->maxItemsPerSlot;
    }




    /**
     * @param mixed $maxItemsPerSlot
     */
    public function setMaxItemsPerSlot($maxItemsPerSlot)
    {
        $this->maxItemsPerSlot = $maxItemsPerSlot;
    }




    /**
     * @return array
     */
    public function getAvailableDrinks()
    {
        return $this->availableDrinks;
    }




    /**
     * @param array $availableDrinks
     */
    public function setAvailableDrinks($availableDrinks)
    {
        $this->availableDrinks = $availableDrinks;
    }




    /**
     * @return mixed
     */
    public function getNumberOfSlots()
    {
        return $this->numberOfSlots;
    }




    /**
     * @param mixed $numberOfSlots
     */
    public function setMaxNumberOfSlots($numberOfSlots)
    {
        $this->numberOfSlots = $numberOfSlots;
    }




    /**
     * @return mixed
     */
    public function getSlots()
    {
        return $this->slots;
    }




    /**
     * @param mixed $slots
     */
    public function setSlots($slots)
    {
        $this->slots = $slots;
    }




    /**
     * @return mixed
     */
    public function getItemsPerSlot()
    {
        return $this->itemsPerSlot;
    }




    /**
     * @param mixed $itemsPerSlot
     */
    public function setItemsPerSlot($itemsPerSlot)
    {
        $this->itemsPerSlot = $itemsPerSlot;
    }




    public function refill()
    {
    }




    public function buy($item)
    {

    }




    public function changeMoney()
    {
    }




    public function addSlot(\Dba\Flavia\VendingMachine\SlotInterface $slot)
    {
        $this->slots[] = $slot;
        return $this;
    }
}