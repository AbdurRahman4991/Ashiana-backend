<?php
namespace App\Interfaces;

interface ProductRepositoryInterface
{
    public function getTrendingProducts(int $limit = 10);

    public function findById($id);
    
    public function findBySlug($slug);

    public function getGenerics(array $genericIds);

    public function getAlternativeBrands($product, array $genericIds);

    public function getRecommendedProducts($product);

    public function getManufacturer($brandId);

    public function getCategory($categoryId);

}
