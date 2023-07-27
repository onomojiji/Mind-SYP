<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PointageController extends Controller
{
    public function index(){

    }

    public function store(Request $request){
        dd($request);
        return redirect()->back();
    }

    public function create(){

        return view("importations.create");
    }
}
