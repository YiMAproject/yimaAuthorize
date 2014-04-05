<?php
namespace yimaAuthorize\Service;

use yimaAuthorize\Permission\PermissionInterface;

/**
 * Class PermissionsRegistry
 *
 * @TODO: Using pluginInterface (service locator against registry)
 *
 * @package yimaAuthorize\Service
 */
class PermissionsRegistry
{
    protected static $permissions = array();

    /**
     * Add permission set to registry
     *
     * @param PermissionInterface $permission
     *
     * @throws \Exception
     */
    public static function add(PermissionInterface $permission)
    {
        $name = $permission->getName();

        if (isset(self::$permissions[$name])) {
            throw new \Exception(
                sprintf(
                    'The permission with name "%s" exists and registered as "%s" class.',
                    $name,
                    get_class(self::$permissions[$name])
                )
            );
        }

        self::$permissions[$name] = $permission;
    }

    /**
     * Get permission set class
     *
     * @param $name
     *
     * @return PermissionInterface
     * @throws \Exception
     */
    public static function get($name)
    {
        if (!self::has($name)) {
            throw new \Exception(
                sprintf('"%s" not found in registry.', $name)
            );
        }

        return self::$permissions[$name];
    }

    /**
     * Has permission set registered?
     *
     * @param $name
     *
     * @return bool
     */
    public static function has($name)
    {
        return isset(self::$permissions[$name]);
    }

    /**
     * Remove permissions set
     *
     * @param $name
     */
    public static function remove($name)
    {
        if (self::has($name)) {
            unset(self::$permissions[$name]);
        }
    }

    /**
     * Get all registered permissions set
     *
     * @return array
     */
    public static function getRegistry()
    {
        return self::$permissions;
    }
}
