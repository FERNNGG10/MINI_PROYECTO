<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Supplier_Game extends Pivot
{
    protected $table = 'supplier_games';
    use HasFactory;
    protected $fillable = ['supplier_id','game_id'];
    public $timestamps = false;
}
