<?php
namespace App\Interfaces;

interface ProductRepositoryInterface
{
    public function getTrendingProducts(int $limit = 10);
}
