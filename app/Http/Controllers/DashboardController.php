<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
  public function index()
  {
    $members = Member::all(); // Fetch members from DB
    return view('dashboard', compact('members'));
  }
}
