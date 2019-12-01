<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    public function office(){
    	return $this->belongsTo('App\Models\Office');
    }

    public function offices(){
        return $this->belongsToMany('App\Models\Office', 'employee_office', 'employee_id', 'office_id');
    }
}
