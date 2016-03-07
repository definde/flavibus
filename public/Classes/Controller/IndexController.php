<?php

namespace Dba\Flavia\Controller;

class IndexController extends AbstractController
{
    public function __construct($vendingMachineService = NULL)
    {
        parent::__construct($vendingMachineService);
        $this->printPossibleCommands();
    }




    public function indexAction()
    {
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









    private function printPossibleCommands()
    {
        $venMachine = $this->getVendingMachineService()->getVendingMachine();
        foreach($venMachine->getSlots() as $slot){
            echo("<a href='/index/buy/item/".$slot->getTitle()."/money/4.5'>Buy a ".$slot->getTitle()." for ". $slot->getItemPrice() ."€</a> <br />");
        }

        echo("<a href='/index/reset'>Reset/Refill Vendingmachine</a> <br />");
        echo("---------------------------------------------------<br />");
    }
}