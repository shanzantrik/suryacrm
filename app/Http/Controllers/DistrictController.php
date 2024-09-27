<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\State;
use Illuminate\Http\Request;

class DistrictController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $districts = District::with('state')->get();
            return datatables()->of($districts)
                ->addColumn('state_name', function ($row) {
                    return $row->state->name;
                })
                ->addColumn('actions', function ($row) {
                    return '<button type="button" class="btn btn-warning btn-sm edit-btn" data-id="' . $row->id . '">Edit</button>
                            <button type="button" class="btn btn-danger btn-sm delete-btn" data-id="' . $row->id . '">Delete</button>';
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        $states = State::all(); // Fetch for modal dropdown
        return view('districts.index', compact('states'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'state_id' => 'required|exists:states,id'
        ]);
        District::create($request->all());

        return response()->json(['success' => 'District created successfully']);
    }

    public function edit($id)
    {
        $district = District::find($id);
        return response()->json($district);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'state_id' => 'required|exists:states,id'
        ]);
        $district = District::find($id);
        $district->update($request->all());

        return response()->json(['success' => 'District updated successfully']);
    }

    public function destroy($id)
    {
        $district = District::find($id);
        $district->delete();

        return response()->json(['success' => 'District deleted successfully']);
    }
}
