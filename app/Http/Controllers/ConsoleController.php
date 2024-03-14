<?php

namespace App\Http\Controllers;

use App\Models\Console;
use App\Models\Console_Inventory;
use App\Models\Supplier;
use App\Models\Supplier_Console;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ConsoleController extends Controller
{
    public function index()
    {
       $consoles = Console::with(['suppliers','consoleInventory'])->get();
       return response()->json(["consoles"=>$consoles],200);
    }

    public function store(Request $request){
        $validate = Validator::make($request->all(),[
            'name'  =>  'required',
            'maker' =>  'required',
            'stock'=> 'required|numeric',
            'price'=> 'required|numeric',
            'supplier_id'=> 'required|numeric|exists:suppliers,id'
        ]);
        if($validate->fails()){
            return response()->json([
                "Errorr"=>$validate->errors()
            ],422);
        }
        $console=Console::create([
            'name'  =>  $request->name,
            'maker' =>  $request->maker
        ]);
        $inventory=Console_Inventory::create([
            'console_id'   =>  $console->id,
            'stock' =>  $request->stock,
            'price' =>  $request->price
        ]);
        $supplier = Supplier_Console::create([
            'console_id'   =>  $console->id,
            'supplier_id'   =>  $request->supplier_id
        ]);
        return response()->json([
            'msg'   =>  "Console created succesfully",
            'data'  =>  $console->load('suppliers','consoleInventory')
        ],201);
    }

    public function show(int $id){
        $console = Console::with('suppliers','consoleInventory')->find($id);
        if($console){
            return response()->json(["console"=>$console],200);
        }
        return response()->json(["msg"=>"Console not found"],404);
    }

    public function update(Request $request, int $id){
        $validate = Validator::make($request->all(),[
            'name'  =>  'required',
            'maker' =>  'required',
            'stock'=> 'required|numeric',
            'price'=> 'required|numeric',

        ]);
        if($validate->fails()){
            return response()->json([
                "Errorr"=>$validate->errors()
            ],422);
        }
        $console = Console::find($id);
        if($console){
            $console->update([
                'name'  =>  $request->name,
                'maker' =>  $request->maker
            ]);
            $console->consoleInventory->update([
                'stock' =>  $request->stock,
                'price' =>  $request->price
            ]);

            return response()->json([
                'msg'   =>  "Console updated succesfully",
                'data'  =>  $console->load('suppliers','consoleInventory')
            ],200);
        }
        return response()->json(["msg"=>"Console not found"],404);
    }

    public function destroy(int $id){
        $console = Console::find($id);
        if($console){
            $console->delete();
            return response()->json(["msg"=>"Console deleted succesfully"],200);
        }
        return response()->json(["msg"=>"Console not found"],404);
    }
}
