<?php
namespace Mf\Emailer;

return [
    /*плагин контроллера для доступа Emailer - генерация и льправка писем HTML, например, уведомлений*/
    'controller_plugins' => [
        'aliases' => [
            'Emailer' => Controller\Plugin\Emailer::class,
            'emailer' => Controller\Plugin\Emailer::class,
        ],
        'factories' => [
            Controller\Plugin\Emailer::class => Controller\Plugin\EmailerFactory::class,
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
    /*сетка для админки*/
    "interface"=>[
        "emailer"=>__DIR__."/admin.emailer.php",
    ],
    "emailer"=>[
        "config"=>[
            "database"  =>  "DefaultSystemDb",
            "cache"     =>  "DefaultSystemCache",
        ],
    ],
];
