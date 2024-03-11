<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Console extends Model
{
    protected $table = 'consoles';
    use HasFactory;
    protected $fillable = ['name','maker'];
    public $timestamps = false;

    public function suppliers()
    {
       return $this->belongsToMany(Supplier::class,'supplier_consoles');
    }
    public function consoleInventory()
    {
        return $this->hasOne(Console_Inventory::class);
    }
    public function orderedByUsers()
    {
        return $this->belongsToMany(User::class, 'orders_console')
        ->withPivot('quantity');
    }
    public function suppliedBySuppliers()
    {
        return $this->belongsToMany(Supplier::class, 'orders_console')
        ->withPivot('quantity');
    }
    public function purchasedByUsers()
    {
        return $this->belongsToMany(User::class, 'console_sales')
        ->withPivot('quantity','total');
    }

}
