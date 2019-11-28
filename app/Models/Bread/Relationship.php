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
        $arrRoleIds = session('api_role_ids');
        $arrRoleIds = is_array($arrRoleIds) ? $arrRoleIds : explode(',', $arrRoleIds);
        // dd($arrRoleIds);
        return $this->hasManyThrough('App\Models\Bread\Attribute', 'App\Models\Bread\ApiAttribute', 'relatioship_id', 'id', 'id', 'attribute_id')
            ->selectRaw('attributes.*, SUM(api_attributes.search) as search, SUM(api_attributes.listing) as listing')
            ->join('api_role_api_attribute', 'api_role_api_attribute.api_attribute_id', '=', 'api_attributes.id')
            ->whereIn('api_role_api_attribute.api_role_id', $arrRoleIds)
            ->groupBy('attributes.id');
    }

    // public function attributes()
    // {
    // 	$arrValue = session('api_role_ids');
    //     $arrValue = is_array($arrValue) ? $arrValue : explode(',', $arrValue);
    //     return $this->belongsToMany('App\Models\Bread\Attribute');
    //     return $this->hasManyThrough('App\Models\Bread\Attribute', 'App\Models\Bread\Table', 'id', 'table_id', 'relationship_table_id', 'id');
    //     	// ->join('api_role_attribute', 'api_role_attribute.attribute_id', '=', 'attributes.id')
    //     	// ->select(DB::Raw('`attributes`.*, `tables`.`id` as `laravel_through_key`, `api_role_attribute`.`search`, `api_role_attribute`.`listing`'))
    //     	// ->where('attributes.status', 1)
    //     	// ->whereIn('api_role_attribute.api_role_id', $arrValue);
    //     	// ->whereHas('apiRole', function($query){
    //     	// 	$query->when(session('api_role_ids'), function($query, $arrValue){
    //     	// 		$arrValue = is_array($arrValue) ? $arrValue : explode(',', $arrValue);
    //     	// 		return $query->join('relationships', 'relationships.id', '=', 'api_role_attribute.relationship_id')
    //     	// 	});
    //     	// });
    // }

    /**
     * Get all of the relationship's attributes.
     */
    // public function attributes()
    // {
    //     return $this->morphMany('App\Models\Bread\ApiAttribute', 'modulable');
    // }

    public function apiRole(){
    	return $this->belongsToMany('App\Models\Bread\ApiRole');
    }

}
