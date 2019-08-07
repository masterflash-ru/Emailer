<?php
/**
* фабрика для плагина контроллера, плагин проедназначен для доступа к страницам внутри контроллеров
* например, для генерации писем уведомлений юзерам
*/

namespace Mf\Emailer\Controller\Plugin;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;


class EmailerFactory implements FactoryInterface
{
    /**
     * 
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $connection=$container->get('DefaultSystemDb');
        $config=$container->get('config');
        $ViewHelperManager=$container->get('ViewHelperManager');
        
        return new $requestedName($config,$ViewHelperManager,$connection);
    }

}
