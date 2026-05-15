<?php

namespace App\Controllers\Admin;

use App\Models\StopModel;
use App\Models\UserModel;
use App\Models\ZoneModel;

class DashboardController extends BaseAdminController
{
    public function index()
    {
        $stopModel = new StopModel();
        $userModel = new UserModel();
        $zoneModel = new ZoneModel();

        $data = [
            'title'           => lang('Admin.dashboard'),
            'totalZones'      => $zoneModel->countAll(),
            'publishedZones'  => $zoneModel->where('is_published', 1)->countAllResults(),
            'totalStops'      => $stopModel->countAll(),
            'publishedStops'  => $stopModel->where('is_published', 1)->countAllResults(),
            'totalUsers'      => $userModel->countAll(),
        ];

        return $this->view('admin/dashboard', $data);
    }
}
