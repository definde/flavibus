<?php

namespace Dba\Flavia\Service;

class VendingMachineService
{
    protected $vendingMachine;

    protected $storage;


    /**
     * @return mixed
     */
    public function getVendingMachine()
    {
        return $this->vendingMachine;
    }




    /**
     * @param mixed $vendingMachine
     */
    public function setVendingMachine($vendingMachine)
    {
        $this->vendingMachine = $vendingMachine;
    }




    /**
     * @return mixed
     */
    public function getStorage()
    {
        return $this->storage;
    }




    /**
     * @param mixed $storage
     */
    public function setStorage($storage)
    {
        $this->storage = $storage;
    }




    public function findSlotByName($name)
    {
        foreach ($this->getVendingMachine()->getSlots() as $slot) {
            if ($slot->getTitle() == $name) {
                return $slot;
            }
        }
    }




    public function buyDrink($slotName, $money)
    {
        $slot = $this->findSlotByName($slotName);
        $items = $slot->getItems();
        if ($this->isDrinkAvailable($slot) &&
            $this->isMoneyEnough($slot, $money) &&
            $this->processChangeMoney($slot, $money)
        ) {

            echo("You bought a coke for " . floatval(reset($items)->getPrice()) . "Euro<br>");
            echo("You paid" . floatval($money) . "Euro<br>");
            array_shift($items);
            $slot->setItems($items);
        }
    }




    private function processChangeMoney($slot, $givenMoney)
    {
        $available = $this->getVendingMachine()->getAvailableChangeMoney();
        $items = $slot->getItems();
        $moneyDifferenceInCent = floatval($givenMoney) * 100 - floatval(reset($items)->getPrice() * 100);
        krsort($available);

        if(true == $this->calculateChangeMoney($available, $moneyDifferenceInCent)){
            return true;
        } else {
            echo("Sorry, we do not have change money for your requested payment. <br />");
        }




    }




    public function calculateChangeMoney($available, $moneyDifferenceInCent)
    {
        $changeCoins = array();
        foreach ($available as $valueOfSingleCoin => $numberOfCoinsAvailable) {

            $amountOfCoinsNeeded = intval(floatval($moneyDifferenceInCent) / $valueOfSingleCoin);

            if ($amountOfCoinsNeeded < 1) {
                continue;
            }

            $moneyDifferenceInCent = floatval($moneyDifferenceInCent) % $valueOfSingleCoin;

            if ($amountOfCoinsNeeded <= $numberOfCoinsAvailable) {
                $available[$valueOfSingleCoin] -= $amountOfCoinsNeeded;
                $changeCoins[$valueOfSingleCoin] = $amountOfCoinsNeeded;
            } else {
                $available[$valueOfSingleCoin] = $available[$valueOfSingleCoin] - $numberOfCoinsAvailable;
                $changeCoins[$valueOfSingleCoin] = $available[$valueOfSingleCoin] - $numberOfCoinsAvailable;
                $moneyDifferenceInCent = $moneyDifferenceInCent + (($amountOfCoinsNeeded - $numberOfCoinsAvailable) * $valueOfSingleCoin);
            }

            if (intval($moneyDifferenceInCent) > 0) {
                continue;
            } else {
                break;
            }
        }
        if ($moneyDifferenceInCent > 0) {
            return false;
        }

        $this->getVendingMachine()->setAvailableChangeMoney($available);
        $this->printChangeMoney($changeCoins);
        return true;
    }








    private function isDrinkAvailable(\Dba\Flavia\VendingMachine\SlotInterface $slot)
    {
        if (true == $slot->hasItems()){
            return true;
        } else {
            echo('Sorry, no drinks of this type are still available.<br />');
            return false;
        }
    }




    private function isMoneyEnough($slot, $money)
    {
        $items = $slot->getItems();

        if (floatval(reset($items)->getPrice()) < floatval($money)) {
            return true;
        } else {
            echo("Not enough money paid.<br />");
            return false;
        }
    }




    public function changeMoney($slot, $money)
    {
        $changeMoney = $this->getVendingMachine()->getAvailableChangeMoney();
    }




    private function hasChangeMoney()
    {
    }




    public function loadVendingMachine()
    {
    }




    public function createVendingMachine()
    {

        $vendingMachine = new \Dba\Flavia\VendingMachine\SodaVendingMachine;
        $vendingMachine->setMaxNumberOfSlots(10);
        $vendingMachine->setMaxItemsPerSlot(5);
        $vendingMachine = $this->completeRefill($vendingMachine);

        return $vendingMachine;
    }




    public function completeRefill(\Dba\Flavia\VendingMachine\VendingMachineInterface $vendingMachine)
    {

        foreach ($vendingMachine->getAvailableDrinks() as $key => $value) {
            $slot = new \Dba\Flavia\VendingMachine\Slot();
            $slot->setMaxItems($vendingMachine->getMaxItemsPerSlot());
            $slot->setUid($value['name']);
            $slot->setTitle($value['name']);
            $slot->setItemPrice($value['price']);
            for ($i = 0; $i < $vendingMachine->getMaxItemsPerSlot(); $i++) {
                $item = new \Dba\Flavia\VendingMachine\Item();
                $item->setName($value['name']);
                $item->setPrice($value['price']);
                $slot->addItem($item);
            }
            $vendingMachine->addSlot($slot);
        }

        return $vendingMachine;
    }

    private function printChangeMoney($changeMoney){
        $sum = 0;

        foreach($changeMoney as $coinValue => $coinAmount ){
            echo("You get $coinAmount Coin(s) of " . ($coinValue/100) . "Euro <br />");
            $sum += (($coinValue/100) * $coinAmount);
        }
        echo("----------<br/>");
        echo("You get a total of " . $sum . "Euro change. <br /><br /><br />");
    }
}