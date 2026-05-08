<?php

namespace App\Controllers;

use App\Models\ProjectsModel;
use App\Models\RegionsModel;

class Transparency extends BaseController
{
    public function index()
    {
        $projects = new ProjectsModel();
        $regions  = (new RegionsModel())->regionsOnly()->find();

        $regionId = $this->request->getGet('region') ? (int) $this->request->getGet('region') : null;
        $status   = $this->request->getGet('status');

        $b = $projects->withRegion();
        if ($regionId) {
            $b = $b->where('projects.region_id', $regionId);
        }
        if ($status) {
            $b = $b->where('projects.status', $status);
        }

        return view('transparency/index', [
            'title'        => 'Government Transparency — SmartCity PH',
            'projects'     => $b->orderBy('projects.budget', 'DESC')->find(),
            'regions'      => $regions,
            'totalBudget'  => $projects->totalBudget(),
            'statusCounts' => $projects->statusCounts(),
            'selRegion'    => $regionId,
            'selStatus'    => $status,
        ]);
    }
}
