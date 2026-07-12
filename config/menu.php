<?php

return [
    [
        'name' => 'Dashboard',
        'icon' => 'fas fa-home',
        'route' => 'dashboard',
        'permission' => 'view-dashboard',
    ],
    [
        'name' => 'Users',
        'icon' => 'fas fa-users',
        'route' => 'users.index',
        'permission' => 'manage-users',
    ],
    [
        'name' => 'Settings',
        'icon' => 'fas fa-cog',
        'route' => 'settings.index',
        'permission' => 'manage-settings',
    ],
];
