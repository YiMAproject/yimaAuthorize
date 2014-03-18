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
        $ip = $this->getRoleIdentity();


        // we have not access on localhost server for route name "skeleton-core"
        return !($ip == '127.0.0.1' && $resource == 'skeleton-core');
    }

    /**
     * Get identity name for current role
     * exp. guest for site members
     *
     * @return mixed
     */
    public function getRoleIdentity()
    {
        return $_SERVER['SERVER_ADDR'];
    }

    /**
     * Get Identity data about current role
     *
     * @return mixed
     */
    public function getStorageIdentity()
    {
        return null;
    }

    /**
     * Factory from array
     *
     * @param array $options
     *
     * @return self
     */
    public function factoryFromArray(array $options)
    {
        return new self();
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
