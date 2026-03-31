<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CompanyService;

class CompanyController extends Controller
{
     protected $companyService;

    public function __construct(CompanyService $companyService)
    {
        $this->companyService = $companyService;
    }

    public function index()
    {
        $data = $this->companyService->getAllCompanies();

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
}
