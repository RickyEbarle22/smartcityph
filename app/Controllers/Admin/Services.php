<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AgenciesModel;
use App\Models\RegionsModel;
use App\Models\ServicesModel;

class Services extends BaseController
{
    public function index()
    {
        $services = (new ServicesModel())
            ->select('services.*, regions.name as region_name')
            ->join('regions', 'regions.id = services.region_id', 'left')
            ->orderBy('services.created_at', 'DESC')
            ->paginate(15);

        return view('admin/services/index', [
            'title'    => 'Manage Services — SmartCity PH',
            'services' => $services,
            'pager'    => (new ServicesModel())->pager,
        ]);
    }

    public function create()
    {
        return view('admin/services/create', [
            'title'    => 'New Service — SmartCity PH',
            'regions'  => (new RegionsModel())->regionsOnly()->find(),
            'agencies' => (new AgenciesModel())->where('is_active', 1)->orderBy('name', 'ASC')->find(),
        ]);
    }

    public function store()
    {
        $rules = [
            'name'     => 'required|max_length[150]',
            'category' => 'required|max_length[80]',
        ];
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = $this->collectFields();
        $data['slug'] = url_title(strtolower($data['name']), '-', true);

        $img = $this->request->getFile('image');
        if ($img && $img->isValid() && ! $img->hasMoved()) {
            if ($img->getSize() <= 2 * 1024 * 1024 && in_array(strtolower($img->getExtension()), ['jpg', 'jpeg', 'png', 'webp'], true)) {
                $name = $img->getRandomName();
                $img->move(FCPATH . 'uploads/services/', $name);
                $data['image'] = $name;
            }
        }

        (new ServicesModel())->insert($data);
        return redirect()->to(base_url('admin/services'))->with('success', 'Service created.');
    }

    public function edit(int $id)
    {
        $services = new ServicesModel();
        $service  = $services->find($id);
        if (! $service) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        return view('admin/services/edit', [
            'title'    => 'Edit Service — SmartCity PH',
            'service'  => $service,
            'regions'  => (new RegionsModel())->regionsOnly()->find(),
            'agencies' => (new AgenciesModel())->where('is_active', 1)->orderBy('name', 'ASC')->find(),
        ]);
    }

    public function update(int $id)
    {
        $rules = [
            'name'     => 'required|max_length[150]',
            'category' => 'required|max_length[80]',
        ];
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $services = new ServicesModel();
        $current  = $services->find($id);
        if (! $current) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = $this->collectFields();
        $data['slug'] = url_title(strtolower($data['name']), '-', true);

        $img = $this->request->getFile('image');
        if ($img && $img->isValid() && ! $img->hasMoved()) {
            if ($img->getSize() <= 2 * 1024 * 1024 && in_array(strtolower($img->getExtension()), ['jpg', 'jpeg', 'png', 'webp'], true)) {
                $name = $img->getRandomName();
                $img->move(FCPATH . 'uploads/services/', $name);
                $data['image'] = $name;
            }
        }

        $services->update($id, $data);
        return redirect()->to(base_url('admin/services'))->with('success', 'Service updated.');
    }

    public function delete(int $id)
    {
        (new ServicesModel())->delete($id);
        return redirect()->to(base_url('admin/services'))->with('success', 'Service removed.');
    }

    public function toggleFeatured(int $id)
    {
        $services = new ServicesModel();
        $s = $services->find($id);
        if (! $s) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        $services->update($id, ['is_featured' => $s['is_featured'] ? 0 : 1]);
        return redirect()->to(base_url('admin/services'))->with('success', $s['is_featured'] ? 'Removed from Featured.' : 'Added to Featured — now on the homepage.');
    }

    public function toggleActive(int $id)
    {
        $services = new ServicesModel();
        $s = $services->find($id);
        if (! $s) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        $services->update($id, ['is_active' => $s['is_active'] ? 0 : 1]);
        return redirect()->to(base_url('admin/services'))->with('success', $s['is_active'] ? 'Service deactivated — hidden from public.' : 'Service activated — visible on /services.');
    }

    private function collectFields(): array
    {
        return [
            'name'            => $this->request->getPost('name'),
            'category'        => $this->request->getPost('category'),
            'short_desc'      => $this->request->getPost('short_desc'),
            'description'     => $this->request->getPost('description'),
            'icon'            => $this->request->getPost('icon') ?: 'fa-cog',
            'requirements'    => $this->request->getPost('requirements'),
            'steps'           => $this->request->getPost('steps'),
            'fee'             => $this->request->getPost('fee'),
            'processing_time' => $this->request->getPost('processing_time'),
            'office'          => $this->request->getPost('office'),
            'contact'         => $this->request->getPost('contact'),
            'website'         => $this->request->getPost('website'),
            'agency'          => $this->request->getPost('agency'),
            'agency_id'       => $this->request->getPost('agency_id') ?: null,
            'region_id'       => $this->request->getPost('region_id') ?: null,
            'is_nationwide'   => $this->request->getPost('is_nationwide') ? 1 : 0,
            'is_featured'     => $this->request->getPost('is_featured') ? 1 : 0,
            'is_popular'      => $this->request->getPost('is_popular') ? 1 : 0,
            'is_active'       => $this->request->getPost('is_active') ? 1 : 0,
        ];
    }
}
