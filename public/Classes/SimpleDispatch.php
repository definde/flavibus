<?php

namespace Dba\Flavia;

class SimpleDispatch
{
    protected $request;


    protected $storage;


    protected $vendingMachineService;




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




    public function __construct()
    {
        $storage = new \Dba\Flavia\Storage\Store(new \Dba\Flavia\Storage\SessionAdapter);
        $this->setStorage($storage);
    }




    /**
     * @return mixed
     */
    public function getRequest()
    {
        return $this->request;
    }




    /**
     * @return mixed
     */
    public function getVendingMachineService()
    {
        return $this->vendingMachineService;
    }




    /**
     * @param mixed $vendingMachineService
     */
    public function setVendingMachineService($vendingMachineService)
    {
        $this->vendingMachineService = $vendingMachineService;
    }




    /**
     * @param mixed $request
     */
    public function setRequest($request)
    {
        $this->request = $request;
    }




    private function getVendingMachineFromStoreIfPossible()
    {

        if ($this->getStorage()->get('vendingMachine') instanceof \Dba\Flavia\VendingMachine\VendingMachineInterface) {
            return $this->getStorage()->get('vendingMachine');
        } else {

            $vendingMachine = $this->getVendingMachineService()->createVendingMachine();
            $this->getStorage()->set("vendingMachine", $vendingMachine);

            return $vendingMachine;
        }
    }




    /**
     *
     */
    public function bootstrap()
    {

        //let's initialize a service class for our vending machine to inject it to the controller.
        $vendingMachineService = new \Dba\Flavia\Service\VendingMachineService();
        $this->setVendingMachineService($vendingMachineService);
        $vendingMachineService->setVendingMachine($this->getVendingMachineFromStoreIfPossible());
    }




    /**
     * Before we do anything we do anything we have to be sure to have a vending maching or create one if not so.
     */
    public function preDispatch()
    {
    }




    public function dispatch($request)
    {
        session_start();
        $this->bootstrap();

        $this->preDispatch();
        $this->setRequest($request);

        $requestSplit = explode('/', $request['REQUEST_URI']);

        array_shift($requestSplit);
        $controllerName = "Dba\\Flavia\\Controller\\" . ucfirst(array_shift($requestSplit)) . "Controller";

        $method = array_shift($requestSplit) . "Action";

        $test = new $controllerName;
        $test->setVendingMachineService($this->getVendingMachineService());
        $test->handleRequestParameter($requestSplit);

        call_user_func(array($test, $method));

        $this->shutDown();
    }




    private function shutDown()
    {
        var_dump($this->getStorage()->get('vendingMaching'));
        die;
        if ($this->getStorage()->get('vendingMaching')) {
            $this->getStorage()->set('vendingMachine', $this->getVendingMachineService()->getVendingMachine());
        }
    }
}