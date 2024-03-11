<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Game_Sale extends Pivot
{
    protected $table = 'game_sales';
    use HasFactory;
    protected $fillable = ['user_id','game_id','quantity','total'];
    public $timestamps = false;

    public function game()
    {
        return $this->belongsTo(Game::class);   
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
