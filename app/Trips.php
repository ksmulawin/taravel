<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trips extends Model
{
  

    protected $dates = [
  		'planned_date',
  		'checkout_date',
          'created_at',
          'updated_at'
      ];
}
