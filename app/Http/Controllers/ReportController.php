<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function __invoke()
    {
        $user_has_permission = Auth::user()->can('view-reports') or Auth::user()->can('generate-report');

        return view('report.index', compact('user_has_permission'));
    }
}
