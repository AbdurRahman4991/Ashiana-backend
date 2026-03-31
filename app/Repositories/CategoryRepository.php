<?php

namespace App\Repositories;

use App\Interfaces\CategoryRepositoryInterface;
use App\Models\CategoryManage;


class CategoryRepository implements CategoryRepositoryInterface
{
    public function getAll()
    {
        return CategoryManage::select('id', 'name')->latest()->get();
    }
}
