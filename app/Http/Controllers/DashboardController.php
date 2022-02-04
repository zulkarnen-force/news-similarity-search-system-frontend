<?php

namespace App\Http\Controllers;

use App\Models\Files;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $countadmin = User::where('roles','=','ADMIN')->count();
        $countuser = User::where('roles','=','USER')->count();
        $countfile = Files::query()->count('*');
        $users = User::select(DB::raw("COUNT(*) as count"))
            // ->whereYear("created_at", date('2021'))
            ->groupBy(DB::raw("Month(created_at)"))
            ->pluck('count');
        $files = Files::select(DB::raw("COUNT(*) as count"))
            // ->whereYear("created_at", date('Y'))
            ->groupBy(DB::raw("Month(created_at)"))
            ->pluck('count');
        $reported = DB::table('users')
            ->join('files', 'users.id', '=', 'files.created_by')
            ->select(
                'users.name as name',
                DB::raw('COUNT(files.created_by) as y')
            )
            ->groupBy('users.name')
            ->get();
        return view('contents.dashboard.index',compact('countadmin','countuser','countfile','users','files','reported'));
    }
}