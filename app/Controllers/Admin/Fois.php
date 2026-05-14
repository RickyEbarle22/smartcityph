<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\FoisModel;

class Fois extends BaseController
{
    public function index()
    {
        $model    = new FoisModel();
        $selStatus = $this->request->getGet('status');

        $b = $model->withAgency();
        if ($selStatus) {
            $b = $b->where('fois.status', $selStatus);
        }
        $rows = $b->orderBy('fois.created_at', 'DESC')->paginate(20);

        return view('admin/fois/index', [
            'title'        => 'Manage FOI Requests — SmartCity PH',
            'fois'         => $rows,
            'pager'        => $model->pager,
            'statusCounts' => $model->statusCounts(),
            'selStatus'    => $selStatus,
        ]);
    }

    public function view(int $id)
    {
        $model = new FoisModel();
        $foi   = $model->withAgency()->where('fois.id', $id)->first();
        if (! $foi) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        return view('admin/fois/view', [
            'title' => 'FOI ' . esc($foi['reference']) . ' — SmartCity PH',
            'foi'   => $foi,
        ]);
    }

    public function respond(int $id)
    {
        $rules = ['status' => 'required'];
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $model = new FoisModel();
        $foi   = $model->find($id);
        if (! $foi) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $status = $this->request->getPost('status');
        $update = [
            'status'   => $status,
            'response' => $this->request->getPost('response'),
        ];
        if (in_array($status, ['fulfilled', 'denied'], true)) {
            $update['responded_at'] = date('Y-m-d H:i:s');
        }

        $model->update($id, $update);
        return redirect()->to(base_url('admin/fois/view/' . $id))->with('success', 'Response recorded.');
    }
}
