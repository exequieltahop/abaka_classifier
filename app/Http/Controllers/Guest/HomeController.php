<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    public function index() {
        try {
            return view('pages.guest.home.index');
        } catch (\Throwable $th) {
            /**
             * log error
             * abort 500
             */
            dd($th->getMessage());
            Log::error($th->getMessage());
            abort(500);
        }
    }
}
