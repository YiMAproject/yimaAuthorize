<?php
namespace yimaAuthorize\Auth\Interfaces;
use Poirot\AuthSystem\Authenticate\Interfaces\iAuthenticateProvider;
use Poirot\AuthSystem\Authorize\Interfaces\iAuthPermission;

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

}
