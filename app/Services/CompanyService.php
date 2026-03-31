<?php

namespace App\Services;

use App\Interfaces\CompanyRepositoryInterface;

class CompanyService
{
    protected $companyRepo;

    public function __construct(CompanyRepositoryInterface $companyRepo)
    {
        $this->companyRepo = $companyRepo;
    }

    public function getAllCompanies()
    {
        return $this->companyRepo->getAll();
    }
}