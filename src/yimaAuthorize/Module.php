<?php
namespace yimaAuthorize;

use yimaAuthorize\Permission\PermissionInterface;
use Zend\EventManager\EventInterface;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ControllerPluginProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\ModuleManager\Feature\ViewHelperProviderInterface;

/**
 * Class Module
 *
 * @package yimaAuthorize
 */
class Module implements
    BootstrapListenerInterface,
    ServiceProviderInterface,
    ViewHelperProviderInterface,
    ControllerPluginProviderInterface,
    ConfigProviderInterface,
    AutoloaderProviderInterface
{
    /**
     * Listen to the bootstrap event
     *
     * @param EventInterface $e
     *
     * @return array
     */
	public function onBootstrap(EventInterface $e)
	{
        /** @var $app \Zend\Mvc\Application */
        $app    = $e->getTarget();
        $events = $app->getEventManager();
        $sm     = $app->getServiceManager();

        // register each permission guard to events
        $permsManager = $sm->get('yimaAuthorize.PermissionsManager');
        foreach ($permsManager->getRegisteredServices() as $srvcs) {
            if (is_array($srvcs) && !empty($srvcs)) {
                foreach ($srvcs as $prm) {
                    /** @var $prm PermissionInterface */
                    $prm   = $permsManager->get($prm);
                    $guard = $prm->getGuard();
                    if ($guard) {
                        $events->attach($guard);
                    }
                }
            }
        }
	}

    /**
     * Expected to return \Zend\ServiceManager\Config object or array to
     * seed such an object.
     *
     * @return array|\Zend\ServiceManager\Config
     */
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'yimaAuthorize.PermissionsManager' => 'yimaAuthorize\Service\PermissionManagerFactory'
            ),
        );
    }

    /**
     * Expected to return \Zend\ServiceManager\Config object or array to
     * seed such an object.
     *
     * @return array|\Zend\ServiceManager\Config
     */
    public function getViewHelperConfig()
    {
        return array(
            'invokables' => array(
                'authorize' => 'yimaAuthorize\Mvc\View\AuthorizeHelper'
            ),
        );
    }

    /**
     * Expected to return \Zend\ServiceManager\Config object or array to
     * seed such an object.
     *
     * @return array|\Zend\ServiceManager\Config
     */
    public function getControllerPluginConfig()
    {
        return array(
            'invokables' => array(
                'authorize' => 'yimaAuthorize\Mvc\Controller\AuthorizePlugin'
            ),
        );
    }

    /**
     * Returns configuration to merge with application configuration
     *
     * @return array|\Traversable
     */
    public function getConfig()
    {
        return include __DIR__ . '/../../config/module.config.php';
    }

    /**
     * Return an array for passing to Zend\Loader\AutoloaderFactory.
     *
     * @return array
     */
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__,
                ),
            ),
        );
    }
}
