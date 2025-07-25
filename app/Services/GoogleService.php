<?php

namespace App\Services;

use League\OAuth2\Client\Provider\Google;
use App\Models\UserModel;

class GoogleService
{
    protected $provider;
    protected $userModel;

    public function __construct()
    {
        $this->provider = new Google([
            'clientId'     => env('GOOGLE_CLIENT_ID'),
            'clientSecret' => env('GOOGLE_CLIENT_SECRET'),
            'redirectUri'  => env('GOOGLE_REDIRECT_URI'),
        ]);
        
        $this->userModel = new UserModel();
    }

    public function getAuthUrl()
    {
        try {
            $options = [
                'scope' => ['email', 'profile'],
                'prompt' => 'select_account' // Forces account selection
            ];
            return $this->provider->getAuthorizationUrl($options);
        } catch (\Exception $e) {
            log_message('error', 'Google Auth URL Error: ' . $e->getMessage());
            return false;
        }
    }

    public function getUser($code)
    {
        try {
            $token = $this->provider->getAccessToken('authorization_code', [
                'code' => $code
            ]);

            $user = $this->provider->getResourceOwner($token);

            return [
                'email' => $user->getEmail(),
                'first_name' => $user->getFirstName(),
                'last_name' => $user->getLastName(),
                'social_id' => $user->getId(),
                'profile_pic' => $user->getAvatar(),
            ];
        } catch (\Exception $e) {
            log_message('error', 'Google OAuth Error: ' . $e->getMessage());
            return false;
        }
    }

    public function handleCallback($code)
    {
        $googleUser = $this->getUser($code);
        
        if (!$googleUser) return false;

        $user = $this->userModel->getUserBySocialId('google', $googleUser['social_id']);

        if (!$user) {
            $user = $this->userModel->getUserByEmail($googleUser['email']);
            
            $userData = [
                'role_id' => 2,
                'first_name' => $googleUser['first_name'] ?? 'Google',
                'last_name' => $googleUser['last_name'] ?? 'User',
                'email' => $googleUser['email'],
                'password' => bin2hex(random_bytes(16)),
                'profile_pic' => $googleUser['profile_pic'],
                'social_provider' => 'google',
                'social_id' => $googleUser['social_id'],
                'status' => 'active',
            ];

            if (!$user) {
                $this->userModel->save($userData);
            } else {
                $userData['id'] = $user['id'];
                $this->userModel->save($userData);
            }

            $user = $this->userModel->getUserBySocialId('google', $googleUser['social_id']);
        }

        $this->userModel->updateLastLogin($user['id']);

        session()->set([
            'user_id' => $user['id'],
            'email' => $user['email'],
            'role_id' => $user['role_id'],
            'isLoggedIn' => true,
        ]);

        return true;
    }
}