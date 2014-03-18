<?php
namespace yimaAuthorize\Guard;

use yimaAuthorize\Permission\PermissionInterface;
use Zend\EventManager\ListenerAggregateInterface;

interface GuardInterface extends ListenerAggregateInterface
{
    /**
     * Get permission
     *
     * @return PermissionInterface
     */
    public function getPermission();
}
