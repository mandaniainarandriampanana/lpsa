<?php

namespace Lpsa\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Lpsa\CoreBundle\Controller\CoreController;
use Lpsa\AppBundle\Statistic\Excel\ExcelKpi;
use Lpsa\AppBundle\Statistic\Excel\ExcelTrirLtir;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

/**
 * StatisticController
 *
 */
class StatisticController extends CoreController
{
    // section of KPIHSE
    public function kpihseAction(Request $request){
        $dateStart = $dateEnd = null; 
        $form = $this->createForm($this->get('form.type.lpsa_kpihse_filter'));
        $form->handleRequest($request);
        $reset = false;
        $export = false;
        if ($form->isSubmitted() && $form->isValid()) {
            $reset = $form->get('btnReset')->isClicked();
            $export = $form->get('btnExport')->isClicked();
            if(!$reset){
                $dateStart = $form->get('dateStart')->getData();
                $dateEnd = $form->get('dateEnd')->getData();
            } else {
                return $this->redirect($this->generateUrl('statistic_kpihse'), 302);
            }
        }
        $kpihse = $this->get('app.statistic.kpihse');
        $kpihse->process($dateStart,$dateEnd);
        $monthHeaders = $kpihse->getMonthHeaders();
        $currentCumul = $kpihse->getCurrentCumul();
        $latestYear = $kpihse->getLatestCumul();
        if($export){
            $manager = $this->get('app.document.excel_manager');
            ExcelKpi::init($kpihse,$manager)
                    ->process();
            //$ltirTrir = $this->getLtirTrir($dateStart,$dateEnd);
            //$this->prepareExportLtirTrir($ltirTrir,1,true);
            $excelDocument = $manager->getDocument();
            $writer = $manager->createWriter($excelDocument, 'Excel2007');
            return $manager->outStreamResponse($writer,$kpihse->getDateEnd()->format('m-') . 'HPI\'S HSE ' . $kpihse->getDateEnd()->format('Y').'.xlsx');
        }
        return $this->render('LpsaAppBundle:Statistic:kpihse.html.twig', array(
            'aKpihse' => $kpihse->getKPIHSE(),
            'monthHeaders' => $monthHeaders,
            'currentCumul' => $currentCumul,
            'latestYear' => $latestYear,
            'form' => $form->createView(),
            'dateEnd' => $kpihse->getDateEnd(),
            'dateStart' => $kpihse->getDateStart()
        ));
    }

    private function prepareExportLtirTrir($ltirTrir,$index = 0,$newSheet = false,$userId = null){
        $manager = $this->get('app.document.excel_manager');
        ExcelTrirLtir::init($ltirTrir,$manager,$index,$newSheet)
                    ->process($userId)
                    ->addDataToSheet(2);
    }

    // section of TRIR - LTIR
    public function graphAction(Request $request){
        $dateStart = $dateEnd = null; 
        $form = $this->createForm($this->get('form.type.lpsa_kpihse_filter'));
        $form->handleRequest($request);
        $reset = false;
        $export = false;
        if ($form->isSubmitted() && $form->isValid()) {
            $reset = $form->get('btnReset')->isClicked();
            $export = $form->get('btnExport')->isClicked();
            if(!$reset){
                $dateStart = $form->get('dateStart')->getData();
                $dateEnd = $form->get('dateEnd')->getData();
            } else {
                return $this->redirect($this->generateUrl('statistic_ltir_trir_graph'), 302);
            }
        }
        $ltirTrir = $this->getLtirTrir($dateStart,$dateEnd);
        $monthHeaders = $ltirTrir->getMonthHeaders();
        if($export){
            $usr = $this->get('security.context')->getToken()->getUser();
            $userId = $usr->getId();
            $this->removeTemp($userId);
            $this->makeDirectoryUploadTemp($userId);
            
            $graphLtir = $request->request->get('graphLtir');
            $graphTrir = $request->request->get('graphTrir');
            $folder = 'uploads/temp/'.$userId.'/';
            $imgLtir = $this->save_base64_image($graphLtir, 'graph_ltir', $folder);
            $imgTrir = $this->save_base64_image($graphTrir, 'graph_trir',$folder);
            
            $this->prepareExportLtirTrir($ltirTrir,0,false,$userId);
            $manager = $this->get('app.document.excel_manager');
            $excelDocument = $manager->getDocument();
            $writer = $manager->createWriter($excelDocument, 'Excel2007');
            return $manager->outStreamResponse($writer,$ltirTrir->getDateEnd()->format('m-') . 'GRAPH ' . $ltirTrir->getDateEnd()->format('Y').'.xlsx');
        }
        return $this->render('LpsaAppBundle:Statistic:ltir_trir.html.twig', array(
            'aTrir' => $ltirTrir->getTRIR(),
            'aLtir' => $ltirTrir->getLTIR(),
            'aTrir12Months' => $ltirTrir->getTRIR12Months(),
            'aLtir12Months' => $ltirTrir->getLTIR12Months(),
            'monthHeaders12Months' => $ltirTrir->getMonthHeaders12Months(),
            'ltirTrir' => $ltirTrir,
            'monthHeaders' => $monthHeaders,
            'form' => $form->createView(),
            'dateEnd' => $ltirTrir->getDateEnd(),
            'dateStart' => $ltirTrir->getDateStart(),
            'chart' => $this->getChart($ltirTrir)
        ));
    }

    private function save_base64_image($base64_image_string, $output_file_without_extentnion, $path_with_end_slash="" ) {
        $splited = explode(',', substr( $base64_image_string , 5 ) , 2);
        $mime=$splited[0];
        $data=$splited[1];
        $output_file_with_extentnion = '';
        $mime_split_without_base64=explode(';', $mime,2);
        $mime_split=explode('/', $mime_split_without_base64[0],2);
        if(count($mime_split)==2)
        {
            $extension=$mime_split[1];
            if($extension=='jpeg')$extension='jpg';
            //if($extension=='javascript')$extension='js';
            //if($extension=='text')$extension='txt';
            $output_file_with_extentnion.=$output_file_without_extentnion.'.'.$extension;
        }
        file_put_contents( $path_with_end_slash . $output_file_with_extentnion, base64_decode($data) );
        return $output_file_with_extentnion;
    }
    private function makeDirectoryUploadTemp($userId){
        $folder = 'uploads/temp/'.$userId.'/';
        $fs = new Filesystem();
            try {
                $fs->mkdir($folder.mt_rand());
            } catch (IOExceptionInterface $e) {
            echo "An error occurred while creating your directory at ".$e->getPath();
        }
    }
    private function removeTemp($userId){
        $folder = 'uploads/temp/'.$userId.'/';
        $fs = new Filesystem();
            try {
                $fs->remove(array('symlink', $folder, 'activity.log'));
            } catch (IOExceptionInterface $e) {
            echo "An error occurred while suppressing file at ".$e->getPath();
        }
    }
}
