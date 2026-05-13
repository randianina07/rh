<?php

namespace App\Controllers;

use App\Models\EmployeModel;

class AuthController extends BaseController {

    public function login()
    {
        if (session()->get('isLoggedIn')) {
            return $this->redirectByUserRole(session()->get('role'));
        }
        return view('auth/login');
    }

    public function authenticate()
    {
        if (!$this->request->is('post')) {
            return redirect()->to('/login');
        }

        $session = session();
        $model = new EmployeModel();

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        if (!$this->validate([
            'email' => 'required|valid_email',
            'password' => 'required|min_length[6]',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $user = $model->where('email', $email)->first();

        if ($user && password_verify($password, $user['password'])) {
            
            $displayName = trim(($user['prenom'] ?? '') . ' ' . ($user['nom'] ?? ''));

            $session->set([
                'user_id'    => $user['id'],
                'nom'        => $displayName,
                'email'      => $user['email'],
                'role'       => $user['role'], // admin,rh,employe
                'isLoggedIn' => true,
            ]);

            return $this->redirectByUserRole($user['role'], $displayName);

        } else {
            return redirect()->back()->withInput()->with('error', 'Email ou mot de passe incorrect.');
        }
    }

    private function redirectByUserRole($role, $name = '')
    {
        $message = !empty($name) ? 'Bienvenue ' . $name . ' !' : '';

        switch ($role) {
            case 'admin':
                return redirect()->to('/admin/dashboard')->with('success', $message);
            case 'rh':
                return redirect()->to('/rh/dashboard')->with('success', $message);
            case 'employe':
                return redirect()->to('/employe/dashboard')->with('success', $message);
            default:
                return redirect()->to('/login')->with('error', 'Rôle non reconnu.');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}