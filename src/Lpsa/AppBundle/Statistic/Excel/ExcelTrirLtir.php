<?php

namespace Lpsa\AppBundle\Statistic\Excel;

class ExcelTrirLtir{

    public static function __callStatic($method,$arguments){
        $sheet = new SheetLtirTrir();
        return call_user_func_array(array($sheet,$method),$arguments);
    }
}