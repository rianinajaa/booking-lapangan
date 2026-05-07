<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function admin()
    {
        return view('admin.dashboard');
    }

    public function guru()
    {
        return view('guru.dashboard');
    }

    public function user()
    {
        return view('user.dashboard');
    }
}