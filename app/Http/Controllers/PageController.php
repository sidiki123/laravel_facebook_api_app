<?php

namespace App\Http\Controllers;

use App\Models\Publication;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function home() {
        return view('pages.dashboard.index');
    }

    public function publications() {
        $publications = Publication::orderBy('created_at','desc')->get();
    }
}
