<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\PointagesImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PointageController extends Controller
{
    public function index(){

        return view("importations.index");

    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {

        Excel::import(new PointagesImport, $request->file("file"));

        return redirect()->back()->with("success", "Pointages importés avec succès");
    }

    public function create(){
        return view("importations.create");
    }

}
