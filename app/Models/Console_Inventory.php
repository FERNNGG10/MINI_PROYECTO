<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Console_Inventory extends Model
{
    protected $table = 'console_inventory';
    use HasFactory;
    protected $fillable = ['console_id','stock','price'];
    public $timestamps = false;
    public function console()
    {
        return $this->belongsTo(Console::class);
    }
}
