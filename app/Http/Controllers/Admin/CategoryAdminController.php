<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryAdminController extends Controller
{
    public function index()
    {
        return view('admin.categories.index', ['categories' => Category::all()]);
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'image' => 'image'
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('categories', 'public');
        }

        Category::create($data);
        return redirect('/admin/categories');
    }
     public function destroy(Category $category)
    {
        $category->delete();
        return redirect('/admin/categories');
    }

    public function edit(Category $category)
{
    return view('admin.categories.edit', compact('category'));
}

public function update(Request $request, Category $category)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'image' => 'nullable|image'
    ]);

    $category->name = $request->name;

    if ($request->hasFile('image')) {
        $category->image = $request->file('image')->store('categories', 'public');
    }

    $category->save();

    return redirect('/admin/categories')->with('success', 'Category updated successfully!');
}

    
}
