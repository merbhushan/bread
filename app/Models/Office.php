<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    protected $primaryKey = 'ofc_id';
    public function creator(){
        return $this->belongsTo('App\Models\Employee', 'created_by', 'id');
    }

    public function employees(){
        return $this->hasOne('App\Models\Employee');
        return $this->hasMany('App\Models\Employee');
    }
}
