<?php
namespace yimaAuthorize\Permission;
use yimaAuthorize\Guard\GuardInterface;

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
     * @param null|string $role
     * @param null|string $resource
     * @param null|string $privilege
     *
     * @return boolean
     */
    public function isAllowed($role = null, $resource = null, $privilege = null);

    /**
     * Get Identity data for current authenticated role
     *
     * @return mixed
     */
    public function getIdentity();

    /**
     * Get guard
     *
     * @return GuardInterface
     */
    public function getGuard();
}
