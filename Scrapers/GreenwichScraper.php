<?php

/**
 * Created by PhpStorm.
 * User: Fefe
 * Date: 9/2/2016
 * Time: 10:21 PM
 * Source: http://www.greenwichchamber.com/list/search?q=Find+a+Business&st=0
 */
class GreenwichScraper
{
    public static function scrape() {
        echo date('H:i:s') , "Running GreenwichScraper.php\n
            Scraping: http://www.greenwichchamber.com/list/search?q=Find+a+Business&st=0" , EOL;

        require_once(dirname(__FILE__)."/../Business/Business.php");
        require_once('simple_html_dom.php');
        //Input URL for catalog here
        $url = 'http://www.greenwichchamber.com/list/search?q=Find+a+Business&st=0';
        $html = new simple_html_dom();
        $html->load_file($url);

        $businesses = $html->find('div[class=mn-listingcontent]');

        $index = 0;
        $total = sizeof($businesses);
        echo $total;
        foreach ($businesses as $item) {
            //Get Names
            $names[] = $item->children(0)->first_child()->first_child()->innertext;

            //Get Address
            $address[] = $item->children(0)->children(3)->plaintext;

            //Get Websites
            $websiteString = $item->children(0)->first_child()->first_child()->outertext;
            $websiteString = str_replace("<a href=\"", "", $websiteString);
            $websiteString = preg_replace("/\".*$/", "", $websiteString);
            $websites[] = $websiteString;

            //Get Phone Numbers
            $phoneString = $item->children(1)->children(0)->children(0)->plaintext;
            $phoneString = str_replace("Map", "", $phoneString);
            $phoneString = trim($phoneString);
            $phones[] = $phoneString;

            $index++;
        }

        $businessList = new BusinessList();
        for($i = 0; $i < sizeof($names); $i++) {
            $business = new Business($names[$i]);
            $business->setAddress($address[$i]);
            $business->setWebsite($websites[$i]);
            $business->setPhone($phones[$i]);
            $businessList->addToArray($business);
        }

        //Add the entire list of businesses to excel
        $businessList->addListToExcel("Greenwich Catalog");
    }
}