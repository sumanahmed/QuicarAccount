<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    use HasFactory;

    public function carType () {
        return $this->belongsTo('App\Models\CarType','car_type_id');
    }

    public function model () {
        return $this->belongsTo('App\Models\CarType','model_id');
    }

    public function year () {
        return $this->belongsTo('App\Models\CarType','year_id');
    }
}
