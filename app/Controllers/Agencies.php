<?php

namespace App\Controllers;

use App\Models\AgenciesModel;
use App\Models\ServicesModel;

class Agencies extends BaseController
{
    public function index()
    {
        $agencies = new AgenciesModel();

        $q        = trim((string) $this->request->getGet('q'));
        $category = trim((string) $this->request->getGet('category'));

        $list = $agencies->search($q ?: null, $category ?: null)->find();

        return view('agencies/index', [
            'title'      => 'Government Agencies — SmartCity PH',
            'agencies'   => $list,
            'categories' => $agencies->categories(),
            'q'          => $q,
            'selCategory'=> $category,
            'total'      => count($list),
        ]);
    }

    public function detail(string $slug)
    {
        $agencies = new AgenciesModel();
        $agency   = $agencies->findBySlug($slug);

        if (! $agency) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Services linked to this agency by id OR matching acronym/name (legacy text field)
        $services = (new ServicesModel())
            ->select('services.*, regions.name as region_name')
            ->join('regions', 'regions.id = services.region_id', 'left')
            ->where('services.is_active', 1)
            ->groupStart()
                ->where('services.agency_id', $agency['id'])
                ->orLike('services.agency', $agency['acronym'] ?: $agency['name'])
            ->groupEnd()
            ->orderBy('services.is_featured', 'DESC')
            ->orderBy('services.name', 'ASC')
            ->findAll(20);

        return view('agencies/detail', [
            'title'    => esc($agency['name']) . ' — SmartCity PH',
            'agency'   => $agency,
            'services' => $services,
        ]);
    }
}
