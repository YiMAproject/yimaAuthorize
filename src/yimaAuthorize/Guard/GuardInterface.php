<?php
namespace yimaAuthorize\Guard;

use Zend\EventManager\ListenerAggregateInterface;

interface GuardInterface extends ListenerAggregateInterface
{
    /**
     * Get permission name
     *
     * @return string
     */
    public function getPermissionName();
}