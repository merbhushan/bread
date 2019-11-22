<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Bread\Table;

class TestController extends Controller
{
    public function index(Request $request){
    	$objTable = Table::with('relationships', 'attributes', 'relationships.attributes')->find(1);
    	
    	$objEmployee = (new $objTable->model);
    	$arrAttributes = $objTable->attributes->pluck('name')->toArray();

    	foreach($objTable->relationships as $relationship){
    		$arrRelationshipAttributes = $relationship->attributes->pluck('name')->toArray();
    		
    		$objRelations = (new $objTable->model)->{$relationship->name}();
    		
    		switch ($relationship->type) {
    			case 'belongsTo':
    				array_push($arrAttributes, $objRelations->getForeignKeyName());
    				array_push($arrRelationshipAttributes, $objRelations->getOwnerKeyName());
    				break;
    		}
    		
    		$objEmployee = $objEmployee -> with($relationship->name .':' .implode(',', array_unique($arrRelationshipAttributes)));
    	}
    	return $objEmployee->select(array_unique($arrAttributes))->find(4656);
    }
}

