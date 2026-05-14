<?php

namespace App\Controllers\Admin;

use App\Models\StopModel;
use App\Models\UserModel;

class DashboardController extends BaseAdminController
{
    public function index()
    {
        $stopModel = new StopModel();
        $userModel = new UserModel();

        $data = [
            'title'           => lang('Admin.dashboard'),
            'totalStops'      => $stopModel->countAll(),
            'publishedStops'  => $stopModel->where('is_published', 1)->countAllResults(),
            'totalUsers'      => $userModel->countAll(),
        ];

        return $this->view('admin/dashboard', $data);
    }
}
