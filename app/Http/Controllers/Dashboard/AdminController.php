<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        if(view()->exists('dashboard.'.$id)){
            return view('dashboard.'.$id);
        }
        else
        {
            return view('dashboard.404');
        }

    }

}
