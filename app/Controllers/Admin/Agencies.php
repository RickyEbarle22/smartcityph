<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AgenciesModel;

class Agencies extends BaseController
{
    public function index()
    {
        $list = (new AgenciesModel())
            ->orderBy('name', 'ASC')
            ->paginate(20);

        return view('admin/agencies/index', [
            'title'    => 'Manage Agencies — SmartCity PH',
            'agencies' => $list,
            'pager'    => (new AgenciesModel())->pager,
        ]);
    }

    public function create()
    {
        return view('admin/agencies/create', [
            'title' => 'New Agency — SmartCity PH',
        ]);
    }

    public function store()
    {
        $rules = ['name' => 'required|max_length[150]'];
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = $this->collectFields();
        $data['slug'] = url_title(strtolower($data['name']), '-', true);
        $data['logo'] = $this->saveLogo();

        (new AgenciesModel())->insert($data);
        return redirect()->to(base_url('admin/agencies'))->with('success', 'Agency created.');
    }

    public function edit(int $id)
    {
        $model  = new AgenciesModel();
        $agency = $model->find($id);
        if (! $agency) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        return view('admin/agencies/edit', [
            'title'  => 'Edit Agency — SmartCity PH',
            'agency' => $agency,
        ]);
    }

    public function update(int $id)
    {
        $rules = ['name' => 'required|max_length[150]'];
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $model   = new AgenciesModel();
        $current = $model->find($id);
        if (! $current) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = $this->collectFields();
        $data['slug'] = url_title(strtolower($data['name']), '-', true);

        if ($logo = $this->saveLogo()) {
            $data['logo'] = $logo;
        }

        $model->update($id, $data);
        return redirect()->to(base_url('admin/agencies'))->with('success', 'Agency updated.');
    }

    public function delete(int $id)
    {
        (new AgenciesModel())->delete($id);
        return redirect()->to(base_url('admin/agencies'))->with('success', 'Agency removed.');
    }

    public function toggleActive(int $id)
    {
        $model = new AgenciesModel();
        $a = $model->find($id);
        if (! $a) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        $model->update($id, ['is_active' => $a['is_active'] ? 0 : 1]);
        return redirect()->to(base_url('admin/agencies'))->with('success', $a['is_active'] ? 'Agency hidden from public directory.' : 'Agency visible on /agencies.');
    }

    private function collectFields(): array
    {
        return [
            'name'        => $this->request->getPost('name'),
            'acronym'     => $this->request->getPost('acronym'),
            'description' => $this->request->getPost('description'),
            'category'    => $this->request->getPost('category'),
            'website'     => $this->request->getPost('website'),
            'email'       => $this->request->getPost('email'),
            'phone'       => $this->request->getPost('phone'),
            'address'     => $this->request->getPost('address'),
            'head_name'   => $this->request->getPost('head_name'),
            'head_title'  => $this->request->getPost('head_title'),
            'is_active'   => $this->request->getPost('is_active') ? 1 : 0,
        ];
    }

    private function saveLogo(): ?string
    {
        $img = $this->request->getFile('logo');
        if (! $img || ! $img->isValid() || $img->hasMoved()) {
            return null;
        }
        if ($img->getSize() > 2 * 1024 * 1024) {
            return null;
        }
        if (! in_array(strtolower($img->getExtension()), ['jpg', 'jpeg', 'png', 'webp', 'svg'], true)) {
            return null;
        }
        $dir = FCPATH . 'uploads/agencies/';
        if (! is_dir($dir)) {
            @mkdir($dir, 0777, true);
        }
        $name = $img->getRandomName();
        $img->move($dir, $name);
        return $name;
    }
}
