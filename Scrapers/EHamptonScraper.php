<?php

/**
 * Created by PhpStorm.
 * User: Fefe
 * Date: 9/4/2016
 * Time: 2:47 PM
 * Source: http://www.easthamptonchamber.com/directory.php
 */
class EHamptonScraper
{
    public static function scrape() {
        echo date('H:i:s') , "Running EHamptonScraper.php\n
            Scraping: http://www.easthamptonchamber.com/directory.php" , EOL;

        require_once(dirname(__FILE__)."/../Business/Business.php");
        require_once('simple_html_dom.php');
        $url = 'http://www.easthamptonchamber.com/directory.php';
        $html = new simple_html_dom();
        $html = file_get_html($url);
        //$html->load_file($url);

        $hrefs = $html->find('a');
        $catalogHref = "directory.php?cat=";
        $catalogName = [];
        $catalogLink = [];
        foreach ($hrefs as $item) {
            if(strpos($item->outertext, $catalogHref) == true and $item) {
                // If link is part of the catalogLink, get the link by itself.
                $websiteString = $item->outertext;
                $websiteString = str_replace("<a href='", "", $websiteString);
                $websiteString = preg_replace("/'.*$/", "", $websiteString);
                $websiteString = str_replace("<a href=\"", "", $websiteString);
                $websiteString = preg_replace("/\".*$/", "", $websiteString);
                if(in_array($websiteString, $catalogLink) != true) {
                    $title = str_replace("&", "and", $item->innertext);
                    $catalogName[] = $title;
                    $catalogLink[] = "http://www.easthamptonchamber.com/" . $websiteString;
                }
            }
        }

        $numElements = sizeof($catalogName);
        $names = [];
        $types = [];
        $address = [];
        $phones = [];
        $websites = [];
        $emails = [];
        $descriptions = [];

        echo "Number of Listings: " . $numElements . "\nObtaining Data...";

        for ($i = 0; $i < $numElements; $i++) {
            $html = file_get_html($catalogLink[$i]);
            $contactDiv = $html->find('.entity-contact');
            foreach ($contactDiv as $contactInfo) {
                $names[] = $contactInfo->children(0)->children(0)->innertext;
                $types[] = $catalogName[$i];
                $nullAddress = is_null($contactInfo->children(0)->find('strong', 0));
                if ($nullAddress) {
                    $address[] = "N/A";
                } else {
                    $addressString = $contactInfo->children(0)->find('strong', 0)->innertext;
                    $addressString = str_replace("<br />", "", $addressString);
                    $address[] = $addressString;
                }
                $phones[] = trim($contactInfo->children(2)->children(0)->plaintext);

                // Get entities within the description
                $contactDescription = $contactInfo->next_sibling()->first_child();
                //Websites
                $nullWebsite = is_null($contactDescription->find('a[target]', 0));
                if($nullWebsite) {
                    $websites[] = "N/A";
                } else {
                    $websiteString = $contactDescription->find('a[target]', 0)->outertext;
                    $websiteString = str_replace("<a href=\"", "", $websiteString);
                    $websiteString = preg_replace("/\".*$/", "", $websiteString);
                    $websites[] = $websiteString;
                }

                //Emails
                $emailTarget = $contactDescription->find('a[!target]', 0);
                $nullEmail = is_null($emailTarget);
                if($nullEmail) {
                    $emails[] = "N/A";
                } else {
                    $emailString = $emailTarget->plaintext;
                    $emails[] = $emailString;
                }

                //Descriptions
                if(is_null($contactDescription->find('em', 0))) {
                    $descriptions[] = "N/A";
                } else {
                    $descriptions[] = $contactDescription->find('em', 0)->innertext;
                }
            }
        }
        $businessList = new BusinessList();
        for($i = 0; $i < sizeof($names); $i++) {
            $business = new Business($names[$i]);
            $business->setType($types[$i]);
            $business->setAddress($address[$i]);
            $business->setWebsite($websites[$i]);
            $business->setEmail($emails[$i]);
            $business->setPhone($phones[$i]);
            $business->setDescription($descriptions[$i]);
            $businessList->addToArray($business);
        }

        //Add the entire list of businesses to excel
        $businessList->addListToExcel("EastHampton Catalog");
    }
}
?>