<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::whereNull('parent_id')
            ->with('childCategories')
            ->orderby('name', 'asc')
            ->paginate(5);
        return response()->json([
            'categories' => $categories
        ], 200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'parent_id' => 'numeric',
            'name' => 'required|string|max:191',
            ]);

        $category = new Category([
            'name' => $request->name,
            'parent_id' => $request->parent_id,
        ]);
        if($category->save()){
            return response()->json([
                'message' => 'New category created successfully.',
                'status_code' => 200,

            ], 200);
        } else {
            return  response()->json([
                'message' => 'Some error accrued! Please try again.',
                'status_code' => 500,

            ], 500);
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::find($id);

        if($category){
            return response()->json([
                'category' => $category,
                'status_code' => 200,

            ], 200);
        } else {
            return  response()->json([
                'message' => 'Some error accrued! Please try again.',
                'status_code' => 500,

            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'parent_id' => 'numeric',
            'name' => 'required|string|max:191',
        ]);

        $category = Category::find($id);
        $category->slug = null;
        $category->update([
            'parent_id' => $request->parent_id,
            'name' => $request->name
        ]);

        if($category){
            return response()->json([
                'message' => 'Category updated successfully.',
                'status_code' => 200

            ], 200);
        } else {
            return  response()->json([
                'message' => 'Some error accrued! Please try again.',
                'status_code' => 500,

            ], 500);
        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        if($category->delete()){
            return response()->json([
                'message' => 'Category deleted successfully.',
                'status_code' => 200

            ], 200);
        } else {
            return  response()->json([
                'message' => 'Some error accrued! Please try again.',
                'status_code' => 500,

            ], 500);
        }
    }
}
