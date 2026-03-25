<?php

namespace App\Http\Controllers\Reporting;

use App\Http\Controllers\Controller;
use App\Services\Reporting\ReportingService;

class ReportingController extends Controller
{
    public function __construct(private readonly ReportingService $service)
    {
    }

    public function index()
    {
        $stats = $this->service->getDashboardStats();

        return view('admin.reports.index', compact('stats'));
    }
}

