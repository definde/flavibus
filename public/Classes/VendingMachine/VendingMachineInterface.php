<?php
namespace Dba\Flavia\VendingMachine;

interface VendingMachineInterface
{
    public function setSlots($numebrOfSlots);




    public function getSlots();




    public function refill();




    public function buy($item);




    public function changeMoney();
}