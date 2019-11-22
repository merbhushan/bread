<?php

namespace App\Models\Bread;

use Illuminate\Database\Eloquent\Model;

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
        return $this->hasManyThrough('App\Models\Bread\Attribute', 'App\Models\Bread\Table', 'id', 'table_id', 'relationship_table_id', 'id');
    }
}
