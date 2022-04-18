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
        $publications = Publication::where('status','published')->orderBy('created_at','desc')->get();

        return view('pages.dashboard.index',compact('publications'));
    }

}
