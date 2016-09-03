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

    public static function createWorkBook() {
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
            ->setDescription("Test document for PHPExcel, generated using PHP classes.")
            ->setKeywords("office PHPExcel php")
            ->setCategory("Test result file");


// Add some data
        echo date('H:i:s') , " Add some data" , EOL;
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Business Name')
            ->setCellValue('B1', 'Category')
            ->setCellValue('C1', 'Address')
            ->setCellValue('D1', 'Website')
            ->setCellValue('E1', 'Email')
            ->setCellValue('F1', 'Phone #')
            ->setCellValue('G1', 'Fax #')
            ->setCellValue('H1', 'Description');

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(30); //Business Name Width Increased
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15); //Business Name Width Increased
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(40); //Business Name Width Increased
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25); //Business Name Width Increased
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25); //Business Name Width Increased
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15); //Business Name Width Increased
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15); //Business Name Width Increased
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(80); //Description Width Increased
        $objPHPExcel->getActiveSheet()->getStyle('A8')->getAlignment()->setWrapText(true);


// Rename worksheet
        echo date('H:i:s') , " Rename worksheet" , EOL;
        $objPHPExcel->getActiveSheet()->setTitle('Simple');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);

    }

    public static function addBusiness($index, $item) {
        global $objPHPExcel;
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $index, $item->getName())
                ->setCellValue('B' . $index, $item->getType())
                ->setCellValue('C' . $index, $item->getAddress())
                ->setCellValue('D' . $index, $item->getWebsite())
                ->setCellValue('E' . $index, $item->getEmail())
                ->setCellValue('F' . $index, $item->getPhone())
                ->setCellValue('G' . $index, $item->getFax())
                ->setCellValue('H' . $index, $item->getDescription());
    }

    public static function saveAndClose() {
        require_once dirname(__FILE__) . '\PHPExcel.php';
// Save Excel 2007 file
        echo date('H:i:s') , " Write to Excel2007 format" , EOL;
        $callStartTime = microtime(true);

        global $objPHPExcel;
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save(str_replace('.php', '.xlsx', __FILE__));
        $callEndTime = microtime(true);
        $callTime = $callEndTime - $callStartTime;

        echo date('H:i:s') , " File written to " , str_replace('.php', '.xlsx', pathinfo(__FILE__, PATHINFO_BASENAME)) , EOL;
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