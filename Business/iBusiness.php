<?php

/**
 * Created by PhpStorm.
 * User: Fefe
 * Date: 9/2/2016
 * Time: 4:30 PM
 * Description: The interface used by all the businesses. Every Business should have a
 * name and specified type, but not all will have a phone, email, fax, you name it.
 *
 * <b>In example, if a directory consists of businesses that have everything but an Address,
 * simply create a class implementing the iBusiness interface and add everything else but
 * the address variable.</b>
 */
interface iBusiness
{
    function printInfo();
    function getName();
    function setName($name);
    function getType();
    function setType($type);
}