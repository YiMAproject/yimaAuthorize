<?php
namespace yimaAuthorize\Mvc;

use Zend\Mvc\Controller\PluginManager;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\ServiceManager;
use Zend\View\HelperPluginManager;

class AuthorizeAbstractHelper implements
    ServiceLocatorAwareInterface
{
    /**
     * @var ServiceLocatorInterface
     */
    protected $serviceLocator;

    /**
     * functor()
     *
     * @param $pname
     *
     * @return \yimaAuthorize\Auth\PermissionInterface
     */
    public function __invoke($pname)
    {
        /** @var HelperPluginManager|PluginManager $sl */
        $sl = $this->getServiceLocator();
        /** @var ServiceManager $sm */
        $sm = $sl->getServiceLocator();

        // get registered PermissionsManager service and retrieve plugin
        $permissionsManager = $sm->get('yimaAuthorize.PermissionsManager');

        return $permissionsManager->get($pname);
    }

    /**
     * Set service locator
     *
     * @param ServiceLocatorInterface $serviceLocator
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    /**
     * Get service locator
     *
     * @return ServiceLocatorInterface
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }
}
