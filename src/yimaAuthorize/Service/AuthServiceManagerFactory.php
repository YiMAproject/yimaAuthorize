<?php
namespace yimaAuthorize\Service;

use Zend\Mvc\Application;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\Config as ServiceConfig;

class AuthServiceManagerFactory implements FactoryInterface {

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

        $config = $serviceLocator->get('Config');
        $config = (isset($config['yima_authorize']) && is_array($config['yima_authorize']))
            ? $config['yima_authorize']
            : array();

        // add existance permissions to registry >>> {
        $permsConfig  = (isset($config['services'])) ? $config['services'] : array();
        $permsConfig  = new ServiceConfig($permsConfig);
        /** @var $permsManager \yimaAuthorize\Service\AuthServiceManager */
        $permsManager = new AuthServiceManager($permsConfig);

        return $permsManager;
        // <<< }
    }
}
