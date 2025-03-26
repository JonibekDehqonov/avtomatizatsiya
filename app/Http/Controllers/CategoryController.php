<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    public function index()
    {
        return view('category.category');
    }
    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required|string',
            'myfile' => 'nullable|image'
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
            'status' => true,
            'redirect' => '/products',
        ]);
    }
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        // dd($category);
        return response()->json($category);
    }

    public function update(Request $request, Category $category)
    {
        $validate = $request->validate([
            'name' => 'required|string',
            'myfile' => 'nullable|image'
        ]);
        if ($request->hasFile('myfile')) {
            if ($category->myfile) {
                Storage::disk('public')->delete($category->myfile);
            }
            $fileName = $request->file('myfile')->getClientOriginalName();
            $filePath = $request->file('myfile')->storeAs('categories', $fileName, 'public');
            $data['myfile'] = $filePath;
        }
        $categorys = Category::update([
            'name_category' => $validate['name'],
            'img_category' => $validate['myfile'] ?? null
        ]);
        return response()->json('sucsses');
    }
    public function destroy(Category $category)
    {
        $category->delete();
        return response()->json($category);
    }

    public function getCategory(Request $request)
    {
        if ($request->ajax()) {
            $data = Category::all();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('img_category', function ($row) {
                    $imgPath = $row->img_category ?? 'default.png';
                    return  'storage/' . $imgPath;
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
}
