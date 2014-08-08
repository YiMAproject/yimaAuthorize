<?php
namespace yimaAuthorize\Service;

use Zend\Mvc\Application;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\Config as ServiceConfig;

/**
 * Class PermissionManagerFactory
 *
 * @package yimaAuthorize\Service
 */
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

        /** @var $events \Zend\EventManager\EventManager */
        $events = $application->getEventManager();

        // -------------------------------------------------------------------------------------

        $config = $application->getConfig();
        $config = (isset($config['yima_authorize']) && is_array($config['yima_authorize']))
            ? $config['yima_authorize']
            : array();

        // add existance permissions to registry >>> {
        $permsConfig  = (isset($config['permissions'])) ? $config['permissions'] : array();
        $permsConfig  = new ServiceConfig($permsConfig);
        /** @var $permsManager \yimaAuthorize\Service\PermissionsPluginManager */
        $permsManager = new PermissionsPluginManager($permsConfig);

        // register each permission guard to events
        foreach ($permsManager->getRegisteredServices() as $srvcs) {
            if (is_array($srvcs) && !empty($srvcs)) {
                foreach ($srvcs as $prm) {
                    $prm = $permsManager->get($prm);

                    $guard = $prm->getGuard();
                    if ($guard) {
                        $events->attach($guard);
                    }
                }
            }
        }

        return $permsManager;
        // <<< }
    }
}
