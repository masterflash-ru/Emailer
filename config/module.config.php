<?php
namespace Mf\Emailer;

return [
    'service_manager' => [
        'factories' => [//сервисы-фабрики
        ],
    ],

    //контроллеры
    'controllers' => [
        'factories' => [
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];
