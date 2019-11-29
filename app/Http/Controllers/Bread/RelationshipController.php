<?php

namespace App\Http\Controllers\Bread;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Bread\Relationship;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\Bread\AttributesProcess;

class RelationshipController extends Controller
{
	use AttributesProcess;

	private $model, $relationship, $modelAttributes = [], $request, $arrAttributes = [], $arrWhere = [], $strRelationName;

	public function __construct(Request $request, $model){
		$this->request = $request;
		$this->model = $model;
	}

	public function handle(Relationship $relationship){
		$relations = null;
    	$this->strRelationName = '';

		// $this->arrAttributes[$relationship->name] = $relationship->attributes->pluck('name')->toArray();
		$this->arrAttributes[$relationship->name] = [];

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
	}

	public function applyRelationship(Relationship $relationship){
		$this->arrWhere[$relationship->name] = [];
		$this->applyListing($this->request, $relationship->attributes, $this->arrAttributes[$relationship->name], $this->arrWhere[$relationship->name]);
		$this->model = $this->model->with([
			$relationship->name => function($query) use($relationship){
				$query->select(array_unique($this->arrAttributes[$relationship->name]));
			}
		]);

		return $this->model;
	}

	public function getModelAttributes(){
		return $this->modelAttributes;
	}

	public function getModel(){
		return $this->model;
	}

	// public function getRelationsAttributes($strRelationName){
	public function getRelationsAttributes(){
		dd($this->arrWhere);
		return $this->arrAttributes;
	}

	private function belongsTo(BelongsTo $belongsTo){
		// initialize relationship attribute array if it's not initialized
		if(!empty($this->strRelationName) 
			&& isset($this->arrAttributes[$this->strRelationName])
			&& !is_array($this->arrAttributes[$this->strRelationName])
		){
			$this->arrAttributes[$this->strRelationName] = [];	
		}

		// First relation will directly related with our main model so strRelationName will empty so for that add foreign key into main model attributes else update in a respective relationship attributes.
		if(empty($this->strRelationName)){
		    array_push($this->modelAttributes, $belongsTo->getForeignKeyName());
		}
		else{
			array_push($this->arrAttributes[$this->strRelationName], $belongsTo->getForeignKeyName());
		}
		// Update Relation name for current relation
		$this->strRelationName .= (empty($this->strRelationName) ? '' : '.') .$belongsTo->getRelationName();
		// Update OwnerKey name in Respective relationship attributes
		array_push($this->arrAttributes[$this->strRelationName], $belongsTo->getOwnerKeyName());
    }

    private function getAttributes(){

	}
}
