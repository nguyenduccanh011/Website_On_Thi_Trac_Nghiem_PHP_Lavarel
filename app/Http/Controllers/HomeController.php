<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $exams = Exam::where('is_active', true)
                    ->with(['category', 'questions'])
                    ->latest()
                    ->take(6)
                    ->get();

        return view('home', compact('exams'));
    }
}