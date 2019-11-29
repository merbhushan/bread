<?php

namespace App\Traits\Bread;

use Illuminate\Http\Request;

trait AttributesProcess
{
	public function applyListing(Request $request, $attributes, &$arrSelect = null, &$arrWhere = []){
		// $arrSelect =  empty($arrSelect) ? [] : $arrSelect;
		// $arrWhere = [];
		foreach ($attributes as $attribute){
			if($attribute->listing){
				array_push($arrSelect, $attribute->name);
			}

			if($attribute->search){
				$this->applySearch($request, $attribute, $arrWhere);
			}

		}
    }

    public function applySearch(Request $request, $attribute, &$arrWhere){
    	if(!is_null($request->{$attribute->name})){
    		array_push($arrWhere, [$attribute->name, '=', $request->{$attribute->name}]);
    	}
    }
}
