<?php

namespace App\Http\Controllers;

use App\Models\Console_Inventory;
use App\Models\Console_Sale;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SaleConsoleController extends Controller
{
    public function index()
    {
        $users = Console_Sale::with('user','console')->get();
        return response()->json(["data"=>$users],200);
    }

    public function store(Request $request){
        $validate = Validator::make($request->all(),[
            'console_id' => 'required|numeric',
            'quantity' => 'required|numeric'
        ]);
        if($validate->fails()){
            return response()->json(["message"=>$validate->errors()],400);
        }
        $invetory = Console_Inventory::where('console_id',$request->console_id)->first();
        if($invetory->stock < $request->quantity){
            return response()->json(["message"=>"Console out of stock"],400);
        }
        $total = $invetory->price * $request->quantity;
        $sale_console = Console_Sale::create([
            'user_id' => auth()->user()->id,
            'console_id' => $request->console_id,
            'quantity' => $request->quantity,
            'total' => $total
        ]);
        $invetory->decrement('stock',$request->quantity);
        return response()->json(["message"=>"Console purchased successfully","Sale"=>$sale_console],201);
    }

    public function show(int $id)
    {
        $sale_console = Console_Sale::find($id);
        if($sale_console){
            $sale_console->load('console', 'user');
            return response()->json(["data"=>$sale_console],200);
        }
        return response()->json(["message"=>"Console_Sale not found"],404);
    }
}
