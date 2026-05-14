<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\FaqsModel;

class Faqs extends BaseController
{
    public function index()
    {
        $list = (new FaqsModel())
            ->orderBy('sort_order', 'ASC')
            ->orderBy('id', 'ASC')
            ->paginate(25);

        return view('admin/faqs/index', [
            'title' => 'Manage FAQs — SmartCity PH',
            'faqs'  => $list,
            'pager' => (new FaqsModel())->pager,
        ]);
    }

    public function create()
    {
        return view('admin/faqs/create', ['title' => 'New FAQ — SmartCity PH']);
    }

    public function store()
    {
        $rules = [
            'question' => 'required',
            'answer'   => 'required',
        ];
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        (new FaqsModel())->insert($this->collectFields());
        return redirect()->to(base_url('admin/faqs'))->with('success', 'FAQ added.');
    }

    public function edit(int $id)
    {
        $model = new FaqsModel();
        $faq   = $model->find($id);
        if (! $faq) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        return view('admin/faqs/edit', [
            'title' => 'Edit FAQ — SmartCity PH',
            'faq'   => $faq,
        ]);
    }

    public function update(int $id)
    {
        $rules = [
            'question' => 'required',
            'answer'   => 'required',
        ];
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $model = new FaqsModel();
        if (! $model->find($id)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        $model->update($id, $this->collectFields());
        return redirect()->to(base_url('admin/faqs'))->with('success', 'FAQ updated.');
    }

    public function delete(int $id)
    {
        (new FaqsModel())->delete($id);
        return redirect()->to(base_url('admin/faqs'))->with('success', 'FAQ deleted.');
    }

    public function toggleActive(int $id)
    {
        $model = new FaqsModel();
        $f = $model->find($id);
        if (! $f) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        $model->update($id, ['is_active' => $f['is_active'] ? 0 : 1]);
        return redirect()->to(base_url('admin/faqs'))->with('success', $f['is_active'] ? 'FAQ hidden.' : 'FAQ visible.');
    }

    private function collectFields(): array
    {
        return [
            'question'   => $this->request->getPost('question'),
            'answer'     => $this->request->getPost('answer'),
            'category'   => $this->request->getPost('category'),
            'sort_order' => (int) ($this->request->getPost('sort_order') ?: 0),
            'is_active'  => $this->request->getPost('is_active') ? 1 : 0,
        ];
    }
}
