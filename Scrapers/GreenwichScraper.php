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
        require_once(dirname(__FILE__)."/../Business/Business.php");
        require_once('simple_html_dom.php');

        //Input URL for catalog here
        $url = 'http://www.greenwichchamber.com/list/search?q=Find+a+Business&st=0';
        $html = new simple_html_dom();
        $html->load_file($url);

        //Grab the names of Greenwich in an array
        $businesses = $html->find('div[class=mn-title]');
        foreach ($businesses as $item) {
            $titles[] = $item->children(0)->innertext;
        }

        //Send the businesses (As of right now only names) to a newly created businessList
        $businessList = new BusinessList();
        foreach ($titles as $name) {
            $business = new Business($name);
            $businessList->addToArray($business);
        }

        //Add the entire list of business to excel
        $businessList->addListToExcel();
    }
}