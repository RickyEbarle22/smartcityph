<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ReportsModel;
use App\Models\UsersModel;

class Users extends BaseController
{
    public function index()
    {
        $users = new UsersModel();
        $items = $users->withRegion()->orderBy('users.created_at', 'DESC')->paginate(15);

        $reports = new ReportsModel();
        $counts  = [];
        foreach ($items as $u) {
            $counts[$u['id']] = $reports->where('user_id', $u['id'])->countAllResults(true);
        }

        return view('admin/users/index', [
            'title'  => 'Manage Citizens — SmartCity PH',
            'users'  => $items,
            'pager'  => $users->pager,
            'counts' => $counts,
        ]);
    }

    public function view(int $id)
    {
        $user = (new UsersModel())->withRegion()->where('users.id', $id)->first();
        if (! $user) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        $reports = (new ReportsModel())->where('user_id', $id)->orderBy('created_at', 'DESC')->find();
        return view('admin/users/view', [
            'title'   => $user['first_name'] . ' ' . $user['last_name'] . ' — SmartCity PH',
            'user'    => $user,
            'reports' => $reports,
        ]);
    }

    public function toggle(int $id)
    {
        $users = new UsersModel();
        $u = $users->find($id);
        if (! $u) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        $users->update($id, ['is_active' => $u['is_active'] ? 0 : 1]);
        return redirect()->to(base_url('admin/users'))->with('success', 'Account status updated.');
    }
}
