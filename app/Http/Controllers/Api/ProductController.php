<?php

// namespace App\Http\Controllers\Api;

// use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;
// use App\Interfaces\ProductRepositoryInterface;
// use App\Http\Resources\ProductResource;
// use App\Models\ProductManage;
// use Carbon\Carbon;
// use App\Services\productService;

// class ProductController extends Controller
// {
//     private $productRepo;
//     protected $productService;

//         public function __construct(ProductRepositoryInterface $productRepo)
//         {
//             $this->productRepo = $productRepo;
//              $this->productService = $productService;
//         }

//         public function trending()
//         {
//             $products = $this->productRepo->getTrendingProducts(10);

//             return response()->json([
//                 'status' => true,
//                 'data' => ProductResource::collection($products)
//             ]);
//         }

//         public function newProducts()
//         {
//             $products = ProductManage::with(['category','manufacturing'])
//                 ->where('created_at', '>=', Carbon::now()->subDays(30))
//                 ->paginate(10);

//             return response()->json([
//                 'status' => true,
//                 'data' => $products
//             ]);
//         }

//     public function search(Request $request)
//     {
//         $search = $request->search;

//         $products = ProductManage::with(['manufacturing','generic','category'])
//             ->where('name', 'LIKE', "%$search%")
//             ->orWhereHas('manufacturing', function ($q) use ($search) {
//                 $q->where('name', 'LIKE', "%$search%");
//             })
//             ->orWhereHas('category', function ($q) use ($search) {
//                 $q->where('name', 'LIKE', "%$search%");
//             })
//             ->select(
//                 'id',
//                 'name',
//                 'slug',
//                 'image',
//                 'brand_id',
//                 'category_id',
//                 'selling_price',
//                 'discounted_price',
//                 'discount_percent',
//                 'stock'
//             )
//             ->limit(20)
//             ->get();

//         return response()->json([
//             'status' => true,
//             'data' => $products
//         ]);
//     }

//     public function show($id)
//     {
//         $product = $this->productService->getProductDetails($id);

//         if (!$product) {
//             return response()->json([
//                 'success' => false,
//                 'message' => 'Product not found'
//             ], 404);
//         }

//         return response()->json([
//             'success' => true,
//             'message' => 'Product details fetched successfully',
//             'data' => new ProductResource($product)
//         ]);
//     }
// }


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\ProductRepositoryInterface;
use App\Http\Resources\ProductResource;
use App\Models\ProductManage;
use Carbon\Carbon;
use App\Services\ProductService;

class ProductController extends Controller
{
    private $productRepo;
    protected $productService;

    public function __construct(
        ProductRepositoryInterface $productRepo,
        ProductService $productService
    ) {
        $this->productRepo = $productRepo;
        $this->productService = $productService;
    }

    public function trending()
    {
        $products = $this->productRepo->getTrendingProducts(10);

        return response()->json([
            'status' => true,
            'data' => $products // Resource না দিলেও চলবে এখানে
        ]);
    }

    public function newProducts()
    {
        $products = ProductManage::with(['category','manufacturing'])
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->paginate(10);

        return response()->json([
            'status' => true,
            'data' => $products
        ]);
    }

    public function search(Request $request)
    {
        $search = $request->search;

        $products = ProductManage::with(['manufacturing','generic','category'])
            ->where('name', 'LIKE', "%$search%")
            ->orWhereHas('manufacturing', function ($q) use ($search) {
                $q->where('name', 'LIKE', "%$search%");
            })
            ->orWhereHas('category', function ($q) use ($search) {
                $q->where('name', 'LIKE', "%$search%");
            })
            ->select(
                'id',
                'name',
                'slug',
                'image',
                'brand_id',
                'category_id',
                'selling_price',
                'discounted_price',
                'discount_percent',
                'stock'
            )
            ->limit(20)
            ->get();

        return response()->json([
            'status' => true,
            'data' => $products
        ]);
    }

    public function show($id)
    {
        $product = $this->productService->getProductDetails($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Product details fetched successfully',
            'data' => new ProductResource($product)
        ]);
    }
}
