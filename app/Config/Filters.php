<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\Honeypot;
use CodeIgniter\Filters\InvalidChars;
use CodeIgniter\Filters\SecureHeaders;

class Filters extends BaseConfig
{
    public $aliases = [
        'csrf'     => CSRF::class,
        'toolbar'  => DebugToolbar::class,
        'honeypot' => Honeypot::class,
        'invalidchars' => InvalidChars::class,
        'secureheaders' => SecureHeaders::class,
        'auth' => \App\Filters\AuthFilter::class,
        'admin' => \App\Filters\AdminFilter::class,
    ];

    public $globals = [
        'before' => [
            'csrf' => ['except' => ['auth/google/callback']],
        ],
        'after' => [
            'toolbar',
        ],
    ];

    public $methods = [];

    public $filters = [];
}