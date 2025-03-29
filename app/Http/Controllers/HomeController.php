<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = \DB::table('exam_categories')
            ->whereIn('exam_categories.correct_column_name', [1, 2, 3]) // Update 'correct_column_name'
            ->get();

        return view('home', compact('categories'));
    }
}