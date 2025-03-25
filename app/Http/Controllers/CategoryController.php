<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(){
        return view('category.category');
    }
    public function store(Request $request) {
        $validate=$request->validate([
            'name'=>'required|string',
            'myfile'=>'nullable|image'
        ]);

        if ($request->hasFile('myfile')) {
            $name = $request->file('myfile')->getClientOriginalName();
            $filePath = $request->file('myfile')->storeAs('categories', $name, 'public');
            $validate['myfile'] = $filePath;
        }
        $category = Category::create([
            'name_category' => $validate['name'],
            'img_category' => $validate['myfile'] ?? null
        ]);
        return response()->json([
            'status'=>true,
            'redirect'=>'/products',
        ]);
    }

}
