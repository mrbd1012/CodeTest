<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductImage;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     *@param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filterProducts = [];
        if($request->filter_from_price){
            $filterProducts[]=['price', '>=', $request->filter_price_start];
        }
        if($request->filter_to_price){
            $filterProducts[] = ['price', '>=', $request->filter_price_end];
        }
        if($request->filter_from_date){
            $filterProducts[] = Carbon::parse($request->filter_from_date)->format('Y-m-d');
        }
        if($request->filter_from_date){
            $filterProducts[] = Carbon::parse($request->filter_from_date)->format('Y-m-d');
        }


        $products = Product::with(['category' => function($query){
            $query->select('id', 'name', 'parent_id')
                ->whereNull('parent_id')
                ->with('childCategories')
                ->orderby('name', 'asc');
        }])
            ->with(['productImages' => function($query){
                $query->select('id', 'image');
            }])
            ->where($filterProducts);
        return response()->json([
            'products' => $products
        ], 200);

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $request->validate([
            'category_id' => 'numeric',
            'name' => 'required|string|max:191',
            'description' => 'required|string',
            'price' => 'required|numeric',
        ],
            [
                'category_id.number' => 'Error with Category field.'
            ]);

        $product = new Product([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
        ]);
        if (!empty($request->featured_image)) {
            $uploding_path = 'public/assets/products/image';
            $file_name = 'product_' . time() . '.' . $request->image->extension();
            $image = Image::make($request->image);
            $image->resize(200, 200);
            $image->save($uploding_path . $file_name);
            $uploaded_image_name_with_path = $uploding_path . $file_name;
            $product->featured_image = $uploaded_image_name_with_path;
        }
        $product->save();

        if (!empty($request->product_images)) {
            foreach ($request->product_images as $image) {
                $productImage = new productImage();

                $productImage->product_id = $product->id;

                $uploding_path = 'public/assets/products/image';
                $file_name = 'product_' . $product->id . "_" . time() . '_' . $image->extension();
                $image = Image::make($image);
                $image->resize(200, 200);
                $image->save($uploding_path . $file_name);
                $uploaded_image_name_with_path = $uploding_path . $file_name;
                $productImage->image = $uploaded_image_name_with_path;
                $productImage->save();
            }
        }

        if($product){
            return response()->json([
                'message' => 'Product created cuccessfully.',
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id)->with(['category' => function($query){
            $query->select('id', 'name', 'parent_id')
                ->whereNull('parent_id')
                ->with('childCategories')
                ->orderby('name', 'asc');
        }])
            ->with(['productImages' => function($query){
                $query->select('id', 'image');
            }])->get();

        if ($product){
            return response()->json([
                'product' => $product,
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
        $product = Product::find($id)->with(['category' => function($query){
            $query->select('id', 'name', 'parent_id')
                ->whereNull('parent_id')
                ->with('childCategories')
                ->orderby('name', 'asc');
        }])
            ->with(['productImages' => function($query){
                $query->select('id', 'image');
            }])->get();

        if ($product){
            return response()->json([
                'product' => $product,
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
            'category_id' => 'numeric',
            'name' => 'required|string|max:191',
            'description' => 'required|string',
            'price' => 'required|numeric',
        ],
            [
                'category_id.number' => 'Error with Category field.'
            ]);

        $product = Product::find($id);
        $product->slug = null;
        $product->update([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
        ]);

        if(!empty($request->featured_image)){
            $uploding_path = 'public/assets/products/image';
            $file_name = 'product_' . time() . '.' . $request->image->extension();
            $image = Image::make($request->image);
            $image->resize(200, 200);
            $image->save($uploding_path . $file_name);
            $uploaded_image_name_with_path = $uploding_path . $file_name;
            $product->featured_image = $uploaded_image_name_with_path;
        }


        $product->save();

        $product->productImages()->delete();

        if (!empty( $request->product_images )) {
            foreach ($request->product_images as $image) {
                $productImage = new productImage();

                $productImage->product_id = $product->id;

                $uploding_path = 'public/assets/products/image';
                $file_name = 'product_' . $product->id . "_" . time() . '_' . $image->extension();
                $image = Image::make($image);
                $image->resize(200, 200);
                $image->save($uploding_path . $file_name);
                $uploaded_image_name_with_path = $uploding_path . $file_name;
                $productImage->image = $uploaded_image_name_with_path;
                $productImage->save();
            }
        }

        if($product){
            return response()->json([
                'message' => 'Product updated!.',
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        $product->productImages()->delete();
        if($product->delete()){
            return response()->json([
                'message' => 'Product deleted!.',
                'status_code' => 200,

            ], 200);
        } else {
            return  response()->json([
                'message' => 'Some error accrued! Please try again.',
                'status_code' => 500,

            ], 500);
        }
    }
}
