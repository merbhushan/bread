<?php

namespace App\Traits\Bread;

use Illuminate\Http\Request;

trait AttributesProcess
{
	public function applyListing(Request $request, $attributes, &$arrSelect = null, &$arrWhere = [], &$arrFilter = [], $strRelationName = ''){
		foreach ($attributes as $attribute){
			if($attribute->name === 'RCount' && $strRelationName !== ''){
				
				if(!is_null($request->{$strRelationName ."." .$attribute->name})){
		    		$this->arrWhereHasCount[$strRelationName] = $request->{$strRelationName ."." .$attribute->name};
		    	}
		    	continue;
			}

			if($attribute->listing){
				array_push($arrSelect, $attribute->name);
			}

			if($attribute->search){
				$this->applySearch($request, $attribute, $arrWhere, $strRelationName);
			}

			if($attribute->relation_filter){
				$this->applySearch($request, $attribute, $arrFilter, $strRelationName);
			}

		}
    }

    public function applySearch(Request $request, $attribute, &$arrWhere, $strRelationName){
    	$strAttributeName = ((empty($strRelationName) ? "" : ($strRelationName .".")) .$attribute->name);

    	if(is_null($request->{$strAttributeName})){
    		return 1;
    	}

    	array_push($arrWhere, [$attribute->name, '=', $request->{$strAttributeName}]);
    }
}
