<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Meal;
use App\Models\Category;
use Illuminate\Http\Request;

class MealAdminController extends Controller
{
    public function index()
    {
        return view('admin.meals.index', [
            'meals' => Meal::with('category')->get()
        ]);
    }

    public function create()
    {
        return view('admin.meals.create', [
            'categories' => Category::all()
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => 'required',
            'name' => 'required',
            'description' => 'nullable',
            'price' => 'required|numeric',
            'image' => 'nullable|image'
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('meals', 'public');
        }

        Meal::create($data);

        return redirect('/admin/meals');
    }

    public function edit(Meal $meal)
{
    return view('admin.meals.edit', [
        'meal' => $meal,
        'categories' => Category::all()
    ]);
}

public function update(Request $request, Meal $meal)
{
    $data = $request->validate([
        'category_id' => 'required',
        'name' => 'required',
        'description' => 'nullable',
        'price' => 'required|numeric',
        'image' => 'nullable|image'
    ]);

    if ($request->hasFile('image')) {
        $data['image'] = $request->file('image')->store('meals', 'public');
    }

    $meal->update($data);

    return redirect('/admin/meals')->with('success', 'Meal updated successfully.');
}

public function destroy(Meal $meal)
{
    $meal->delete();
    return redirect('/admin/meals')->with('success', 'Meal deleted successfully.');
}
    public function toggleAvailability(Meal $meal)
{
    $meal->is_available = !$meal->is_available;
    $meal->save();

    return back()->with('success', 'Meal status updated.');
}

}
