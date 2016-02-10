<?php

namespace CuentasFacturas\Http\Controllers;

use Illuminate\Http\Request;

use CuentasFacturas\Http\Requests;
use CuentasFacturas\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        return view('home.home');
    }
}
