<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index(){
        $categories = Category::all();
        return response()->json(["categories"=>$categories],200);
    }

    public function store(Request $request){
        $validate = Validator::make($request->all(),[
            'name'  =>  'required'
        ]);
        if($validate->fails()){
            return response()->json([
                "Error"=>$validate->errors()
            ],422);
        }
        $category=Category::create([
            'name'  =>  $request->name
        ]);
        return response()->json([
            'msg'   =>  "Category created succesfully",
            'data'  =>  $category
        ],201);
    }

    public function show(int $id){
        $category = Category::find($id);
        if($category){
            return response()->json(["category"=>$category],200);
        }
        return response()->json(["msg"=>"Category not found"],404);
    }

    public function update(Request $request, int $id){
        $category = Category::find($id);
        if($category){
            $validate = Validator::make($request->all(),[
                'name'  =>  'required'
            ]);
            if($validate->fails()){
                return response()->json([
                    "Error"=>$validate->errors()
                ],422);
            }
            $category->name = $request->name;
            $category->save();
            return response()->json([
                'msg'   =>  "Category updated succesfully",
                'data'  =>  $category
            ],200);
        }
        return response()->json(["msg"=>"Category not found"],404);
    }

    public function destroy(int $id){
        $category = Category::find($id);
        if($category){
            $category->delete();
            return response()->json([
                'msg'   =>  "Category deleted succesfully",
                'data'  =>  $category
            ],200);
        }
        return response()->json(["msg"=>"Category not found"],404);
    }
}
