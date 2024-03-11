<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Supplier_Console extends Pivot
{
    protected $table = 'supplier_consoles';
    use HasFactory;
    protected $fillable = ['console_id','supplier_id'];
    public $timestamps = false;
}
