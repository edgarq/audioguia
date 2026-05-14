<?php

namespace App\Controllers\Admin;

use App\Models\UserModel;

class UsersController extends BaseAdminController
{
    private UserModel $model;

    public function __construct()
    {
        $this->model = new UserModel();
    }

    public function index()
    {
        if (!$this->isSuperAdmin()) {
            return redirect()->to(base_url('admin/dashboard'))->with('error', lang('Admin.forbidden'));
        }
        return $this->view('admin/users/index', [
            'title' => lang('Admin.users'),
            'users' => $this->model->findAll(),
        ]);
    }

    public function create()
    {
        if (!$this->isSuperAdmin()) {
            return redirect()->to(base_url('admin/dashboard'))->with('error', lang('Admin.forbidden'));
        }
        return $this->view('admin/users/form', ['title' => lang('Admin.createUser'), 'user' => null]);
    }

    public function store()
    {
        if (!$this->isSuperAdmin()) {
            return redirect()->to(base_url('admin/dashboard'))->with('error', lang('Admin.forbidden'));
        }

        $rules = [
            'username' => 'required|min_length[3]|max_length[100]|is_unique[users.username]',
            'email'    => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[8]',
            'role'     => 'required|in_list[superadmin,editor]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->insert([
            'username'      => $this->request->getPost('username'),
            'email'         => $this->request->getPost('email'),
            'password_hash' => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT, ['cost' => 12]),
            'role'          => $this->request->getPost('role'),
            'is_active'     => 1,
        ]);

        return redirect()->to(base_url('admin/users'))->with('success', lang('Admin.userCreated'));
    }

    public function edit($id = null)
    {
        if (!$this->isSuperAdmin()) {
            return redirect()->to(base_url('admin/dashboard'))->with('error', lang('Admin.forbidden'));
        }
        $user = $this->model->find($id);
        if (!$user) {
            return redirect()->to(base_url('admin/users'))->with('error', lang('Admin.notFound'));
        }
        return $this->view('admin/users/form', ['title' => lang('Admin.editUser'), 'user' => $user]);
    }

    public function update($id = null)
    {
        if (!$this->isSuperAdmin()) {
            return redirect()->to(base_url('admin/dashboard'))->with('error', lang('Admin.forbidden'));
        }

        $user = $this->model->find($id);
        if (!$user) {
            return redirect()->to(base_url('admin/users'))->with('error', lang('Admin.notFound'));
        }

        $rules = [
            'username'  => "required|min_length[3]|max_length[100]|is_unique[users.username,id,{$id}]",
            'email'     => "required|valid_email|is_unique[users.email,id,{$id}]",
            'role'      => 'required|in_list[superadmin,editor]',
            'is_active' => 'required|in_list[0,1]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'username'  => $this->request->getPost('username'),
            'email'     => $this->request->getPost('email'),
            'role'      => $this->request->getPost('role'),
            'is_active' => (int) $this->request->getPost('is_active'),
        ];

        $pwd = $this->request->getPost('password');
        if ($pwd) {
            if (strlen($pwd) < 8) {
                return redirect()->back()->withInput()->with('error', lang('Admin.passwordTooShort'));
            }
            $data['password_hash'] = password_hash($pwd, PASSWORD_BCRYPT, ['cost' => 12]);
        }

        $this->model->update($id, $data);
        return redirect()->to(base_url('admin/users'))->with('success', lang('Admin.userUpdated'));
    }

    public function delete($id = null)
    {
        if (!$this->isSuperAdmin()) {
            return redirect()->to(base_url('admin/dashboard'))->with('error', lang('Admin.forbidden'));
        }

        if ((int) $id === (int) session()->get('admin_id')) {
            return redirect()->to(base_url('admin/users'))->with('error', lang('Admin.cannotDeleteSelf'));
        }

        $this->model->delete($id);
        return redirect()->to(base_url('admin/users'))->with('success', lang('Admin.userDeleted'));
    }
}
