<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AgenciesModel;
use App\Models\ProjectsModel;
use App\Models\RegionsModel;

class Projects extends BaseController
{
    public function index()
    {
        $list = (new ProjectsModel())
            ->select('projects.*, regions.name as region_name')
            ->join('regions', 'regions.id = projects.region_id', 'left')
            ->orderBy('projects.created_at', 'DESC')
            ->paginate(15);

        return view('admin/projects/index', [
            'title'    => 'Manage Projects — SmartCity PH',
            'projects' => $list,
            'pager'    => (new ProjectsModel())->pager,
        ]);
    }

    public function create()
    {
        return view('admin/projects/create', [
            'title'    => 'New Project — SmartCity PH',
            'regions'  => (new RegionsModel())->regionsOnly()->find(),
            'agencies' => (new AgenciesModel())->active()->orderBy('name', 'ASC')->findAll(),
        ]);
    }

    public function store()
    {
        $rules = [
            'title'  => 'required|max_length[255]',
            'status' => 'required',
        ];
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = $this->collectFields();
        $data['image'] = $this->saveImage() ?: null;

        (new ProjectsModel())->insert(array_filter($data, static fn ($v) => $v !== null));
        return redirect()->to(base_url('admin/projects'))->with('success', 'Project created.');
    }

    public function edit(int $id)
    {
        $model   = new ProjectsModel();
        $project = $model->find($id);
        if (! $project) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        return view('admin/projects/edit', [
            'title'    => 'Edit Project — SmartCity PH',
            'project'  => $project,
            'regions'  => (new RegionsModel())->regionsOnly()->find(),
            'agencies' => (new AgenciesModel())->active()->orderBy('name', 'ASC')->findAll(),
        ]);
    }

    public function update(int $id)
    {
        $rules = [
            'title'  => 'required|max_length[255]',
            'status' => 'required',
        ];
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $model   = new ProjectsModel();
        $current = $model->find($id);
        if (! $current) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = $this->collectFields();
        if ($img = $this->saveImage()) {
            $data['image'] = $img;
        }

        $model->update($id, $data);
        return redirect()->to(base_url('admin/projects'))->with('success', 'Project updated.');
    }

    public function delete(int $id)
    {
        (new ProjectsModel())->delete($id);
        return redirect()->to(base_url('admin/projects'))->with('success', 'Project removed.');
    }

    private function collectFields(): array
    {
        $progress = (int) $this->request->getPost('progress');
        $progress = max(0, min(100, $progress));

        return [
            'title'           => $this->request->getPost('title'),
            'description'     => $this->request->getPost('description'),
            'agency'          => $this->request->getPost('agency'),
            'agency_id'       => $this->request->getPost('agency_id') ?: null,
            'budget'          => $this->request->getPost('budget') ?: 0,
            'amount_released' => $this->request->getPost('amount_released') ?: 0,
            'status'          => $this->request->getPost('status') ?: 'planned',
            'region_id'       => $this->request->getPost('region_id') ?: null,
            'start_date'      => $this->request->getPost('start_date') ?: null,
            'end_date'        => $this->request->getPost('end_date') ?: null,
            'progress'        => $progress,
        ];
    }

    private function saveImage(): ?string
    {
        $img = $this->request->getFile('image');
        if (! $img || ! $img->isValid() || $img->hasMoved()) {
            return null;
        }
        if ($img->getSize() > 2 * 1024 * 1024) {
            return null;
        }
        if (! in_array(strtolower($img->getExtension()), ['jpg', 'jpeg', 'png', 'webp'], true)) {
            return null;
        }
        $dir = FCPATH . 'uploads/projects/';
        if (! is_dir($dir)) {
            @mkdir($dir, 0777, true);
        }
        $name = $img->getRandomName();
        $img->move($dir, $name);
        return $name;
    }
}
