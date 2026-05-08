<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ReportsModel;

class Reports extends BaseController
{
    public function index()
    {
        $reports = new ReportsModel();
        $status  = $this->request->getGet('status');

        $b = $reports->withDetails();
        if ($status) {
            $b = $b->where('reports.status', $status);
        }

        $items = $b->orderBy('reports.created_at', 'DESC')->paginate(15);

        return view('admin/reports/index', [
            'title'        => 'Manage Reports — SmartCity PH',
            'reports'      => $items,
            'pager'        => $reports->pager,
            'selStatus'    => $status,
            'statusCounts' => $reports->statusCounts(),
        ]);
    }

    public function view(int $id)
    {
        $report = (new ReportsModel())->withDetails()->where('reports.id', $id)->first();
        if (! $report) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        return view('admin/reports/view', [
            'title'  => 'Report ' . $report['reference'] . ' — SmartCity PH',
            'report' => $report,
        ]);
    }

    public function updateStatus(int $id)
    {
        $rules = [
            'status'      => 'required|in_list[pending,reviewing,in_progress,resolved,rejected]',
            'priority'    => 'permit_empty|in_list[low,medium,high,urgent]',
            'admin_notes' => 'permit_empty|max_length[2000]',
            'assigned_to' => 'permit_empty|max_length[100]',
        ];
        if (! $this->validate($rules)) {
            return redirect()->back()->with('errors', $this->validator->getErrors());
        }

        $reports = new ReportsModel();
        $status  = $this->request->getPost('status');

        $update = [
            'status'      => $status,
            'priority'    => $this->request->getPost('priority') ?: 'medium',
            'admin_notes' => $this->request->getPost('admin_notes'),
            'assigned_to' => $this->request->getPost('assigned_to'),
            'resolved_at' => $status === 'resolved' ? date('Y-m-d H:i:s') : null,
        ];

        $reports->update($id, $update);
        return redirect()->to(base_url('admin/reports/view/' . $id))->with('success', 'Report status updated.');
    }
}
