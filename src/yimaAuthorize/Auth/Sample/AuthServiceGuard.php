<?php
namespace yimaAuthorize\Auth\Sample;

use Poirot\AuthSystem\Authenticate\Exceptions\AccessDeniedException;
use yimaAuthorize\Auth\Interfaces\AuthServiceInterface;
use yimaAuthorize\Auth\Interfaces\GuardInterface;
use yimaAuthorize\Auth\Sample\Authorize\PermResource;
use yimaAuthorize\Exception\AuthException;
use yimaBase\Mvc\Application;
use yimaBase\Mvc\MvcEvent;
use Zend\EventManager\EventManagerInterface;
use Zend\Http\Response;

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

        $this->listeners[] = $events->attach(
            MvcEvent::EVENT_ERROR
            , array($this, 'onError')
            , 10001
        );
    }

    /**
     * Event callback to be triggered on dispatch, causes application error triggering
     * in case of failed authorization check
     *
     * @param MvcEvent $event
     */
    public function onRoute(MvcEvent $event)
    {
        $authService = $this->authService;

        $resource  = new PermResource();
        $match     = $event->getRouteMatch();
        $routeName = $match->getMatchedRouteName();
        $resource->setRouteName($routeName);

        if ($authService->isAllowed($resource, null))
            // Authorized User with Access
            return ;

        $authService->riseException(new AccessDeniedException());
    }

    function onError(MvcEvent $event)
    {
        $error = $event->getError();

        if (!$error instanceof AuthException)
            // no error, we're ok
            return ;

        if (get_class($error->getAuthService()) !== get_class($this->authService))
            // we are only handle error rised from this service
            return ;

        // We Can Output something with Event::setResult($res);

        ## $res can be Response, ViewModel Instance or an array feed for Default ViewModel
        $response = $event->getResponse();
        $response->getHeaders()->addHeaderLine('Location', '/auth/login');
        $response->setStatusCode(302);
        $event->setResult($response);

        # or
        // $event->setResult(['this' => 'is_content']);

        ## We can stop further events -----
        # $event->stopPropagation();

        ## and return result
        # return $response;
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
