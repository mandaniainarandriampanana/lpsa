<?php

namespace Lpsa\AppBundle\Service;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class ExcelDocumentManager{

    private $document;
    private $phpExcelIO;

    public function __construct(){
        $this->document = new \PHPExcel();
    }

    /**
     * Creates an empty PHPExcel Object if the filename is empty, otherwise loads the file into the object.
     *
     * @param string $filename
     *
     * @return \PHPExcel
     */
    public function createObject($filename = null) {
        return (null === $filename) ? new \PHPExcel() : call_user_func(array($this->document, 'load'), $filename);
    }

    public function getDocument() {
        return $this->document;
    }

    public function createPHPExcelWorksheetDrawing() {
        return new \PHPExcel_Worksheet_Drawing();
    }
    
    /**
     * Create a writer given the PHPExcelObject and the type,
     *   the type coul be one of PHPExcel_IOFactory::$_autoResolveClasses
     *
     * @param \PHPExcel $phpExcelObject
     * @param string    $type
     *
     *
     * @return \PHPExcel_Writer_IWriter
     */
    public function createWriter(\PHPExcel $phpExcelObject, $type = 'Excel5')
    {
        return call_user_func(array('\PHPExcel_IOFactory', 'createWriter'), $phpExcelObject, $type);
    }

    /**
     * Stream the file as Response.
     *
     * @param \PHPExcel_Writer_IWriter $writer
     * @param int                      $status
     * @param array                    $headers
     *
     * @return StreamedResponse
     */
    protected function createStreamedResponse(\PHPExcel_Writer_IWriter $writer, $status = 200, $headers = array())
    {
        return new StreamedResponse(
            function () use ($writer) {
                $writer->save('php://output');
            },
            $status,
            $headers
        );
    }

    /**
     * Create a PHPExcel Helper HTML Object
     *
     * @return \PHPExcel_Helper_HTML
     */
    public function createHelperHTML()
    {
        return new \PHPExcel_Helper_HTML();
    }

    public function outStreamResponse(\PHPExcel_Writer_IWriter $writer,$fileName = 'stream-file.xlsx', $status = 200, $headers = array()){
        $response = $this->createStreamedResponse($writer, $status, $headers);
        // adding headers
        $dispositionHeader = $response->headers->makeDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            $fileName
        );
        $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
        $response->headers->set('Pragma', 'public');
        $response->headers->set('Cache-Control', 'maxage=1');
        $response->headers->set('Content-Disposition', $dispositionHeader);
        return $response;
    }

    public function fromArray($source,$headers, $index = 0,$nullValue = 0, $startCell = 'A1', $strictNullComparaison = false,$rowHeader = 1,$startCellHeader = 'A') {
        if(empty($source) || !is_array($source)){
            throw new \RuntimeException('Source data can not be empty or not array.'); 
        }
        reset($source);
        $this->setHeaders($headers,$index,$rowHeader,$startCellHeader);
        $this->document->getSheet($index)->fromArray($source, $nullValue, $startCell, $strictNullComparaison);
        return $this;
    }

    public function setTitle($title, $index = 0) {
        $this->document->getSheet($index)->setTitle($title);   
        return $this;
    }

    public function setValue($cell, $value, $index = 0) {
        $this->document->getSheet($index)->setCellValue($cell,$value);  
        return $this;
    }

    public function setHeaders($data,$index = 0,$row = 1,$startCellHeader = 'A',$startAutoSize = 'A') {
        if(!empty($data)){
            $sheet = $this->getSheet($index);
            $alphas = range($startCellHeader, 'Z');
            $c = 0;
            $lastCol = 'A';
            foreach($data as $value){
                if(!isset($alphas[$c])){
                    break;
                }
                $sheet->setCellValue($alphas[$c].$row, (string)$value);
                $lastCol = $alphas[$c];
                $c++;
            }
            $this->autoSizeCols($index, $lastCol,$startAutoSize);
        }
        return $this;
    }

    public function getSheet($index) {
        return $this->document->getSheet($index);
    }

    public function autoSizeCols($index, $lastCol, $firstCol = 'A', $autoSize = true) {
        for ($col = ord($firstCol); $col <= ord($lastCol); $col++)
        {
            $this->document->getSheet($index)->getColumnDimension(chr($col))->setAutoSize($autoSize);
        }
        return $this;
    }

    public function addSheet($title = '') {
        $ews = new \PHPExcel_Worksheet($this->document);
        if(!empty($title)){
            $ews->setTitle($title);
        }
        $this->document->addSheet($ews);
        return $this;
    }

    public function setProperties($creator, $title, $subject, $description = '', $keywords = '', $category = '', $lastModifiedBy = '') {
        $this->document->getProperties()->setCreator($creator)
                        ->setLastModifiedBy($lastModifiedBy)
                        ->setTitle($title)
                        ->setSubject($subject)
                        ->setDescription($description)
                        ->setKeywords($keywords)
                        ->setCategory($category);
        return $this;
    }
}