<?php

namespace Lpsa\ChartBundle\Twig;

use Lpsa\ChartBundle\Chart\ChartInterface;
use Lpsa\ChartBundle\Chart\LinearChart;
use Symfony\Bundle\TwigBundle\TwigEngine;

class ChartTwigExtension extends \Twig_Extension
{
    
    /**
     * @inheritDoc
     */
    public function getName()
    {
        return 'chart_twig_extension';
    }

    /**
     * @inheritDoc
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('chart_render_html', [$this, 'renderHTML'], ['is_safe' => ['html'], 'needs_environment' => false]),
            new \Twig_SimpleFunction('chart_render_js', [$this, 'renderJS'], ['is_safe' => ['html'], 'needs_environment' => false]),
        ];
    }

    /**
     * @param ChartInterface $chart
     * @param int $width
     * @param int $height
     * @return string
     */
    public function renderHTML(ChartInterface $chart, $width = 400, $height = 400)
    {
        return '<canvas id="'.$chart->getId().'" width="'.$width.'" height="'.$height.'"></canvas>';
    }

    /**
     * @param ChartInterface $chart
     * @return string
     */
    public function renderJS(ChartInterface $chart)
    {        
        $js = '<script>$(document).ready(function(){';
        $js .= 'var ctx'.$chart->getId().' = initCanvas(document.getElementById(\''.$chart->getId().'\')).getContext(\'2d\');';
        $js .= 'ctx'.$chart->getId().'.canvas.width = 350;';
        $js .= 'ctx'.$chart->getId().'.canvas.height = 350;';
        $js .= 'var chart'.$chart->getId().' = new Chart(ctx'.$chart->getId().', {';
        $js .= '"type": "'.$chart->getType().'",';
        if($chart->getHeight()){
            $js .= '"height": "'.$chart->getHeight().'",';
        }
        if($chart->getWidth()){
            $js .= '"width": "'.$chart->getWidth().'",';
        }
        $js .= '"data": '.json_encode($chart->getData());
        if (!is_null($chart->getOptions())) {
            $js .= ',"options": '.$chart->getOptions();
        }
        $js .= '});';
        $js .= '});</script>';
        return $js;
    }
}