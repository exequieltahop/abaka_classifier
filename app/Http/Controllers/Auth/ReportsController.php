<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\InferencedImage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    public function index()
    {
        $data = [];

        if (Auth::user()->role == 1) {
            $data['total_users'] = User::whereNot('role', 1)->get()->count();
            $data['total_experts'] = User::where('role', 2)->get()->count();
            $data['total_regular_users'] = User::where('role', 3)->get()->count();
        }

        $data['validated_images'] = InferencedImage::whereNot('status', 1)->get()->count();
        $data['unvalidated_images'] = InferencedImage::where('status', 1)->get()->count();
        $data['accurate_validation'] = InferencedImage::where('status', 2)->get()->count();
        $data['less_accurate_validation'] = InferencedImage::where('status', 3)->get()->count();
        $data['not_accurate_validation'] = InferencedImage::where('status', 4)->get()->count();

        return view('pages.auth.reports.index', $data);
    }

    public function getChartData(Request $request)
    {
        $year = urldecode($request->year);

        $data = DB::table('inferenced_images')
        ->join('users', 'users.id', '=', 'inferenced_images.user_id')
        ->select(
            'users.brgy',
            'inferenced_images.system_predicted_class',
            DB::raw('COUNT(*) as total')
        )
        ->whereYear('inferenced_images.created_at', $year)
        ->groupBy('users.brgy', 'inferenced_images.system_predicted_class')
        ->get();
            
        return response()->json($data);
    }
}
