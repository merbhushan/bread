<?php

namespace App\Traits;

trait CommonScope
{
    public function scopeStatus($query, $strStatus){
    	return $query->where('status', $strStatus);
    }
}
