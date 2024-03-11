<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Rules\Email;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SupplierController extends Controller
{
    public function index(){
        $suppliers = Supplier::all();
        return response()->json(["suppliers"=>$suppliers],200);
    }

    public function store(Request $request){
       $validate = Validator::make($request->all(),[
           'name'  =>  'required',
           'email' =>  ['required','email','unique:suppliers',new Email()],
           'phone' =>  'required|min:10|max:10'
       ]);
        if($validate->fails()){
            return response()->json([
            "Error"=>$validate->errors()
            ],422);
        }
        $supplier=Supplier::create([
            'name'  =>  $request->name,
            'email' =>  $request->email,
            'phone' =>  $request->phone
        ]);
        return response()->json([
            'msg'   =>  "Supplier created succesfully",
            'data'  =>  $supplier
        ],201);
    }

    public function show(int $id){
        $supplier = Supplier::find($id);
        if($supplier){
            return response()->json(["supplier"=>$supplier],200);
        }
        return response()->json(["msg"=>"Supplier not found"],404);
    }

    public function update(Request $request, int $id){
        $supplier = Supplier::find($id);
        if($supplier){
            $validate = Validator::make($request->all(),[
                'name'  =>  'required',
                'email' =>  ['required','email','unique:suppliers,email,'.$id,new Email()],
                'phone' =>  'required|min:10|max:10'
            ]);
            if($validate->fails()){
                return response()->json([
                    "Error"=>$validate->errors()
                ],422);
            }
            $supplier->name = $request->name;
            $supplier->email = $request->email;
            $supplier->phone = $request->phone;
            $supplier->save();
            return response()->json([
                'msg'   =>  "Supplier updated succesfully",
                'data'  =>  $supplier
            ],200);
        }
        return response()->json(["msg"=>"Supplier not found"],404);
    }

    public function destroy(int $id){
        $supplier = Supplier::find($id);
        if($supplier){
            $supplier->delete();
            return response()->json([
                'msg'   =>  "Supplier deleted succesfully",
                'data'  =>  $supplier
            ],200);
        }
        return response()->json(["msg"=>"Supplier not found"],404);
    }

}
