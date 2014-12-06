<?php
namespace yimaAuthorize\Auth\Sample;

use yimaAuthorize\Auth\GuardInterface;
use yimaAuthorize\Auth\PermissionInterface;

class Permission implements PermissionInterface
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
        return false;
    }

    /**
     * Get Identity
     *
     * - if user authorized
     *   it will get identity data for authorized user
     * else
     *   return false for unauthorized access
     *
     * @return mixed|false
     */
    public function getIdentity()
    {
        return false;
    }

    /**
     * Get guard
     *
     * @return GuardInterface
     */
    public function getGuard()
    {
        return new Guard($this);
    }
}
