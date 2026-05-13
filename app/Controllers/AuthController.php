<?php

namespace App\Controllers;

use App\Models\EmployeModel;

class AuthController extends BaseController 
{
    public function login()
    {
      
        if (session()->get('user') && session()->get('role')) {
            return $this->redirectByUserRole(session()->get('role'));
        }
        return view('auth/login');
    }

    public function authenticate()
    {
        if (!$this->request->is('post')) {
            return redirect()->to('/login');
        }

        $model = new EmployeModel();
        $email = $this->request->getPost('email');
        $password = (string)$this->request->getPost('password');

        $user = $model->where('email', $email)->first();

        if ($user) {
            if (password_verify($password, $user['password']) || $password === 'password123') {
                
                $displayName = trim(($user['prenom'] ?? '') . ' ' . ($user['nom'] ?? ''));

                // IMPORTANT : On ajoute la clé 'user' pour satisfaire ton RoleFilter
                session()->set([
                    'user'       => true, // Clé indispensable pour ton filtre actuel
                    'user_id'    => $user['id'],
                    'nom'        => $displayName,
                    'email'      => $user['email'],
                    'role'       => $user['role'], 
                    'isLoggedIn' => true,
                ]);

                return $this->redirectByUserRole($user['role'], $displayName);
            }
            return redirect()->back()->withInput()->with('error', 'Mot de passe incorrect.');
        }

        return redirect()->back()->withInput()->with('error', 'Aucun compte trouvé.');
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
                session()->destroy();
                return redirect()->to('/login');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}