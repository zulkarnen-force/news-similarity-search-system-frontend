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
        // count user->admin->card admin
        $admin = User::where('roles','=','ADMIN')->count();
        
        // count user->admin->card user
        $user = User::where('roles','=','USER')->count();

        // count files->admin->card sum files
        $file = Files::query()->count('*');

        // count untuk users -> linechart
        $users = User::select(DB::raw("COUNT(*) as count"))
            // ->whereYear("created_at", date('2021'))
            ->groupBy(DB::raw("Month(created_at)"))
            ->pluck('count');

        // count untuk files-> linechart
        $files = Files::select(DB::raw("COUNT(*) as count"))
            // ->whereYear("created_at", date('Y'))
            ->groupBy(DB::raw("Month(created_at)"))
            ->pluck('count');
        
        // count reporter "name" && "count->files->uploaded"
        $reporter = DB::table('users')
            ->join('files', 'users.id', '=', 'files.created_by')
            ->select(
                'users.name as name',
                DB::raw('COUNT(files.created_by) as y')
            )
            ->groupBy('users.name')
            ->get();
        
        return view('contents.dashboard.index',compact(
            'admin',
            'user',
            'file',
            'users',
            'files',
            'reporter'
        ));
    }
}