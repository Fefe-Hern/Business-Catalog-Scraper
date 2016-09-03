<?php

/**
 * Created by PhpStorm.
 * User: Fefe
 * Date: 9/2/2016
 * Time: 5:04 PM
 */
include 'iBusiness.php';
class BusinessFull implements iBusiness
{
    var $name;
    var $type;
    var $address;
    var $website;
    var $email;
    var $phone;
    var $fax;
    var $description;

    /**
     * Business constructor.
     * @param $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     *
     */
    public function printInfo()
    {
        // TODO: Implement printInfo() method.
        return "----------------\n
        Name: $this->name\n
        Type: $this->type\n
        Address: $this->address\n
        Website: $this->website\n
        E-Mail: $this->email\n
        Phone: $this->phone\n
        Fax: $this->fax\n
        Description: $this->description\n
        --------------------\n
        ";
    }

    public function setAttributes($type, $address, $website, $email, $phone, $fax, $description) {
        $this->type = $type;
        $this->address = $address;
        $this->website = $website;
        $this->email = $email;
        $this->phone = $phone;
        $this->fax = $fax;
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return mixed
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * @param mixed $website
     */
    public function setWebsite($website)
    {
        $this->website = $website;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param mixed $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return mixed
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * @param mixed $fax
     */
    public function setFax($fax)
    {
        $this->fax = $fax;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }


}