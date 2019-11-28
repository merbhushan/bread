<?php

namespace App\Http\Controllers\Bread;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Bread\Relationship;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RelationshipController extends Controller
{
	private $model, $relationship, $modelAttributes = [], $request, $arrRelationshipsAttributes, $strRelationName;

	public function __construct(Request $request, $model){
		$this->request = $request;
		$this->model = $model;
	}

	public function handle(Relationship $relationship){
		$relations = null;
    	$this->strRelationName = '';

		$this->arrRelationshipsAttributes[$relationship->name] = [];

		// Get all relationships that asociated with this.
		$arrTrhoughRelations = explode('.', $relationship->name);

		foreach ($arrTrhoughRelations as $strRelation) {
			if(empty($relations)){
				$relations = (new $this->model)->{$strRelation}();
    		}
    		else{
    			$relations = $relations->getRelated()->{$strRelation}();
    		}

    		switch ($relations) {
    			case $relations instanceof BelongsTo :
    				$this->belongsTo($relations);
    				break;
    			
    			default:
    				# code...
    				break;
    		}
		}

		$this->arrRelationshipsAttributes[$relationship->name] = array_merge($this->arrRelationshipsAttributes[$relationship->name], $relationship->attributes->pluck('name')->toArray());
	}

	public function getModelAttributes(){
		return $this->modelAttributes;
	}

	public function getRelationsAttributes(){
		return $this->arrRelationshipsAttributes;
	}

	private function belongsTo(BelongsTo $belongsTo){
		// First relation will directly related with our main model so strRelationName will empty so for that add foreign key into main model attributes else update in a respective relationship attributes.
		if(empty($this->strRelationName)){
		    array_push($this->modelAttributes, $belongsTo->getForeignKeyName());
		}
		else{
		  	$this->arrRelationshipsAttributes[$this->strRelationName][] = $belongsTo->getForeignKeyName();
		}
		// Update Relation name for current relation
		$this->strRelationName .= (empty($this->strRelationName) ? '' : '.') .$belongsTo->getRelationName();
		// Update OwnerKey name in Respective relationship attributes
		$this->arrRelationshipsAttributes[$this->strRelationName][] = $belongsTo->getOwnerKeyName();
    }

    private function getAttributes(){

	}
}
