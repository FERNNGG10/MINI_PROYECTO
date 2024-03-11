<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Console_Sale extends Pivot
{
    protected $table = 'console_sales';
    use HasFactory;
    protected $fillable = ['user_id','console_id','quantity','total'];
    public $timestamps = false;

    public function console()
    {
        return $this->belongsTo(Console::class);   
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
