<?php
namespace cAuthorize\Widget\Account;

use Widget\AbstractWidget;
use Zend\View\Model\ViewModel;
use Zend\Navigation\AbstractContainer;
use Zend\View\Helper\Navigation as NavigationHelper;
use Widget\Exception;

class Widget extends AbstractWidget
{
	public function doneAction()
	{
		$sl = $this->getServiceLocator();

		$authenticated = false;
		if ($sl->has('authorized')) {
			$service = $sl->get('authorized');
			
			$auth_service   = $service['service'];
			$navigation     = $sl->get('authorize\navigation');
			$authenticated  = true;
		}
		
		return compact('authenticated','auth_service','navigation');
	}
}
