<?php

namespace Lpsa\AppBundle\Statistic\Excel;

class SheetKpihse{

    private $row = 5;
    private $rowIndicatorCumul = array();
    private $kpihse;
    private $manager;
    private $index;    

    public function init($kpihse,$manager,$index = 0,$newSheet = false){
        $this->kpihse = $kpihse;
        $this->manager = $manager;
        if($newSheet){
            $this->manager->addSheet();
        }
        $this->index = $index;
        return $this;
    }

    public function process(){
        $rowStart = 6;        
        $monthHeaders = $this->kpihse->getMonthHeaders();
        $currentCumul = $this->kpihse->getCurrentCumul();
        $latestYear = $this->kpihse->getLatestCumul();
        $headers = $this->getExcelHeaders($monthHeaders,$currentCumul,$latestYear,'A');
        $datas = $this->getExcelData($currentCumul,$latestYear);
        $this->manager->setTitle('HPI\'S HSE ' . $this->kpihse->getDateEnd()->format('M Y'))
                ->fromArray($datas,array(),$this->index,null,'A'.$rowStart)
                ->setHeaders($headers,$this->index,5,'A');
        $this->setCellStyle($monthHeaders,'B',$rowStart);        
        $excelDocument = $this->manager->getDocument();
        $excelDocument->getSheet($this->index)->insertNewColumnBefore('A', 2);
        $value = $excelDocument->getSheet($this->index)->getCell('C5')->getValue();
        $excelDocument->getSheet($this->index)->mergeCells('A5:C5');
        $excelDocument->getSheet($this->index)->getCell('A5')->setValue($value);
        $excelDocument->getSheet($this->index)->getStyle('A5')->applyFromArray(array(
            'font'  => array(
                'bold'  => true,
                'color' => array('rgb' => '000000'),
                'size'  => 13,
                'name'  => 'Verdana'),
            'alignment' => array(
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_THIN
                )
            ),
            'fill' => array(
                'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '5A93A6')
            )
        ));  
        $excelDocument->getSheet($this->index)->mergeCells('B6:B36');
        $excelDocument->getSheet($this->index)->getCell('B6')->setValue('TRIR et LTRIR');
        $excelDocument->getSheet($this->index)->getStyle('B6')->getAlignment()->setTextRotation(90);
        $excelDocument->getSheet($this->index)->getStyle('B6')->applyFromArray([
            'font'  => array(
                'bold'  => true,
                'color' => array('rgb' => '000000'),
                'size'  => 13,
                'name'  => 'Verdana'
            ),
            'alignment' => array(
                'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_THIN
                )
            ),
            'fill' => array(
                'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'C3C8C9')
            )
        ]);
        $excelDocument->getSheet($this->index)->mergeCells('A6:A49');
        $excelDocument->getSheet($this->index)->getCell('A6')->setValue('SECURITE - SURETE');
        $excelDocument->getSheet($this->index)->getStyle('A6')->getAlignment()->setTextRotation(90);
        $excelDocument->getSheet($this->index)->getStyle('A6')->applyFromArray([
            'font'  => array(
                'bold'  => true,
                'color' => array('rgb' => 'FFFFFF'),
                'size'  => 13,
                'name'  => 'Verdana'
            ),
            'alignment' => array(
                'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_THIN
                )
            ),
            'fill' => array(
                'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '979A9C')
            )
        ]);
        $excelDocument->getSheet($this->index)->mergeCells('A50:A64');
        $excelDocument->getSheet($this->index)->getCell('A50')->setValue('RETOUR D\'EXPERIENCE');
        $excelDocument->getSheet($this->index)->getStyle('A50')->getAlignment()->setTextRotation(90);
        $excelDocument->getSheet($this->index)->getStyle('A50')->applyFromArray([
            'font'  => array(
                'bold'  => true,
                'color' => array('rgb' => 'FFFFFF'),
                'size'  => 13,
                'name'  => 'Verdana'
            ),
            'alignment' => array(
                'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_THIN
                )
            ),
            'fill' => array(
                'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '979A9C')
            )
        ]);
        $excelDocument->getSheet($this->index)->mergeCells('A65:A79');
        $excelDocument->getSheet($this->index)->getCell('A65')->setValue('ENVIRONNEMENT');
        $excelDocument->getSheet($this->index)->getStyle('A65')->getAlignment()->setTextRotation(90);
        $excelDocument->getSheet($this->index)->getStyle('A65')->applyFromArray([
            'font'  => array(
                'bold'  => true,
                'color' => array('rgb' => 'FFFFFF'),
                'size'  => 13,
                'name'  => 'Verdana'
            ),
            'alignment' => array(
                'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_THIN
                )
            ),
            'fill' => array(
                'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '979A9C')
            )
        ]);
        $excelDocument->getSheet($this->index)->mergeCells('A80:A84');
        $excelDocument->getSheet($this->index)->getCell('A80')->setValue('QUALITE PRODUIT');
        $excelDocument->getSheet($this->index)->getStyle('A80')->getAlignment()->setTextRotation(90);
        $excelDocument->getSheet($this->index)->getStyle('A80')->applyFromArray([
            'font'  => array(
                'bold'  => true,
                'color' => array('rgb' => 'FFFFFF'),
                'size'  => 8,
                'name'  => 'Verdana'
            ),
            'alignment' => array(
                'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_THIN
                )
            ),
            'fill' => array(
                'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '979A9C')
            )
        ]);
        $excelDocument->getSheet($this->index)->mergeCells('A85:A88');
        $excelDocument->getSheet($this->index)->getCell('A85')->setValue('PAQSSSE (Audits internes & Groupes)');
        $excelDocument->getSheet($this->index)->getStyle('A85')->getAlignment()->setTextRotation(90);
        $excelDocument->getSheet($this->index)->getStyle('A85')->applyFromArray([
            'font'  => array(
                'bold'  => true,
                'color' => array('rgb' => 'FFFFFF'),
                'size'  => 8,
                'name'  => 'Verdana'
            ),
            'alignment' => array(
                'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_THIN
                )
            ),
            'fill' => array(
                'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '979A9C')
            )
        ]);
        //cumul special color
        $excelDocument->getSheet($this->index)
            ->getStyle('C29')
            ->getFill()
            ->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)
            ->getStartColor()
            ->setRGB('979A9C');
        $excelDocument->getSheet($this->index)
            ->getStyle('C34')
            ->getFill()
            ->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)
            ->getStartColor()
            ->setRGB('979A9C');
        $excelDocument->getSheet($this->index)->mergeCells('B37:B39');
        $excelDocument->getSheet($this->index)->getCell('B37')->setValue('VOLS');
        $excelDocument->getSheet($this->index)->getStyle('B37')->getAlignment()->setTextRotation(90);
        $excelDocument->getSheet($this->index)->getStyle('B37')->applyFromArray([
            'font'  => array(
                'bold'  => true,
                'color' => array('rgb' => '000000'),
                'size'  => 13,
                'name'  => 'Verdana'
            ),
            'alignment' => array(
                'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_THIN
                )
            ),
            'fill' => array(
                'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'C3C8C9')
            )
        ]);
        $excelDocument->getSheet($this->index)->mergeCells('B40:B49');
        $excelDocument->getSheet($this->index)->getCell('B40')->setValue('INDICATEURS SPECIFIQUES TRANSPORT');
        $excelDocument->getSheet($this->index)->getStyle('B40')->getAlignment()->setTextRotation(90);
        $excelDocument->getSheet($this->index)->getStyle('B40')->applyFromArray([
            'font'  => array(
                'bold'  => true,
                'color' => array('rgb' => '000000'),
                'size'  => 8,
                'name'  => 'Verdana'
            ),
            'alignment' => array(
                'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_THIN
                )
            ),
            'fill' => array(
                'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'C3C8C9')
            )
        ]);
        $excelDocument->getSheet($this->index)->mergeCells('B50:B54');
        $excelDocument->getSheet($this->index)->getCell('B50')->setValue('EXERCICES D\'URGENCE');
        $excelDocument->getSheet($this->index)->getStyle('B50')->getAlignment()->setTextRotation(90);
        $excelDocument->getSheet($this->index)->getStyle('B50')->applyFromArray([
            'font'  => array(
                'bold'  => true,
                'color' => array('rgb' => '000000'),
                'size'  => 8,
                'name'  => 'Verdana'
            ),
            'alignment' => array(
                'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_THIN
                )
            ),
            'fill' => array(
                'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'C3C8C9')
            )
        ]);
        $excelDocument->getSheet($this->index)->mergeCells('B55:B57');
        $excelDocument->getSheet($this->index)->getCell('B55')->setValue('TOOLBOX');
        $excelDocument->getSheet($this->index)->getStyle('B55')->getAlignment()->setTextRotation(90);
        $excelDocument->getSheet($this->index)->getStyle('B55')->applyFromArray([
            'font'  => array(
                'bold'  => true,
                'color' => array('rgb' => '000000'),
                'size'  => 8,
                'name'  => 'Verdana'
            ),
            'alignment' => array(
                'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_THIN
                )
            ),
            'fill' => array(
                'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'C3C8C9')
            )
        ]);
        $excelDocument->getSheet($this->index)->getCell('B58')->setValue('VISITES');
        $excelDocument->getSheet($this->index)->getStyle('B58')->applyFromArray([
            'font'  => array(
                'bold'  => true,
                'color' => array('rgb' => '000000'),
                'size'  => 8,
                'name'  => 'Verdana'
            ),
            'alignment' => array(
                'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_THIN
                )
            ),
            'fill' => array(
                'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'C3C8C9')
            )
        ]);
        $excelDocument->getSheet($this->index)->mergeCells('B59:B64');
        $excelDocument->getSheet($this->index)->getCell('B59')->setValue('REPORTING EVENEMENT');
        $excelDocument->getSheet($this->index)->getStyle('B59')->getAlignment()->setTextRotation(90);
        $excelDocument->getSheet($this->index)->getStyle('B59')->applyFromArray([
            'font'  => array(
                'bold'  => true,
                'color' => array('rgb' => '000000'),
                'size'  => 8,
                'name'  => 'Verdana'
            ),
            'alignment' => array(
                'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_THIN
                )
            ),
            'fill' => array(
                'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'C3C8C9')
            )
        ]);
        $excelDocument->getSheet($this->index)->mergeCells('B65:B70');
        $excelDocument->getSheet($this->index)->getCell('B65')->setValue('EPANDAGES  DEBORDEMENTS FUITES');
        $excelDocument->getSheet($this->index)->getStyle('B65')->getAlignment()->setTextRotation(90);
        $excelDocument->getSheet($this->index)->getStyle('B65')->applyFromArray([
            'font'  => array(
                'bold'  => true,
                'color' => array('rgb' => '000000'),
                'size'  => 8,
                'name'  => 'Verdana'
            ),
            'alignment' => array(
                'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_THIN
                )
            ),
            'fill' => array(
                'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'C3C8C9')
            )
        ]);
        
        $excelDocument->getSheet($this->index)->getCell('B71')->setValue('POLUTION MARINE');
        $excelDocument->getSheet($this->index)->getStyle('B71')->applyFromArray([
            'font'  => array(
                'bold'  => true,
                'color' => array('rgb' => '000000'),
                'size'  => 8,
                'name'  => 'Verdana'
            ),
            'alignment' => array(
                'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_THIN
                )
            ),
            'fill' => array(
                'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'C3C8C9')
            )
        ]);

        $excelDocument->getSheet($this->index)->mergeCells('B72:B75');
        $excelDocument->getSheet($this->index)->getCell('B72')->setValue('PIEZOMETRES');
        $excelDocument->getSheet($this->index)->getStyle('B72')->getAlignment()->setTextRotation(90);
        $excelDocument->getSheet($this->index)->getStyle('B72')->applyFromArray([
            'font'  => array(
                'bold'  => true,
                'color' => array('rgb' => '000000'),
                'size'  => 8,
                'name'  => 'Verdana'
            ),
            'alignment' => array(
                'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_THIN
                )
            ),
            'fill' => array(
                'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'C3C8C9')
            )
        ]);

        $excelDocument->getSheet($this->index)->mergeCells('B76:B79');
        $excelDocument->getSheet($this->index)->getCell('B76')->setValue('DECANTEURS');
        $excelDocument->getSheet($this->index)->getStyle('B76')->getAlignment()->setTextRotation(90);
        $excelDocument->getSheet($this->index)->getStyle('B76')->applyFromArray([
            'font'  => array(
                'bold'  => true,
                'color' => array('rgb' => '000000'),
                'size'  => 8,
                'name'  => 'Verdana'
            ),
            'alignment' => array(
                'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_THIN
                )
            ),
            'fill' => array(
                'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'C3C8C9')
            )
        ]);
        $excelDocument->getSheet($this->index)->mergeCells('B80:B84');
        $excelDocument->getSheet($this->index)->getCell('B80')->setValue('LABORATOIRE');
        $excelDocument->getSheet($this->index)->getStyle('B80')->getAlignment()->setTextRotation(90);
        $excelDocument->getSheet($this->index)->getStyle('B80')->applyFromArray([
            'font'  => array(
                'bold'  => true,
                'color' => array('rgb' => '000000'),
                'size'  => 8,
                'name'  => 'Verdana'
            ),
            'alignment' => array(
                'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_THIN
                )
            ),
            'fill' => array(
                'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'C3C8C9')
            )
        ]);
        $excelDocument->getSheet($this->index)->mergeCells('B85:B88');
        $excelDocument->getSheet($this->index)->getCell('B85')->setValue('Dépôts et Siège');
        $excelDocument->getSheet($this->index)->getStyle('B85')->getAlignment()->setTextRotation(90);
        $excelDocument->getSheet($this->index)->getStyle('B85')->applyFromArray([
            'font'  => array(
                'bold'  => true,
                'color' => array('rgb' => '000000'),
                'size'  => 8,
                'name'  => 'Verdana'
            ),
            'alignment' => array(
                'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_THIN
                )
            ),
            'fill' => array(
                'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'C3C8C9')
            )
        ]);
        $this->setHeaderTitle();
    }

    private function setHeaderTitle(){
        $wizard = new \PHPExcel_Helper_HTML;
        $this->manager->setValue('A1', $wizard->toRichTextObject('<font size="11"><b>LOGISTIQUE PETROLIERE</b></font>'), $this->index);
        $this->manager->setValue('A2', $wizard->toRichTextObject('<font size="11"><b>DHSSEQ-DD</b></font>'), $this->index);
        $this->manager->setValue('A3', $wizard->toRichTextObject('<font size="8"><b>DATE</b></font>'), $this->index);
        $this->manager->setValue('B3', $wizard->toRichTextObject('<font size="8"><b>'.$this->kpihse->getDateEnd()->format('d/m/Y').'</b></font>'), $this->index);
        $this->manager->setValue('A4', $wizard->toRichTextObject('<font size="11"><b>KPI HSSEQ-DD '.$this->kpihse->getDateEnd()->format('M Y').'</b></font>'), $this->index);
    }

    private function setCellStyle($monthHeaders,$cellStart,$rowStart){
        $excelDocument = $this->manager->getDocument();

        $styleIndicator = array(
            'font'  => array(
                'bold'  => false,
                'color' => array('rgb' => '000000'),
                'size'  => 8,
                'name'  => 'Verdana'),
            'alignment' => array(
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );
        $styleLastCumul = array(
            'font'  => array(
                'bold'  => false,
                'color' => array('rgb' => '000000'),
                'size'  => 10,
                'name'  => 'Verdana'),
            'alignment' => array(
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
            'fill' => array(
                'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'b0d2f4')
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );
        $stylePerMonth = array(
            'font'  => array(
                'bold'  => false,
                'color' => array('rgb' => '000000'),
                'size'  => 10,
                'name'  => 'Verdana'),
            'alignment' => array(
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
            'fill' => array(
                'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '67bf96')
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );
        $styleCumulMonth = array(
            'font'  => array(
                'bold'  => false,
                'color' => array('rgb' => '000000'),
                'size'  => 10,
                'name'  => 'Verdana'),
            'alignment' => array(
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
            'fill' => array(
                'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'EFF0F1')
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );
        for($i = 6; $i <= $this->row; $i++){
            if(in_array($i,$this->rowIndicatorCumul)){
                $styleIndicator['fill'] = array(
                    'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => 'b0b5ba')
                );
            } else {
                $styleIndicator['fill'] = array(
                    'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => 'EFF0F1')
                );
            }
            $excelDocument->getSheet($this->index)->getStyle($cellStart . $i)
                          ->applyFromArray($styleIndicator);
        }
        $alphas = range($cellStart, 'Z');
        $excelDocument->getSheet($this->index)->getStyle($cellStart . $rowStart . ':' . $cellStart .$this->row)
                      ->applyFromArray($styleLastCumul);
        $col = 1;
        foreach($monthHeaders as $monthHeader){
            $excelDocument->getSheet($this->index)->getStyle($alphas[$col]. $rowStart . ':'.$alphas[$col].$this->row)
                          ->applyFromArray($stylePerMonth);
            $col++;
        }
        $excelDocument->getSheet($this->index)->getStyle($alphas[$col]. $rowStart . ':'.$alphas[$col].$this->row)
                      ->applyFromArray($styleCumulMonth);
        $col++;
        $excelDocument->getSheet($this->index)->getStyle($alphas[$col]. $rowStart . ':'.$alphas[$col].$this->row)
                      ->applyFromArray($styleCumulMonth);
    }

    private function getExcelHeaders($monthHeaders,$currentCumul,$latestYear,$cellStartHeader = 'A'){
        $excelDocument = $this->manager->getDocument();
        $col = 0;
        $alphas = range($cellStartHeader, 'Z');
        $styleArray = array(
            'font'  => array(
                'bold'  => true,
                'color' => array('rgb' => '000000'),
                'size'  => 13,
                'name'  => 'Verdana'),
            'alignment' => array(
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_THIN
                )
            ),
            'fill' => array(
                'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '5A93A6')
            )
        );
        $excelDocument->getSheet($this->index)->getStyle($alphas[$col] . '5')->applyFromArray($styleArray);
        $headers = array('Indicateurs');
        $headers[] = 'Cumul ' . $latestYear->getDate()->format('Y');
        $col++;
        foreach($monthHeaders as $monthHeader){
            $headers[] = $monthHeader->format('M-Y');
            $excelDocument->getSheet($this->index)->getStyle($alphas[$col] . '5')->applyFromArray($styleArray);
            $col++;
        }
        $headers[] = 'Cumul ' . $currentCumul->getDate()->format('Y');
        $excelDocument->getSheet($this->index)->getStyle($alphas[$col] . '5')->applyFromArray($styleArray);
        $col++;
        //objectif KpiHse 
        $objectifKpihse = $this->kpihse->getObjectifKpihse();
        $headers[] = 'Objectif ' . $objectifKpihse->getDateEnd()->format('Y');
        $excelDocument->getSheet($this->index)->getStyle($alphas[$col] . '5')->applyFromArray($styleArray);
        $col++;
        $excelDocument->getSheet($this->index)->getStyle($alphas[$col] . '5')->applyFromArray($styleArray);
        $this->row++;
        return $headers;
    }    

    private function getExcelData($currentCumul,$latestYear){        
        $datas = array();
        $wizard = new \PHPExcel_Helper_HTML;
        //objectif KpiHse 
        $objectifKpihse = $this->kpihse->getObjectifKpihse();
        //fat        
        $datas[] = $this->getFatData($currentCumul,$latestYear,'nbLpsa',$wizard->toRichTextObject('<font size="9">Nbre <b>FAT</b> "LPSA"</font>'));
        $datas[] = $this->getFatData($currentCumul,$latestYear,'nbContracte',$wizard->toRichTextObject('<font size="9">Nbre <b>FAT</b> "Contract&eacute;s"</font>'));
        $datas[] = $this->getFatData($currentCumul,$latestYear,'nbTiers',$wizard->toRichTextObject('<font size="9">Nbre <b>FAT</b> "Tiers"</font>'));
        $totalFat = array($wizard->toRichTextObject('<font size="9">Cumul <b>FAT Fatality</b></font>'));
        $totalFat[] = (string) $latestYear->getTotalFat();
        foreach($this->kpihse->getKPIHSE() as $kpi){
            $totalFat[] = (string) $kpi->getTotalFat();
        }
        $totalFat[] = (string) $currentCumul->getTotalFat();
        $totalFat[] = (string) $objectifKpihse->getTotalFat();
        $datas[] = $totalFat;
        $this->row += 4;
        $this->rowIndicatorCumul[] = $this->row - 1;
        //lti
        $datas[] = $this->getLtiData($currentCumul,$latestYear,'nbLpsa',$wizard->toRichTextObject('<font size="9">Nbre <b>LTI</b> "LPSA"</font>'));
        $datas[] = $this->getLtiData($currentCumul,$latestYear,'nbContracte',$wizard->toRichTextObject('<font size="9">Nbre <b>LTI</b> "Contract&eacute;s"</font>'));
        $totalLti = array($wizard->toRichTextObject('<font size="9">Cumul <b>LTI Lost Time Injury</b></font>'));
        $totalLti[] = (string) $latestYear->getTotalLti();
        foreach($this->kpihse->getKPIHSE() as $kpi){
            $totalLti[] = (string) $kpi->getTotalLti();
        }
        $totalLti[] = (string) $currentCumul->getTotalLti();
        $totalLti[] = (string) $objectifKpihse->getTotalLti();
        $datas[] = $totalLti;
        $this->row += 3;
        $this->rowIndicatorCumul[] = $this->row - 1;
        //rwc
        $totalRwc = array($wizard->toRichTextObject('<font size="9">Poste Am&eacute;nag&eacute; <b>RWC</b></font>'));
        $totalRwc[] = (string) $latestYear->getTotalRwc();
        foreach($this->kpihse->getKPIHSE() as $kpi){
            $totalRwc[] = (string) $kpi->getTotalRwc();
        }
        $totalRwc[] = (string) $currentCumul->getTotalRwc();
        $totalRwc[] = (string) $objectifKpihse->getRwc();
        $datas[] = $totalRwc;
        $this->row++;
        $this->rowIndicatorCumul[] = $this->row - 1;
        //mt
        $datas[] = $this->getMtData($currentCumul,$latestYear,'nbLpsa',$wizard->toRichTextObject('<font size="9">Nbre <b>MT</b> "LPSA"</font>'));
        $datas[] = $this->getMtData($currentCumul,$latestYear,'nbContracte',$wizard->toRichTextObject('<font size="9">Nbre <b>MT</b> "Contract&eacute;s"</font>'));
        $totalMt = array($wizard->toRichTextObject('<font size="9">Cumul <b>MT Medical Traitement</b></font>'));
        $totalMt[] = (string) $latestYear->getTotalMt();
        foreach($this->kpihse->getKPIHSE() as $kpi){
            $totalMt[] = (string) $kpi->getTotalMt();
        }
        $totalMt[] = (string) $currentCumul->getTotalMt();
        $totalMt[] = (string) $objectifKpihse->getTotalMt();
        $datas[] = $totalMt;
        $this->row += 3;
        $this->rowIndicatorCumul[] = $this->row - 1;
        //fa
        $datas[] = $this->getFaData($currentCumul,$latestYear,'nbLpsa',$wizard->toRichTextObject('<font size="9">Nbre <b>FA</b> "LPSA"</font>'));
        $datas[] = $this->getFaData($currentCumul,$latestYear,'nbContracte',$wizard->toRichTextObject('<font size="9">Nbre <b>FA</b> "Contract&eacute;s"</font>'));
        $totalFa = array($wizard->toRichTextObject('<font size="9">Cumul <b>FA First Aid</b></font>'));
        $totalFa[] = (string) $latestYear->getTotalFa();
        foreach($this->kpihse->getKPIHSE() as $kpi){
            $totalFa[] = (string) $kpi->getTotalFa();
        }
        $totalFa[] = (string) $currentCumul->getTotalFa();
        $totalFa[] = (string) $objectifKpihse->getTotalFa();
        $datas[] = $totalFa;
        $this->row += 3;
        $this->rowIndicatorCumul[] = $this->row - 1;
        //tri
        $tri = array($wizard->toRichTextObject('<font size="9"><b>TRI</b> Total Recording Injury</font>'));
        $tri[] = (string) $latestYear->getTRI();
        foreach($this->kpihse->getKPIHSE() as $kpi){
            $tri[] = (string) $kpi->getTRI();
        }
        $tri[] = (string) $currentCumul->getTRI();
        $tri[] = (string) $objectifKpihse->getTri();
        $datas[] = $tri;
        $this->row++;
        //TRIR (sur 12 mois glissants)
        $trir12 = array($wizard->toRichTextObject('<font size="9"><b>TRIR (sur 12 mois glissants)</b></font>'));
        $trir12[] = (string) $latestYear->getTrir12();
        foreach($this->kpihse->getKPIHSE() as $kpi){
            $trir12[] = (string) $kpi->getTrir12();
        }
        $trir12[] = (string) $currentCumul->getTrir12();
        $trir12[] = (string) $objectifKpihse->getTrir12Mois();
        $datas[] = $trir12;
        $this->row++;
        //LTIR (sur 12 mois glissants)
        $ltir12 = array($wizard->toRichTextObject('<font size="9"><b>LTIR (sur 12 mois glissants)</b></font>'));
        $ltir12[] = (string) $latestYear->getLtir12();
        foreach($this->kpihse->getKPIHSE() as $kpi){
            $ltir12[] = (string) $kpi->getLtir12();
        }
        $ltir12[] = (string) $currentCumul->getLtir12();
        $ltir12[] = (string) $objectifKpihse->getLtir12Mois();
        $datas[] = $ltir12;
        $this->row++;
        //TRIR 
        $trir = array($wizard->toRichTextObject('<font size="9"><b>TRIR</b></font>'));
        $trir[] = (string) $latestYear->getTrir();
        foreach($this->kpihse->getKPIHSE() as $kpi){
            $trir[] = (string) $kpi->getTrir();
        }
        $trir[] = (string) $currentCumul->getTrir();
        $trir[] = (string) $objectifKpihse->getTrir();
        $datas[] = $trir;
        $this->row++;
        //LTIR 
        $ltir = array($wizard->toRichTextObject('<font size="9"><b>LTIR</b></font>'));
        $ltir[] = (string) $latestYear->getLtir();
        foreach($this->kpihse->getKPIHSE() as $kpi){
            $ltir[] = (string) $kpi->getLtir();
        }
        $ltir[] = (string) $currentCumul->getLtir();
        $ltir[] = (string) $objectifKpihse->getLtir();
        $datas[] = $ltir;
        $this->row++;
        //FAR 
        $far = array($wizard->toRichTextObject('<font size="9"><b>FAR</b></font>'));
        $far[] = (string) $latestYear->getFar();
        foreach($this->kpihse->getKPIHSE() as $kpi){
            $far[] = (string) $kpi->getTrirObject()->getFar();
        }
        $far[] = (string) $currentCumul->getTrirObject()->getFar();
        $far[] = (string) $objectifKpihse->getFar();
        $datas[] = $far;
        $this->row++;
        //FAR (sur 12 mois glissants) 
        $far12 = array($wizard->toRichTextObject('<font size="9"><b>FAR (sur 12 mois glissants)</b></font>'));
        $far12[] = (string) $latestYear->getFar12();
        foreach($this->kpihse->getKPIHSE() as $kpi){
            $far12[] = (string) $kpi->getFar12();
        }
        $far12[] = (string) $currentCumul->getFar12();
        $far12[] = (string) $objectifKpihse->getFar12Mois();
        $datas[] = $far12;
        $this->row++;
        //Nbre d'accidents  "D&eacute;pots" avec arrêt 
        $nbLostTimeAccidentRepositories = array($wizard->toRichTextObject('<font size="9">Nbre d\'accidents  <b>"D&eacute;pots"</b> avec arr&ecirc;t</font>'));
        $nbLostTimeAccidentRepositories[] = (string) $latestYear->getNbLostTimeAccidentRepositories();
        foreach($this->kpihse->getKPIHSE() as $kpi){
            $nbLostTimeAccidentRepositories[] = (string) $kpi->getNbLostTimeAccidentRepositories();
        }
        $nbLostTimeAccidentRepositories[] = (string) $currentCumul->getNbLostTimeAccidentRepositories();
        $nbLostTimeAccidentRepositories[] = (string) $objectifKpihse->getNbreAccidentDepotAvecArret();
        $datas[] = $nbLostTimeAccidentRepositories;
        $this->row++;
        //Nbre d'accidents "Transport Terrestre" avec arrêt 
        $nbTransportTerrestreAvecArret = array($wizard->toRichTextObject('<font size="9">Nbre d\'accidents <b>"Transport Terrestre"</b> avec arr&ecirc;t</font>'));
        $nbTransportTerrestreAvecArret[] = (string) $latestYear->getNbTransportTerrestreAvecArret();
        foreach($this->kpihse->getKPIHSE() as $kpi){
            $nbTransportTerrestreAvecArret[] = (string) $kpi->getNbTransportTerrestreAvecArret();
        }
        $nbTransportTerrestreAvecArret[] = (string) $currentCumul->getNbTransportTerrestreAvecArret();
        $nbTransportTerrestreAvecArret[] = (string) $objectifKpihse->getNbreAccidentTransportTerrestreAvecArret();
        $datas[] = $nbTransportTerrestreAvecArret;
        $this->row++;
        //Nbre d'accidents"Transport Maritime" avec arrêt 
        $nbTransportMaritimeAvecArret = array($wizard->toRichTextObject('<font size="9">Nbre d\'accidents <b>"Transport Maritime"</b> avec arr&ecirc;t</font>'));
        $nbTransportMaritimeAvecArret[] = (string) $latestYear->getNbTransportMaritimeAvecArret();
        foreach($this->kpihse->getKPIHSE() as $kpi){
            $nbTransportMaritimeAvecArret[] = (string) $kpi->getNbTransportMaritimeAvecArret();
        }
        $nbTransportMaritimeAvecArret[] = (string) $currentCumul->getNbTransportMaritimeAvecArret();
        $nbTransportMaritimeAvecArret[] = (string) $objectifKpihse->getNbreAccidentTransportMaritimeAvecArret();
        $datas[] = $nbTransportMaritimeAvecArret;
        $this->row++;
        //Nbre d'accidents "Si&egrave;ge" avec arrêt
        $nbLostTimeAccidentCenter = array($wizard->toRichTextObject('<font size="9">Nbre d\'accidents <b>"Si&egrave;ge"</b> avec arr&ecirc;t</font>'));
        $nbLostTimeAccidentCenter[] = (string) $latestYear->getNbLostTimeAccidentCenter();
        foreach($this->kpihse->getKPIHSE() as $kpi){
            $nbLostTimeAccidentCenter[] = (string) $kpi->getNbLostTimeAccidentCenter();
        }
        $nbLostTimeAccidentCenter[] = (string) $currentCumul->getNbLostTimeAccidentCenter();
        $nbLostTimeAccidentCenter[] = (string) $objectifKpihse->getNbreAccidentSiegeAvecArret();
        $datas[] = $nbLostTimeAccidentCenter;
        $this->row++;
        //CUMUL des accidents avec arrêt
        $totalAvecArret = array($wizard->toRichTextObject('<font size="9">CUMUL des accidents avec arr&ecirc;t</font>'));
        $totalAvecArret[] = (string) $latestYear->getCumulAvecArret();
        foreach($this->kpihse->getKPIHSE() as $kpi){
            $totalAvecArret[] = (string) $kpi->getCumulAvecArret();
        }
        $totalAvecArret[] = (string) $currentCumul->getCumulAvecArret();
        $totalAvecArret[] = (string) $objectifKpihse->getCumulAvecArret();
        $datas[] = $totalAvecArret;
        $this->row++;
        //Nbre d'accidents  "D&eacute;pots" sans arrêt
        $nbAccidentRepositories = array($wizard->toRichTextObject('<font size="9">Nbre d\'accidents  <b>"D&eacute;pots"</b> sans arr&ecirc;t</font>'));
        $nbAccidentRepositories[] = (string) $latestYear->getNbAccidentRepositories();
        foreach($this->kpihse->getKPIHSE() as $kpi){
            $nbAccidentRepositories[] = (string) $kpi->getNbAccidentRepositories();
        }
        $nbAccidentRepositories[] = (string) $currentCumul->getNbAccidentRepositories();
        $nbAccidentRepositories[] = (string) $objectifKpihse->getNbreAccidentDepotSansArret();
        $datas[] = $nbAccidentRepositories;
        $this->row++;
        //Nbre d'accidents "Transport Terrestre" sans arrêt 
        $nbTransportTerrestreSansArret = array($wizard->toRichTextObject('<font size="9">Nbre d\'accidents "Transport Terrestre" sans arr&ecirc;t </font>'));
        $nbTransportTerrestreSansArret[] = (string) $latestYear->getNbTransportTerrestreSansArret();
        foreach($this->kpihse->getKPIHSE() as $kpi){
            $nbTransportTerrestreSansArret[] = (string) $kpi->getNbTransportTerrestreSansArret();
        }
        $nbTransportTerrestreSansArret[] = (string) $currentCumul->getNbTransportTerrestreSansArret();
        $nbTransportTerrestreSansArret[] = (string) $objectifKpihse->getNbreAccidentTransportTerrestreSansArret();
        $datas[] = $nbTransportTerrestreSansArret;
        $this->row++;
        //Nbre d'accidents"Transport Maritime" sans arrêt 
        $nbTransportMaritimeSansArret = array($wizard->toRichTextObject('<font size="9">Nbre d\'accidents <b>"Transport Maritime"</b> sans arr&ecirc;t</font>'));
        $nbTransportMaritimeSansArret[] = (string) $latestYear->getNbTransportMaritimeSansArret();
        foreach($this->kpihse->getKPIHSE() as $kpi){
            $nbTransportMaritimeSansArret[] = (string) $kpi->getNbTransportMaritimeSansArret();
        }
        $nbTransportMaritimeSansArret[] = (string) $currentCumul->getNbTransportMaritimeSansArret();
        $nbTransportMaritimeSansArret[] = (string) $objectifKpihse->getNbreAccidentTransportMaritimeSansArret();
        $datas[] = $nbTransportMaritimeSansArret;
        $this->row++;
        //Nbre d'accidents "Si&egrave;ge" sans arrêt
        $nbAccidentCenter = array($wizard->toRichTextObject('<font size="9">Nbre d\'accidents <b>"Si&egrave;ge"</b> sans arr&ecirc;t</font>'));
        $nbAccidentCenter[] = (string) $latestYear->getNbAccidentCenter();
        foreach($this->kpihse->getKPIHSE() as $kpi){
            $nbAccidentCenter[] = (string) $kpi->getNbAccidentCenter();
        }
        $nbAccidentCenter[] = (string) $currentCumul->getNbAccidentCenter();
        $nbAccidentCenter[] = (string) $objectifKpihse->getNbreAccidentSiegeSansArret();
        $datas[] = $nbAccidentCenter;
        //CUMUL des accidents sans arrêt
        $totalSansArret = array($wizard->toRichTextObject('<font size="9">CUMUL des accidents sans arr&ecirc;t</font>'));
        $totalSansArret[] = (string) $latestYear->getCumulSansArret();
        foreach($this->kpihse->getKPIHSE() as $kpi){
            $totalSansArret[] = (string) $kpi->getCumulSansArret();
        }
        $totalSansArret[] = (string) $currentCumul->getCumulSansArret();
        $totalSansArret[] = (string) $objectifKpihse->getCumulSansArret();
        $datas[] = $totalSansArret;
        $this->row++;
        //Nbre d'Agressions
        $nbIntrusion = array($wizard->toRichTextObject('<font size="9">Nbre d\'Agressions</font>'));
        $nbIntrusion[] = (string) $latestYear->getNbAgression();
        foreach($this->kpihse->getKPIHSE() as $kpi){
            $nbIntrusion[] = (string) $kpi->getNbAgression();
        }
        $nbIntrusion[] = (string) $currentCumul->getNbAgression();
        $nbIntrusion[] = (string) $objectifKpihse->getNbreAgression();
        $datas[] = $nbIntrusion;
        $this->row++;
        //Nbre de Vols
        $nbVol = array($wizard->toRichTextObject('<font size="9">Nbre de Vols</font>'));
        $nbVol[] = (string) $latestYear->getNbVol();
        foreach($this->kpihse->getKPIHSE() as $kpi){
            $nbVol[] = (string) $kpi->getNbVol();
        }
        $nbVol[] = (string) $currentCumul->getNbVol();
        $nbVol[] = (string) $objectifKpihse->getNbreVol();
        $datas[] = $nbVol;
        $this->row++;
        //Nbre d'intrusions
        $nbIntrusion = array($wizard->toRichTextObject('<font size="9">Nbre d\'intrusions</font>'));
        $nbIntrusion[] = (string) $latestYear->getNbIntrusion();
        foreach($this->kpihse->getKPIHSE() as $kpi){
            $nbIntrusion[] = (string) $kpi->getNbIntrusion();
        }
        $nbIntrusion[] = (string) $currentCumul->getNbIntrusion();
        $nbIntrusion[] = (string) $objectifKpihse->getNbreIntrusion();
        $datas[] = $nbIntrusion;
        $this->row++;
        //Nombre de jours depuis dernier accident corporel y compris tiers "Transport Route"
        $nbreJourAccidentCorporelTransportRoute = array($wizard->toRichTextObject('<font size="9">Nombre de jours depuis dernier accident corporel y compris tiers "Transport Route"</font>'));
        $nbreJourAccidentCorporelTransportRoute[] = (string) $latestYear->getNbreJourAccidentCorporelTransportRoute();
        foreach($this->kpihse->getKPIHSE() as $kpi){
            $nbreJourAccidentCorporelTransportRoute[] = (string) $kpi->getNbreJourAccidentCorporelTransportRoute();
        }
        $nbreJourAccidentCorporelTransportRoute[] = (string) $currentCumul->getNbreJourAccidentCorporelTransportRoute();
        $nbreJourAccidentCorporelTransportRoute[] = (string) $objectifKpihse->getNbreJourDernierAccidentCorporelRoute();
        $datas[] = $nbreJourAccidentCorporelTransportRoute;
        $this->row++;
        //KM parcourus "Transport Route" depuis dernier accident corporel y compris tiers
        $kmAccidentCorporelTransportRoute = array($wizard->toRichTextObject('<font size="9">KM parcourus "Transport Route" depuis dernier accident corporel y compris tiers</font>'));
        $kmAccidentCorporelTransportRoute[] = (string) $latestYear->getKmAccidentCorporelTransportRoute();
        foreach($this->kpihse->getKPIHSE() as $kpi){
            $kmAccidentCorporelTransportRoute[] = (string) $kpi->getKmAccidentCorporelTransportRoute();
        }
        $kmAccidentCorporelTransportRoute[] = (string) $currentCumul->getKmAccidentCorporelTransportRoute();
        $kmAccidentCorporelTransportRoute[] = (string) $objectifKpihse->getKmDernierAccidentCorporelRoute();
        $datas[] = $kmAccidentCorporelTransportRoute;
        $this->row++;
        //Nombre de jours depuis dernier accident corporel y compris tiers "Transport Rail"
        $nbreJourAccidentCorporelTransportRail = array($wizard->toRichTextObject('<font size="9">Nombre de jours depuis dernier accident corporel y compris tiers "Transport Rail"</font>'));
        $nbreJourAccidentCorporelTransportRail[] = (string) $latestYear->getNbreJourAccidentCorporelTransportRail();
        foreach($this->kpihse->getKPIHSE() as $kpi){
            $nbreJourAccidentCorporelTransportRail[] = (string) $kpi->getNbreJourAccidentCorporelTransportRail();
        }
        $nbreJourAccidentCorporelTransportRail[] = (string) $currentCumul->getNbreJourAccidentCorporelTransportRail();
        $nbreJourAccidentCorporelTransportRail[] = (string) $objectifKpihse->getNbreJourDernierAccidentCorporelRail();
        $datas[] = $nbreJourAccidentCorporelTransportRail;
        $this->row++;
        //KM parcourus "Transport Rail" depuis dernier accident corporel y compris tiers
        $kmAccidentCorporelTransportRail = array($wizard->toRichTextObject('<font size="9">KM parcourus "Transport Rail" depuis dernier accident corporel y compris tiers</font>'));
        $kmAccidentCorporelTransportRail[] = (string) $latestYear->getKmAccidentCorporelTransportRail();
        foreach($this->kpihse->getKPIHSE() as $kpi){
            $kmAccidentCorporelTransportRail[] = (string) $kpi->getKmAccidentCorporelTransportRail();
        }
        $kmAccidentCorporelTransportRail[] = (string) $currentCumul->getKmAccidentCorporelTransportRail();
        $kmAccidentCorporelTransportRail[] = (string) $objectifKpihse->getKmDernierAccidentCorporelRail();
        $datas[] = $kmAccidentCorporelTransportRail;
        $this->row++;
        //Nombre de jours depuis dernier incident y compris tiers "Transport Maritime"
        $nbreJourIncidentTransportMaritime = array($wizard->toRichTextObject('<font size="9">Nombre de jours depuis dernier incident y compris tiers "Transport Maritime"</font>'));
        $nbreJourIncidentTransportMaritime[] = (string) $latestYear->getNbreJourIncidentTransportMaritime();
        foreach($this->kpihse->getKPIHSE() as $kpi){
            $nbreJourIncidentTransportMaritime[] = (string) $kpi->getNbreJourIncidentTransportMaritime();
        }
        $nbreJourIncidentTransportMaritime[] = (string) $currentCumul->getNbreJourIncidentTransportMaritime();
        $nbreJourIncidentTransportMaritime[] = (string) $objectifKpihse->getNbreJourDernierIncidentMaritime();
        $datas[] = $nbreJourIncidentTransportMaritime;
        $this->row++;
        //Miles parcourus "Transport Maritime" depuis dernier incident y compris tiers
        $kmIncidentTransportMaritime = array($wizard->toRichTextObject('<font size="9">Miles parcourus "Transport Maritime" depuis dernier incident y compris tiers</font>'));
        $kmIncidentTransportMaritime[] = (string) $latestYear->getKmIncidentTransportMaritime();
        foreach($this->kpihse->getKPIHSE() as $kpi){
            $kmIncidentTransportMaritime[] = (string) $kpi->getKmIncidentTransportMaritime();
        }
        $kmIncidentTransportMaritime[] = (string) $currentCumul->getKmIncidentTransportMaritime();
        $kmIncidentTransportMaritime[] = (string) $objectifKpihse->getMilesDernierIncidentMaritime();
        $datas[] = $kmIncidentTransportMaritime;
        $this->row++;
        //Nombre de jours depuis derni&egrave;re fatalit&eacute; y compris tiers "Tout mode transport"
        $nbreJourFatalite = array($wizard->toRichTextObject('<font size="9">Nombre de jours depuis derni&egrave;re fatalit&eacute; y compris tiers "Tout mode transport"</font>'));
        $nbreJourFatalite[] = (string) $latestYear->getNbreJourFatalite();
        foreach($this->kpihse->getKPIHSE() as $kpi){
            $nbreJourFatalite[] = (string) $kpi->getNbreJourFatalite();
        }
        $nbreJourFatalite[] = (string) $currentCumul->getNbreJourFatalite();
        $nbreJourFatalite[] = (string) $objectifKpihse->getNbreJourDernierFatalite();
        $datas[] = $nbreJourFatalite;
        $this->row++;
        //Taux de sinistralit&eacute; de transport de mati&egrave;res dangereuses
        $tauxSinistraliteMatiereDangereuse = array($wizard->toRichTextObject('<font size="9">Taux de sinistralit&eacute; de transport de mati&egrave;res dangereuses</font>'));
        $tauxSinistraliteMatiereDangereuse[] = (string) $latestYear->getTauxSinistraliteMatiereDangereuse();
        foreach($this->kpihse->getKPIHSE() as $kpi){
            $tauxSinistraliteMatiereDangereuse[] = (string) $kpi->getTauxSinistraliteMatiereDangereuse();
        }
        $tauxSinistraliteMatiereDangereuse[] = (string) $currentCumul->getTauxSinistraliteMatiereDangereuse();
        $tauxSinistraliteMatiereDangereuse[] = (string) $objectifKpihse->getTauxSinistralite();
        $datas[] = $tauxSinistraliteMatiereDangereuse;
        $this->row++;
        //KM parcourus véhicules legers 
        $kmVehiculeLeger = array($wizard->toRichTextObject('<font size="9">KM parcourus v&eacute;hicules legers</font>'));
        $kmVehiculeLeger[] = (string) $latestYear->getKmVehiculeLeger();
        foreach($this->kpihse->getKPIHSE() as $kpi){
            $kmVehiculeLeger[] = (string) $kpi->getKmVehiculeLeger();
        }
        $kmVehiculeLeger[] = (string) $currentCumul->getKmVehiculeLeger();
        $kmVehiculeLeger[] = (string) $objectifKpihse->getKmVehiculeLeger();
        $datas[] = $kmVehiculeLeger;
        $this->row++;
        //Taux de sinistralit&eacute; de transport v&eacute;hicules l&eacute;gers
        $tauxSinistraliteVehiculeLeger = array($wizard->toRichTextObject('<font size="9">Taux de sinistralit&eacute; de transport v&eacute;hicules l&eacute;gers</font>'));
        $tauxSinistraliteVehiculeLeger[] = (string) $latestYear->getTauxSinistraliteVehiculeLeger();
        foreach($this->kpihse->getKPIHSE() as $kpi){
            $tauxSinistraliteVehiculeLeger[] = (string) $kpi->getTauxSinistraliteVehiculeLeger();
        }
        $tauxSinistraliteVehiculeLeger[] = (string) $currentCumul->getTauxSinistraliteVehiculeLeger();
        $tauxSinistraliteVehiculeLeger[] = (string) $objectifKpihse->getTauxSinistraliteVehiculeLeger();
        $datas[] = $tauxSinistraliteVehiculeLeger;
        $this->row++;
        //Nbre d'exercices POI
        $nbPoi = array($wizard->toRichTextObject('<font size="9">Nbre d\'exercices POI</font>'));
        $nbPoi[] = (string) $latestYear->getNbPoi();
        foreach($this->kpihse->getKPIHSE() as $kpi){
            $nbPoi[] = (string) $kpi->getNbPoi();
        }
        $nbPoi[] = (string) $currentCumul->getNbPoi();
        $nbPoi[] = (string) $objectifKpihse->getNbreExercicePoi();
        $datas[] = $nbPoi;
        $this->row++;
        //Nbre d'exercices mini POI
        $nbMiniPoi = array($wizard->toRichTextObject('<font size="9">Nbre d\'exercices mini POI</font>'));
        $nbMiniPoi[] = (string) $latestYear->getNbMiniPoi();
        foreach($this->kpihse->getKPIHSE() as $kpi){
            $nbMiniPoi[] = (string) $kpi->getNbMiniPoi();
        }
        $nbMiniPoi[] = (string) $currentCumul->getNbMiniPoi();
        $nbMiniPoi[] = (string) $objectifKpihse->getNbreExerciceMiniPoi();
        $datas[] = $nbMiniPoi;
        $this->row++;
        //Nbre d'exercices PUM (Plan d'Urgence Maritime Tier1 )
        $nbPum = array($wizard->toRichTextObject('<font size="9">Nbre d\'exercices PUM (Plan d\'Urgence Maritime Tier1 )</font>'));
        $nbPum[] = (string) $latestYear->getNbPum();
        foreach($this->kpihse->getKPIHSE() as $kpi){
            $nbPum[] = (string) $kpi->getNbPum();
        }
        $nbPum[] = (string) $currentCumul->getNbPum();
        $nbPum[] = (string) $objectifKpihse->getNbreExercicePum();
        $datas[] = $nbPum;
        $this->row++;
        //Nombre d'exercice combin&eacute; avec l'OLEP
        $nbCombine = array($wizard->toRichTextObject('<font size="9">Nombre d\'exercice combin&eacute; avec l\'OLEP</font>'));
        $nbCombine[] = (string) $latestYear->getNbCombine();
        foreach($this->kpihse->getKPIHSE() as $kpi){
            $nbCombine[] = (string) $kpi->getNbCombine();
        }
        $nbCombine[] = (string) $currentCumul->getNbCombine();
        $nbCombine[] = (string) $objectifKpihse->getNbreExerciceCombine();
        $datas[] = $nbCombine;
        $this->row++;
        //Nbre d'exercices CMC
        $nbCmc = array($wizard->toRichTextObject('<font size="9">Nbre d\'exercices CMC</font>'));
        $nbCmc[] = (string) $latestYear->getNbCmc();
        foreach($this->kpihse->getKPIHSE() as $kpi){
            $nbCmc[] = (string) $kpi->getNbCmc();
        }
        $nbCmc[] = (string) $currentCumul->getNbCmc();
        $nbCmc[] = (string) $objectifKpihse->getNbreExerciceCmc();
        $datas[] = $nbCmc;
        $this->row++;
        //SIEGE
        $toolboxSiege = array($wizard->toRichTextObject('<font size="9">SIEGE</font>'));
        $toolboxSiege[] = (string) $latestYear->getToolboxSiege();
        foreach($this->kpihse->getKPIHSE() as $kpi){
            $toolboxSiege[] = (string) $kpi->getToolboxSiege();
        }
        $toolboxSiege[] = (string) $currentCumul->getToolboxSiege();
        $toolboxSiege[] = (string) $objectifKpihse->getToolboxSiege();
        $datas[] = $toolboxSiege;
        $this->row++;
        //DEPOTS
        $toolboxDepots = array($wizard->toRichTextObject('<font size="9">DEPOTS</font>'));
        $toolboxDepots[] = (string) $latestYear->getToolboxDepots();
        foreach($this->kpihse->getKPIHSE() as $kpi){
            $toolboxDepots[] = (string) $kpi->getToolboxDepots();
        }
        $toolboxDepots[] = (string) $currentCumul->getToolboxDepots();
        $toolboxDepots[] = (string) $objectifKpihse->getToolboxDepot();
        $datas[] = $toolboxDepots;
        $this->row++;
        //SCT
        $toolboxSct = array($wizard->toRichTextObject('<font size="9">SCT</font>'));
        $toolboxSct[] = (string) $latestYear->getToolboxSct();
        foreach($this->kpihse->getKPIHSE() as $kpi){
            $toolboxSct[] = (string) $kpi->getToolboxSct();
        }
        $toolboxSct[] = (string) $currentCumul->getToolboxSct();
        $toolboxSct[] = (string) $objectifKpihse->getToolboxSct();
        $datas[] = $toolboxSct;
        $this->row++;
        //Nombre de Visites Sécurité CODIR  
        $visite = array($wizard->toRichTextObject('<font size="9">Nombre de Visites S&eacute;curit&eacute; CODIR</font>'));
        $visite[] = (string) $latestYear->getVisite();
        foreach($this->kpihse->getKPIHSE() as $kpi){
            $visite[] = (string) $kpi->getVisite();
        }
        $visite[] = (string) $currentCumul->getVisite();
        $visite[] = (string) $objectifKpihse->getNbreVisiteCodir();
        $datas[] = $visite;
        $this->row++;
        //Nombre d'évènement reporté: Toutes activités  y compris Petites unités 
        $nbEvenementReporte = array($wizard->toRichTextObject('<font size="9">Nombre d\'&eacute;v&egrave;nement report&eacute;: Toutes activit&eacute;s  y compris Petites unit&eacute;s </font>'));
        $nbEvenementReporte[] = (string) $latestYear->getNbEvenementReporte();
        foreach($this->kpihse->getKPIHSE() as $kpi){
            $nbEvenementReporte[] = (string) $kpi->getNbEvenementReporte();
        }
        $nbEvenementReporte[] = (string) $currentCumul->getNbEvenementReporte();
        $nbEvenementReporte[] = (string) $objectifKpihse->getNbreEvenementReporte();
        $datas[] = $nbEvenementReporte;
        $this->row++;
        //Indice de reporting 
        $indiceReporting = array($wizard->toRichTextObject('<font size="9">Indice de reporting</font>'));
        $indiceReporting[] = (string) $latestYear->getIndiceReporting();
        foreach($this->kpihse->getKPIHSE() as $kpi){
            $indiceReporting[] = (string) $kpi->getIndiceReporting();
        }
        $indiceReporting[] = (string) $currentCumul->getIndiceReporting();
        $indiceReporting[] = (string) $objectifKpihse->getIndiceReporting();
        $datas[] = $indiceReporting;
        $this->row++;
        //Nombre de Presqu'Accidents (PA)
        $presqueAccident = array($wizard->toRichTextObject('<font size="9">Nombre de Presqu\'Accidents (PA)</font>'));
        $presqueAccident[] = (string) $latestYear->getPresqueAccident();
        foreach($this->kpihse->getKPIHSE() as $kpi){
            $presqueAccident[] = (string) $kpi->getPresqueAccident();
        }
        $presqueAccident[] = (string) $currentCumul->getPresqueAccident();
        $presqueAccident[] = (string) $objectifKpihse->getNbrePresqueAccident();
        $datas[] = $presqueAccident;
        $this->row++;
        //Nombre des Actes et situations Dangéreuses (AD)
        $situationDangereuse = array($wizard->toRichTextObject('<font size="9">Nombre des Actes et situations Dang&eacute;reuses (AD)</font>'));
        $situationDangereuse[] = (string) $latestYear->getSituationDangereuse();
        foreach($this->kpihse->getKPIHSE() as $kpi){
            $situationDangereuse[] = (string) $kpi->getSituationDangereuse();
        }
        $situationDangereuse[] = (string) $currentCumul->getSituationDangereuse();
        $situationDangereuse[] = (string) $objectifKpihse->getNbreActeSituationDangereuse();
        $datas[] = $situationDangereuse;
        $this->row++;
        //Nbre d' Incidents  Potentiels nécéssitant un ADC  (IP)
        $incidentPotentiel = array($wizard->toRichTextObject('<font size="9">Nombre des Actes et situations Dang&eacute;reuses (AD)</font>'));
        $incidentPotentiel[] = (string) $latestYear->getIncidentPotentiel();
        foreach($this->kpihse->getKPIHSE() as $kpi){
            $incidentPotentiel[] = (string) $kpi->getIncidentPotentiel();
        }
        $incidentPotentiel[] = (string) $currentCumul->getIncidentPotentiel();
        $incidentPotentiel[] = (string) $objectifKpihse->getNbreIncidentPotentiel();
        $datas[] = $incidentPotentiel;
        $this->row++;
        //Nbre d'Analyses par Arbre Des Causes Réalisées
        $getNbParArbreCauseRealise = array($wizard->toRichTextObject('<font size="9">Nbre d\'Analyses par Arbre Des Causes R&eacute;alis&eacute;es</font>'));
        $getNbParArbreCauseRealise[] = (string) $latestYear->getNbParArbreCauseRealise();
        foreach($this->kpihse->getKPIHSE() as $kpi){
            $getNbParArbreCauseRealise[] = (string) $kpi->getNbParArbreCauseRealise();
        }
        $getNbParArbreCauseRealise[] = (string) $currentCumul->getNbParArbreCauseRealise();
        $getNbParArbreCauseRealise[] = (string) $objectifKpihse->getNbreAnalyseArbreCauseRealise();
        $datas[] = $getNbParArbreCauseRealise;
        $this->row++;
        //Zone étanche >159litres
        $environmentMore1m3ZE = array($wizard->toRichTextObject('<font size="9">Zone &eacute;tanche > 159litres</font>'));
        $environmentMore1m3ZE[] = (string) $latestYear->getEnvironmentMore1m3ZE();
        foreach($this->kpihse->getKPIHSE() as $kpi){
            $environmentMore1m3ZE[] = (string) $kpi->getEnvironmentMore1m3ZE();
        }
        $environmentMore1m3ZE[] = (string) $currentCumul->getEnvironmentMore1m3ZE();
        $environmentMore1m3ZE[] = (string) $objectifKpihse->getZoneEtancheSup159();
        $datas[] = $environmentMore1m3ZE;
        $this->row++;
        //Zone étanche <159litres
        $environmentLess1m3ZE = array($wizard->toRichTextObject('<font size="9">Zone &eacute;tanche <159litres</font>'));
        $environmentLess1m3ZE[] = (string) $latestYear->getEnvironmentLess1m3ZE();
        foreach($this->kpihse->getKPIHSE() as $kpi){
            $environmentLess1m3ZE[] = (string) $kpi->getEnvironmentLess1m3ZE();
        }
        $environmentLess1m3ZE[] = (string) $currentCumul->getEnvironmentLess1m3ZE();
        $environmentLess1m3ZE[] = (string) $objectifKpihse->getZoneEtancheInf159();
        $datas[] = $environmentLess1m3ZE;
        $this->row++;
        //Zone non étanche  > 159 litres
        $environmentMore1m3ZNE = array($wizard->toRichTextObject('<font size="9">Zone non &eacute;tanche  > 159 litres</font>'));
        $environmentMore1m3ZNE[] = (string) $latestYear->getEnvironmentMore1m3ZNE();
        foreach($this->kpihse->getKPIHSE() as $kpi){
            $environmentMore1m3ZNE[] = (string) $kpi->getEnvironmentMore1m3ZNE();
        }
        $environmentMore1m3ZNE[] = (string) $currentCumul->getEnvironmentMore1m3ZNE();
        $environmentMore1m3ZNE[] = (string) $objectifKpihse->getZoneNonEtancheSup159();
        $datas[] = $environmentMore1m3ZNE;
        $this->row++;
        //Zone non étanche < 159 litres
        $environmentLess1m3ZNE = array($wizard->toRichTextObject('<font size="9">Zone non &eacute;tanche < 159 litres</font>'));
        $environmentLess1m3ZNE[] = (string) $latestYear->getEnvironmentLess1m3ZNE();
        foreach($this->kpihse->getKPIHSE() as $kpi){
            $environmentLess1m3ZNE[] = (string) $kpi->getEnvironmentLess1m3ZNE();
        }
        $environmentLess1m3ZNE[] = (string) $currentCumul->getEnvironmentLess1m3ZNE();
        $environmentLess1m3ZNE[] = (string) $objectifKpihse->getZoneNonEtancheInf159();
        $datas[] = $environmentLess1m3ZNE;
        $this->row++;
        //Fuite de produits non mesurables
        $fuiteNonMesurable = array($wizard->toRichTextObject('<font size="9">Fuite de produits non mesurables</font>'));
        $fuiteNonMesurable[] = (string) $latestYear->getFuiteNonMesurable();
        foreach($this->kpihse->getKPIHSE() as $kpi){
            $fuiteNonMesurable[] = (string) $kpi->getFuiteNonMesurable();
        }
        $fuiteNonMesurable[] = (string) $currentCumul->getFuiteNonMesurable();
        $fuiteNonMesurable[] = (string) $objectifKpihse->getFuiteProduitNonMesurable();
        $datas[] = $fuiteNonMesurable;
        $this->row++;
        //TOTAL
        $totalEnvironment = array($wizard->toRichTextObject('<font size="9">TOTAL</font>'));
        $totalEnvironment[] = (string) $latestYear->getTotalEnvironment();
        foreach($this->kpihse->getKPIHSE() as $kpi){
            $totalEnvironment[] = (string) $kpi->getTotalEnvironment();
        }
        $totalEnvironment[] = (string) $currentCumul->getTotalEnvironment();
        $totalEnvironment[] = (string) $objectifKpihse->getTotalEnvironment();
        $datas[] = $totalEnvironment;
        $this->row++;
        //Fuite flexible en cours de réception ou avarie coque
        $nbFuiteflexible = array($wizard->toRichTextObject('<font size="9">Fuite flexible en cours de r&eacute;ception ou avarie coque</font>'));
        $nbFuiteflexible[] = (string) $latestYear->getNbFuiteflexible();
        foreach($this->kpihse->getKPIHSE() as $kpi){
            $nbFuiteflexible[] = (string) $kpi->getNbFuiteflexible();
        }
        $nbFuiteflexible[] = (string) $currentCumul->getNbFuiteflexible();
        $nbFuiteflexible[] = (string) $objectifKpihse->getPollutionMarine();
        $datas[] = $nbFuiteflexible;
        $this->row++;
        //Nbres d'échantillons prélévés
        $piezometreNbEchantillonPreleve = array($wizard->toRichTextObject('<font size="9">Nbres d\'&eacute;chantillons pr&eacute;l&eacute;v&eacute;s</font>'));
        $piezometreNbEchantillonPreleve[] = (string) $latestYear->getPiezometreNbEchantillonPreleve();
        foreach($this->kpihse->getKPIHSE() as $kpi){
            $piezometreNbEchantillonPreleve[] = (string) $kpi->getPiezometreNbEchantillonPreleve();
        }
        $piezometreNbEchantillonPreleve[] = (string) $currentCumul->getPiezometreNbEchantillonPreleve();
        $piezometreNbEchantillonPreleve[] = (string) $objectifKpihse->getPiezometreNbEchantillonPreleve();
        $datas[] = $piezometreNbEchantillonPreleve;
        $this->row++;
        //Nbres d'échantillons analysés
        $piezometreNbEchantillonAnalyse = array($wizard->toRichTextObject('<font size="9">Nbres d\'&eacute;chantillons analys&eacute;s</font>'));
        $piezometreNbEchantillonAnalyse[] = (string) $latestYear->getPiezometreNbEchantillonAnalyse();
        foreach($this->kpihse->getKPIHSE() as $kpi){
            $piezometreNbEchantillonAnalyse[] = (string) $kpi->getPiezometreNbEchantillonAnalyse();
        }
        $piezometreNbEchantillonAnalyse[] = (string) $currentCumul->getPiezometreNbEchantillonAnalyse();
        $piezometreNbEchantillonAnalyse[] = (string) $objectifKpihse->getPiezometreNbEchantillonAnalyse();
        $datas[] = $piezometreNbEchantillonAnalyse;
        $this->row++;
        //Nbre d'anomalies relevées
        $piezometreNbAnomalieReleve = array($wizard->toRichTextObject('<font size="9">Nbre d\'anomalies relev&eacute;es</font>'));
        $piezometreNbAnomalieReleve[] = (string) $latestYear->getPiezometreNbAnomalieReleve();
        foreach($this->kpihse->getKPIHSE() as $kpi){
            $piezometreNbAnomalieReleve[] = (string) $kpi->getPiezometreNbAnomalieReleve();
        }
        $piezometreNbAnomalieReleve[] = (string) $currentCumul->getPiezometreNbAnomalieReleve();
        $piezometreNbAnomalieReleve[] = (string) $objectifKpihse->getPiezometreNbAnomalieReleve();
        $datas[] = $piezometreNbAnomalieReleve;
        $this->row++;
        //Taux de non-conformité
        $piezometreTauxNonConformite = array($wizard->toRichTextObject('<font size="9">Taux de non-conformit&eacute;</font>'));
        $piezometreTauxNonConformite[] = (string) $latestYear->getPiezometreTauxNonConformite();
        foreach($this->kpihse->getKPIHSE() as $kpi){
            $piezometreTauxNonConformite[] = (string) $kpi->getPiezometreTauxNonConformite();
        }
        $piezometreTauxNonConformite[] = (string) $currentCumul->getPiezometreTauxNonConformite();
        $piezometreTauxNonConformite[] = (string) $objectifKpihse->getPiezometreTauxNonConformite();
        $datas[] = $piezometreTauxNonConformite;
        $this->row++;
        //Nbres d'échantillons prélévés
        $decanteurNbEchantillonPreleve = array($wizard->toRichTextObject('<font size="9">Nbres d\'&eacute;chantillons pr&eacute;l&eacute;v&eacute;s</font>'));
        $decanteurNbEchantillonPreleve[] = (string) $latestYear->getDecanteurNbEchantillonPreleve();
        foreach($this->kpihse->getKPIHSE() as $kpi){
            $decanteurNbEchantillonPreleve[] = (string) $kpi->getDecanteurNbEchantillonPreleve();
        }
        $decanteurNbEchantillonPreleve[] = (string) $currentCumul->getDecanteurNbEchantillonPreleve();
        $decanteurNbEchantillonPreleve[] = (string) $objectifKpihse->getDecanteurNbEchantillonPreleve();
        $datas[] = $decanteurNbEchantillonPreleve;
        $this->row++;
        //Nbres d'échantillons analysés
        $decanteurNbEchantillonAnalyse = array($wizard->toRichTextObject('<font size="9">Nbres d\'&eacute;chantillons analys&eacute;s</font>'));
        $decanteurNbEchantillonAnalyse[] = (string) $latestYear->getDecanteurNbEchantillonAnalyse();
        foreach($this->kpihse->getKPIHSE() as $kpi){
            $decanteurNbEchantillonAnalyse[] = (string) $kpi->getDecanteurNbEchantillonAnalyse();
        }
        $decanteurNbEchantillonAnalyse[] = (string) $currentCumul->getDecanteurNbEchantillonAnalyse();
        $decanteurNbEchantillonAnalyse[] = (string) $objectifKpihse->getDecanteurNbEchantillonAnalyse();
        $datas[] = $decanteurNbEchantillonAnalyse;
        $this->row++;
        //Nbre d'anomalies relevées
        $decanteurNbAnomalieReleve = array($wizard->toRichTextObject('<font size="9">Nbre d\'anomalies relev&eacute;es</font>'));
        $decanteurNbAnomalieReleve[] = (string) $latestYear->getDecanteurNbAnomalieReleve();
        foreach($this->kpihse->getKPIHSE() as $kpi){
            $decanteurNbAnomalieReleve[] = (string) $kpi->getDecanteurNbAnomalieReleve();
        }
        $decanteurNbAnomalieReleve[] = (string) $currentCumul->getDecanteurNbAnomalieReleve();
        $decanteurNbAnomalieReleve[] = (string) $objectifKpihse->getDecanteurNbAnomalieReleve();
        $datas[] = $decanteurNbAnomalieReleve;
        $this->row++;
        //Taux de non-conformité
        $decanteurTauxNonConformite = array($wizard->toRichTextObject('<font size="9">Taux de non-conformit&eacute;</font>'));
        $decanteurTauxNonConformite[] = (string) $latestYear->getDecanteurTauxNonConformite();
        foreach($this->kpihse->getKPIHSE() as $kpi){
            $decanteurTauxNonConformite[] = (string) $kpi->getDecanteurTauxNonConformite();
        }
        $decanteurTauxNonConformite[] = (string) $currentCumul->getDecanteurTauxNonConformite();
        $decanteurTauxNonConformite[] = (string) $objectifKpihse->getDecanteurTauxNonConformite();
        $datas[] = $decanteurTauxNonConformite;
        $this->row++;
        //Nbre d'échantillons prélévés
        $laboratoireNbEchantillonPreleve = array($wizard->toRichTextObject('<font size="9">Nbre d\'&eacute;chantillons pr&eacute;l&eacute;v&eacute;s</font>'));
        $laboratoireNbEchantillonPreleve[] = (string) $latestYear->getLaboratoireNbEchantillonPreleve();
        foreach($this->kpihse->getKPIHSE() as $kpi){
            $laboratoireNbEchantillonPreleve[] = (string) $kpi->getLaboratoireNbEchantillonPreleve();
        }
        $laboratoireNbEchantillonPreleve[] = (string) $currentCumul->getLaboratoireNbEchantillonPreleve();
        $laboratoireNbEchantillonPreleve[] = (string) $objectifKpihse->getLaboratoireNbEchantillonPreleve();
        $datas[] = $laboratoireNbEchantillonPreleve;
        $this->row++;
        //Nbre d'échantillons analysés
        $laboratoireNbEchantillonAnalyse = array($wizard->toRichTextObject('<font size="9">Nbre d\'&eacute;chantillons analys&eacute;s</font>'));
        $laboratoireNbEchantillonAnalyse[] = (string) $latestYear->getLaboratoireNbEchantillonAnalyse();
        foreach($this->kpihse->getKPIHSE() as $kpi){
            $laboratoireNbEchantillonAnalyse[] = (string) $kpi->getLaboratoireNbEchantillonAnalyse();
        }
        $laboratoireNbEchantillonAnalyse[] = (string) $currentCumul->getLaboratoireNbEchantillonAnalyse();
        $laboratoireNbEchantillonAnalyse[] = (string) $objectifKpihse->getLaboratoireNbEchantillonAnalyse();
        $datas[] = $laboratoireNbEchantillonAnalyse;
        $this->row++;
        //Nbre d'anomalies relevées
        $laboratoireNbAnomalieReleve = array($wizard->toRichTextObject('<font size="9">Nbre d\'anomalies relev&eacute;es</font>'));
        $laboratoireNbAnomalieReleve[] = (string) $latestYear->getLaboratoireNbAnomalieReleve();
        foreach($this->kpihse->getKPIHSE() as $kpi){
            $laboratoireNbAnomalieReleve[] = (string) $kpi->getLaboratoireNbAnomalieReleve();
        }
        $laboratoireNbAnomalieReleve[] = (string) $currentCumul->getLaboratoireNbAnomalieReleve();
        $laboratoireNbAnomalieReleve[] = (string) $objectifKpihse->getLaboratoireNbAnomalieReleve();
        $datas[] = $laboratoireNbAnomalieReleve;
        $this->row++;
        //Taux de non-conformité
        $laboratoireTauxNonConformite = array($wizard->toRichTextObject('<font size="9">Taux de non-conformit&eacute;</font>'));
        $laboratoireTauxNonConformite[] = (string) $latestYear->getLaboratoireTauxNonConformite();
        foreach($this->kpihse->getKPIHSE() as $kpi){
            $laboratoireTauxNonConformite[] = (string) $kpi->getLaboratoireTauxNonConformite();
        }
        $laboratoireTauxNonConformite[] = (string) $currentCumul->getLaboratoireTauxNonConformite();
        $laboratoireTauxNonConformite[] = (string) $objectifKpihse->getLaboratoireTauxNonConformite();
        $datas[] = $laboratoireTauxNonConformite;
        $this->row++;
        //Résultats Essais Circulaires (Taux de conformité sur les paramètres analysés) 
        $laboratoireResultatEssaiCirculaire = array($wizard->toRichTextObject('<font size="9">R&eacute;sultats Essais Circulaires<br/>(Taux de conformit&eacute; sur les param&egrave;tres analys&eacute;s)</font>'));
        $laboratoireResultatEssaiCirculaire[] = (string) $latestYear->getLaboratoireResultatEssaiCirculaire();
        foreach($this->kpihse->getKPIHSE() as $kpi){
            $laboratoireResultatEssaiCirculaire[] = (string) $kpi->getLaboratoireResultatEssaiCirculaire();
        }
        $laboratoireResultatEssaiCirculaire[] = (string) $currentCumul->getLaboratoireResultatEssaiCirculaire();
        $laboratoireResultatEssaiCirculaire[] = (string) $objectifKpihse->getLaboratoireResultatEssaiCirculaire();
        $datas[] = $laboratoireResultatEssaiCirculaire;
        $this->row++;
        //Nombre de non-conformités clôturées
        $nbreNonConformiteCloture = array($wizard->toRichTextObject('<font size="9">Nombre de non-conformit&eacute;s cl&ocirc;tur&eacute;es</font>'));
        $nbreNonConformiteCloture[] = (string) $latestYear->getNbreNonConformiteCloture();
        foreach($this->kpihse->getKPIHSE() as $kpi){
            $nbreNonConformiteCloture[] = (string) $kpi->getNbreNonConformiteCloture();
        }
        $nbreNonConformiteCloture[] = (string) $currentCumul->getNbreNonConformiteCloture();
        $nbreNonConformiteCloture[] = (string) $objectifKpihse->getNbreNonConformiteCloture();
        $datas[] = $nbreNonConformiteCloture;
        $this->row++;
        //Nombre de non-conformités non-échues
        $nbreNonConformiteNonEchue = array($wizard->toRichTextObject('<font size="9">Nombre de non-conformit&eacute;s non-&eacute;chues</font>'));
        $nbreNonConformiteNonEchue[] = (string) $latestYear->getNbreNonConformiteNonEchue();
        foreach($this->kpihse->getKPIHSE() as $kpi){
            $nbreNonConformiteNonEchue[] = (string) $kpi->getNbreNonConformiteNonEchue();
        }
        $nbreNonConformiteNonEchue[] = (string) $currentCumul->getNbreNonConformiteNonEchue();
        $nbreNonConformiteNonEchue[] = (string) $objectifKpihse->getNbreNonConformiteNonEchue();
        $datas[] = $nbreNonConformiteNonEchue;
        $this->row++;
        //Nombre OVERDUE
        $nbreOVERDUE = array($wizard->toRichTextObject('<font size="9">Nombre OVERDUE</font>'));
        $nbreOVERDUE[] = (string) $latestYear->getNbreOVERDUE();
        foreach($this->kpihse->getKPIHSE() as $kpi){
            $nbreOVERDUE[] = (string) $kpi->getNbreOVERDUE();
        }
        $nbreOVERDUE[] = (string) $currentCumul->getNbreOVERDUE();
        $nbreOVERDUE[] = (string) $objectifKpihse->getNbreOVERDUE();
        $datas[] = $nbreOVERDUE;
        $this->row++;
        //Pourcentage OVERDUE
        $pourcentageOVERDUE = array($wizard->toRichTextObject('<font size="9">Pourcentage OVERDUE</font>'));
        $pourcentageOVERDUE[] = (string) $latestYear->getPourcentageOVERDUE();
        foreach($this->kpihse->getKPIHSE() as $kpi){
            $pourcentageOVERDUE[] = (string) $kpi->getPourcentageOVERDUE();
        }
        $pourcentageOVERDUE[] = (string) $currentCumul->getPourcentageOVERDUE();
        $pourcentageOVERDUE[] = (string) $objectifKpihse->getPourcentageOVERDUE();
        $datas[] = $pourcentageOVERDUE;
        $this->row++;
        return $datas;
    }

    private function getFatData($currentCumul,$latestYear,$index,$indicator){
        $fats = array($indicator);
        $objectifKpihse = $this->kpihse->getObjectifKpihse();
        $fats[] = (string) $latestYear->getFat()[$index];
        foreach($this->kpihse->getKPIHSE() as $kpi){
            $fat = $kpi->getFat();
            $fats[] = (string) $fat[$index];            
        }
        $fats[] = (string) $currentCumul->getFat()[$index];
        switch($index){
            case 'nbLpsa': $fats[] = (string) $objectifKpihse->getNbreFatLpsa();
                break;
            case 'nbContracte': $fats[] = (string) $objectifKpihse->getNbreFatContracte();
                break;
            case 'nbTiers': $fats[] = (string) $objectifKpihse->getNbreFatTiers();
                break;
        }
        return $fats;
    }

    private function getLtiData($currentCumul,$latestYear,$index,$indicator){
        $ltis = array($indicator);
        $objectifKpihse = $this->kpihse->getObjectifKpihse();
        $ltis[] = (string) $latestYear->getLti()[$index];
        foreach($this->kpihse->getKPIHSE() as $kpi){
            $lti = $kpi->getLti();
            $ltis[] = (string) $lti[$index];
        }
        $ltis[] = (string) $currentCumul->getLti()[$index];
        switch($index){
            case 'nbLpsa': $ltis[] = (string) $objectifKpihse->getNbreLtiLpsa();
                break;
            case 'nbContracte': $ltis[] = (string) $objectifKpihse->getNbreLtiContracte();
                break;
        }
        return $ltis;
    }

    private function getMtData($currentCumul,$latestYear,$index,$indicator){
        $mts = array($indicator);
        $objectifKpihse = $this->kpihse->getObjectifKpihse();
        $mts[] = (string) $latestYear->getMt()[$index];
        foreach($this->kpihse->getKPIHSE() as $kpi){
            $mt = $kpi->getMt();
            $mts[] = (string) $mt[$index];
        }
        $mts[] = (string) $currentCumul->getMt()[$index];
        switch($index){
            case 'nbLpsa': $mts[] = (string) $objectifKpihse->getNbreMtLpsa();
                break;
            case 'nbContracte': $mts[] = (string) $objectifKpihse->getNbreMtContracte();
                break;
        }
        return $mts;
    }

    private function getFaData($currentCumul,$latestYear,$index,$indicator){
        $fas = array($indicator);
        $objectifKpihse = $this->kpihse->getObjectifKpihse();
        $fas[] = (string) $latestYear->getFa()[$index];
        foreach($this->kpihse->getKPIHSE() as $kpi){
            $fa = $kpi->getFa();
            $fas[] = (string) $fa[$index];
        }
        $fas[] = (string) $currentCumul->getFa()[$index];
        switch($index){
            case 'nbLpsa': $fas[] = (string) $objectifKpihse->getNbreFaLpsa();
                break;
            case 'nbContracte': $fas[] = (string) $objectifKpihse->getNbreFaContracte();
                break;
        }
        return $fas;
    }
}