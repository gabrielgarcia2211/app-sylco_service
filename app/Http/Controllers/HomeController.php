<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        if (auth()->user()->hasRole('Coordinador')) {

            $dataContratista = DB::select("SELECT count('role_id') as contratista FROM model_has_roles WHERE role_id = 3 ");
            return view('dash.coordinador.index')->with(compact('dataContratista'));

        }
    }
}
