<?php

namespace Dba\Flavia\Controller;

class IndexController extends AbstractController
{
    public function __construct()
    {
        $this->printPossibleCommands();
    }




    public function indexAction()
    {
        $venMachine = $this->getVendingMachineService()->getVendingMachine();
        var_dump($venMachine->getAvailableChangeMoney());
    }




    public function buyAction()
    {

        $itemToBuy = $this->getParam('item');
        $moneySpent = $this->getParam('money');

        $this->getVendingMachineService()->buyDrink($itemToBuy, $moneySpent);
    }




    public function resetAction()
    {
        unset($_SESSION['vendingMachine']);
    }




    public function showDrinksAction()
    {

        $venMachine = $this->getVendingMachineService()->getVendingMachine();

        foreach ($venMachine->getSlots() as $slot) {
            echo $slot->getTitle() . " available: " . count($slot->getItems()) . "<br>";
        }
    }




    private function printPossibleCommands()
    {
        echo("<a href='/index/index'>First Command</a> <br />");
        echo("<a href='/index/buy/item/coke/money/4.5'>Buy a Coke</a> <br />");
        echo("<a href='/index/showdrinks'>Show all drinks</a> <br />");
        echo("<a href='/index/reset'>Reset</a> <br />");
    }
}