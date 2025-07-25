<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Welcome to Multi-Role System',
            'description' => 'A complete user role management system built with CodeIgniter 4'
        ];
        
        return $this->render('Frontend/Home/index', $data);
    }
}