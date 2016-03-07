<?php

namespace Dba\Flavia\Controller;

abstract class AbstractController
{
    protected $vendingMachineService;


    protected $requestParamter;

    public function __construct($vendingMachineService = NULL)
    {
        $this->setVendingMachineService($vendingMachineService);
    }


    /**
     * @return mixed
     */
    public function getRequestParamter()
    {
        return $this->requestParamter;
    }




    /**
     * @param mixed $requestParamter
     */
    public function setRequestParamter($requestParamter)
    {
        $this->requestParamter = $requestParamter;
    }




    protected function getParam($key)
    {
        $params = $this->getRequestParamter();
        if (isset($params[$key])) {
            return $params[$key];
        }
    }




    public function handleRequestParameter($paramter)
    {
        $newArray = array();
        if (is_array($paramter)) {
            for ($i = 0; $i < count($paramter); $i += 2) {
                $newArray[$paramter[$i]] = $paramter[$i + 1];
            }

            $this->setRequestParamter($newArray);
        }
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
    public function setVendingMachineService(\Dba\Flavia\Service\VendingMachineService $vendingMachineService)
    {
        $this->vendingMachineService = $vendingMachineService;
    }
}