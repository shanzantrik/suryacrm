<?php

namespace App\Http\Controllers;

use App\Models\SubCategory;
use App\Models\Category;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $subCategories = SubCategory::with('category')->select('subcategories.*');

            return datatables()->of($subCategories)
                ->addColumn('category_name', function ($row) {
                    return $row->category ? $row->category->name : 'N/A';
                })
                ->addColumn('actions', function ($row) {
                    $editBtn = '<button type="button" class="btn btn-warning btn-sm edit-btn" data-id="' . $row->id . '">Edit</button>';
                    $deleteBtn = '<form action="' . route('subcategories.destroy', $row->id) . '" method="POST" style="display:inline;">
                                    ' . csrf_field() . '
                                    ' . method_field('DELETE') . '
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Are you sure?\')">Delete</button>
                                  </form>';
                    return $editBtn . ' ' . $deleteBtn;
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        $categories = Category::all(); // Pass categories to the view
        return view('subcategories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'category_id' => 'required|exists:categories,id',
        ]);

        SubCategory::create($request->all());
        return response()->json(['success' => 'SubCategory created successfully.']);
    }

    public function edit($id)
    {
        $subCategory = SubCategory::findOrFail($id); // Ensure the subcategory exists
        return response()->json($subCategory);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'category_id' => 'required|exists:categories,id',
        ]);

        $subCategory = SubCategory::findOrFail($id); // Ensure the subcategory exists
        $subCategory->update($request->all());
        return response()->json(['success' => 'SubCategory updated successfully.']);
    }

    public function destroy(SubCategory $subcategory) // Ensure correct model reference
    {
        $subcategory->delete();
        return redirect()->route('subcategories.index')
            ->with('success', 'SubCategory deleted successfully.');
    }
}
