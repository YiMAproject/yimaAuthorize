<?php
namespace yimaAuthorize\Permission;

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
     * Get name of this permission section
     * - access from registry
     *
     * @return string
     */
    public function getName();

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
     * Get identity name for current role
     * exp. guest for site members
     *
     * @return mixed
     */
    public function getRoleIdentity();

    /**
     * Get Identity data about current role
     *
     * @return mixed
     */
    public function getStorageIdentity();

    /**
     * Factory from array
     *
     * @param array $options
     *
     * @return mixed
     */
    public function factoryFromArray(array $options);

    /**
     * Get ListenerAggregateInterface guard
     *
     * @return mixed
     */
    public function getGuard();
}
