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
            $this->isMoneyEnough($slot, $money)
        ) {
            echo("You bought a coke for " . floatval(reset($items)->getPrice()) . "€<br>");
            echo("You paid" . floatval($money) . "€<br>");
            echo("Your change money is" . $this->getChangeMoney($slot, $money) . "<br>");
        }
    }




    private function getChangeMoney($slot, $money)
    {
        $available = $this->getVendingMachine()->getAvailableChangeMoney();
        $items = $slot->getItems();
        $moneyDifferenceInCent = floatval($money) * 100 - floatval(reset($items)->getPrice() * 100);
        krsort($available);
        $available = $this->calculateChangeMoney($available, $moneyDifferenceInCent);
        $this->getVendingMachine()->setAvailableChangeMoney($available);

        var_dump($this->getVendingMachine()->getAvailableChangeMoney());
        die;
    }




    public function calculateChangeMoney($available, $moneyDifferenceInCent)
    {
        foreach ($available as $wert => $anzahl) {
            $total = $wert * $anzahl;

            $muenzenDieserArtBenoetigt = intval(floatval($moneyDifferenceInCent) / $wert);

            if ($muenzenDieserArtBenoetigt < 1) {
                continue;
            }

            $moneyDifferenceInCent = floatval($moneyDifferenceInCent) % $wert;

            if ($muenzenDieserArtBenoetigt <= $anzahl) {
                $available[$wert] -= $muenzenDieserArtBenoetigt;
            } else {
                $available[$wert] = $available[$wert] - $anzahl;
                $moneyDifferenceInCent = $moneyDifferenceInCent + (($muenzenDieserArtBenoetigt - $anzahl) * $wert);
            }

            if (intval($moneyDifferenceInCent) > 0) {
                continue;
            } else {
                break;
            }
        }
        if ($moneyDifferenceInCent > 0) {
            throw new \Exception('No change money left.');
        }

        return $available;
    }




    public function xd()
    {
    }




    private function isDrinkAvailable($slot)
    {
        return $slot->hasItems();
    }




    private function isMoneyEnough($slot, $money)
    {
        $items = $slot->getItems();

        if (floatval(reset($items)->getPrice()) < floatval($money)) {
            return true;
        } else {
            throw new \Exception('Not enough money paid.');
        }
    }




    public function changeMoney($slot, $money)
    {
        $changeMoney = $this->getVendingMachine()->getAvailableChangeMoney();

        var_dump($changeMoney);
        die;
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
}