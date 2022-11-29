<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CategoryBussiness;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $category = CategoryBussiness::get();
        return response()->json([
            'success' => true,
            'message' => 'Get Data Category Berhasil',
            'data' => $category
        ], 200);
    }
}
