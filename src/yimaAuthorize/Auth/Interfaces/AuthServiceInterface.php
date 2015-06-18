<?php
namespace yimaAuthorize\Auth\Interfaces;
use Poirot\AuthSystem\Authenticate\Exceptions\AccessDeniedException;
use Poirot\AuthSystem\Authenticate\Interfaces\iAuthenticateProvider;
use Poirot\AuthSystem\Authorize\Interfaces\iAuthPermission;
use yimaAuthorize\Exception\AuthException;

/**
 * Interface PermissionInterface
 *
 * All AuthServices must implement this interface
 *
 * @package yimaAuthorize\Permission
 */
interface AuthServiceInterface
    extends
    iAuthPermission,
    iAuthenticateProvider
{
    /**
     * Throw Exception
     *
     * - usually inject $this Object argument into AuthException Class
     *   on return, so later to handle the error with guards we can
     *   response only for errors that rise from related AuthService
     *
     * - recommend exception have valid http response code as exception code
     *
     * @param AccessDeniedException|\Exception $exception
     *
     * @throws AuthException
     */
    function riseException(\Exception $exception = null);
}
