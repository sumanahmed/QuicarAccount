<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rent extends Model
{
    use HasFactory;

    public function createdBy() {
    	return $this->belongsTo('App\Models\User', 'created_by', 'id');
    }

    public function updatedBy() {
    	return $this->belongsTo('App\Models\User', 'updated_by', 'id');
    }
    
    public function CarType() {
    	return $this->belongsTo('App\Models\CarType', 'car_type_id');
    } 
    
    public function CarModel() {
    	return $this->belongsTo('App\Models\CarModel', 'model_id');
    }
}
