<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedules extends Model
{
    protected $fillable = [
        'user_id', 'destination','details','checkin','checkout'
    ];

	 protected $dates = [
		'planned_date',
		'checkout_date',
        'created_at',
        'updated_at'
    ];

}
