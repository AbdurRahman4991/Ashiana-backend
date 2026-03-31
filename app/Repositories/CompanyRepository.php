<?php

namespace App\Repositories;
use App\Interfaces\CompanyRepositoryInterface;
use App\Models\ManufacturingManage;

class CompanyRepository implements CompanyRepositoryInterface
{
    public function getAll()
    {
        return ManufacturingManage::select('id', 'name')->latest()->get();
    }
}