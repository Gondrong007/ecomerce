<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Helpers\ResponseFormatter;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    public function all(Request $request)
    {
        $id = $request->input('id');
        $limit = $request->input('limit', 10);
        $name = $request->input('id');
        $show_product = $request->input('show_product');

        if ($id) {
            $category = ProductCategory::with(['products'])->find($id);

            if ($category) {
                return ResponseFormatter::success(
                    $category, 'Data category berhasil diambil'
                );
            }else{
                return ResponseFormatter::error(
                    null, 'Data category tidak ada', 404
                );
            }
        }

        $category = ProductCategory::query();

        if ($name) {
            $category->where('name', 'like', '%'. $name . '%');
        }
        if ($show_product) {
            $category->with('products');
        }
        return ResponseFormatter::success(
            $category->paginate($limit),
            'Data category berhasil diambil'
        );
    }
}
