<?php

namespace Lpsa\ChartBundle\DataSet;

use Lpsa\ChartBundle\DataSet\DataSetInterface;

/**
 * @see http://www.chartjs.org/docs/#line-chart-dataset-structure
 */

class LineDataSet implements DataSetInterface{

    private $data;
    private $label;
    private $xAxisID;
    private $yAxisID;
    private $fill;
    private $cubicInterpolationMode;
    private $lineTension;
    private $backgroundColor;
    private $borderWidth;
    private $borderColor;
    private $borderCapStyle;
    private $borderDash;
    private $borderDashOffset;
    private $borderJoinStyle;
    private $pointBorderColor;
    private $pointBackgroundColor;
    private $pointBorderWidth;
    private $pointRadius;
    private $pointHoverRadius;
    private $pointHitRadius;
    private $pointHoverBackgroundColor;
    private $pointHoverBorderColor;
    private $pointHoverBorderWidth;
    private $pointStyle;
    private $showLine;
    private $spanGaps;
    private $steppedLine;

    /**
     * @return array
     */
    public function getData(){
        return $this->data;
    }

    /**
     * @param array $data
     * @return LineDataSet
     */
    public function setData($data){
        $this->data = $data;
        return $this;
    }

    /**
     * @return string
     */
    public function getLabel(){
        return $this->label;
    }

    /**
     * @param string $label
     * @return LineDataSet
     */
    public function setLabel($label){
        $this->label = $label;
        return $this;
    }

    /**
     * @return string
     */
    public function getXAxisID(){
        return $this->xAxisID;
    }

    /**
     * @param string $xAxisID
     * @return LineDataSet
     */
    public function setXAxisID($xAxisID){
        $this->xAxisID = $xAxisID;
        return $this;
    }

    /**
     * @return string
     */
    public function getYAxisID(){
        return $this->yAxisID;
    }

    /**
     * @param string $yAxisID
     * @return LineDataSet
     */
    public function setYAxisID($yAxisID){
        $this->yAxisID = $yAxisID;
        return $this;
    }

    /**
     * @return bool
     */
    public function getFill(){
        return $this->fill;
    }

    /**
     * @param bool $fill
     * @return LineDataSet
     */
    public function setFill($fill){
        $this->fill = $fill;
        return $this;
    }

    /**
     * @return string
     */
    public function getCubicInterpolationMode(){
        return $this->cubicInterpolationMode;
    }

    /**
     * @param string $cubicInterpolationMode
     * @return LineDataSet
     */
    public function setCubicInterpolationMode($cubicInterpolationMode){
        $this->cubicInterpolationMode = $cubicInterpolationMode;
        return $this;
    }

    /**
     * @return float
     */
    public function getLineTension(){
        return $this->lineTension;
    }

    /**
     * @param float $lineTension
     * @return LineDataSet
     */
    public function setLineTension($lineTension){
        $this->lineTension = $lineTension;
        return $this;
    }

    /**
     * @return string
     */
    public function getBackgroundColor(){
        return $this->backgroundColor;
    }

    /**
     * @param string $backgroundColor
     * @return LineDataSet
     */
    public function setBackgroundColor($backgroundColor){
        $this->backgroundColor = $backgroundColor;
        return $this;
    }

    /**
     * @return integer
     */
    public function getBorderWidth(){
        return $this->borderWidth;
    }

    /**
     * @param integer $borderWidth
     * @return LineDataSet
     */
    public function setBorderWidth($borderWidth){
        $this->borderWidth = $borderWidth;
        return $this;
    }

    /**
     * @return string
     */
    public function getBorderColor(){
        return $this->borderColor;
    }

    /**
     * @param string $borderColor
     * @return LineDataSet
     */
    public function setBorderColor($borderColor){
        $this->borderColor = $borderColor;
        return $this;
    }

    /**
     * @return string
     */
    public function getBorderCapStyle(){
        return $this->borderCapStyle;
    }

    /**
     * @param string $borderCapStyle
     * @return LineDataSet
     */
    public function setBorderCapStyle($borderCapStyle){
        $this->borderCapStyle = $borderCapStyle;
        return $this;
    }

    /**
     * @return array
     */
    public function getBorderDash(){
        return $this->borderDash;
    }

    /**
     * @param array $borderDash
     * @return LineDataSet
     */
    public function setBorderDash($borderDash){
        $this->borderDash = $borderDash;
        return $this;
    }

    /**
     * @return float
     */
    public function getBorderDashOffset(){
        return $this->borderDashOffset;
    }

    /**
     * @param float $borderDashOffset
     * @return LineDataSet
     */
    public function setBorderDashOffset($borderDashOffset){
        $this->borderDashOffset = $borderDashOffset;
        return $this;
    }

    /**
     * @return string
     */
    public function getBorderJoinStyle(){
        return $this->borderJoinStyle;
    }

    /**
     * @param string $borderJoinStyle
     * @return LineDataSet
     */
    public function setBorderJoinStyle($borderJoinStyle){
        $this->borderJoinStyle = $borderJoinStyle;
        return $this;
    }

    /**
     * @return string|array
     */
    public function getPointBorderColor(){
        return $this->pointBorderColor;
    }

    /**
     * @param string|array $pointBorderColor
     * @return LineDataSet
     */
    public function setPointBorderColor($pointBorderColor){
        $this->pointBorderColor = $pointBorderColor;
        return $this;
    }

    /**
     * @return string|array
     */
    public function getPointBackgroundColor(){
        return $this->pointBackgroundColor;
    }

    /**
     * @param string|array $pointBackgroundColor
     * @return LineDataSet
     */
    public function setPointBackgroundColor($pointBackgroundColor){
        $this->pointBackgroundColor = $pointBackgroundColor;
        return $this;
    }

    /**
     * @return integer|array
     */
    public function getPointBorderWidth(){
        return $this->pointBorderWidth;
    }

    /**
     * @param integer|array $pointBorderWidth
     * @return LineDataSet
     */
    public function setPointBorderWidth($pointBorderWidth){
        $this->pointBorderWidth = $pointBorderWidth;
        return $this;
    }

    /**
     * @return integer|array
     */
    public function getPointRadius(){
        return $this->pointRadius;
    }

    /**
     * @param integer|array $pointRadius
     * @return LineDataSet
     */
    public function setPointRadius($pointRadius){
        $this->pointRadius = $pointRadius;
        return $this;
    }

    /**
     * @return integer|array
     */
    public function getPointHoverRadius(){
        return $this->pointHoverRadius;
    }

    /**
     * @param integer|array $pointHoverRadius
     * @return LineDataSet
     */
    public function setPointHoverRadius($pointHoverRadius){
        $this->pointHoverRadius = $pointHoverRadius;
        return $this;
    }

    /**
     * @return integer|array
     */
    public function getPointHitRadius(){
        return $this->pointHoverRadius;
    }

    /**
     * @param integer|array $pointHitRadius
     * @return LineDataSet
     */
    public function setPointHitRadius($pointHitRadius){
        $this->pointHitRadius = $pointHitRadius;
        return $this;
    }

    /**
     * @return string|array
     */
    public function getPointHoverBackgroundColor(){
        return $this->pointHoverRadius;
    }

    /**
     * @param string|array $pointHoverBackgroundColor
     * @return LineDataSet
     */
    public function setPointHoverBackgroundColor($pointHoverBackgroundColor){
        $this->pointHoverBackgroundColor = $pointHoverBackgroundColor;
        return $this;
    }

    /**
     * @return string|array
     */
    public function getPointHoverBorderColor(){
        return $this->pointHoverBorderColor;
    }

    /**
     * @param string|array $pointHoverBorderColor
     * @return LineDataSet
     */
    public function setPointHoverBorderColor($pointHoverBorderColor){
        $this->pointHoverBorderColor = $pointHoverBorderColor;
        return $this;
    }

    /**
     * @return integer|array
     */
    public function getPointHoverBorderWidth(){
        return $this->pointHoverBorderWidth;
    }

    /**
     * @param integer|array $pointHoverBorderWidth
     * @return LineDataSet
     */
    public function setPointHoverBorderWidth($pointHoverBorderWidth){
        $this->pointHoverBorderWidth = $pointHoverBorderWidth;
        return $this;
    }

    /**
     * @return string|array
     */
    public function getPointStyle(){
        return $this->pointStyle;
    }

    /**
     * @param string|array $pointStyle
     * @return LineDataSet
     */
    public function setPointStyle($pointStyle){
        $this->pointStyle = $pointStyle;
        return $this;
    }

    /**
     * @return bool
     */
    public function getShowLine(){
        return $this->showLine;
    }

    /**
     * @param bool $showLine
     * @return LineDataSet
     */
    public function setShowLine($showLine){
        $this->showLine = $showLine;
        return $this;
    }

    /**
     * @return bool
     */
    public function getSpanGaps(){
        return $this->spanGaps;
    }

    /**
     * @param bool $spanGaps
     * @return LineDataSet
     */
    public function setSpanGaps($spanGaps){
        $this->spanGaps = $spanGaps;
        return $this;
    }

    /**
     * @return bool
     */
    public function getSteppedLine(){
        return $this->steppedLine;
    }

    /**
     * @param bool $steppedLine
     * @return LineDataSet
     */
    public function setSteppedLine($steppedLine){
        $this->steppedLine = $steppedLine;
        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $vars = get_object_vars($this);
        $array = array();
        foreach ($vars as $index => $var) {
            if (!is_null($var)) {
                $array[$index] = $var;
            }
        }
        return $array;
    }
}