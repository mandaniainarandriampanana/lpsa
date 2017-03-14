<?php

namespace Lpsa\AppBundle\Statistic\Excel;

class SheetLtirTrir{

    private $ltirTrir;
    private $manager;
    private $index;
    private $monthHeaders;
    private $headers;
    private $data;
    private $rowEnd;

    public function init($ltirTrir,$manager,$index = 0,$newSheet = false){
        $this->ltirTrir = $ltirTrir;
        $this->manager = $manager;
        if($newSheet){
            $this->manager->addSheet();
        }
        $this->index = $index;
        return $this;
    }

    public function process($userId = null){
        $this->monthHeaders = $this->ltirTrir->getMonthHeaders();
        $this->headers = $this->getExcelHeaders('B','N',2);
        $this->data = $this->getExcelData();
        $this->setStyleCell('B','R',3);
        $this->setPreHeaders();
        $this->insertChart('graphe LTIR','./uploads/temp/'.$userId.'/graph_ltir.png',3);
        $this->insertChart('graphe TRIR','./uploads/temp/'.$userId.'/graph_trir.png',55);
        return $this;
    }

    private function setPreHeaders(){
        $document = $this->manager->getDocument();
        $document->getSheet($this->index)->mergeCells('I1:J1');
        $this->manager->setValue('I1', 'MENSUEL', $this->index);
        $document->getSheet($this->index)->mergeCells('M1:N1');
        $this->manager->setValue('M1', '12 MOIS GLISSANTS', $this->index);
        $document->getSheet($this->index)->mergeCells('Q1:R1');
        $this->manager->setValue('Q1', 'MENSUEL', $this->index);
        $document->getSheet($this->index)->getStyle('I1')->applyFromArray(array(
            'font'  => array(
                'bold'  => false,
                'color' => array('rgb' => '000000'),
                'name'  => 'Verdana',
                'size'  => 9
            ),
            'alignment' => array(
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_THIN
                )
            ),
            'fill' =>  array(
                'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'DEA92C')
            )
        ));
        $document->getSheet($this->index)->getStyle('M1')->applyFromArray(array(
            'font'  => array(
                'bold'  => false,
                'color' => array('rgb' => '000000'),
                'name'  => 'Verdana',
                'size'  => 9
            ),
            'alignment' => array(
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_THIN
                )
            ),
            'fill' =>  array(
                'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'EDF263')
            )
        ));
        $document->getSheet($this->index)->duplicateStyle($document->getSheet($this->index)->getStyle('I1'),'Q1:R1');
        $document->getSheet($this->index)->duplicateStyle($document->getSheet($this->index)->getStyle('H2'),'O2:P2');
        $document->getSheet($this->index)->duplicateStyle($document->getSheet($this->index)->getStyle('H2'),'Q2:R2');
    }

    public function addDataToSheet($rowStart){        
        $this->manager->setTitle('GRAPH LTIR ' . $this->ltirTrir->getDateEnd()->format('Y'),$this->index)
                ->fromArray($this->data,array(),$this->index,null,'B2')
                ->setHeaders($this->headers,$this->index,$rowStart,'B','B');
        return $this;
    }

    private function setStyleCell($cellStartHeader,$cellEndtHeader,$row){
        $alphas = range($cellStartHeader, $cellEndtHeader);
        $styleArray = array(
            'font'  => array(
                'bold'  => false,
                'color' => array('rgb' => '000000'),
                'name'  => 'Verdana'),
            'alignment' => array(
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );
        $document = $this->manager->getDocument();
        $this->rowEnd = count($this->monthHeaders) + count($this->ltirTrir->getMonthHeaders12Months()) + 1;
        for($i = 0; $i <= count($alphas) - 1; $i++){
            $document->getSheet($this->index)->getStyle($alphas[$i] . $row . ':' . $alphas[$i] . $this->rowEnd)->applyFromArray($styleArray);
            if(!in_array($alphas[$i],['K','L'])){
                $document->getSheet($this->index)->getStyle($alphas[$i] . $row . ':' . $alphas[$i] . $this->rowEnd)->getNumberFormat()->setFormatCode('#,##0.00');
            }
        }
    }

    private function getExcelHeaders($cellStartHeader,$cellEndtHeader,$row){
        $alphas = range($cellStartHeader, $cellEndtHeader);
        $styleArray = array(
            'font'  => array(
                'bold'  => false,
                'color' => array('rgb' => '000000'),
                'name'  => 'Verdana'),
            'alignment' => array(
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );
        $document = $this->manager->getDocument();
        for($i = 0; $i <= count($alphas) - 1; $i++){
            if(in_array($i,[7,8,11,12])){
                $styleArray['font']['size'] = 12;
                if(in_array($i,[7,8])){
                    $styleArray['fill'] = array(
                        'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => 'DEA92C')
                    );
                } else{
                    $styleArray['fill'] = array(
                        'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => 'EDF263')
                    );
                } 
            } else {
                $styleArray['font']['size'] = 9;
                $styleArray['fill'] = array(
                    'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => 'FFFFFF')
                );
            }
            $document->getSheet($this->index)->getStyle($alphas[$i] . $row)->applyFromArray($styleArray);
        }
        $document->getSheet($this->index)->getRowDimension($row)->setRowHeight(25);
        $wizard = new \PHPExcel_Helper_HTML;
        $headers = array(
            'Mois','Décès (FAT)','Incapacité (PDC)','Accident avec arrêt (LTI)',
            'Traitement médical (MT)','Poste aménagé (RWC)','1er Soin (FA)','LTIR','TRIR',
            $wizard->toRichTextObject('<font size="9">Heures travaill&eacute;es <br/>Personnel LPSA</font>'),$wizard->toRichTextObject('<font size="9">Heures travaill&eacute;es <br/>Contractants</font>'),'LTIR','TRIR','objectif LTIR','objectif TRIR','FAR','TRI',
        );
        
        return $headers;
    }

    private function getExcelData(){
        $data = [];
        $aTrir12Months = $this->ltirTrir->getTRIR12Months();
        $aLtir12Months = $this->ltirTrir->getLTIR12Months();
        foreach($this->ltirTrir->getMonthHeaders12Months() as $month => $date){
            $data[] = [
                (string) $date->format('M-Y'),
                (string) $aTrir12Months[$month]->getFat(),
                (string) $aTrir12Months[$month]->getPdc(),
                (string) $aTrir12Months[$month]->getLti(),
                (string) $aTrir12Months[$month]->getMt(),
                (string) $aTrir12Months[$month]->getRwc(),
                (string) $aTrir12Months[$month]->getFa(),
                (string) $aLtir12Months[$month]->getLTIR(),
                (string) $aTrir12Months[$month]->getTRIR(),
                (string) $aTrir12Months[$month]->getHeureLpsa(),
                (string) $aTrir12Months[$month]->getHeureContractant(),
                (string) $aLtir12Months[$month]->get12MonthsLTIR($month),
                (string) $aTrir12Months[$month]->get12MonthsTRIR($month),
                (string) $aLtir12Months[$month]->getObjectifLtir(),
                (string) $aTrir12Months[$month]->getObjectifTrir(),
                (string) $aTrir12Months[$month]->getFar(),
                (string) $aTrir12Months[$month]->getTri(),
            ];
        }
        $aTrir = $this->ltirTrir->getTRIR();
        $aLtir = $this->ltirTrir->getLTIR();
        foreach($this->monthHeaders as $month => $date){
            $data[] = [
                (string) $date->format('M-Y'),
                (string) $aTrir[$month]->getFat(),
                (string) $aTrir[$month]->getPdc(),
                (string) $aTrir[$month]->getLti(),
                (string) $aTrir[$month]->getMt(),
                (string) $aTrir[$month]->getRwc(),
                (string) $aTrir[$month]->getFa(),
                (string) $aLtir[$month]->getLTIR(),
                (string) $aTrir[$month]->getTRIR(),
                (string) $aTrir[$month]->getHeureLpsa(),
                (string) $aTrir[$month]->getHeureContractant(),
                (string) $aLtir[$month]->get12MonthsLTIR($month),
                (string) $aTrir[$month]->get12MonthsTRIR($month),
                (string) $aLtir[$month]->getObjectifLtir(),
                (string) $aTrir[$month]->getObjectifTrir(),
                (string) $aTrir[$month]->getFar(),
                (string) $aTrir[$month]->getTri(),
            ];
        }
        return $data;
    }
    public function insertChart($name,$path, $marge=0){
        $document = $this->manager->getDocument();
        $objDrawingPType = new \PHPExcel_Worksheet_Drawing();
        $objDrawingPType->setWorksheet($document->setActiveSheetIndex($this->index));
        $objDrawingPType->setName($name);
        $objDrawingPType->setPath($path);
        $objDrawingPType->setCoordinates('B'.($document->setActiveSheetIndex($this->index)->getHighestRow() + $marge));
        $objDrawingPType->setWidth(500);                 //set width, height
        $objDrawingPType->setHeight(1000); 
        $objDrawingPType->setOffsetX(200);
    }
}