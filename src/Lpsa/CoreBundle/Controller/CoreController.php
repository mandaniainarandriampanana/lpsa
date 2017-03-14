<?php

namespace Lpsa\CoreBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Lpsa\ChartBundle\Chart\LineChart;
use Lpsa\ChartBundle\DataSet\LineDataSet;

/**
 * Core controller.
 *
 */
class CoreController extends Controller
{
    /**
     * Get abstract gravity for event
     * @param Corporel $corporel
     * @param Materiel $materiel
     * @param Environnement $environnement
     * @param ImpactMediatique $impactmediatique
     * @param ImpactClient $impactclient
     * @param Dysfonctionnement $dysfonctionnement
     * @return string
     */
    protected function getGravityLabel($corporel,$materiel,$environnement,$impactmediatique,$impactclient,$dysfonctionnement){        
        return $this->get('app.abstract_gravity')->getGravityLabel($corporel,$materiel,$environnement,$impactmediatique,$impactclient,$dysfonctionnement);
    }

    /**
     * Get abstract gravity entity for event
     * @param Corporel $corporel
     * @param Materiel $materiel
     * @param Environnement $environnement
     * @param ImpactMediatique $impactmediatique
     * @param ImpactClient $impactclient
     * @param Dysfonctionnement $dysfonctionnement
     * @return string
     */
    protected function getGravity($corporel,$materiel,$environnement,$impactmediatique,$impactclient,$dysfonctionnement){        
        return $this->get('app.abstract_gravity')->getGravity($corporel,$materiel,$environnement,$impactmediatique,$impactclient,$dysfonctionnement);
    }
    
    public function getDepotManager(){
        return $this->get('app.depot.manager');
    }
    
    public function getCorporelManager(){
        return $this->get('app.corporel.manager');
    }
    
    public function getEnvironnementManager(){
        return $this->get('app.environnement.manager');
    }
    
    public function getMaterielManager(){
        return $this->get('app.materiel.manager');
    }
    
    public function getEvenementManager(){
        return $this->get('app.evenement.manager');
    }
    
    public function getDepartementManager(){
        return $this->get('app.departement.manager');
    }
    
    public function getServiceManager(){
        return $this->get('app.service.manager');
    }
    
    public function getDepotCategorieManager(){
        return $this->get('app.depotcategorie.manager');
    }
    
    public function getEvenementStatutManager(){
        return $this->get('app.evenementstatut.manager');
    }
    public function getEvenementCategorieManager(){
        return $this->get('app.evenementcategorie.manager');
    }
    public function getResponsableServiceManager(){
        return $this->get('app.responsableservice.manager');
    }

    public function toChartLabels($measures){
        $labels = [];
        foreach($measures as $measure){
            $labels[] = $measure->format('M-Y');
        }
        return $labels;
    }

    public function toChartDataLTIR($monthHeaders,$ltirTrir){
        $data = [];
        $ltirs = $ltirTrir->getLTIR();
        foreach($monthHeaders as $month => $date){
            $data[] = $ltirs[$month]->getLTIR();
        }
        return $data;
    }

    public function toChartDataTRIR($monthHeaders,$ltirTrir){
        $data = [];
        $trirs = $ltirTrir->getTRIR();
        foreach($monthHeaders as $month => $date){
            $data[] = $trirs[$month]->getTRIR();
        }
        return $data;
    }

    public function toChartData12MonthsLTIR($monthHeaders,$ltirTrir){
        $data = [];
        $ltirs = $ltirTrir->getLTIR();
        foreach($monthHeaders as $month => $date){
            $data[] = $ltirs[$month]->get12MonthsLTIR($month);
        }
        return $data;
    }

    public function toChartData12MonthsTRIR($monthHeaders,$ltirTrir){
        $data = [];
        $trirs = $ltirTrir->getTRIR();
        foreach($monthHeaders as $month => $date){
            $data[] = $trirs[$month]->get12MonthsTRIR($month);
        }
        return $data;
    }

    public function getLtirTrir($dateStart,$dateEnd){
        $ltirTrir = $this->get('app.statistic.ltir_trir');
        $ltirTrir->process($dateStart,$dateEnd);
        return $ltirTrir;
    }
    
    public function toChartDataObjectifLtirTririr($objectifLtirTrir = array(),$Ltir=false){
        $objectifLtir = array();
        $objectifTrir = array();
        for($i=0;$i<12;$i++){
            if(key_exists($i, $objectifLtirTrir)){
                $objectifLtir[$i] = floatval($objectifLtirTrir[$i]['objectifLtir']);
                $objectifTrir[$i] = floatval($objectifLtirTrir[$i]['objectifTrir']);
            }
            else{
                $objectifLtir[$i] = 0.0;
                $objectifTrir[$i] =0.0;
            }
        }
        if($Ltir){
            return $objectifLtir;
        }
            return $objectifTrir;
    }

    public function getChart($ltirTrir = null,$width = null,$height = null){
        if($ltirTrir === null){
            $ltirTrir = $this->getLtirTrir(null,null);//default
        }
        $monthHeaders = $ltirTrir->getMonthHeaders();
        $labels = $this->toChartLabels($monthHeaders);
        $chartLtir = new LineChart();
        $chartLtir->setId('chartLtir');
        $chartLtir->displayValuePoint(false);
        $chartLtir->setType('line')->setLabels($labels)
                  ->setWidth($width)
                  ->setHeight($height)
                    ;
        $lineDataSet = new LineDataSet();
        $lineDataSet->setLabel('LTIR')
                    ->setFill(false)
                    ->setLineTension(0.1)
                    ->setBackgroundColor("rgba(75,192,192,0.4)")
                    ->setBorderColor("rgba(75,192,192,1)")
                    ->setBorderCapStyle('butt')
                    ->setBorderDash(array())
                    ->setBorderDashOffset(0.0)
                    ->setBorderJoinStyle('miter')
                    ->setPointBorderColor("rgba(75,192,192,1)")
                    ->setPointBackgroundColor("#000")
                    ->setPointBorderWidth(1)
                    ->setPointHoverRadius(5)
                    ->setPointHoverBackgroundColor("rgba(75,192,192,1)")
                    ->setPointHoverBorderColor("rgba(220,220,220,1)")
                    ->setPointHoverBorderWidth(2)
                    ->setPointRadius(1)
                    ->setPointHitRadius(10)
                    ->setSpanGaps(false)
                    ->setData($this->toChartDataLTIR($monthHeaders,$ltirTrir));
        $chartLtir->addDataSet($lineDataSet);
        $lineDataSet12Months = new LineDataSet();
        $lineDataSet12Months->setLabel('LTIR 12 mois glissants')
                    ->setFill(false)
                    ->setLineTension(0.1)
                    ->setBackgroundColor("rgba(214,94,94,0.4)")
                    ->setBorderColor("rgba(214,94,94,1)")
                    ->setBorderCapStyle('butt')
                    ->setBorderDash(array())
                    ->setBorderDashOffset(0.0)
                    ->setBorderJoinStyle('miter')
                    ->setPointBorderColor("rgba(214,94,94,1)")
                    ->setPointBackgroundColor("#000")
                    ->setPointBorderWidth(1)
                    ->setPointHoverRadius(5)
                    ->setPointHoverBackgroundColor("rgba(214,94,94,1)")
                    ->setPointHoverBorderColor("rgba(220,220,220,1)")
                    ->setPointHoverBorderWidth(2)
                    ->setPointRadius(1)
                    ->setPointHitRadius(10)
                    ->setSpanGaps(false)
                    ->setData($this->toChartData12MonthsLTIR($monthHeaders,$ltirTrir));
        $chartLtir->addDataSet($lineDataSet12Months);
        $objectifLtir = new LineDataSet();
        $objectifLtir->setLabel('Objectif LTIR')
                    ->setFill(false)
                    ->setLineTension(0.1)
                    ->setBackgroundColor("rgba(154,186,89,0.4)")
                    ->setBorderColor("rgba(154,186,89,1)")
                    ->setBorderCapStyle('butt')
                    ->setBorderDash(array())
                    ->setBorderDashOffset(0.0)
                    ->setBorderJoinStyle('miter')
                    ->setPointBorderColor("rgba(154,186,89,1)")
                    ->setPointBackgroundColor("#000")
                    ->setPointBorderWidth(1)
                    ->setPointHoverRadius(5)
                    ->setPointHoverBackgroundColor("rgba(154,186,89,1)")
                    ->setPointHoverBorderColor("rgba(220,220,220,1)")
                    ->setPointHoverBorderWidth(2)
                    ->setPointRadius(1)
                    ->setPointHitRadius(10)
                    ->setSpanGaps(false)
                    ->setData($this->toChartDataObjectifLtirTririr($ltirTrir->getObjectifLtirTrir(),true));
        $chartLtir->addDataSet($objectifLtir);
        $chartLtir->generateData();
        $chartTrir = new LineChart();
        $chartTrir->setId('chartTrir');
        $chartTrir->displayValuePoint(false);
        $chartTrir->setType('line')->setLabels($labels)
                  ->setWidth($width)
                  ->setHeight($height)
                  ->setOptions('{
                        global: {
                            responsive: true,
                            maintainAspectRatio: false
                        }
                    }');
        $lineDataSet = new LineDataSet();
        $lineDataSet->setLabel('TRIR')
                    ->setFill(false)
                    ->setLineTension(0.1)
                    ->setBackgroundColor("rgba(75,192,192,0.4)")
                    ->setBorderColor("rgba(75,192,192,1)")
                    ->setBorderCapStyle('butt')
                    ->setBorderDash(array())
                    ->setBorderDashOffset(0.0)
                    ->setBorderJoinStyle('miter')
                    ->setPointBorderColor("rgba(75,192,192,1)")
                    ->setPointBackgroundColor("#000")
                    ->setPointBorderWidth(1)
                    ->setPointHoverRadius(5)
                    ->setPointHoverBackgroundColor("rgba(75,192,192,1)")
                    ->setPointHoverBorderColor("rgba(220,220,220,1)")
                    ->setPointHoverBorderWidth(2)
                    ->setPointRadius(1)
                    ->setPointHitRadius(10)
                    ->setSpanGaps(false)
                    ->setData($this->toChartDataTRIR($monthHeaders,$ltirTrir));
        $chartTrir->addDataSet($lineDataSet);
        $lineDataSet12Months = new LineDataSet();
        $lineDataSet12Months->setLabel('TRIR 12 mois glissants')
                    ->setFill(false)
                    ->setLineTension(0.1)
                    ->setBackgroundColor("rgba(214,94,94,0.4)")
                    ->setBorderColor("rgba(214,94,94,1)")
                    ->setBorderCapStyle('butt')
                    ->setBorderDash(array())
                    ->setBorderDashOffset(0.0)
                    ->setBorderJoinStyle('miter')
                    ->setPointBorderColor("rgba(214,94,94,1)")
                    ->setPointBackgroundColor("#000")
                    ->setPointBorderWidth(1)
                    ->setPointHoverRadius(5)
                    ->setPointHoverBackgroundColor("rgba(214,94,94,1)")
                    ->setPointHoverBorderColor("rgba(220,220,220,1)")
                    ->setPointHoverBorderWidth(2)
                    ->setPointRadius(1)
                    ->setPointHitRadius(10)
                    ->setSpanGaps(false)
                    ->setData($this->toChartData12MonthsTRIR($monthHeaders,$ltirTrir));
        $chartTrir->addDataSet($lineDataSet12Months);
        $objectifTrir = new LineDataSet();
        $objectifTrir->setLabel('Objectif TRIR')
                    ->setFill(false)
                    ->setLineTension(0.1)
                    ->setBackgroundColor("rgba(154,186,89,0.4)")
                    ->setBorderColor("rgba(154,186,89,1)")
                    ->setBorderCapStyle('butt')
                    ->setBorderDash(array())
                    ->setBorderDashOffset(0.0)
                    ->setBorderJoinStyle('miter')
                    ->setPointBorderColor("rgba(154,186,89,1)")
                    ->setPointBackgroundColor("#000")
                    ->setPointBorderWidth(1)
                    ->setPointHoverRadius(5)
                    ->setPointHoverBackgroundColor("rgba(154,186,89,1)")
                    ->setPointHoverBorderColor("rgba(220,220,220,1)")
                    ->setPointHoverBorderWidth(2)
                    ->setPointRadius(1)
                    ->setPointHitRadius(10)
                    ->setSpanGaps(false)
                    ->setData($this->toChartDataObjectifLtirTririr($ltirTrir->getObjectifLtirTrir()));
        $chartTrir->addDataSet($objectifTrir);
        $chartTrir->generateData();
        return array(
            'chartLtir' => $chartLtir,
            'chartTrir' => $chartTrir
        );
    }
}
