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
        $existing = $reports->find($id);
        if (! $existing) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $status   = $this->request->getPost('status');
        $newNotes = trim((string) $this->request->getPost('admin_notes'));
        $hasNotes = $this->request->getPost('admin_notes') !== null;

        $update = ['status' => $status];

        if ($this->request->getPost('priority') !== null) {
            $update['priority'] = $this->request->getPost('priority') ?: ($existing['priority'] ?? 'medium');
        }

        if ($this->request->getPost('assigned_to') !== null) {
            $update['assigned_to'] = $this->request->getPost('assigned_to');
        }

        if ($hasNotes && $newNotes !== '') {
            $update['admin_notes'] = $newNotes;
        }

        if ($status === 'resolved') {
            $update['resolved_at'] = date('Y-m-d H:i:s');
        } elseif ($existing['status'] === 'resolved' && $status !== 'resolved') {
            $update['resolved_at'] = null;
        }

        $reports->update($id, $update);

        $label = ucfirst(str_replace('_', ' ', $status));
        $msg   = 'Report ' . $existing['reference'] . ' updated to ' . $label . '.';

        $back = $this->request->getPost('return_to') === 'view'
            ? base_url('admin/reports/view/' . $id)
            : base_url('admin/reports');

        return redirect()->to($back)->with('success', $msg);
    }
}
