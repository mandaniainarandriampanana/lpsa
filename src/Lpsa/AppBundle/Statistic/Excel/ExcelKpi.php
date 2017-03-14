<?php

namespace Lpsa\AppBundle\Statistic\Excel;

class ExcelKpi{

    public static function __callStatic($method,$arguments){
        $sheet = new SheetKpihse($kpihse,$manager);        
        return call_user_func_array(array($sheet,$method),$arguments);
    }
}