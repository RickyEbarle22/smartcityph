<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\NewsModel;

class News extends BaseController
{
    public function index()
    {
        $news = new NewsModel();
        $items = $news->orderBy('created_at', 'DESC')->paginate(15);
        return view('admin/news/index', [
            'title' => 'Manage News — SmartCity PH',
            'items' => $items,
            'pager' => $news->pager,
        ]);
    }

    public function create()
    {
        return view('admin/news/create', ['title' => 'New Article — SmartCity PH']);
    }

    public function store()
    {
        $rules = [
            'title'    => 'required|max_length[255]',
            'category' => 'required|max_length[80]',
        ];
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = $this->collectFields();
        $data['slug'] = url_title(strtolower($data['title']), '-', true);
        $data['published_at'] = $data['is_published'] ? date('Y-m-d H:i:s') : null;

        $img = $this->request->getFile('image');
        if ($img && $img->isValid() && ! $img->hasMoved()) {
            if ($img->getSize() <= 2 * 1024 * 1024 && in_array(strtolower($img->getExtension()), ['jpg', 'jpeg', 'png', 'webp'], true)) {
                $name = $img->getRandomName();
                $img->move(FCPATH . 'uploads/news/', $name);
                $data['image'] = $name;
            }
        }

        (new NewsModel())->insert($data);
        return redirect()->to(base_url('admin/news'))->with('success', 'Article created.');
    }

    public function edit(int $id)
    {
        $article = (new NewsModel())->find($id);
        if (! $article) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        return view('admin/news/edit', [
            'title'   => 'Edit Article — SmartCity PH',
            'article' => $article,
        ]);
    }

    public function update(int $id)
    {
        $rules = [
            'title'    => 'required|max_length[255]',
            'category' => 'required|max_length[80]',
        ];
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $news = new NewsModel();
        $cur  = $news->find($id);
        if (! $cur) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = $this->collectFields();
        $data['slug'] = url_title(strtolower($data['title']), '-', true);
        if ($data['is_published'] && empty($cur['published_at'])) {
            $data['published_at'] = date('Y-m-d H:i:s');
        }

        $img = $this->request->getFile('image');
        if ($img && $img->isValid() && ! $img->hasMoved()) {
            if ($img->getSize() <= 2 * 1024 * 1024 && in_array(strtolower($img->getExtension()), ['jpg', 'jpeg', 'png', 'webp'], true)) {
                $name = $img->getRandomName();
                $img->move(FCPATH . 'uploads/news/', $name);
                $data['image'] = $name;
            }
        }

        $news->update($id, $data);
        return redirect()->to(base_url('admin/news'))->with('success', 'Article updated.');
    }

    public function delete(int $id)
    {
        (new NewsModel())->delete($id);
        return redirect()->to(base_url('admin/news'))->with('success', 'Article removed.');
    }

    public function togglePublish(int $id)
    {
        $news = new NewsModel();
        $a = $news->find($id);
        if (! $a) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        $update = ['is_published' => $a['is_published'] ? 0 : 1];
        if ($update['is_published'] && empty($a['published_at'])) {
            $update['published_at'] = date('Y-m-d H:i:s');
        }
        $news->update($id, $update);
        return redirect()->to(base_url('admin/news'))->with('success', $a['is_published'] ? 'Article unpublished — hidden from /news.' : 'Article published — live on /news.');
    }

    private function collectFields(): array
    {
        return [
            'title'        => $this->request->getPost('title'),
            'excerpt'      => $this->request->getPost('excerpt'),
            'body'         => $this->request->getPost('body'),
            'category'     => $this->request->getPost('category'),
            'author'       => $this->request->getPost('author') ?: 'SmartCity PH Newsroom',
            'tags'         => $this->request->getPost('tags'),
            'is_featured'  => $this->request->getPost('is_featured') ? 1 : 0,
            'is_published' => $this->request->getPost('is_published') ? 1 : 0,
        ];
    }
}
