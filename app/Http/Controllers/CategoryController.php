<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // Fetch categories from the database
            $categories = Category::select(['id', 'name', 'created_at', 'updated_at']);

            // Return the data in the DataTables format
            return DataTables::of($categories)
                // Format created_at as human-readable
                ->editColumn('created_at', function ($row) {
                    return Carbon::parse($row->created_at)->diffForHumans();
                })
                // Format updated_at as human-readable
                ->editColumn('updated_at', function ($row) {
                    return Carbon::parse($row->updated_at)->diffForHumans();
                })
                ->addColumn('actions', function ($row) {
                    // Add Edit and Delete buttons in the Actions column
                    $editBtn = '<button type="button" class="btn btn-warning btn-sm edit-btn" data-id="' . $row->id . '">Edit</button>';
                    $deleteBtn = '<form action="' . route('categories.destroy', $row->id) . '" method="POST" style="display:inline;">
                                      ' . csrf_field() . '
                                      ' . method_field('DELETE') . '
                                      <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Are you sure?\')">Delete</button>
                                  </form>';
                    return $editBtn . ' ' . $deleteBtn;
                })
                ->rawColumns(['actions'])  // Make the actions column raw HTML
                ->make(true);
        }

        // Return the Blade view for non-AJAX requests
        return view('categories.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
    //     return view('categories.create');
    // }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Category::create($request->all());

        // return redirect()->route('categories.index')
        //     ->with('success', 'Category created successfully.');
        return response()->json(['success' => 'Category created successfully.']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // return view('categories.edit', compact('category'));
        $category = Category::find($id);
        return response()->json($category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $category = Category::find($id);
        $category->update($request->all());
        return response()->json(['success' => 'Category updated successfully.']);
        // $category->update($request->all());

        // return redirect()->route('categories.index')
        //     ->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('categories.index')
            ->with('success', 'Category deleted successfully.');
    }
}
