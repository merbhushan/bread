<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Bread\Table;

class TestController extends Controller
{
    public function index(Request $request){
    	session(['api_role_ids' => [1]]);
    	// dd(\App\Models\Bread\Relationship::find(2)->attributes);

    	// dd(\App\Models\Office::find(3)->creator);
    	// dd(\App\Models\Employee::with('office.creator')->find(4656));
    	$objTable = Table::with(['attributes', 'relationships.attributes'])->find(1);
    	// dd($objTable);
    	$objModel = (new $objTable->model);
    	
    	$tableAttributes = $objTable->attributes;
    	$arrAttributes = [];
    	// $objTable->attributes->pluck('name')->toArray();
    	foreach ($tableAttributes as $tableAttribute) {
    		// Add in listing array if listing flag is set
    		if($tableAttribute->listing){
    			array_push($arrAttributes, $tableAttribute->name);
    		}

    		if($tableAttribute->search){
    			$objModel = $this->applySearch($objModel, $request, $tableAttribute);
    		}
    	}
    	

    	foreach($objTable->relationships as $relationship){
    		$arrRelationshipAttributes = $relationship->attributes->pluck('name')->toArray();
    		
    		$objRelations = (new $objTable->model)->{$relationship->name}();
    		
    		switch ($relationship->type) {
    			case 'belongsTo':
    				array_push($arrAttributes, $objRelations->getForeignKeyName());
    				array_push($arrRelationshipAttributes, $objRelations->getOwnerKeyName());
    				break;
    		}
    		
    		$objModel = $objModel -> with($relationship->name .':' .implode(',', array_unique($arrRelationshipAttributes)));
    	}
    	// dd($objModel->select(array_unique($arrAttributes))->toSql());
    	return $objModel->select(array_unique($arrAttributes))->paginate('10');
    }

    private function applySearch($objModel, $request, $objAttribute){
    	return $objModel->when($request->{$objAttribute->name}, function($query, $strSearchValue) use($objAttribute){
    		return $query->where($objAttribute->name, $strSearchValue);
    	});
    }
}

