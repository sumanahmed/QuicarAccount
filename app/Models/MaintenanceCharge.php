<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceCharge extends Model
{
    use HasFactory;

    protected $table = 'maintenance_charges';

    protected $fillable = [
    	'date',    
    	'purpose',
    	'amount',
    	'paid_to',
    	'paid_by',
    	'payment_by'
    ];
}
