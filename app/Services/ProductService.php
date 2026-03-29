<?php

namespace App\Services;

use App\Interfaces\ProductRepositoryInterface;
use Carbon\Carbon;
use App\Models\ProductManage;

class ProductService
{
    protected $productRepo;

    public function __construct(ProductRepositoryInterface $productRepo)
    {
        $this->productRepo = $productRepo;
    }

    public function getProductDetails($id)
    {
        $product = $this->productRepo->findById($id);

        if (!$product) {
            return null;
        }

        /// 🔹 Generic IDs (relation থেকে)

        $genericIds = json_decode($product->generic_id ?? '[]', true);

        /// 🔥 Alternative Brands
        $alternativeBrands = ProductManage::where('id', '!=', $product->id)
            ->where('brand_id', '!=', $product->brand_id)
            ->where(function ($q) use ($genericIds) {
                foreach ($genericIds as $gid) {
                    $q->orWhereJsonContains('generic_id', (string)$gid); // 🔥 important
                }
            })
        ->take(5)
        ->get();

        /// 🔥 Recommended Products
        $recommendedProducts = ProductManage::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->inRandomOrder()
            ->take(5)
            ->get();

        return [
            'product' => $product,
            'alternativeBrands' => $alternativeBrands,
            'recommendedProducts' => $recommendedProducts,
        ];
    }

    public function filter($request)
    {
        return $this->productRepo->filterProducts(
            $request->category_ids,
            $request->company_ids
        );
    }
}
