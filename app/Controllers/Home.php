<?php

namespace App\Controllers;

use App\Models\NewsModel;
use App\Models\ProjectsModel;
use App\Models\RegionsModel;
use App\Models\ServicesModel;
use App\Models\ReportsModel;
use App\Models\UsersModel;

class Home extends BaseController
{
    public function index()
    {
        $services = new ServicesModel();
        $news     = new NewsModel();
        $regions  = new RegionsModel();
        $projects = new ProjectsModel();
        $users    = new UsersModel();
        $reports  = new ReportsModel();

        $latestServices = (new ServicesModel())
            ->select('services.*, regions.name as region_name')
            ->join('regions', 'regions.id = services.region_id', 'left')
            ->where('services.is_active', 1)
            ->orderBy('services.created_at', 'DESC')
            ->limit(6)
            ->find();

        $recentReports = (new ReportsModel())
            ->select('reports.id, reports.reference, reports.category, reports.location, reports.status, reports.priority, reports.created_at, regions.name as region_name')
            ->join('regions', 'regions.id = reports.region_id', 'left')
            ->orderBy('reports.created_at', 'DESC')
            ->limit(6)
            ->find();

        return view('home/index', [
            'title'             => 'SmartCity PH — Government Services Portal',
            'featuredServices'  => $services->featured(6),
            'latestServices'    => $latestServices,
            'recentReports'     => $recentReports,
            'categoryCounts'    => $services->categoryCounts(),
            'totalServices'     => $services->where('is_active', 1)->countAllResults(),
            'totalRegions'      => $regions->where('type', 'region')->countAllResults(),
            'totalCitizens'     => $users->countAllResults(),
            'totalReports'      => $reports->countAllResults(),
            'regions'           => $regions->regionsOnly()->find(),
            'latestNews'        => $news->latest(3),
            'featuredProjects'  => $projects->withRegion()->orderBy('progress', 'DESC')->limit(3)->find(),
        ]);
    }

    public function about()
    {
        return view('home/about', ['title' => 'About — SmartCity PH']);
    }

    public function contact()
    {
        return view('home/contact', ['title' => 'Contact — SmartCity PH']);
    }

    public function submitContact()
    {
        $rules = [
            'name'    => 'required|min_length[2]|max_length[100]',
            'email'   => 'required|valid_email',
            'subject' => 'required|max_length[150]',
            'message' => 'required|min_length[10]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        return redirect()->to(base_url('contact'))->with('success', 'Thank you for contacting SmartCity PH. We will respond shortly.');
    }

    public function emergency()
    {
        return view('home/emergency', ['title' => 'Emergency Hotlines — SmartCity PH']);
    }
}
