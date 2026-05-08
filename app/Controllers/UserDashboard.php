<?php

namespace App\Controllers;

use App\Models\FeedbackModel;
use App\Models\RegionsModel;
use App\Models\ReportsModel;
use App\Models\ServicesModel;
use App\Models\UsersModel;

class UserDashboard extends BaseController
{
    public function index()
    {
        $userId  = session()->get('user_id');
        $reports = new ReportsModel();
        $feedback= new FeedbackModel();

        $myReports     = $reports->where('user_id', $userId)->orderBy('created_at', 'DESC')->limit(5)->find();
        $totalMine     = $reports->where('user_id', $userId)->countAllResults();
        $pendingMine   = $reports->where('user_id', $userId)->whereIn('status', ['pending', 'reviewing'])->countAllResults();
        $resolvedMine  = $reports->where('user_id', $userId)->where('status', 'resolved')->countAllResults();
        $feedbackCount = $feedback->where('user_id', $userId)->countAllResults();

        return view('user/dashboard', [
            'title'         => 'My Dashboard — SmartCity PH',
            'reports'       => $myReports,
            'totalReports'  => $totalMine,
            'pending'       => $pendingMine,
            'resolved'      => $resolvedMine,
            'feedbackCount' => $feedbackCount,
        ]);
    }

    public function profile()
    {
        $users   = new UsersModel();
        $user    = $users->find(session()->get('user_id'));
        $regions = (new RegionsModel())->regionsOnly()->find();

        return view('user/profile', [
            'title'   => 'Edit Profile — SmartCity PH',
            'user'    => $user,
            'regions' => $regions,
        ]);
    }

    public function updateProfile()
    {
        $rules = [
            'first_name' => 'required|max_length[60]',
            'last_name'  => 'required|max_length[60]',
            'phone'      => 'permit_empty|max_length[25]',
            'address'    => 'permit_empty|max_length[255]',
            'region_id'  => 'permit_empty|integer',
        ];
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $users = new UsersModel();
        $userId = (int) session()->get('user_id');

        $update = [
            'first_name' => $this->request->getPost('first_name'),
            'last_name'  => $this->request->getPost('last_name'),
            'phone'      => $this->request->getPost('phone'),
            'address'    => $this->request->getPost('address'),
            'region_id'  => $this->request->getPost('region_id') ?: null,
        ];

        $img = $this->request->getFile('avatar');
        if ($img && $img->isValid() && ! $img->hasMoved()) {
            if ($img->getSize() <= 2 * 1024 * 1024 && in_array(strtolower($img->getExtension()), ['jpg', 'jpeg', 'png', 'webp'], true)) {
                $name = $img->getRandomName();
                $img->move(FCPATH . 'uploads/avatars/', $name);
                $update['avatar'] = $name;
                session()->set('user_avatar', $name);
            }
        }

        $users->update($userId, $update);
        session()->set([
            'user_first_name' => $update['first_name'],
            'user_last_name'  => $update['last_name'],
            'user_phone'      => $update['phone'],
        ]);

        return redirect()->to(base_url('user/profile'))->with('success', 'Profile updated.');
    }

    public function changePassword()
    {
        $rules = [
            'current_password' => 'required',
            'new_password'     => 'required|min_length[6]',
            'confirm_password' => 'required|matches[new_password]',
        ];
        if (! $this->validate($rules)) {
            return redirect()->back()->with('errors', $this->validator->getErrors());
        }

        $users = new UsersModel();
        $userId = (int) session()->get('user_id');
        $user = $users->find($userId);

        if (! password_verify($this->request->getPost('current_password'), $user['password'])) {
            return redirect()->back()->with('error', 'Current password is incorrect.');
        }

        $users->update($userId, [
            'password' => password_hash($this->request->getPost('new_password'), PASSWORD_DEFAULT),
        ]);

        return redirect()->to(base_url('user/profile'))->with('success', 'Password updated.');
    }

    public function submitFeedback()
    {
        $rules = [
            'service_id' => 'required|integer',
            'rating'     => 'required|integer|greater_than[0]|less_than[6]',
            'comment'    => 'permit_empty|max_length[1000]',
        ];
        if (! $this->validate($rules)) {
            return redirect()->back()->with('errors', $this->validator->getErrors());
        }

        $feedback  = new FeedbackModel();
        $userId    = (int) session()->get('user_id');
        $serviceId = (int) $this->request->getPost('service_id');

        if ($feedback->userHasRated($userId, $serviceId)) {
            return redirect()->back()->with('error', 'You have already reviewed this service.');
        }

        $feedback->insert([
            'user_id'     => $userId,
            'service_id'  => $serviceId,
            'rating'      => (int) $this->request->getPost('rating'),
            'comment'     => $this->request->getPost('comment'),
            'is_approved' => 1,
        ]);
        $feedback->recalculateService($serviceId);

        return redirect()->back()->with('success', 'Thank you for your feedback!');
    }

    public function myReports()
    {
        $reports = new ReportsModel();
        $items   = $reports->where('user_id', session()->get('user_id'))
            ->orderBy('created_at', 'DESC')
            ->paginate(10);

        return view('user/reports', [
            'title'   => 'My Reports — SmartCity PH',
            'reports' => $items,
            'pager'   => $reports->pager,
        ]);
    }

    public function trackReport()
    {
        $ref     = $this->request->getGet('ref');
        $reports = new ReportsModel();
        $report  = $ref ? $reports->findByReference($ref) : null;

        return view('user/track', [
            'title'  => 'Track Report — SmartCity PH',
            'ref'    => $ref,
            'report' => $report,
        ]);
    }

    public function trackLookup()
    {
        $ref = trim($this->request->getPost('reference') ?? '');
        return redirect()->to(base_url('track?ref=' . urlencode($ref)));
    }
}
