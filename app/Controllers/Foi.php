<?php

namespace App\Controllers;

use App\Models\AgenciesModel;
use App\Models\FoisModel;

class Foi extends BaseController
{
    public function index()
    {
        $agencies = (new AgenciesModel())->active()->orderBy('name', 'ASC')->findAll();

        return view('foi/index', [
            'title'    => 'Freedom of Information — SmartCity PH',
            'agencies' => $agencies,
        ]);
    }

    public function submit()
    {
        $rules = [
            'full_name'     => 'required|min_length[2]|max_length[100]',
            'email'         => 'required|valid_email|max_length[150]',
            'request_title' => 'required|min_length[5]|max_length[255]',
            'description'   => 'required|min_length[10]',
            'consent'       => 'required',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $agencyId = $this->request->getPost('agency_id') ?: null;
        $agencyName = null;
        if ($agencyId) {
            $a = (new AgenciesModel())->find((int) $agencyId);
            if ($a) {
                $agencyName = $a['name'];
            }
        }

        $reference = FoisModel::generateReference();

        (new FoisModel())->insert([
            'reference'     => $reference,
            'full_name'     => $this->request->getPost('full_name'),
            'email'         => $this->request->getPost('email'),
            'phone'         => $this->request->getPost('phone'),
            'agency_id'     => $agencyId ? (int) $agencyId : null,
            'agency_name'   => $agencyName,
            'request_title' => $this->request->getPost('request_title'),
            'description'   => $this->request->getPost('description'),
            'purpose'       => $this->request->getPost('purpose'),
            'status'        => 'pending',
        ]);

        return redirect()->to(base_url('foi'))
            ->with('success', 'FOI request submitted. Your reference number is ' . $reference . '. Agencies have 15 working days to respond.');
    }
}
