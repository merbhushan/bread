<?php

namespace App\Models\Bread;

use Illuminate\Database\Eloquent\Model;

class ApiAttribute extends Model
{
    /**
     * The connection name for the model.
     *
     * @var string
     */
    protected $connection = 'bread';

    /**
     * Get the owning modulable model.
     */
    public function modulable()
    {
        return $this->morphTo();
    }
}
