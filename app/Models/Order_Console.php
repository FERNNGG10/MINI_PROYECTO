<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Order_Console extends Pivot
{
    protected $table = 'orders_console';
    use HasFactory;
    protected $fillable = ['user_id','console_id','quantity'];
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function console()
    {
        return $this->belongsTo(Console::class);
    }

}
