<?php
namespace yimaAuthorize;

use yimaAuthorize\Service\PermissionsRegistry;
use Zend\EventManager\EventInterface;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ControllerPluginProviderInterface;
use Zend\ModuleManager\Feature\ViewHelperProviderInterface;
use Zend\Mvc\Application;
use Zend\Mvc\MvcEvent;

/**
 * Class Module
 *
 * @package yimaAuthorize
 */
class Module implements
    BootstrapListenerInterface,
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
        /** @var $e MvcEvent */
        /** @var $application Application */
        $application = $e->getTarget();

        /** @var $sm \Zend\ServiceManager\ServiceManager */
        $sm = $application->getServiceManager();

        // -------------------------------------------------------------------------------------

        $config = $application->getConfig();
        $config = (isset($config['yima_authorize']) && is_array($config['yima_authorize']))
            ? $config['yima_authorize']
            : array();

        // add existance permissions to registry >>> {
        $permissions = (isset($config['permissions'])) ? $config['permissions'] : array();
        foreach ($permissions as $name => $p) {
            if (is_string($p) && $sm->has($p)) {
                $p = $sm->get($p);
            }

            PermissionsRegistry::add($p);
        }
        // <<< }

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
