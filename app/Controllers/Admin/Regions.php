<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\RegionsModel;
use App\Models\ServicesModel;

class Regions extends BaseController
{
    public function index()
    {
        $regions = new RegionsModel();
        $items   = $regions->orderBy('name', 'ASC')->find();

        $services = new ServicesModel();
        $counts   = [];
        foreach ($items as $r) {
            $counts[$r['id']] = $services->where('region_id', $r['id'])->where('is_active', 1)->countAllResults(true);
        }

        return view('admin/regions/index', [
            'title'    => 'Manage Regions — SmartCity PH',
            'regions'  => $items,
            'counts'   => $counts,
        ]);
    }

    public function create()
    {
        return view('admin/regions/create', [
            'title'   => 'New Region — SmartCity PH',
            'parents' => (new RegionsModel())->regionsOnly()->find(),
        ]);
    }

    public function store()
    {
        $rules = [
            'name' => 'required|max_length[150]',
            'type' => 'required|in_list[region,province,city,municipality]',
        ];
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        $data = $this->collect();
        $data['slug'] = $data['slug'] ?: url_title(strtolower($data['name']), '-', true);
        (new RegionsModel())->insert($data);
        return redirect()->to(base_url('admin/regions'))->with('success', 'Region created.');
    }

    public function edit(int $id)
    {
        $region = (new RegionsModel())->find($id);
        if (! $region) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        return view('admin/regions/edit', [
            'title'   => 'Edit Region — SmartCity PH',
            'region'  => $region,
            'parents' => (new RegionsModel())->regionsOnly()->find(),
        ]);
    }

    public function update(int $id)
    {
        $rules = [
            'name' => 'required|max_length[150]',
            'type' => 'required|in_list[region,province,city,municipality]',
        ];
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        $data = $this->collect();
        $data['slug'] = $data['slug'] ?: url_title(strtolower($data['name']), '-', true);
        (new RegionsModel())->update($id, $data);
        return redirect()->to(base_url('admin/regions'))->with('success', 'Region updated.');
    }

    private function collect(): array
    {
        return [
            'name'       => $this->request->getPost('name'),
            'slug'       => $this->request->getPost('slug'),
            'code'       => $this->request->getPost('code'),
            'type'       => $this->request->getPost('type'),
            'parent_id'  => $this->request->getPost('parent_id') ?: null,
            'latitude'   => $this->request->getPost('latitude') ?: null,
            'longitude'  => $this->request->getPost('longitude') ?: null,
            'population' => $this->request->getPost('population') ?: null,
            'is_active'  => $this->request->getPost('is_active') ? 1 : 0,
        ];
    }
}
