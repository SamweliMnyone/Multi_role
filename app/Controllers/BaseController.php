<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class BaseController extends Controller
{
    protected $helpers = ['form', 'url', 'auth'];

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        
        // Load any site-wide settings or data here
    }

    protected function render($view, $data = [])
    {
        $data['currentRoute'] = service('router')->getMatchedRouteOptions()[0] ?? '';
        $data['isLoggedIn'] = session()->has('user_id');
        
        if (session()->has('user_id')) {
            $userModel = new \App\Models\UserModel();
            $data['currentUser'] = $userModel->getUserWithRole(session()->get('user_id'));
        }

        echo view('Frontend/Layouts/header', $data);
        echo view($view, $data);
        echo view('Frontend/Layouts/footer', $data);
    }
}