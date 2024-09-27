<?php

namespace App\Http\Controllers;

use App\Models\State;
use Illuminate\Http\Request;

class StateController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $states = State::all();
            return datatables()->of($states)
                ->addColumn('actions', function ($row) {
                    return '<button type="button" class="btn btn-warning btn-sm edit-btn" data-id="' . $row->id . '">Edit</button>
                            <button type="button" class="btn btn-danger btn-sm delete-btn" data-id="' . $row->id . '">Delete</button>';
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        return view('states.index');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required']);
        State::create($request->all());

        return response()->json(['success' => 'State created successfully']);
    }

    public function edit($id)
    {
        $state = State::find($id);
        return response()->json($state);
    }

    public function update(Request $request, $id)
    {
        $request->validate(['name' => 'required']);
        $state = State::find($id);
        $state->update($request->all());

        return response()->json(['success' => 'State updated successfully']);
    }

    public function destroy($id)
    {
        $state = State::find($id);
        $state->delete();

        return response()->json(['success' => 'State deleted successfully']);
    }
}
