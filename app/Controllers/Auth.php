<?php

namespace App\Controllers;

use App\Models\AdminModel;

class Auth extends BaseController
{
    public function login()
    {
        if (session()->get('admin_logged_in')) {
            return redirect()->to(base_url('admin'));
        }
        return view('admin/login', ['title' => 'Admin Sign In — SmartCity PH']);
    }

    public function authenticate()
    {
        $rules = [
            'username' => 'required|min_length[3]',
            'password' => 'required|min_length[6]',
        ];
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $admins = new AdminModel();
        $admin  = $admins->findByUsername($this->request->getPost('username'));

        if (! $admin || ! password_verify($this->request->getPost('password'), $admin['password'])) {
            return redirect()->back()->withInput()->with('error', 'Invalid credentials.');
        }

        session()->set([
            'admin_logged_in' => true,
            'admin_id'        => (int) $admin['id'],
            'admin_username'  => $admin['username'],
            'admin_full_name' => $admin['full_name'],
            'admin_role'      => $admin['role'],
        ]);

        return redirect()->to(base_url('admin'))->with('success', 'Welcome back, ' . esc($admin['full_name']) . '.');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('admin-login'))->with('success', 'You have been signed out.');
    }
}
