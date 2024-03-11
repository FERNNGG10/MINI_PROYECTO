<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $table = 'suppliers';
    use HasFactory;
    protected $fillable = ['name','email','phone'];
    public $timestamps = false;
    public function suppliedGames()
    {
        return $this->belongsToMany(Game::class, 'supplier_games');
    }
    public function suppliedConsoles()
    {
        return $this->belongsToMany(Console::class, 'supplier_consoles');
    }
    public function orderedGames()
    {
        return $this->belongsToMany(Game::class, 'orders_game')
        ->withPivot('quantity');
    }
    public function orderesConsoles()
    {
        return $this->belongsToMany(Console::class, 'orders_console')
        ->withPivot('quantity');
    }

}
