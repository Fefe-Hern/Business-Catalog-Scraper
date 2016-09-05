<?php
// Include all the different Business objects
/**foreach (glob("Business/*.php") as $filename) {
    include $filename;
}*/
//include 'Business\Business.php';
include 'Business\BusinessList.php';
include 'Excel\Manipulator.php';
// TODO: Include all the web scrapers for different commerce chambers
foreach (glob("Scrapers/*.php") as $fileName) {
    include $fileName;
}
?>
<?php
/**
 * Created by PhpStorm.
 * User: Fefe
 * Date: 9/2/2016
 * Time: 5:18 PM
 */
//Create the list of Businesses in memory. Name the first scraper used here
Manipulator::createWorkBook('Greenwich');
GreenwichScraper::scrape();

Manipulator::createWorkBook('East Hampton');
EHamptonScraper::scrape();
?>