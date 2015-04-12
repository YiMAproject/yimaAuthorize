<?php
namespace yimaAuthorize\Auth\Interfaces;

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
     * Set Authentication Service Object
     *
     * @param AuthServiceInterface $authService Permission
     *
     * @return $this
     */
    function setAuthService(AuthServiceInterface $authService);
}
