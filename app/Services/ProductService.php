<?php

namespace App\Services;

use App\Interfaces\ProductRepositoryInterface;

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
}