<?php

namespace App\Models\Bread;

use Illuminate\Database\Eloquent\Model;
use DB;

class Relationship extends Model
{
	/**
     * The connection name for the model.
     *
     * @var string
     */
    protected $connection = 'bread';

    /**
     * Get the relationship table that owns the relationship.
     */
    public function attributes()
    {
    	$arrValue = session('api_role_ids');
        $arrValue = is_array($arrValue) ? $arrValue : explode(',', $arrValue);
        return $this->belongsToMany('App\Models\Bread\Attribute');
        return $this->hasManyThrough('App\Models\Bread\Attribute', 'App\Models\Bread\Table', 'id', 'table_id', 'relationship_table_id', 'id');
        	// ->join('api_role_attribute', 'api_role_attribute.attribute_id', '=', 'attributes.id')
        	// ->select(DB::Raw('`attributes`.*, `tables`.`id` as `laravel_through_key`, `api_role_attribute`.`search`, `api_role_attribute`.`listing`'))
        	// ->where('attributes.status', 1)
        	// ->whereIn('api_role_attribute.api_role_id', $arrValue);
        	// ->whereHas('apiRole', function($query){
        	// 	$query->when(session('api_role_ids'), function($query, $arrValue){
        	// 		$arrValue = is_array($arrValue) ? $arrValue : explode(',', $arrValue);
        	// 		return $query->join('relationships', 'relationships.id', '=', 'api_role_attribute.relationship_id')
        	// 	});
        	// });
    }

    public function apiRole(){
    	return $this->belongsToMany('App\Models\Bread\ApiRole');
    }

}
