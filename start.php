<?php
// Include all the different Business objects
/**foreach (glob("Business/*.php") as $filename) {
    include $filename;
}*/
include 'Business\BusinessFull.php';
include 'Business\BusinessList.php';
include 'Excel\Manipulator.php';
// TODO: Include all the web scrapers for different commerce chambers
?>
<?php
/**
 * Created by PhpStorm.
 * User: Fefe
 * Date: 9/2/2016
 * Time: 5:18 PM
 */
//Create the list of Businesses in memory.
$businessList = new BusinessList();

$fakeBusiness = new BusinessFull("Fernando's Laboratory");
$fakeBusiness->setAttributes("Lab", "7 W Lane, Central NY NY 11723", "wwww.tcgdex.net",
    "fernhean@hotmail.nw", "123-456-7890", "312-312-4212", "My lab is full of enourmous surprises");
$businessList->addToArray($fakeBusiness);

$secondBusiness = new BusinessFull("Tiffy's Bunnies");
$secondBusiness->setAttributes("Animal Care", "Earth", "tiffysbunnies.com", "tiffy23@aol.321",
    "653-123-4632", "N/A", "The most epic bunnies in existance!");
$businessList->addToArray($secondBusiness);

$businessList->dumpArray();
//echo $fakeBusiness->printInfo();
//Manipulator::createWorkBook();
?>