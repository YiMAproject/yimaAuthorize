<?php
namespace cAuthorize;

use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router;

class Module 
{
	protected $application;
	
	/**
	 * Class internally used 
	 */
	protected $routeMatch;
	
	protected $config;
	
	// initalization implemented methods .................................................................... 
		
	public function onBootstrap($e) 
	{
		$application = $e->getApplication();
		  
		$events = $application->getEventManager();
		$events->attach(MvcEvent::EVENT_ROUTE, array($this, 'authenticate'), -10000);
		
		$this->application = $application; 
	}
	
	public function getServiceConfig()
	{
		return array(
			'factories' => array (
				'authorize\navigation' => 'cAuthorize\Navigation\Service\NavigationFactory',
			),
		);
	}
	
	public function getConfig()
	{
		return include __DIR__ . '/config/module.config.php';
	}
	
	public function getAutoloaderConfig()
	{
		return array('Zend\Loader\StandardAutoloader' => array(
			'namespaces' => array(
				__NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
			),
		));
	}
	
	// ......................................................................................................
	
	public function authenticate(MvcEvent $e) 
	{
		$matches = $this->application->getMvcEvent()->getRouteMatch();
		if (! $matches instanceof Router\RouteMatch) {
			// Can't do anything without a route match
			return;
		}
		$this->routeMatch = $matches; 
		
		$config = $this->getProtectedConfig();
		foreach ($config as $protectedName => $options ) 
		{
			/*
			 *  'mode'     => 'route',
				'options'  => array('route' => 'admin/*'),
				'service'  => 'cAdmin\Authentication\Service',
				'isValid'  => null,
				'notValid' => array ('controller' => 'Index', 'action' => 'noaccess' )
			*/
			
			$authServ = $this->prepareService($options['mode'],$options['options'],$options['service']);
			if (! $authServ) {
				// not match current request
				continue;
			}
			
			if ( $authServ->hasIdentity() ) {
				// we are authenticating
				
				$this->registerService($protectedName);
				return true;
			}
			
			$result = $authServ->authenticate();
			
			// usually nothing to do, maybe you want redirect to a page or controller ........................
			if ($result->isValid()) 
			{
				/*
				 * function someFunction() 
				 * $methodVariable = array($anObject, 'someMethod');
				 */
				if ( is_callable($options['isValid'],true) ) {
					$func = $options['isValid'];
					call_user_func_array($func, array($this->application));
				}
				
				$this->registerService($protectedName);
				return true;
			}
			
			// usually change controller to access denied page ..............................................
			if ( is_array($options['notValid']) ){
				// this is must be: array ('controller' => 'Index', 'action' => 'noaccess' ) 
				foreach ($options['notValid'] as $key=>$val) {
					$matches->setParam($key,$val);
				}
			}
				
			return false;
		} // end foreach
		
	}
	
	protected function registerService($protectedName)
	{
		$app = $this->application;
		$sl  = $app->getServiceManager();
		
		$config  = $this->getProtectedConfig();
		$srvName = 'authorized\\'.$protectedName; 
		$sl->setService($srvName, $config[$protectedName]);
		$sl->setAlias('authorized', $srvName);
	}
	
	/**
	 * Bar asaase $mode dar moghabele $options test mikonad ke aayaa
	 * baa request e fe'li tatbigh daarad agar bood service raaa bar 
	 * migardaanad.
	 * 
	 * @param string $mode 
	 * @param string|array $options
	 * @param string $service
	 * @return boolean
	 */
	protected function prepareService($mode,$options,$service)
	{
		switch ($mode) {
			# this is a route name
			case 'route':
				$matchedRoute = $this->routeMatch->getMatchedRouteName();
				
				$Route = $options['route'];
				if ( strstr($Route, '/*') ) {
					// this is not regular expression just plain route
					$Route = substr( $Route, 0, strpos($Route, '/*') );
					
					// we are not in route
					# exp. $Route is [admin]/* we are in [admin]/path/to/page
					if (strpos($matchedRoute,$Route) !== 0) {
						return false;
					}
				}
				else {
					// regular expression check
					// ...
					
					return false;
				}
				
				break;
				
			default: return false;
		}
		
		$serviceLocator = $this->application->getServiceManager();
		if ($serviceLocator->has($service)) {
			return $serviceLocator->get($service);
		}
		
		// throw exception for not founded service
	}
	
	protected function getProtectedConfig()
	{
		if (isset($this->config)) {
			return $this->config;
		}
		
		$serviceLocator = $this->application->getServiceManager();
		
		$config = $serviceLocator->get('config'); $authConf = array();
		if (isset($config['authorize']) && isset($config['authorize']['protected'])) {
			if (is_array($config['authorize']['protected'])) {
				$authConf = $config['authorize']['protected'];
			}
		}
		
		$this->config = $authConf; 
		return $this->config;
	}
	
}
