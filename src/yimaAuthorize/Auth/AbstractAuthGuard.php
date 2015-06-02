<?php
namespace yimaAuthorize\Auth;

use yimaAuthorize\Auth\Interfaces\AuthServiceInterface;
use yimaAuthorize\Auth\Interfaces\GuardInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\Session\Container;

abstract class AbstractAuthGuard implements GuardInterface
{
    protected $listeners = array();

    /**
     * @var AuthServiceInterface
     */
    protected $authService;

    /**
     * @var \Zend\Session\AbstractContainer
     */
    protected $session_flashes;

    /**
     * Construct
     *
     * @param AuthServiceInterface $authService
     */
    function __construct(AuthServiceInterface $authService)
    {
        $this->setAuthService($authService);
    }

    /**
     * Attach one or more listeners
     *
     * Implementors may add an optional $priority argument; the EventManager
     * implementation will pass this to the aggregate.
     *
     * - attach to self::$listeners
     *
     * @param EventManagerInterface $events
     *
     * @return void
     */
    abstract function attach(EventManagerInterface $events);
    /*
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
     */

    /*
    function onError(MvcEvent $event)
    {
        $error = $event->getError();

        if (!$error instanceof AuthException)
            // no error, we're ok
            return ;

        if (get_class($error->getAuthService()) !== get_class($this->authService))
            // we are only handle error rised from this service
            return ;

        // Save Current Request, To Redirect User After Login:
        $request = $event->getRequest();
        $this->storeRedirectUrl($request->getRequestUri());

        $router  = $event->getRouter();
        $url = $router->assemble(
            ['controller' => 'auth', 'action' => 'login']
            , ['name' => 'route-name']
        );

        // Redirect User To Login Page:
        $response = $event->getResponse();
        $response->getHeaders()->addHeaderLine('Location', $url);
        $response->setStatusCode(302);
        $event->setResult($response);
    }
    */

    /**
     * On UnAuthorized Or Banned Page Usually Guard redirect to login
     * page. here we store redirect url that can be restore on successful
     * login for redirect.
     *
     * note: it can implement to store on session, query string and so ...
     *
     * - when using sessions it must be fetched on target page(login) and
     *   can be stored on input field as hidden value and send to page with each login
     *   retrieval because it has hop for one page and destroyed next.
     *
     * @param $url
     */
    function storeRedirectUrl($url)
    {
        $sessionManager = $this->_getSessionFlashes();
        $sessionManager->offsetSet('auth.login.redirect_url', $url);
        $sessionManager->setExpirationHops(1, 'auth.login.redirect_url');
    }

    /**
     * Get Hop Stored Url
     *
     * ! be aware for hope and @see storeRedirectUrl
     *
     * @return string
     */
    function getStoredUrl()
    {
        return $this->_getSessionFlashes()->offsetGet('auth.login.redirect_url');
    }

    protected function _getSessionFlashes()
    {
        if (!$this->session_flashes)
            $this->session_flashes = new Container(get_class($this), Container::getDefaultManager());

        return $this->session_flashes;
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
    function detach(EventManagerInterface $events)
    {
        foreach ($this->listeners as $index => $listener) {
            if ($events->detach($listener)) {
                unset($this->listeners[$index]);
            }
        }
    }
}
