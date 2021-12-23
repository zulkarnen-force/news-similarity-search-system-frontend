<?php

namespace App\Http\Controllers;

use App\Models\Files;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Testing\Constraints\CountInDatabase;

class FrontendController extends Controller
{
    public function index(Request $request)
    {
        return view('contents.dashboard.index');
    }
    
}
