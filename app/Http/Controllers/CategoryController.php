<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // all categories
    public function show()
    {
        $categories = Category::get();
        return view('Categories.Categories', ['categories' => $categories]);
    }

    // all categories
    public function all()
    {
        $categories = Category::get();

        return response()->json([
            'success' => true,
            'categories' => $categories
        ]);
    }

    // get category by id
    public function cateById($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'error' => 'category not found'
            ], 400);
        }

        return response()->json([
            'success' => true,
            'category' => $category
        ]);
    }

    // category form
    public function form()
    {
        return view('Categories.create-category');
    }

    // add category
    public function add(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $category_old = Category::where('name', $request->name)->first();
        if (!empty($category_old)) {
            return redirect()->route('categories.form')->with('error', 'category already existed');
        }

        $category = new Category();
        $category->name = $request->name;
        $category->save();
        return redirect()->route('categories.show');
    }

    // category form
    public function formUpdate($id)
    {
        $category = Category::find($id);
        return view('Categories.edit-category', ['category' => $category]);
    }

    // add category
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $category_old = Category::where('name', $request->name)->first();
        if (!empty($category_old)) {
            return redirect()->route('categories.formUpdate', $id)->with('error', 'category already existed');
        }

        $category = Category::find($id);
        if (!$category) {
            return response()->json([
                'error' => 'category not found'
            ], 400);
        }

        $category->name = $request->name;
        $category->save();
        return redirect()->route('categories.show');
    }

    // delete a category
    public function delete($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'error' => 'category not found'
            ], 400);
        }

        $category->delete();
        return redirect()->route('categories.show');
    }
}
