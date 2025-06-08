<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Category = Category::all();

        return response()->json($Category, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        
        $Category = Category::Create($request->validated());

        return response()->json($Category, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show( $id)
    {
        $Category = Category::findOrFail($id);
        $Category->all();
        return response()->json($Category, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, $id)
    {
        $Category = Category::findOrFail($id);
        $Category->update($request->validated());

        return response()->json($Category, 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        $Category = Category::findOrFail($id);
        $Category->delete();

        return response()->json($Category, 204);
    }
}
