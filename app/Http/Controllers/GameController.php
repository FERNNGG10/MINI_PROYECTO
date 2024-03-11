<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Game_Inventory;
use App\Models\Supplier_Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class GameController extends Controller
{
    public function index(){
        $games = Game::with(['category','suppliers','gameInventory'])->get();
        return response()->json(["games"=>$games],200);
    }

    public function store(Request $request){
        $validate = Validator::make($request->all(),[
            'name'  =>  'required',
            'maker' =>  'required',
            'category_id'   =>  'required|numeric|exists:categories,id',
            'stock'=> 'required|numeric',
            'price'=> 'required|numeric',
            'supplier_id'=> 'required|numeric|exists:suppliers,id'

        ]);
        if($validate->fails()){
            return response()->json([
                "Errorr"=>$validate->errors()
            ],422);
        }
        $game=Game::create([
            'name'  =>  $request->name,
            'maker' =>  $request->maker,
            'category_id'   =>  $request->category_id
        ]);
        $invetory=Game_Inventory::create([
            'game_id'   =>  $game->id,
            'stock' =>  $request->stock,
            'price' =>  $request->price
        ]);
        $supplier=Supplier_Game::create([
            'game_id'   =>  $game->id,
            'supplier_id'   =>  $request->supplier_id
        ]);
        return response()->json([
            'msg'   =>  "Game created succesfully",
            'data'  =>  $game->load('category','gameInventory','suppliers')
        ],201);
         
    }

    public function show(int $id){
        $game = Game::with('category','gameInventory','suppliers')->find($id);
        if($game){
            return response()->json(["game"=>$game],200);
        }
        return response()->json(["msg"=>"Game not found"],404);
    }

    public function update(Request $request, int $id){
        $game = Game::find($id);
        if($game){
            $validate = Validator::make($request->all(),[
                'name'  =>  'required',
                'maker' =>  'required',
                'category_id'   =>  'required|numeric|exists:categories,id',
                'stock'=> 'required|numeric',
                'price'=> 'required|numeric',
                'supplier_id'=> 'required|numeric|exists:suppliers,id'
            ]);
            if($validate->fails()){
                return response()->json([
                    "Errorr"=>$validate->errors()
                ],422);
            }
            $game->update([
                'name'  =>  $request->name,
                'maker' =>  $request->maker,
                'category_id'   =>  $request->category_id
            ]);
        
            $game->gameInventory->update([
                'stock' =>  $request->stock,
                'price' =>  $request->price
            ]);
        
            $game->suppliers()->sync([$request->supplier_id]);

            return response()->json([
                'msg'   =>  "Game updated succesfully",
                'data'  =>  $game->load('category','gameInventory','suppliers')
            ],200);
        }
        return response()->json(["msg"=>"Game not found"],404);
    }

    public function destroy(int $id){
        $game = Game::find($id);
        if($game){
            $game->delete();
            return response()->json(["msg"=>"Game deleted succesfully"],200);
        }
        return response()->json(["msg"=>"Game not found"],404);
    }
}
