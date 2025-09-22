<?php

namespace App\Http\Controllers\Admin\Pages;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of categories.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Fetch categories along with their children
        $categories = Category::with('children')->whereNull('parent_id')->get();

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form to create a new category.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Fetch all categories to use in the parent category dropdown
        $categories = Category::whereNull('parent_id')->get();

        return view('admin.categories.create', compact('categories'));
    }

    /**
     * Store a newly created category.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        // Create the category
        Category::create($validatedData);

        // Redirect back with a success message
        return redirect()->route('categories.index')->with('success', 'Category created successfully!');
    }

    /**
     * Show the form to edit the specified category.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        // Find the category
        $category = Category::findOrFail($id);

        // Fetch all categories to use in the parent category dropdown
        $categories = Category::whereNull('parent_id')->get();

        return view('admin.categories.edit', compact('category', 'categories'));
    }

    /**
     * Update the specified category.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        // Find the category and update it
        $category = Category::findOrFail($id);
        $category->update($validatedData);

        // Redirect back with a success message
        return redirect()->route('categories.index')->with('success', 'Category updated successfully!');
    }

    /**
     * Show the form to edit the specified child category.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit_Child($id)
    {
        // Find the child category
        $category = Category::findOrFail($id);

        // Fetch all categories to use in the parent category dropdown
        $categories = Category::whereNull('parent_id')->get();

        return view('admin.categories.edit_child', compact('category', 'categories'));
    }

    /**
     * Update the specified child category.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update_Child(Request $request, $id)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        // Find the child category and update it
        $category = Category::findOrFail($id);
        $category->update($validatedData);

        // Redirect back with a success message
        return redirect()->route('categories.index')->with('success', 'Child category updated successfully!');
    }

    /**
     * Remove the specified category from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        // Find the category and delete it
        $category = Category::findOrFail($id);
        $category->delete();

        // Redirect back with a success message
        return redirect()->route('categories.index')->with('success', 'Category deleted successfully!');
    }

    /**
     * Remove the specified child category from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroyChild($id)
    {
        // Find the child category and delete it
        $category = Category::findOrFail($id);
        $category->delete();

        // Redirect back with a success message
        return redirect()->route('categories.index')->with('success', 'Child category deleted successfully!');
    }
}
