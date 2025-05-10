<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:categories,name',
                'description' => 'nullable|string'
            ]);

            $category = Category::create([
                'name' => $validated['name'],
                'description' => $validated['description'],
                'category_id' => Str::random(10),
            ]);

            return redirect()->route('admin.categories.index')
                ->with('success', 'Danh mục đã được tạo thành công.');
                
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Có lỗi xảy ra khi tạo danh mục: ' . $e->getMessage())
                ->withInput();
        }
    }
} 