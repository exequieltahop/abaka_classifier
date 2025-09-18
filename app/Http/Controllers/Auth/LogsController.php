<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LogsController extends Controller
{
    public function index() {
        return view('pages.auth.logs.index');
    }
}
