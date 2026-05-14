<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class BaseAdminController extends BaseController
{
    protected string $adminUser = '';
    protected string $adminRole = '';

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->adminUser = session()->get('admin_username') ?? '';
        $this->adminRole = session()->get('admin_role') ?? '';
    }

    protected function isSuperAdmin(): bool
    {
        return $this->adminRole === 'superadmin';
    }

    protected function view(string $template, array $data = []): string
    {
        $data['adminUser'] = $this->adminUser;
        $data['adminRole'] = $this->adminRole;
        return view($template, $data);
    }
}
