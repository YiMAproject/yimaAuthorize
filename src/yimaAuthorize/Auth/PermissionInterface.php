<?php
namespace yimaAuthorize\Auth;

/**
 * Interface PermissionInterface
 *
 * All permission services must implement this interface
 *
 * @package yimaAuthorize\Permission
 */
interface PermissionInterface
{
    /**
     * Is allowed to features?
     *
     * - get currently identity object if $role not passed
     *
     * @param null|IdentityInterface $role
     * @param null|AbstractResource  $resource
     *
     * @return boolean
     */
    public function isAllowed(IdentityInterface $role = null, /*AbstractResource*/ $resource = null);

    /**
     * Get Identity
     *
     * - if user authorized
     *   it will get identity data for authorized user
     * else
     *   return false|empty IdentityInterface for unauthorized access
     *
     * @return IdentityInterface|false
     */
    public function getIdentity();

    /**
     * Get guard
     *
     * @return GuardInterface
     */
    public function getGuard();
}
