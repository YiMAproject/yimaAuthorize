<?php
namespace yimaAuthorize\Auth\Guard;

use yimaAuthorize\Auth\Permission\PermissionInterface;

use Zend\EventManager\ListenerAggregateInterface;

/**
 * Interface GuardInterface
 *
 * Each Guard Attach Some Listener(s) To Event Manager
 * Listeners Using Permission Object to get Access Control Data-
 * - such as issAllowed(blah, blah, ..);
 *
 * @package yimaAuthorize\Auth\Guard
 */
interface GuardInterface extends ListenerAggregateInterface
{
    /**
     * Set permission Object
     *
     * @param PermissionInterface $permission Permission
     *
     * @return $this
     */
    public function setPermission(PermissionInterface $permission);
}
