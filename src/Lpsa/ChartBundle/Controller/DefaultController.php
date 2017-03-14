<?php

namespace Lpsa\ChartBundle\Controller;
use Lpsa\ChartBundle\Chart\LineChart;
use Lpsa\ChartBundle\DataSet\LineDataSet;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $chart = new LineChart();
        $chart->setId('myChart');
        $chart->displayValuePoint(true);
        $chart->setType('line')->setLabels( ["January", "February", "March", "April", "May", "June", "July"]);
        $lineDataSet = new LineDataSet();
        $lineDataSet->setLabel('My First dataset')
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
                    ->setData([65, 59, 80, 81, 56, 55, 40]);
        $chart->addDataSet($lineDataSet);
        $chart->generateData();
        return $this->render('LpsaChartBundle:Default:index.html.twig',array(
            'chart' => $chart
        ));
        /*$uriPhp = 'data://' . substr($file, 5);
// Get content
$binary = file_get_contents($uriPhp);

$file = 'uploads/charts/'. time() .'.png';

// Save image
file_put_contents($file, $binary);*/
    }
}
