<?php
namespace yimaAuthorize\Auth\Sample;

use yimaAuthorize\Auth\AccessDeniedException;
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
     * @return true
     */
    public function onRoute(MvcEvent $event)
    {
        $service    = $this->getPermission();

        $resource  = new Resource();
        $match     = $event->getRouteMatch();
        $routeName = $match->getMatchedRouteName();
        $resource->setRouteName($routeName);

        // Change current identity, use case only >>>> {
        $identity = new Identity();
        # change this number to any other that 1 cause denied access except of home
        # see Permission class
        $identity->setUid(1);
        $identity->data()->set('full_name', 'Payam Naderi');
        $identity->data()->set('mail', 'naderi.payam@gmail.com');
        // <<<< }

        if ($service->isAllowed($identity, $resource))
            // Authorized User with Access
            return true;

        throw new AccessDeniedException(
            'You have not authorized to access',
            404
        );
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
    protected function getPermission()
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
        foreach ($this->listeners as $index => $listener) {
            if ($events->detach($listener)) {
                unset($this->listeners[$index]);
            }
        }
    }
}
