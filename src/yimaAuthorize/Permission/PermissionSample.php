<?php
namespace yimaAuthorize\Permission;

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
     * @param null|string $resource
     * @param null|string $privilege
     *
     * @return boolean
     */
    public function isAllowed($role = null, $resource = null, $privilege = null)
    {
        $ip = $_SERVER['SERVER_ADDR'];
        // we have not access on localhost server
        return !($ip == '127.0.0.1');
    }

    /**
     * Get identity name for current role
     * exp. guest for site members
     *
     * @return mixed
     */
    public function getRoleIdentity()
    {

    }

    /**
     * Get Identity data about current role
     *
     * @return mixed
     */
    public function getStorageIdentity()
    {

    }

    /**
     * Factory from array
     *
     * @param array $options
     *
     * @return mixed
     */
    public function factoryFromArray(array $options)
    {

    }

    /**
     * Get ListenerAggregateInterface guard
     *
     * @return mixed
     */
    public function getGuard()
    {

    }
}
