<?php
return [
    [
        'icon'=>'nav-icon fas fa-th',
        'route'=>'admin.dashboard',
        'title'=>'Dashboard',
        'badge'=>'New',
        'active'=>'admin.dashboard',
        'ability'=>'dashboard.view'
    ],
    [
        'icon'=>'far fa-circle nav-icon',
        'route'=>'admin.category.index',
        'title'=>'categories',
        'active'=>'admin.category.*',
        "ability"=>"category.view"
    ],
    [
        'icon'=>'far fa-circle nav-icon',
        'route'=>'admin.product.index',
        'title'=>'products',
        'active'=>'admin.product.*',
        'ability'=>'product.view'
    ],
    [
        'icon'=>'far fa-circle nav-icon',
        'route'=>'admin.role.index',
        'title'=>'roles',
        'active'=>'admin.role.*',
        'ability'=>'role.view'
    ],
    [
        'icon'=>'far fa-circle nav-icon',
        'route'=>'admin.admin.index',
        'title'=>'admin',
        'active'=>'admin.admin.*',
        'ability'=>'role.view'
    ],

]

?>