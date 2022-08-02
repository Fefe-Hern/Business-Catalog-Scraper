<?php

/**
 * Created by PhpStorm.
 * User: Fefe
 * Date: 9/2/2022
 * Time: 5:04 PM
 */
class BusinessList
{
    var $businessArray;
    /**
     * BusinessList constructor.
     * @param $businessArray
     */
    public function __construct()
    {
        $this->businessArray = new ArrayObject();
    }

    public function addToArray($business) {
        $this->businessArray->append($business);
    }
    public function dumpArray() {
        var_dump($this->businessArray);
    }

    public function addListToExcel($fileName)
    {
        $index = 2;
        foreach ($this->businessArray as $item) {
            Manipulator::addBusiness($index, $item);
            $index++;
        }
        Manipulator::saveAndClose($fileName);
    }
}