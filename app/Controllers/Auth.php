<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\API\ResponseTrait;
use App\Services\GoogleService;

class Auth extends BaseController
{
    use ResponseTrait;

    protected $userModel;
    protected $validation;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->validation = \Config\Services::validation();
    }
    public function login()
    {
        // If already logged in, redirect to dashboard
        if (session()->has('user_id')) {
            return $this->redirectToDashboard();
        }
    
        if ($this->request->getMethod() === 'post') {
            $rules = [
                'email' => 'required|valid_email',
                'password' => 'required|min_length[8]',
            ];
    
            if (!$this->validate($rules)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }
    
            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');
    
            $user = $this->userModel->where('email', $email)->first();
    
            if (!$user) {
                return redirect()->back()->withInput()->with('error', 'Invalid email or password');
            }
    
            // Verify password
            if (!password_verify($password, $user['password'])) {
                return redirect()->back()->withInput()->with('error', 'Invalid email or password');
            }
    
            if ($user['status'] !== 'active') {
                return redirect()->back()->withInput()->with('error', 'Your account is not active');
            }
    
            // Update last login
            $this->userModel->update($user['id'], ['last_login' => date('Y-m-d H:i:s')]);
    
            // Set user session
            $sessionData = [
                'user_id' => $user['id'],
                'email' => $user['email'],
                'role_id' => $user['role_id'],
                'isLoggedIn' => true,
            ];
    
            session()->set($sessionData);
    
            // Redirect based on role
            return $this->redirectToDashboard();
        }
    
        return $this->render('Frontend/Auth/login', [
            'title' => 'Login',
            'config' => config('Auth'),
        ]);
    }

    public function register()
    {
        // If already logged in, redirect to dashboard
        if (session()->has('user_id')) {
            return $this->redirectToDashboard();
        }

        if ($this->request->getMethod() === 'post') {
            $rules = [
                'first_name' => 'required|min_length[2]|max_length[100]',
                'last_name' => 'required|min_length[2]|max_length[100]',
                'email' => 'required|valid_email|is_unique[users.email]',
                'password' => 'required|min_length[8]',
                'password_confirm' => 'required|matches[password]',
            ];

            if (!$this->validate($rules)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            $userData = [
                'role_id' => 2, // Default role is User
                'first_name' => $this->request->getPost('first_name'),
                'last_name' => $this->request->getPost('last_name'),
                'email' => $this->request->getPost('email'),
                'password' => $this->request->getPost('password'),
                'status' => 'active',
            ];

            if (!$this->userModel->save($userData)) {
                return redirect()->back()->withInput()->with('error', 'Failed to register user');
            }

            // Get the newly created user
            $user = $this->userModel->where('email', $userData['email'])->first();
            
            // Set user session
            $sessionData = [
                'user_id' => $user['id'],
                'email' => $user['email'],
                'role_id' => $user['role_id'],
                'isLoggedIn' => true,
            ];

            session()->set($sessionData);

            return $this->redirectToDashboard();
        }

        return $this->render('Frontend/Auth/register', [
            'title' => 'Register',
        ]);
    }

    protected function redirectToDashboard()
    {
        $roleId = session()->get('role_id');
        
        switch ($roleId) {
            case 1: // Admin
                return redirect()->to('/admin/dashboard')->with('message', 'Welcome Admin!');
            case 2: // User
                return redirect()->to('/user/dashboard')->with('message', 'Welcome back!');
            case 3: // Editor
                return redirect()->to('/editor/dashboard')->with('message', 'Welcome Editor!');
            default:
                return redirect()->to('/dashboard')->with('message', 'Welcome!');
        }
    }

    protected function setRememberMeToken($userId)
    {
        $token = bin2hex(random_bytes(32));
        $expires = date('Y-m-d H:i:s', time() + (86400 * 30)); // 30 days
        
        $this->userModel->update($userId, [
            'remember_token' => $token,
            'token_expires' => $expires
        ]);
        
        helper('cookie');
        set_cookie('remember_me', $token, 86400 * 30);
    }

    public function logout()
    {
        // Clear remember me token if exists
        if (session()->has('user_id')) {
            $this->userModel->update(session()->get('user_id'), [
                'remember_token' => null,
                'token_expires' => null
            ]);
        }
        
        // Destroy session
        session()->destroy();
        
        // Delete remember me cookie
        helper('cookie');
        delete_cookie('remember_me');
        
        return redirect()->to('/login')->with('message', 'You have been logged out');
    }

    



    public function socialLogin()
    {
        // Hardcode 'google' as provider since we're only implementing Google login
        $googleService = new \App\Services\GoogleService();
        $authUrl = $googleService->getAuthUrl();
        
        if (!$authUrl) {
            return redirect()->to('/login')->with('error', 'Failed to initialize Google login');
        }
        
        return redirect()->to($authUrl);
    }
    
    public function socialLoginCallback()
    {
        $code = $this->request->getGet('code');
        
        if (!$code) {
            return redirect()->to('/login')->with('error', 'Authorization failed: no code received');
        }
    
        $googleService = new \App\Services\GoogleService();
        
        if ($googleService->handleCallback($code)) {
            return redirect()->to('/dashboard')->with('message', 'Logged in successfully with Google');
        }
        
        return redirect()->to('/login')->with('error', 'Failed to authenticate with Google');
    }
}