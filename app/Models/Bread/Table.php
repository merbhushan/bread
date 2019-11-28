<?php

namespace App\Models\Bread;

use Illuminate\Database\Eloquent\Model;
use App\Traits\CommonScope;

use DB;

class Table extends Model
{
	use CommonScope;
    /**
     * The connection name for the model.
     *
     * @var string
     */
    protected $connection = 'bread';

    /**
     * Get the relationships for the table.
 */
    public function relationships()
    {
        return $this->hasMany('App\Models\Bread\Relationship')
        	->where('status', 1);
    }

    /**
     * Get all of the table's attributes.
     */
    public function attributes()
    {
        $arrRoleIds = session('api_role_ids');
        $arrRoleIds = is_array($arrRoleIds) ? $arrRoleIds : explode(',', $arrRoleIds);
        // dd($arrRoleIds);
        return $this->hasManyThrough('App\Models\Bread\Attribute', 'App\Models\Bread\ApiAttribute', 'table_id', 'id', 'id', 'attribute_id')
            ->selectRaw('attributes.*, SUM(api_attributes.search) as search, SUM(api_attributes.listing) as listing')
            ->join('api_role_api_attribute', 'api_role_api_attribute.api_attribute_id', '=', 'api_attributes.id')
            ->whereIn('api_role_api_attribute.api_role_id', $arrRoleIds)
            ->groupBy('attributes.id');
        return $this->morphMany('App\Models\Bread\ApiAttribute', 'modulable')
            ->selectRaw('attributes.*, api_attributes.*')
            ->join('attributes', 'attributes.id', '=', 'api_attributes.attribute_id');
    }

    /**
     * Get the fields for the table.
     */
    // public function attributes()
    // {
    // 	$arrValue = session('api_role_ids');
    //     $arrValue = is_array($arrValue) ? $arrValue : explode(',', $arrValue);
    //     return $this->hasMany('App\Models\Bread\Attribute')
    //     	->select(DB::Raw('`attributes`.*, `api_role_attribute`.`search`, `api_role_attribute`.`listing`'))
    //     	->join('api_role_attribute', 'api_role_attribute.attribute_id', '=', 'attributes.id')
    //     	->whereIn('api_role_attribute.api_role_id', $arrValue)
    //     	->where('status', 1)
    //     	->where('api_role_attribute.relationship_id', 0);
    // }

    /**
     * Get the relationship table for the table.
     */
    // public function relationships()
    // {
    //     return $this->hasManyThrough('App\Models\Bread\Table', 'App\Models\Bread\Relationship', 'table_id', 'id', 'id', 'relationship_table_id');
    // }

}
