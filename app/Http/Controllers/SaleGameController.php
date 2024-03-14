<?php

namespace App\Http\Controllers;

use App\Models\Game_Inventory;
use App\Models\Game_Sale;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SaleGameController extends Controller
{
    public function index()
    {
        $users = Game_Sale::with('user','game')->get();
        return response()->json(["data"=>$users],200);
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'game_id' => 'required|numeric',
            'quantity' => 'required|numeric'
        ]);
        if($validate->fails()){
            return response()->json(["message"=>$validate->errors()],400);
        }
        $invetory = Game_Inventory::where('game_id',$request->game_id)->first();
        if($invetory->stock < $request->quantity){
            return response()->json(["message"=>"Game out of stock"],400);
        }
        $total = $invetory->price * $request->quantity;
        $sale_game = Game_Sale::create([
            'user_id' => auth()->user()->id,
            'game_id' => $request->game_id,
            'quantity' => $request->quantity,
            'total' => $total
        ]);
        
        $invetory->decrement('stock',$request->quantity);
        return response()->json(["message"=>"Game purchased successfully","Sale"=>$sale_game],201);
    }

    public function show(int $id)
    {
        $sale_game = Game_Sale::find($id);
        if($sale_game){
            $sale_game->load('game', 'user');
            return response()->json(["data"=>$sale_game],200);
        }
        return response()->json(["message"=>"Game_Sale not found"],404);
    }
}
