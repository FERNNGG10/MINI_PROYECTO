<?php

namespace App\Http\Controllers;

use App\Models\Console_Inventory;
use App\Models\Order_Console;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderConsoleController extends Controller
{
    public function index()
    {
        $users = User::with('orderedConsoles')->get();
        return response()->json(["data"=>$users],200);
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'console_id' => 'required|numeric',
            'quantity' => 'required|numeric'
        ]);
        if($validate->fails()){
            return response()->json(["message"=>$validate->errors()],400);
        }
        $order_console = Order_Console::create([
            'user_id' => auth()->user()->id,
            'console_id' => $request->console_id,
            'quantity' => $request->quantity
        ]);
        $invetory = Console_Inventory::where('console_id',$request->console_id)->first();
        $invetory->increment('stock',$request->quantity);
        return response()->json(["message"=>"Console ordered successfully","Order"=>$order_console],201);
    }

    public function show(int $id)
    {
        $order_console = Order_Console::find($id);
        if($order_console){
            $order_console->load('console', 'user');
            return response()->json(["data"=>$order_console],200);
        }
        return response()->json(["message"=>"Order_Console not found"],404);
    }
}
