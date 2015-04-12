<?php
namespace yimaAuthorize\Auth\Sample\Authorize;

use Poirot\AuthSystem\Authorize\Interfaces\iAuthResource;
use Poirot\Core\AbstractOptions;

class PermResource extends AbstractOptions
    implements iAuthResource
{
    protected $routeName;

    function setRouteName($routeName)
    {
        $this->routeName = (string) $routeName;
    }

    function getRouteName()
    {
        return $this->routeName;
    }
}
