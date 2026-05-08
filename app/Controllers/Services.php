<?php

namespace App\Controllers;

use App\Models\FeedbackModel;
use App\Models\RegionsModel;
use App\Models\ServicesModel;

class Services extends BaseController
{
    public function index()
    {
        $services = new ServicesModel();
        $regions  = new RegionsModel();

        $regionId = $this->request->getGet('region') ? (int) $this->request->getGet('region') : null;
        $category = $this->request->getGet('category');
        $q        = $this->request->getGet('q');

        $builder = $services->search($regionId, $category, $q);
        $perPage = 12;
        $items   = $builder->paginate($perPage);
        $pager   = $services->pager;

        return view('services/index', [
            'title'        => 'Government Services — SmartCity PH',
            'items'        => $items,
            'pager'        => $pager,
            'perPage'      => $perPage,
            'regions'      => $regions->regionsOnly()->find(),
            'categories'   => array_keys($services->categoryCounts()),
            'selRegion'    => $regionId,
            'selCategory'  => $category,
            'selQuery'     => $q,
        ]);
    }

    public function search()
    {
        return $this->index();
    }

    public function detail(string $slug)
    {
        $services = new ServicesModel();
        $service  = $services->findBySlug($slug);

        if (! $service) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $feedback = new FeedbackModel();
        $reviews  = $feedback->approvedForService((int) $service['id']);

        $related = $services->select('services.*, regions.name as region_name')
            ->join('regions', 'regions.id = services.region_id', 'left')
            ->where('services.category', $service['category'])
            ->where('services.id !=', $service['id'])
            ->where('services.is_active', 1)
            ->limit(3)
            ->find();

        return view('services/detail', [
            'title'    => $service['name'] . ' — SmartCity PH',
            'service'  => $service,
            'reviews'  => $reviews,
            'related'  => $related,
        ]);
    }

    public function apiSearch()
    {
        $services = new ServicesModel();
        $q        = $this->request->getGet('q');
        $regionId = $this->request->getGet('region_id') ? (int) $this->request->getGet('region_id') : null;

        $rows = $services->search($regionId, null, $q)->limit(8)->find();

        $out = array_map(static fn ($r) => [
            'id'         => (int) $r['id'],
            'name'       => $r['name'],
            'slug'       => $r['slug'],
            'category'   => $r['category'],
            'agency'     => $r['agency'],
            'short_desc' => $r['short_desc'],
        ], $rows);

        return $this->response->setJSON(['data' => $out]);
    }

    public function apiRegions()
    {
        $regions = (new RegionsModel())->regionsOnly()->find();
        return $this->response->setJSON(['data' => $regions]);
    }
}
