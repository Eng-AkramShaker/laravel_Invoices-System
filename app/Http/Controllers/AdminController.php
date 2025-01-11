<?php

namespace App\Http\Controllers;



class AdminController extends Controller
{
    public function index($page = null)
    {
        if ($page) {
            return view($page);
        }

        return view('home');
    }
}