<?php

namespace App\Controllers;

use App\Models\RegionsModel;
use App\Models\ReportsModel;

class Reports extends BaseController
{
    public function index()
    {
        $regions = (new RegionsModel())->regionsOnly()->find();

        $session = session();
        $prefill = [];
        if ($session->get('user_logged_in')) {
            $prefill = [
                'full_name' => trim(($session->get('user_first_name') ?? '') . ' ' . ($session->get('user_last_name') ?? '')),
                'email'     => $session->get('user_email'),
                'phone'     => $session->get('user_phone'),
            ];
        }

        return view('reports/index', [
            'title'   => 'Report an Issue — SmartCity PH',
            'regions' => $regions,
            'prefill' => $prefill,
        ]);
    }

    public function submit()
    {
        $rules = [
            'full_name'   => 'required|min_length[2]|max_length[100]',
            'email'       => 'required|valid_email',
            'phone'       => 'permit_empty|max_length[25]',
            'category'    => 'required|max_length[60]',
            'region_id'   => 'required|integer',
            'priority'    => 'permit_empty|in_list[low,medium,high,urgent]',
            'location'    => 'required|max_length[255]',
            'description' => 'required|min_length[10]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $reports = new ReportsModel();
        $session = session();

        $data = [
            'reference'   => $reports->generateReference(),
            'user_id'     => $session->get('user_logged_in') ? $session->get('user_id') : null,
            'full_name'   => $this->request->getPost('full_name'),
            'email'       => $this->request->getPost('email'),
            'phone'       => $this->request->getPost('phone'),
            'category'    => $this->request->getPost('category'),
            'region_id'   => (int) $this->request->getPost('region_id'),
            'priority'    => $this->request->getPost('priority') ?: 'medium',
            'location'    => $this->request->getPost('location'),
            'description' => $this->request->getPost('description'),
            'latitude'    => $this->request->getPost('latitude') ?: null,
            'longitude'   => $this->request->getPost('longitude') ?: null,
            'status'      => 'pending',
        ];

        // Optional image upload
        $img = $this->request->getFile('image');
        if ($img && $img->isValid() && ! $img->hasMoved()) {
            if ($img->getSize() <= 2 * 1024 * 1024 && in_array(strtolower($img->getExtension()), ['jpg', 'jpeg', 'png', 'webp'], true)) {
                $name = $img->getRandomName();
                $img->move(FCPATH . 'uploads/reports/', $name);
                $data['image'] = $name;
            }
        }

        $reports->insert($data);
        return redirect()->to(base_url('track?ref=' . $data['reference']))
            ->with('success', 'Report submitted! Your reference number is ' . $data['reference']);
    }
}
