<?php
/**
 * PHPExcel
 *
 * Copyright (C) 2006 - 2014 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPExcel
 * @package    PHPExcel
 * @copyright  Copyright (c) 2006 - 2014 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    ##VERSION##, ##DATE##
 */
class Manipulator {
    var $fileName = "Manipulator.xlsx";
    var $fileType = "Excel2007";
    var $objPHPExcel = null;

    public static function createWorkBook($sheetName) {
        /** Error reporting */
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/London');

        define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

        /** Include PHPExcel */
        require_once dirname(__FILE__) . '\PHPExcel.php';

// Create new PHPExcel object
        echo date('H:i:s') , " Create new PHPExcel object" , EOL;
        global $objPHPExcel;
        $objPHPExcel = new PHPExcel();

// Set document properties
        echo date('H:i:s') , " Set document properties" , EOL;
        $objPHPExcel->getProperties()->setCreator("Fernando Hernandez")
            ->setLastModifiedBy("Fernando Hernandez")
            ->setTitle("Businesses from Commerce Sites")
            ->setSubject("PHPExcel Test Document")
            ->setDescription("Business Catalog, generated using PHP classes PHPExcel and simple_html_dom.")
            ->setKeywords("office PHPExcel php Business Catalog")
            ->setCategory("Business Catalog");


// Add some data
        echo date('H:i:s') , " Add some data" , EOL;
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Business Name')
            ->setCellValue('B1', 'Category')
            ->setCellValue('C1', 'Address')
            ->setCellValue('D1', 'Website')
            ->setCellValue('E1', 'Email')
            ->setCellValue('F1', 'Phone #')
            ->setCellValue('G1', 'Description');

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(30); //Business Name Width Increased
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15); //Type Width Decreased
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(40); //Address Width Increased
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(8);  //Website Link Width Decreased
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25); //Email Width Increased
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15); //Phone Width Increased
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(150); //Description Width Increased

// Rename worksheet
        echo date('H:i:s') , " Rename worksheet to Catalog", EOL;
        $objPHPExcel->getActiveSheet()->setTitle("Catalog");


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);

    }

    public static function addBusiness($index, $item) {
        global $objPHPExcel;
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $index, $item->getName())
                ->setCellValue('B' . $index, $item->getType())
                ->setCellValue('C' . $index, $item->getAddress())
                ->setCellValue('D' . $index, "Link")
                ->setCellValue('E' . $index, $item->getEmail())
                ->setCellValue('F' . $index, $item->getPhone())
                ->setCellValue('G' . $index, $item->getDescription());

        // Create Hyperlink for Website
        $websiteCell = "D" . $index; //As shown in setCellValue, this affects the website link design.
        $link_style_array = [
            'font'  => [
                'color' => ['rgb' => '0000FF'],
                'underline' => 'single'
            ]
        ];
        $weblink = $item->getWebsite();
        $target = 'http';
        if (strpos($weblink, $target) !== false) {
            $objPHPExcel->getActiveSheet()->getStyle($websiteCell)->applyFromArray($link_style_array);
            $objPHPExcel->getActiveSheet()->getCell($websiteCell)->
            setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
            $objPHPExcel->getActiveSheet()->getCell($websiteCell)->
                getHyperlink()->setUrl($weblink);
            echo $weblink . "\n";
        } else {
            echo "false\n";
        }

    }

    public static function newSheet($index, $sheetName) {
        global $objPHPExcel;
        $objPHPExcel->setActiveSheetIndex($index);
        $objPHPExcel->getActiveSheet()->setTitle($sheetName);
    }

    public static function saveAndClose($fileName) {
        require_once dirname(__FILE__) . '\PHPExcel.php';
        global $objPHPExcel;
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);
        // Wrap the name and address to prevent stacking
        $objPHPExcel->getActiveSheet()->getStyle('A1:A'.$objPHPExcel->getActiveSheet()->getHighestRow())
            ->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle('C1:C'.$objPHPExcel->getActiveSheet()->getHighestRow())
            ->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle('F1:F'.$objPHPExcel->getActiveSheet()->getHighestRow())
            ->getAlignment()->setWrapText(true);

        // Save Excel 2007 file
        echo date('H:i:s') , " Write to Excel2007 format" , EOL;
        $callStartTime = microtime(true);

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save("Catalogs/" . str_replace('.php', '.xls', $fileName . '.xls'));
        $callEndTime = microtime(true);
        $callTime = $callEndTime - $callStartTime;

        echo date('H:i:s') , " File written to " , str_replace('.php', '.xls', pathinfo($fileName . '.xls', PATHINFO_BASENAME)) , EOL;
        echo 'Call time to write Workbook was ' , sprintf('%.4f',$callTime) , " seconds" , EOL;
        // Echo memory usage
        echo date('H:i:s') , ' Current memory usage: ' , (memory_get_usage(true) / 1024 / 1024) , " MB" , EOL;

// Echo memory peak usage
        echo date('H:i:s') , " Peak memory usage: " , (memory_get_peak_usage(true) / 1024 / 1024) , " MB" , EOL;

// Echo done
        echo date('H:i:s') , " Done writing files" , EOL;
        echo 'Files have been created in ' , getcwd() , EOL;
    }
}
?>