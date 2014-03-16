<?php
namespace yimaAuthorize\Guard;

use yimaAuthorize\Service\PermissionsRegistry;
use Zend\EventManager\EventManagerInterface;
use Zend\Mvc\MvcEvent;

class SampleRouteGuard implements GuardInterface
{
    protected $listeners = array();

    /**
     * {@inheritDoc}
     */
    public function attach(EventManagerInterface $events)
    {
        $this->listeners[] = $events->attach(MvcEvent::EVENT_ROUTE, array($this, 'onRoute'), -1000);
    }

    /**
     * Event callback to be triggered on dispatch, causes application error triggering
     * in case of failed authorization check
     *
     * @param MvcEvent $event
     *
     * @return void
     */
    public function onRoute(MvcEvent $event)
    {
        $service    = PermissionsRegistry::get($this->getPermissionName());

        $match      = $event->getRouteMatch();
        $routeName  = $match->getMatchedRouteName();

        if ($service->isAllowed($service->getRoleIdentity(), $routeName)) {
            return;
        }

        $event->setError('You have not authorized to access');
        $event->setParam('route', $routeName);
        $event->setParam('identity', $service->getRoleIdentity());
        $event->setParam('exception', new \Exception('You are not authorized to access ' . $routeName));

        /* @var $app \Zend\Mvc\Application */
        $app = $event->getTarget();

        $app->getEventManager()->trigger(MvcEvent::EVENT_DISPATCH_ERROR, $event);
    }

    /**
     * Get permission name
     *
     * @return string
     */
    public function getPermissionName()
    {
        // now we have only write down a sample, you can use guards for every permissions
        // - by setting permission name to class

        // we use this on getting service from PermissionsRegistry
        // as you can see on onRoute method

        return 'sample';
    }

    /**
     * Detach all previously attached listeners
     *
     * @param EventManagerInterface $events
     *
     * @return void
     */
    public function detach(EventManagerInterface $events)
    {
        // TODO: Implement detach() method.
    }
}
