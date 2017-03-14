<?php

namespace Lpsa\ChartBundle\DataSet;

interface DataSetInterface{

    /**
     * @return array
     */
    public function getData();

    /**
     * @param array $data
     * @return DataSetInterface
     */
    public function setData($data);

    /**
     * @return string
     */
    public function getLabel();

    /**
     * @param string $label
     * @return DataSetInterface
     */
    public function setLabel($label);

    /**
     * @return array
     */
    public function toArray();
}