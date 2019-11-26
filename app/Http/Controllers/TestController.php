<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Bread\Table;

class TestController extends Controller
{
    public function index(Request $request){
    	session(['api_role_ids' => [1]]);
    	// dd(\App\Models\Bread\Table::find(1)->attributes);
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
    	
    	$arrRelationships = [];
    	// dd($objTable->relationships);
    	foreach($objTable->relationships as $relationship){
    		$objRelations = null;
    		$strKeyName = null;
    		
    		$arrTrhoughRelations = explode('.', $relationship->name);
    		
    		foreach ($arrTrhoughRelations as $strRelation) {
    			if(empty($objRelations)){
					$objRelations = (new $objTable->model)->{$strRelation}();

    			}
    			else{
    				$objRelations = $objRelations->getRelated()->{$strRelation}();
    			}

    			switch ($relationship->type) {
		    		case 'belongsTo':
		    			if(empty($strKeyName)){
		    				array_push($arrAttributes, $objRelations->getForeignKeyName());
		    				$strKeyName = $objRelations->getRelationName();
		    			}
		    			else{
		    				$arrRelationshipsAttributes[$strKeyName][] = $objRelations->getForeignKeyName();
		    				$strKeyName .= '.' .$objRelations->getRelationName();
		    			}
		    			$arrRelationshipsAttributes[$strKeyName][] = $objRelations->getOwnerKeyName();
		    			break;
		    	}

    		}
		    if(is_array($arrRelationshipsAttributes[$strKeyName])){
		    	$arrRelationshipsAttributes[$strKeyName] = array_merge($arrRelationshipsAttributes[$strKeyName], $relationship->attributes->pluck('name')->toArray());
		   	}
		    else{
		    	$arrRelationshipsAttributes[$strKeyName] = $relationship->attributes->pluck('name')->toArray();
		    }
            // dd($relationship);
    		// $objRelations = (new $objTable->model)->{$relationship->name}();

    	}
    	// dd($arrRelationshipsAttributes);
    	foreach ($arrRelationshipsAttributes as $strRelationshipName => $arrRelationshipAttributes) {
    		$arrRelationships[$strRelationshipName] = function($query) use($arrRelationshipAttributes){
    			return $query->select(array_unique($arrRelationshipAttributes));
    		};
    	}
    		// dd($arrRelationships);
    	// $arrRelationships['a.b'] = 'test';
    	// dd($arrRelationships);
    	if(!empty($arrRelationships)){
    		$objModel = $objModel -> with($arrRelationships);
    		// $objModel = $objModel -> with($relationship->name .':' .implode(',', array_unique($arrRelationshipAttributes)));
    		// dd($arrRelationships);
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

