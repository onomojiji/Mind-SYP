<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;

class UsersController extends Controller
{
    public function index(){


        return view("Users.index");
    }

    public function create(){


        return view("Users.create");
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {

        return redirect()->back()->with("success", "Utilisateur créé avec succès.");
    }
}
