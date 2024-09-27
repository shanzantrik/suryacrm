<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Holiday_Dates;
use App\Models\Category;
use App\Models\SubCategory;

class HolidayController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $holidays = Holiday_Dates::with(['category', 'subcategory'])->get();
            return datatables()->of($holidays)
                ->addColumn('category_name', function ($row) {
                    return $row->category->name;
                })
                ->addColumn('subcategory_name', function ($row) {
                    return $row->subcategory->name;
                })
                ->addColumn('actions', function ($row) {
                    return '<button type="button" class="btn btn-warning btn-sm edit-btn" data-id="' . $row->id . '">Edit</button>
                            <button type="button" class="btn btn-danger btn-sm delete-btn" data-id="' . $row->id . '">Delete</button>';
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        $categories = Category::all();
        return view('holidays.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'holiday_date' => 'required|date',
            'description' => 'required|string',
            'religion' => 'required|array',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'required|exists:subcategories,id'
        ]);
        $religions = implode(',', $request->religion);
        Holiday_Dates::create([
            'holiday_date' => $request->holiday_date,
            'description' => $request->description,
            'religion' => $religions,  // Insert the comma-separated string
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
        ]);
        return response()->json(['success' => 'Holiday created successfully']);
    }

    public function edit($id)
    {
        $holiday = Holiday_Dates::find($id);
        return response()->json($holiday);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'holiday_date' => 'required|date',
            'description' => 'required|string',
            'religion' => 'required|array',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'required|exists:subcategories,id'
        ]);

        $religions = implode(',', $request->religion);
        $holiday = Holiday_Dates::find($id);
        $holiday->update([
            'holiday_date' => $request->holiday_date,
            'description' => $request->description,
            'religion' => $religions,  // Update the comma-separated string
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
        ]);
        return response()->json(['success' => 'Holiday updated successfully']);
    }

    public function destroy($id)
    {
        $holiday = Holiday_Dates::find($id);
        $holiday->delete();
        return response()->json(['success' => 'Holiday deleted successfully']);
    }

    public function getSubcategoriesByCategory($category_id)
    {
        $subcategories = SubCategory::where('category_id', $category_id)->get();
        return response()->json($subcategories);
    }
    // Fetch holiday data for the calendar
    public function getHolidaysForCalendar()
    {
        $holidays = Holiday_Dates::all();
        $events = [];

        foreach ($holidays as $holiday) {
            $events[] = [
                'title' => $holiday->description,
                'start' => $holiday->holiday_date,
                'category' => $holiday->category_id,
                'subcategory' => $holiday->subcategory_id
            ];
        }

        return response()->json($events);
    }
}
