<?php

namespace App\Models\Bread;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
	/**
     * The connection name for the model.
     *
     * @var string
     */
    protected $connection = 'bread';

    public function apiRole(){
    	return $this->belongsToMany('App\Models\Bread\ApiRole');
    }
}
