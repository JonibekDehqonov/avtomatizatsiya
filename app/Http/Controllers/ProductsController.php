<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductsRequest;
use App\Models\Category;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class ProductsController extends Controller
{

    public function index()
    {
        $products = Products::all();
        $category= Category::all();
        // dd($products);
        return view('products.index')->with([
        'products'=> $products,
        'categorys'=>$category,
         ]);
    }
    public function create()
    {

        return view('products.create');
    }
    public function getProducts(Request $request)
    {
        if ($request->ajax()) {

            $data = Products::with('category');
            
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('category', function ($row){
                    return $row->category->name_category ?? 'No Category';
                })
                ->addColumn('image', function ($row) {
                    $imagePath =$row->image ? $row->image : 'default.png';
                    return  'storage/'.$imagePath;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<div class="btn-group">
                            <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ri-list-settings-line"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a  class="dropdown-item edit" href="javascript:void(0)" data-id="' . $row->id . '"><i class="ri-pencil-line"></i> Update</a></li>
                                <li><a class="dropdown-item delete" href="javascript:void(0)" data-id="' . $row->id . '"><i class="ri-delete-bin-line"></i> Delete</a></li>
                            </ul>
                        </div>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }


    public function store(ProductsRequest $request)
    {
        $validatedData = $request->validated();

        if ($request->hasFile('image')) {
            $name = $request->file('image')->getClientOriginalName();
            $filePath = $request->file('image')->storeAs('categories', $name, 'public');
            $validatedData['image'] = $filePath;
        }

       $product= Products::create($validatedData);
        return response()->json($product);
    }



    /**
     * Show the form for editing the specified resource.
     */
        public function edit($id)
        {
            $product = Products::findOrFail($id);
            return response()->json($product);
        }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductsRequest $request, Products $product)
    {   

        $data = $request->validated();

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
    
            $fileName = $request->file('image')->getClientOriginalName();
            $filePath = $request->file('image')->storeAs('products', $fileName, 'public');             
            $data['image'] = $filePath;
        }
    
        $product->update($data);
        return redirect()->route('products.index');
    }


    public function destroy(Products $product)
    {
        // dd($product);
        $product->delete();
        return response()->json($product);
    }
}
