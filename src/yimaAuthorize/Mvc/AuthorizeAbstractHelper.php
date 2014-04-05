<?php
namespace yimaAuthorize\Mvc;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class AuthorizeAbstractHelper
 *
 * @package yimaAuthorize\Mvc
 */
class AuthorizeAbstractHelper implements ServiceLocatorAwareInterface
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
     * @return \yimaAuthorize\Permission\PermissionInterface
     */
    public function __invoke($pname)
    {
        // get parent serviceLocator(SM) from pluginManagers
        $sl = $this->getServiceLocator();
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
