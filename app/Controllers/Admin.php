<?php

namespace App\Controllers;

use App\Models\NewsModel;
use App\Models\ProjectsModel;
use App\Models\ReportsModel;
use App\Models\ServicesModel;
use App\Models\UsersModel;

class Admin extends BaseController
{
    public function index()
    {
        $services = new ServicesModel();
        $news     = new NewsModel();
        $reports  = new ReportsModel();
        $users    = new UsersModel();
        $projects = new ProjectsModel();

        $pendingReports = $reports->where('status', 'pending')->countAllResults(false);
        $totalReports   = $reports->countAllResults(true);

        return view('admin/dashboard', [
            'title'           => 'Admin Dashboard — SmartCity PH',
            'totalServices'   => $services->where('is_active', 1)->countAllResults(),
            'totalNews'       => $news->where('is_published', 1)->countAllResults(),
            'pendingReports'  => $pendingReports,
            'totalReports'    => $totalReports,
            'totalCitizens'   => $users->countAllResults(),
            'totalProjects'   => $projects->countAllResults(),
            'recentReports'   => $reports->withDetails()->orderBy('reports.created_at', 'DESC')->limit(5)->find(),
            'recentNews'      => $news->orderBy('created_at', 'DESC')->limit(5)->find(),
            'reportStatus'    => $reports->statusCounts(),
        ]);
    }
}
