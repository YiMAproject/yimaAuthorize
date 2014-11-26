<?php
namespace yimaAuthorize\Auth\Sample;

use yimaAuthorize\Auth\GuardInterface;
use yimaAuthorize\Auth\PermissionInterface;

use Zend\EventManager\EventManagerInterface;
use Zend\Mvc\MvcEvent;

class Guard implements GuardInterface
{
    protected $listeners = array();

    /**
     * @var PermissionInterface
     */
    protected $permission;

    /**
     * Construct
     *
     * @param PermissionInterface $permission
     */
    public function __construct(PermissionInterface $permission)
    {
        $this->setPermission($permission);
    }

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
        $service    = $this->getPermission();

        $match      = $event->getRouteMatch();
        $routeName  = $match->getMatchedRouteName();

        $role = $service->getIdentity();
        $role = $role['REMOTE_ADDR'];

        if ($service->isAllowed($role, $routeName))
            return;

        $event->setError('You have not authorized to access');
        $event->setParam('route', $routeName);
        $event->setParam('identity', $service->getIdentity());
        $event->setParam('exception', new \Exception('You are not authorized to access ' . $routeName));

        /* @var $app \Zend\Mvc\Application */
        $app = $event->getTarget();

        $app->getEventManager()->trigger(MvcEvent::EVENT_DISPATCH_ERROR, $event);
    }

    /**
     * Set permission Object
     *
     * @param PermissionInterface $permission Permission
     *
     * @return $this
     */
    public function setPermission(PermissionInterface $permission)
    {
        $this->permission = $permission;

        return $this;
    }

    /**
     * Get permission object
     *
     * @return PermissionInterface
     */
    public function getPermission()
    {
        return $this->permission;
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
