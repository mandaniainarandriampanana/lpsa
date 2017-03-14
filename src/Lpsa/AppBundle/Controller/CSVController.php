<?php

namespace Lpsa\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Lpsa\AppBundle\Entity\HeureTravail;
use Lpsa\AppBundle\Entity\ObjectifLtirTrir;


/**
 * CSV controller.
 *
 */
class CSVController extends Controller
{
    /**
     * export CSV.
     *
     */
    public function exportAction(Request $request)
    {
        if($request->isMethod('POST')){
            if(isset($_FILES['file']) && !empty($_FILES) && !empty($_FILES['file'])){
                $data = [];
                foreach($_FILES['file']['name'] as $key=>$name){
                    $csv = new \parseCSV();
                    $csv->encoding('UTF-8');
                    $csv->delimiter = "\t";
                    $csv->parse($_FILES['file']['tmp_name'][$key]);
                    if(empty($data)){
                        $tmp = array();
                        foreach($csv->data as $k => $val){ 
                            foreach($val as $v){
                                $tmp[] = array($v);
                            }    
                        }    
                        $data = $tmp;
                    } else {
                        $tmp = array();
                        foreach($csv->data as $k => $val){ 
                            foreach($val as $v){
                                $tmp[] = $v;
                            }    
                        } 
                        foreach($data as $k => $v){
                            $new = $data[$k];
                            $new[] = $tmp[$k];
                            $data[$k] = $new;
                        }
                    }
                }
                $csv = new \parseCSV();
                $csv->output('data.csv', $data, array('Heures travaillées Contractants','Heures travaillées Personnel LPSA','Mois','Objectif LTIR','Objectif TRIR'), ',');
            }
        }
        return $this->render('LpsaAppBundle:CSV:export.html.twig', array());
    }

    /**
     * import CSV.
     *
     */
    public function importAction(Request $request)
    {
        $month = array(
            'Jan' => 1,
            'Feb' => 2,
            'Mar' => 3,
            'Apr' => 4,
            'May' => 5,
            'Jun' => 6,
            'Jul' => 7,
            'Aug' => 8,
            'Sep' => 9,
            'Oct' => 10,
            'Nov' => 11,
            'Dec' => 12
        );
        if($request->isMethod('POST')){
            if(isset($_FILES['file']) && !empty($_FILES) && !empty($_FILES['file'])){
                $csv = new \parseCSV();
                $csv->auto($_FILES['file']['tmp_name']); 
                $em = $this->getDoctrine()->getManager();
                $heureCategories = $em->getRepository('LpsaAppBundle:HeureTravailCategorie')->findAll();
                //echo '<pre>';var_dump($csv->data);die;
                foreach($csv->data as $k => $val){ 
                    $m = $val['Mois'];
                    $arr = explode('-',$m);
                    $heureTravailLpsa = new HeureTravail();
                    $heureTravailLpsa->setHeure((float)$val['Heures travaillées Personnel LPSA'])
                                 ->setMois($month[$arr[0]])
                                 ->setAnnee('20'.$arr[1])
                                 ->setHeureTravailCategorie($heureCategories[0]);
                    $heureTravailContractant = new HeureTravail();
                    $heureTravailContractant->setHeure((float)$val['Heures travaillées Contractants'])
                                 ->setMois($month[$arr[0]])
                                 ->setAnnee('20'.$arr[1])
                                 ->setHeureTravailCategorie($heureCategories[1]);
                    $objectif = new ObjectifLtirTrir();
                    $objectif->setTrir($val['Objectif TRIR'])
                             ->setLtir($val['Objectif LTIR'])
                             ->setMois($month[$arr[0]])
                             ->setAnnee('20'.$arr[1]);
                    $em->persist($heureTravailLpsa);
                    $em->persist($heureTravailContractant);
                    $em->persist($objectif);
                    $em->flush();
                } 
                
            }
        }
        return $this->render('LpsaAppBundle:CSV:import.html.twig', array());
    }

    /**
     * import CSV.
     *
     */
    public function importKpiAction(Request $request)
    {
        $month = array(
            'Jan' => 1,
            'Feb' => 2,
            'Mar' => 3,
            'Apr' => 4,
            'May' => 5,
            'Jun' => 6,
            'Jul' => 7,
            'Aug' => 8,
            'Sep' => 9,
            'Oct' => 10,
            'Nov' => 11,
            'Dec' => 12
        );
        if($request->isMethod('POST')){
            if(isset($_FILES['file']) && !empty($_FILES) && !empty($_FILES['file'])){
                $csv = new \parseCSV();
                $csv->auto($_FILES['file']['tmp_name']); 
                $em = $this->getDoctrine()->getManager();
                echo '<pre>';var_dump($csv->data);die;
                foreach($csv->data as $k => $val){ 
                    $m = $val['Mois'];
                    $arr = explode('-',$m);
                } 
                
            }
        }
        return $this->render('LpsaAppBundle:CSV:importKpi.html.twig', array());
    }

}
