<?php
namespace yimaAuthorize;

use yimaAuthorize\Auth\Interfaces\AuthServiceInterface;
use yimaAuthorize\Auth\Interfaces\GuardInterface;
use yimaAuthorize\Auth\Interfaces\MvcAuthServiceInterface;
use yimaAuthorize\Service\AuthServiceManager;
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
     * @throws \Exception
     * @return void
     */
	public function onBootstrap(EventInterface $e)
	{
        /** @var $app \Zend\Mvc\Application */
        $app    = $e->getTarget();
        $events = $app->getEventManager();
        $sm     = $app->getServiceManager();

        // register each permission's guard to event manager
        $permsManager = $sm->get('yimaAuthorize.AuthServiceManager');
        if (!$permsManager instanceof AuthServiceManager)
            throw new \Exception(sprintf(
                'Invalid Permission Manager, It must be instance of "%s" but "%s" given.'
                , 'PermissionManager'
                , get_class($permsManager)
            ));

        foreach ($permsManager->getRegisteredServices() as $services) {
            if (is_array($services))
                foreach ($services as $prm) {
                    /** @var $prm AuthServiceInterface */
                    $prm   = $permsManager->get($prm);
                    if ($prm instanceof MvcAuthServiceInterface) {
                        /** @var $prm MvcAuthServiceInterface */
                        $guard = $prm->getGuard();
                        if ($guard && $guard instanceof GuardInterface)
                            $events->attach($guard);
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
            'factories' => [
                'yimaAuthorize.AuthServiceManager' => 'yimaAuthorize\Service\AuthServiceManagerFactory'
            ],
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
            'invokables' => [
                'authorize' => 'yimaAuthorize\Mvc\View\AuthorizeHelper'
            ],
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
            'invokables' => [
                'authorize' => 'yimaAuthorize\Mvc\Controller\AuthorizePlugin'
            ],
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
            'Zend\Loader\StandardAutoloader' => [
                'namespaces' => [
                    __NAMESPACE__ => __DIR__,
                ],
            ],
        );
    }
}
