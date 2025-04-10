<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $query = Exam::with('category', 'questions');

        if ($request->has('search') && $request->search) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }

        $exams = $query->latest()->paginate(6)->appends($request->query());

        $categories = Category::all();

        return view('home', compact('exams', 'categories'));
    }
}