<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    /**
     * Method to prepare query filters
     */
    protected function processQueryParams($avaliableFilters, Request $request){
        $whereFilter = [];

        foreach($avaliableFilters as $name=>$type){
            $tmp = $request->get($name);
            if (!empty($tmp)){
                switch ($type) {
                    case '=':
                        $whereFilter[] = [$name,$type,$tmp];
                        break;
                    case 'like':
                        $whereFilter[] = [$name,$type,'%'.$tmp.'%'];
                        break;
                    default:
                        $whereFilter[] = [$name,$type,$tmp];
                        break;
                }
            }
        }

        return $whereFilter;

    }
}
