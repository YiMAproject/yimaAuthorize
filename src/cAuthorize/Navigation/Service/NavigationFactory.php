<?php
namespace cAuthorize\Navigation\Service;

use Zend\Navigation\Service\DefaultNavigationFactory;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Mvc\Router\RouteMatch;
use Zend\Mvc\Router\RouteStackInterface as Router;
use Zend\Navigation\Exception;
use Zend\Mvc\ModuleRouteListener;

class NavigationFactory extends DefaultNavigationFactory
{
    protected function getName()
    {
        return 'authorize\navigation';
    }
    
    protected function getPages(ServiceLocatorInterface $serviceLocator)
    {
    	if (null === $this->pages) {
    		if (!$serviceLocator->has('authorized')) {
    			throw new Exception\InvalidArgumentException('Could not find "authorized" service, authentication not Occurrence yet.');
    		}
    		
    		$configuration = $serviceLocator->get('authorized');
    
    		if (!isset($configuration['account-navigation'])) {
    			$configuration['account-navigation'] = array();
    		}
    		
    		$config = &$configuration['account-navigation'];
    		$pages       = $this->getPagesFromConfig($config);
    		
    		$application = $serviceLocator->get('Application');
    		$routeMatch  = $application->getMvcEvent()->getRouteMatch();
    		$router      = $application->getMvcEvent()->getRouter();
    
    		$this->pages = $this->injectComponents($pages, $routeMatch, $router);
    	}
    	return $this->pages;
    }
}
