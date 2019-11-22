<?php

namespace App\Models\Bread;

use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
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
        return $this->hasMany('App\Models\Bread\Relationship');
    }

    /**
     * Get the fields for the table.
     */
    public function attributes()
    {
        return $this->hasMany('App\Models\Bread\Attribute');
    }

    /**
     * Get the relationship table for the table.
     */
    // public function relationships()
    // {
    //     return $this->hasManyThrough('App\Models\Bread\Table', 'App\Models\Bread\Relationship', 'table_id', 'id', 'id', 'relationship_table_id');
    // }

}
