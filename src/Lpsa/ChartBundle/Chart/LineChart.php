<?php 

namespace Lpsa\ChartBundle\Chart;

use Lpsa\ChartBundle\Chart\ChartInterface;
use Lpsa\ChartBundle\DataSet\DataSetInterface;
use Lpsa\ChartBundle\DataSet\LineDataSet;
use Lpsa\ChartBundle\DataSet\DataSetException;

class LineChart implements ChartInterface{

    private $data;
    private $options;
    private $labels;
    private $id;
    private $dataSets;
    private $type;
    private $displayValuePoint;
    private $width;
    private $height;

    public function __construct()
    {
        $this->id     = 'chart'.mt_rand(0, 4096);
        $this->labels = [];
    }

    /**
     * @return string
     */
    public function getId(){
        return $this->id;
    }

    /**
     * @inheritDoc
     */
    public function setId($id){
        $this->id = $id;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getWidth(){
        return $this->width;
    }

    /**
     * @inheritDoc
     */
    public function setWidth($width){
        $this->width = $width;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getHeight(){
        return $this->height;
    }

    /**
     * @inheritDoc
     */
    public function setHeight($height){
        $this->height = $height;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getType(){
        return $this->type;
    }

    /**
     * @inheritDoc
     */
    public function setType($type){
        $this->type = $type;
        return $this;
    }


    /**
     * @inheritDoc
     */
    public function getData(){
        return $this->data;
    }

    /**
     * @inheritDoc
     */
    public function setData($data){
        $this->data = $data;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getOptions(){
        return $this->options;
    }

    /**
     * @inheritDoc
     */
    public function setOptions($options){
        $this->options = $options;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getLabels(){
        return $this->labels;
    }

    /**
     * @inheritDoc
     */
    public function setLabels($labels){
        $this->labels = $labels;
        return $this;
    }
    
    /**
     * @inheritDoc
     */
    public function addLabel($label){
        $this->labels[] = $label;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getDataSets(){
        return $this->dataSets;
    }

    /**
     * @inheritDoc
     */
    public function setDataSets($dataSets){
        $this->dataSets = $dataSets;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function addDataSet(DataSetInterface $dataSet){
        $this->dataSets[] = $dataSet;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getDefaultOptions(){
        return 'animation: {
                    onComplete: function() {
                        this.chart.controller.draw();
                        drawValue(this, 1);
                    },
                    onProgress: function(state) {
                        var animation = state.animationObject;
                        drawValue(this, animation.currentStep / animation.numSteps);
                    }		
                }';
    }

    /**
     * @inheritDoc
     */
    public function generateData()
    {
        if($this->displayValuePoint && empty($this->options)){
            $this->options = '{' . $this->getDefaultOptions() . '}';
        }
        $data = [
            'labels'   => $this->getLabels(),
            'datasets' => [],
        ];
        foreach ($this->getDataSets() as $dataSet) {
            if (!$dataSet instanceof LineDataSet) {
                throw new DataSetException('DataSet must be an instance of LineDataSet, '.get_class($dataSet).' given');
            }
            if (!empty($dataSet->getData())) {
                $data['datasets'][] = $dataSet->toArray();
            }
        }
        $this->setData($data);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function displayValuePoint($displayValuePoint){
        $this->displayValuePoint = $displayValuePoint;
        return $this;
    }
}