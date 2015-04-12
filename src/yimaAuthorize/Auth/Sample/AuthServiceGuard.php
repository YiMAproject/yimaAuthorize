<?php
namespace yimaAuthorize\Auth\Sample;

use Poirot\AuthSystem\Authenticate\Exceptions\AccessDeniedException;
use Poirot\AuthSystem\Authenticate\Exceptions\UserNotActivatedException;
use yimaAuthorize\Auth\Interfaces\AuthServiceInterface;
use yimaAuthorize\Auth\Interfaces\GuardInterface;
use yimaAuthorize\Auth\Sample\Authorize\PermResource;
use Zend\EventManager\EventManagerInterface;
use Zend\Mvc\MvcEvent;

class AuthServiceGuard implements GuardInterface
{
    protected $listeners = array();

    /**
     * @var AuthServiceInterface
     */
    protected $authService;

    /**
     * Construct
     *
     * @param AuthServiceInterface $authService
     */
    public function __construct(AuthServiceInterface $authService)
    {
        $this->setAuthService($authService);
    }

    /**
     * {@inheritDoc}
     */
    public function attach(EventManagerInterface $events)
    {
        $this->listeners[] = $events->attach(
            MvcEvent::EVENT_ROUTE
            , array($this, 'onRoute')
            , -1000
        );
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
        $authService = $this->authService;

        $resource  = new PermResource();
        $match     = $event->getRouteMatch();
        $routeName = $match->getMatchedRouteName();
        $resource->setRouteName($routeName);

        if ($authService->isAllowed(null, $resource))
            // Authorized User with Access
            return true;

        // Redirect To Login Route,
        // i'm not stop events probation so be aware of that ...
        /*
        $match->setMatchedRouteName('');
        $match->setParam('controller', 'innClinic\Controller\Auth');
        $match->setParam('action', 'login');
        */

        // or ....

        throw new AccessDeniedException();
    }

    /**
     * Set Authentication Service Object
     *
     * @param AuthServiceInterface $authService Permission
     *
     * @return $this
     */
    function setAuthService(AuthServiceInterface $authService)
    {
        $this->authService = $authService;

        return $this;
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
