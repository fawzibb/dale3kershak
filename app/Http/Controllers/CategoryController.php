<?php

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return Category::all();
    }

    public function store(Request $request)
    {
        $category = Category::create($request->validate([
            'name' => 'required',
            'image' => 'nullable'
        ]));

        return response()->json($category, 201);
    }

    public function update(Request $request, Category $category)
    {
        $category->update($request->validate([
            'name' => 'required',
            'image' => 'nullable'
        ]));

        return response()->json($category);
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return response()->json(['message' => 'Deleted']);
    }
}
