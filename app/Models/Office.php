<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'office_master';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'office_id';
}
