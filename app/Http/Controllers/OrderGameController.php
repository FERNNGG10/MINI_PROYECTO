<?php

namespace App\Http\Controllers;

use App\Models\Game_Inventory;
use App\Models\Order_Game;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderGameController extends Controller
{
    public function index()
    {
        $users = Order_Game::with('user','game')->get();
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
        $order_game = Order_Game::create([
            'user_id' => auth()->user()->id,
            'game_id' => $request->game_id,
            'quantity' => $request->quantity
        ]);
        $invetory = Game_Inventory::where('game_id',$request->game_id)->first();
        $invetory->increment('stock',$request->quantity);
        return response()->json(["message"=>"Game ordered successfully","Order"=>$order_game],201);
    }

    public function show(int $id)
    {
        $order_game = Order_Game::find($id);
        if($order_game){
            $order_game->load('game', 'user');
            return response()->json(["data"=>$order_game],200);
        }
        return response()->json(["message"=>"Order_Game not found"],404);
    }
}
