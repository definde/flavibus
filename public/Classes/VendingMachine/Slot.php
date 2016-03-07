<?php

namespace Dba\Flavia\VendingMachine;

class Slot implements SlotInterface
{
    protected $slotNumber;


    protected $maxItems;


    protected $items;


    protected $title;


    protected $uid;

    protected $itemPrice;




    /**
     * @return mixed
     */
    public function getItemPrice()
    {
        return $this->itemPrice;
    }




    /**
     * @param mixed $itemPrice
     */
    public function setItemPrice($itemPrice)
    {
        $this->itemPrice = $itemPrice;
    }





    public function hasItems()
    {
        return (count($this->getItems()) > 0);
    }




    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }




    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }




    /**
     * @return mixed
     */
    public function getUid()
    {
        return $this->uid;
    }




    /**
     * @param mixed $uid
     */
    public function setUid($uid)
    {
        $this->uid = $uid;
    }




    /**
     * @return mixed
     */
    public function getSlotNumber()
    {
        return $this->slotNumber;
    }




    /**
     * @param mixed $slotNumber
     */
    public function setSlotNumber($slotNumber)
    {
        $this->slotNumber = $slotNumber;
    }




    /**
     * @return mixed
     */
    public function getMaxItems()
    {
        return $this->maxItems;
    }




    /**
     * @param mixed $maxItems
     */
    public function setMaxItems($maxItems)
    {
        $this->maxItems = $maxItems;
    }




    /**
     * @return mixed
     */
    public function getItems()
    {
        return $this->items;
    }




    /**
     * @param mixed $items
     */
    public function setItems($items)
    {
        $this->items = $items;
    }




    public function addItem(\Dba\Flavia\VendingMachine\ItemInterface $item)
    {
        $this->items[] = $item;
        return $this;
    }
}