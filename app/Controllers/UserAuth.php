<?php

namespace App\Controllers;

use App\Models\RegionsModel;
use App\Models\UsersModel;

class UserAuth extends BaseController
{
    public function login()
    {
        if (session()->get('user_logged_in')) {
            return redirect()->to(base_url('user/dashboard'));
        }
        return view('auth/login', ['title' => 'Sign In — SmartCity PH']);
    }

    public function doLogin()
    {
        $rules = [
            'email'    => 'required|valid_email',
            'password' => 'required|min_length[6]',
        ];
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $email = $this->request->getPost('email');
        $pass  = $this->request->getPost('password');

        $users = new UsersModel();
        $user  = $users->findByEmail($email);

        if (! $user || ! password_verify($pass, $user['password'])) {
            return redirect()->back()->withInput()->with('error', 'Invalid email or password.');
        }
        if (! $user['is_active']) {
            return redirect()->back()->with('error', 'This account has been deactivated.');
        }

        session()->set([
            'user_logged_in'  => true,
            'user_id'         => (int) $user['id'],
            'user_email'      => $user['email'],
            'user_first_name' => $user['first_name'],
            'user_last_name'  => $user['last_name'],
            'user_phone'      => $user['phone'],
            'user_avatar'     => $user['avatar'],
        ]);

        $users->update($user['id'], ['last_login' => date('Y-m-d H:i:s')]);

        return redirect()->to(base_url('user/dashboard'))->with('success', 'Welcome back, ' . esc($user['first_name']) . '!');
    }

    public function register()
    {
        $regions = (new RegionsModel())->regionsOnly()->find();
        return view('auth/register', [
            'title'   => 'Create an Account — SmartCity PH',
            'regions' => $regions,
        ]);
    }

    public function doRegister()
    {
        $rules = [
            'first_name'       => 'required|min_length[2]|max_length[60]',
            'last_name'        => 'required|min_length[2]|max_length[60]',
            'email'            => 'required|valid_email|is_unique[users.email]',
            'phone'            => 'permit_empty|max_length[25]',
            'region_id'        => 'permit_empty|integer',
            'password'         => 'required|min_length[6]',
            'confirm_password' => 'required|matches[password]',
            'terms'            => 'required',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $users = new UsersModel();
        $users->insert([
            'first_name' => $this->request->getPost('first_name'),
            'last_name'  => $this->request->getPost('last_name'),
            'email'      => $this->request->getPost('email'),
            'password'   => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'phone'      => $this->request->getPost('phone'),
            'region_id'  => $this->request->getPost('region_id') ?: null,
            'is_verified'=> 1,
            'is_active'  => 1,
        ]);

        return redirect()->to(base_url('login'))->with('success', 'Account created. You can now sign in.');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('/'))->with('success', 'You have been signed out.');
    }
}
