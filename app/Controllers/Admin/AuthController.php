<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\LoginThrottle;
use App\Models\UserModel;

class AuthController extends BaseController
{
    public function login()
    {
        if (session()->get('admin_logged_in')) {
            return redirect()->to(base_url('admin/dashboard'));
        }
        return view('admin/auth/login', ['title' => 'Admin Login']);
    }

    public function doLogin()
    {
        $throttle = new LoginThrottle();
        $ip       = $this->request->getIPAddress();

        if ($throttle->tooManyAttempts($ip)) {
            return redirect()->back()->with('error', lang('Admin.tooManyAttempts'));
        }

        $rules = [
            'email'    => 'required|valid_email',
            'password' => 'required|min_length[6]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $model = new UserModel();
        $user  = $model->findByEmail($this->request->getPost('email'));

        // Always call password_verify to prevent timing-based email enumeration
        $dummy = '$2y$12$invalidhashpaddinginvalidhashpaddinginvalidhashpadding00';
        $hash  = $user ? $user->password_hash : $dummy;

        if (!$user || !password_verify($this->request->getPost('password'), $hash)) {
            $throttle->record($ip);
            return redirect()->back()->withInput()->with('error', lang('Admin.invalidCredentials'));
        }

        $throttle->clear($ip);
        session()->regenerate(true);
        session()->set([
            'admin_logged_in' => true,
            'admin_id'        => $user->id,
            'admin_username'  => $user->username,
            'admin_role'      => $user->role,
        ]);

        $model->update($user->id, ['last_login' => date('Y-m-d H:i:s')]);

        return redirect()->to(base_url('admin/dashboard'));
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('admin/login'));
    }
}
