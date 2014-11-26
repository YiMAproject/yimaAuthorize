<?php
namespace yimaAuthorize\Auth;

use Zend\EventManager\ListenerAggregateInterface;

/**
 * Interface GuardInterface
 *
 * Each Guard Attach Some Listener(s) To Event Manager
 * Listeners Using Permission Object to get Access Control Data-
 * - such as issAllowed(blah, blah, ..);
 *
 * @package yimaAuthorize\Auth
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
