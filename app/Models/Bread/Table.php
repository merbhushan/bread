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
     * Get the fields for the table.
     */
    public function attributes()
    {
    	$arrValue = session('api_role_ids');
        $arrValue = is_array($arrValue) ? $arrValue : explode(',', $arrValue);
        return $this->hasMany('App\Models\Bread\Attribute')
        	->select(DB::Raw('`attributes`.*, `api_role_attribute`.`search`, `api_role_attribute`.`listing`'))
        	->join('api_role_attribute', 'api_role_attribute.attribute_id', '=', 'attributes.id')
        	->whereIn('api_role_attribute.api_role_id', $arrValue)
        	->where('status', 1)
        	->where('api_role_attribute.relationship_id', 0);
    }

    /**
     * Get the relationship table for the table.
     */
    // public function relationships()
    // {
    //     return $this->hasManyThrough('App\Models\Bread\Table', 'App\Models\Bread\Relationship', 'table_id', 'id', 'id', 'relationship_table_id');
    // }

}
