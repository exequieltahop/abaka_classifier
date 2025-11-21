<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    /**
     * Return the landing page home
     *
     * @return Illuminate\Contracts\View\View
     */
    public function index(): View {
        return view('pages.guest.home.index');
    }

}
