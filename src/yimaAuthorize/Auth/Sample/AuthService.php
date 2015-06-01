<?php
namespace yimaAuthorize\Auth\Sample;

use Poirot\AuthSystem\Authenticate\Adapter\AggrAuthAdapter;
use Poirot\AuthSystem\Authenticate\Adapter\DigestFileAuthAdapter;
use Poirot\AuthSystem\Authenticate\Exceptions\AccessDeniedException;
use Poirot\AuthSystem\Authenticate\Interfaces\iAuthenticateAdapter;
use Poirot\AuthSystem\Authenticate\Interfaces\iIdentity;
use Poirot\AuthSystem\Authorize\Interfaces\iAuthResource;
use Poirot\AuthSystem\BaseIdentity;
use yimaAuthorize\Auth\Interfaces\GuardInterface;
use yimaAuthorize\Auth\Interfaces\MvcAuthServiceInterface;
use yimaAuthorize\Auth\Sample\Authorize\PermResource;
use yimaAuthorize\Exception\AuthException;

class AuthService implements MvcAuthServiceInterface
{
    /**
     * @var AggrAuthAdapter
     */
    protected $__authAdapter;

    /**
     * Is allowed to features?
     *
     * @param null|iAuthResource $resource
     * @param null|iIdentity     $role
     *
     * @throws \Exception
     * @return boolean
     */
    function isAllowed(/*iAuthResource*/ $resource = null, /*iIdentity*/ $role = null)
    {
        $role = ($role) ?: $this->getAuthAdapter()->identity();

        if (!is_object($resource)
            || (!$resource instanceof PermResource || !method_exists($resource, 'getRouteName'))
        )
            throw new \Exception('Invalid Resource Type, Can`t Check The Permissions.');

        // All has access on home, but authorized users has access on other routes
        return ($resource->getRouteName() == 'home' || $role->hasAuthenticated());
    }

    /**
     * Get Authenticate Adapter
     *
     * @return iAuthenticateAdapter
     */
    function getAuthAdapter()
    {
        if (!$this->__authAdapter) {
            $authAdapter = new AggrAuthAdapter(new BaseIdentity(get_class($this)));
            $authAdapter->addAuthentication(
                new DigestFileAuthAdapter()
            );

            $this->__authAdapter = $authAdapter;
        }

        return $this->__authAdapter;
    }

    /**
     * Get guard
     *
     * @return GuardInterface
     */
    public function getGuard()
    {
        // set this as guard authService
        return new AuthServiceGuard($this);
    }

    /**
     * Throw Exception
     *
     * - usually inject $this as AuthService into AuthException
     * - exception must have valid response code as error code
     *
     * @param AccessDeniedException|\Exception $exception
     *
     * @throws AuthException
     */
    function riseException(\Exception $exception = null)
    {
        ($exception !== null) ?: $exception = new AccessDeniedException();

        throw new AuthException($this, $exception->getCode(), $exception);
    }
}
