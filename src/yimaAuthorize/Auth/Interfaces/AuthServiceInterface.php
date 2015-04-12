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
     * - usually inject $this as AuthService into AuthException
     * - exception must have valid response code as error code
     *
     * @param AccessDeniedException|\Exception $exception
     *
     * @throws AuthException
     */
    function riseException(\Exception $exception = null);
}
