<?php
namespace yimaAuthorize\Auth\Sample;

use yimaAuthorize\Auth\AbstractResource;

class Resource extends AbstractResource
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
