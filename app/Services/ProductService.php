<?php

// namespace App\Services;

// use App\Repositories\Interfaces\ProductRepositoryInterface;

// class ProductService
// {
//     protected $productRepo;

//     public function __construct(ProductRepositoryInterface $productRepo)
//     {
//         $this->productRepo = $productRepo;
//     }

//     public function getProductDetails($id)
//     {
//         $product = $this->productRepo->findById($id);

//         if (!$product) {
//             return null;
//         }

//         return $product;
//     }
// }


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
}