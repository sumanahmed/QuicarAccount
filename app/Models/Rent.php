<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rent extends Model
{
    use HasFactory;

    public function createdBy() {
    	return $this->belongsTo('App\Models\User','created_by');
    }

    public function updatedBy() {
    	return $this->belongsTo('App\Models\User','updated_by');
    }
}
