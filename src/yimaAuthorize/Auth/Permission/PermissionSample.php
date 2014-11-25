<?php
namespace yimaAuthorize\Auth\Permission;

use yimaAuthorize\Auth\Guard\GuardInterface;
use yimaAuthorize\Auth\Guard\SampleRouteGuard;

class PermissionSample implements PermissionInterface
{
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
