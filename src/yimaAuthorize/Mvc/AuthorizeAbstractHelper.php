<?php
namespace yimaAuthorize\Mvc;

use yimaAuthorize\Service\PermissionsRegistry;

/**
 * Class AuthorizeAbstractHelper
 *
 * @package yimaAuthorize\Mvc
 */
class AuthorizeAbstractHelper
{
    /**
     * functor()
     *
     * @param $pname
     *
     * @return \yimaAuthorize\Permission\PermissionInterface
     */
    public function __invoke($pname)
    {
        return PermissionsRegistry::get($pname);
    }
}
