<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $table = 'games';
    use HasFactory;
    protected $fillable = ['name','maker','category_id'];
    public $timestamps = false;
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function suppliers(){
        return $this->belongsToMany(Supplier::class, 'supplier_games');
    }
    public function gameInventory()
    {
        return $this->hasOne(Game_Inventory::class);
    }
    public function orderedByUsers()
    {
        return $this->belongsToMany(User::class, 'orders_game')
        ->withPivot('quantity');
    }
    public function suppliedBySuppliers()
    {
        return $this->belongsToMany(Supplier::class, 'orders_game')
        ->withPivot('quantity');
    }
    public function purchasedByUsers(){
        return $this->belongsToMany(User::class, 'game_sales')
        ->withPivot('quantity','total');
    }
}
