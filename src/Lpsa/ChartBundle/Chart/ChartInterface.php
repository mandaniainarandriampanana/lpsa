<?php

namespace Lpsa\ChartBundle\Chart;

use Lpsa\ChartBundle\DataSet\DataSetInterface;

interface ChartInterface{

    /**
     * @return string
     */
    public function getId();

    /**
     * @param string $id
     * @return ChartInterface
     */
    public function setId($id);

    /**
     * @return int
     */
    public function getWidth();

    /**
     * @param int $width
     * @return ChartInterface
     */
    public function setWidth($width);

    /**
     * @return int
     */
    public function getHeight();

    /**
     * @param int $height
     * @return ChartInterface
     */
    public function setHeight($height);

    /**
     * @return string
     */
    public function getType();

    /**
     * @param string $type
     * @return ChartInterface
     */
    public function setType($type);

    /**
     * @return array
     */
    public function getData();

    /**
     * @param array $data
     * @return ChartInterface
     */
    public function setData($data);

    /**
     * @return string
     */
    public function getOptions();

    /**
     * @param string $options
     * @return ChartInterface
     */
    public function setOptions($options);

    /**
     * @return array
     */
    public function getLabels();

    /**
     * @param array $labels
     * @return ChartInterface
     */
    public function setLabels($labels);

    /**
     * @param string $label
     * @return ChartInterface
     */
    public function addLabel($label);

    /**
     * @return DataSetInterface[]
     */
    public function getDataSets();

    /**
     * @param DataSetInterface[] $dataSets
     * @return ChartInterface
     */
    public function setDataSets($dataSets);

    /**
     * @param DataSetInterface $dataSet
     * @return ChartInterface
     */
    public function addDataSet(DataSetInterface $dataSet);

    /**
     * @return ChartInterface
     */
    public function generateData();

    /**
     * @param bool $displayValuePoint
     * @return ChartInterface
     */
    public function displayValuePoint($displayValuePoint);

    /**
     * @return string
     */
    public function getDefaultOptions();
}