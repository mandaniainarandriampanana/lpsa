<?php

namespace Lpsa\AppBundle\Statistic\Excel;

class SheetPaqssse {
    protected $paqssses;
    private $manager;
    private $dateNow;
    
    public function __construct($paqssses,$manager){
        $this->paqssses = $paqssses;
        $this->manager = $manager;
        $this->dateNow = new \DateTime();
    }
    public function process(){
        $datas = $this->getExcelData();
    }
    public function getExcelData(){
        $datas = array();
        foreach($this->paqssses as $paqssse){
            $datas[] = $this->oneLineData($paqssse);
        }
        $lineStart = 3;
        $nbline = count($datas)+$lineStart;
        $header = $this->BuildTabHeader($lineStart);
        $this->addDefaultCellStyle($this->manager->getDocument());
        $this->addBorderTab($lineStart,$nbline,$header);
        $this->manager->fromArray($header,array(),0,null,'A3');
        $this->manager->fromArray($datas,array(),0,null,'A4');
        
    }
    public function oneLineData($paqssse){
        $lineAsArray = array();
        $lineAsArray['numero'] = $this->getNumeroOnly($paqssse);
        $lineAsArray['origineAction'] = ($paqssse->getDescriptionFait()) ? $paqssse->getDescriptionFait():'';
        $lineAsArray['siteConcerne'] = $paqssse->getDepot()->getSigle();
        $lineAsArray['date'] = $paqssse->getDateEmission()->format('Y');
        $lineAsArray['anomalieConstate'] =  $paqssse->getPaq3se()->getAnomalieConstate();
        $lineAsArray['action'] = ($paqssse->getPaq3se()->getAction()) ? $paqssse->getPaq3se()->getAction():'';
        $lineAsArray['porteurContent'] = '';
        $lineAsArray['acteurContent'] = '';
        $lineAsArray['gravite'] = ($paqssse->getGravite()) ? $paqssse->getGravite()->getValeur():'';
        $lineAsArray['frequence'] = $paqssse->getPaq3se()->getFrequence();
        $lineAsArray['niveauRisque'] = $paqssse->getPaq3se()->getNiveauRisque();
        $lineAsArray['priorite'] = $paqssse->getPaq3se()->getPriorite();
        $lineAsArray['avancementContent'] = '';
        $lineAsArray['realisation'] = $paqssse->getPaq3se()->getRealisation().'%';
        $lineAsArray['dateFinPlusTard'] = ($paqssse->getPaq3se()->getDateFin()) ? $paqssse->getPaq3se()->getDateFin()->format('d/m/Y'):null;
        $lineAsArray['commentaires'] = ($paqssse->getEvenementEnquete()) ? $paqssse->getEvenementEnquete()->getCommentaire():'';
        $lineAsArray['avancementOrigineAction'] = $paqssse->getPaq3se()->getRealisation().'%';
        $lineAsArray['statut'] = $paqssse->getEvenementStatut()->getLibelle();
        $lineAsArray['DateClotureEffective'] = '';
        $lineAsArray['Overdue'] = $this->getOverdue($paqssse);
        return $lineAsArray;
    }
    /**
     * 
     * @param type $paqssse
     * @return string
     */
    private function getOverdue($paqssse){
        if($paqssse->getPaq3se()->getDateFin()){
            $dateFin = $paqssse->getPaq3se()->getDateFin();
            $now = new \DateTime();
            if($dateFin<$now){
                return 'OUI';
            }
        }
        return 'NON';
    }
    /**
     * 
     * @return string
     */
    private function BuildTabHeader($lineStart){
        $header = array('N°','Origine des actions','Site concerné','Date','Anomalies constatées',' ACTIONS','','','Gravité','Frequence','Niveau de Risque','Priorité','','Réalisation','Date fin au plus Tard','Commentaires','Avancement par rapport à l\'origine des actions','Statut','Date de Clôture effective','Overdue au '.$this->dateNow->format('d/m/Y'));
        $nbColumn = count($header)-1;
        $alphas = range('A', 'Z');
        $endCellColumn = $alphas[$nbColumn];
        $excelDocument = $this->manager->getDocument();
        $this->headerAutoSize('A',$endCellColumn);
        $excelDocument->getSheet(0)->getStyle('A'.$lineStart.':'.$endCellColumn.$lineStart)->applyFromArray($this->styleTabHeader());
        $this->otherHeadersTab($excelDocument,$lineStart);
        return $header;
    }
    public function otherHeadersTab($excelDocument,$lineStart){
        $styleHeader = $excelDocument->getSheet(0)->getStyle('A'.$lineStart);
        $lineOtherHeader = $lineStart-1;
        $excelDocument->getSheet(0)->duplicateStyle($styleHeader,'G'.$lineOtherHeader);
        $excelDocument->getSheet(0)->duplicateStyle($styleHeader,'H'.$lineOtherHeader);
        $excelDocument->getSheet(0)->duplicateStyle($styleHeader,'M'.$lineOtherHeader);
        $this->addBorderOtherTab(array('G'.$lineOtherHeader,'H'.$lineOtherHeader,'M'.$lineOtherHeader));
        //SET VALUE OTHER TAB headder
        $excelDocument->getSheet(0)->setCellValue('G'.$lineOtherHeader,'ACTEURS');
        $excelDocument->getSheet(0)->setCellValue('H'.$lineOtherHeader,'PORTEURS');
        $excelDocument->getSheet(0)->setCellValue('M'.$lineOtherHeader,'AVANCEMENT DU PLAN D\'ACTIONS ET DELAI DE REALISATION');
    }
     public function addBorderOtherTab($arrayCell){
         foreach($arrayCell as $cell){
                $this->manager->getDocument()->getSheet(0)->getStyle($cell)->applyFromArray(array(
                'borders' => array(
                'allborders' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_THIN
                )
            )));
         }
     }
    /**
     * 
     * @param type $excelDocument
     * @param type $cellName
     * @param type $width
     */
    public function cellWidth($excelDocument,$cellName,$width){
        $excelDocument->getSheet(0)->getColumnDimension($cellName)->setWidth($width);
    }
    /**
     * 
     * @param type $excelDocument
     * @param type $row
     * @param type $heigth
     */
    public function rowDimension($excelDocument,$row,$heigth){
        $excelDocument->getSheet(0)->getRowDimension($row)->setRowHeight($heigth);
    }
    /**
     * 
     * @param type $startCell
     * @param type $endCellColumn
     */
    public function headerAutoSize($startCell,$endCellColumn){
        $alphas = range($startCell, $endCellColumn);
        foreach($alphas as $cellName){
            $this->manager->getDocument()->getSheet(0)->getColumnDimension($cellName)->setAutoSize(true);
        }
    }
    /**
     * 
     * @param type $fontSize
     * @return array
     */
    public function styleTabHeader($fontSize = 10){
        $styleArray = array(
            'font'  => array(
                'bold'  => true,
                'color' => array('rgb' => '000000'),
                'size'  => $fontSize,
                'name'  => 'Arial',
                'wrap' => true),
            'alignment' => array(
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
        );
        return $styleArray;
    }
    public function addDefaultCellStyle($excelDocument){
        $style = array(
            'font'  => array(
                'color' => array('rgb' => '000000'),
                'size'  => 9,
                'name'  => 'Arial',
                'wrap' => true),
            'alignment' => array(
                    'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                )
            );
        $excelDocument->getSheet(0)->getDefaultStyle()->applyFromArray($style);
        
    }
    public function addBorderTab($lineStart,$nbline,$header){
        $excelDocument = $this->manager->getDocument();
        $nbColumn = count($header)-1;
        $alphas = range('A', 'Z');
        $endCellColumn = $alphas[$nbColumn];
        $excelDocument->getSheet(0)->getStyle('A'.$lineStart.':'.$endCellColumn.$nbline)->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_THIN
                )
        )));
    }
    public function getNumeroOnly($paqssse){
        $numEnregistrement = $paqssse->getNumeroEnregistrement();
        list($sigle, $numero, $year) = split('[/-]', $numEnregistrement);
        return $numero;
    }
}
