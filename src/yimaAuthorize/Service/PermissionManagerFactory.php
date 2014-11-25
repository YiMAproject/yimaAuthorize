<?php
namespace yimaAuthorize\Service;

use Zend\Mvc\Application;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\Config as ServiceConfig;

class PermissionManagerFactory implements FactoryInterface {

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var $application Application */
        $application = $serviceLocator->get('application');

        // -------------------------------------------------------------------------------------

        $config = $application->getConfig();
        $config = (isset($config['yima_authorize']) && is_array($config['yima_authorize']))
            ? $config['yima_authorize']
            : array();

        // add existance permissions to registry >>> {
        $permsConfig  = (isset($config['permissions'])) ? $config['permissions'] : array();
        $permsConfig  = new ServiceConfig($permsConfig);
        /** @var $permsManager \yimaAuthorize\Service\PermissionManager */
        $permsManager = new PermissionManager($permsConfig);

        return $permsManager;
        // <<< }
    }
}
