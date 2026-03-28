<?php

namespace App\Services;

use App\Interfaces\ProductRepositoryInterface;
use Carbon\Carbon;

class ProductService
{
    protected $productRepo;

    public function __construct(ProductRepositoryInterface $productRepo)
    {
        $this->productRepo = $productRepo;
    }

    public function getProductDetails($id)
    {
        return $this->productRepo->findById($id);
    }
        
    public function filter($request)
    {
        return $this->productRepo->filterProducts(
            $request->category_ids,
            $request->company_ids
        );
    }

    // public function getProductDetails($slug)
    // {
    //     $product = $this->productRepo->findBySlug($slug);

    //     if (!$product) {
    //         return null;
    //     }

    //     $genericIds = json_decode($product->generic_id ?? '[]', true);

    //     return [
    //         'product' => $product,
    //         'generic' => $this->productRepo->getGenerics($genericIds),
    //         'alternative_brands' => $this->productRepo->getAlternativeBrands($product, $genericIds),
    //         'recommended_products' => $this->productRepo->getRecommendedProducts($product),
    //         'delivery_date' => Carbon::now()->addDay()->toDateString(),
    //         'manufacturer' => $this->productRepo->getManufacturer($product->brand_id),
    //         'category' => $this->productRepo->getCategory($product->category_id),
    //     ];
    // }
}