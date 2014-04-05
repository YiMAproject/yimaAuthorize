<?php
namespace yimaAuthorize\Permission;
use yimaAuthorize\Guard\GuardInterface;
use yimaAuthorize\Guard\SampleRouteGuard;

/**
 * Class PermissionSample
 *
 * @package yimaAuthorize\Permission
 */
class PermissionSample implements PermissionInterface
{
    /**
     * Get name of this permission section
     * - access from registry
     *
     * @return string
     */
    public function getName()
    {
        return 'sample';
    }

    /**
     * Is allowed to features?
     *
     * @param null|string $role
     * @param null|string $resource Route name
     * @param null|string $privilege
     *
     * @return boolean
     */
    public function isAllowed($role = null, $resource = null, $privilege = null)
    {
        // we have not access on localhost server for route name "skeleton-core"
        return !($role == '127.0.0.1' && $resource == 'skeleton-core');
    }

    /**
     * Get Identity data about current role
     *
     * @return mixed
     */
    public function getIdentity()
    {
        return $_SERVER;
    }

    /**
     * Get guard
     *
     * @return GuardInterface
     */
    public function getGuard()
    {
        return new SampleRouteGuard($this);
    }
}
