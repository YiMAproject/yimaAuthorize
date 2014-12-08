<?php
namespace yimaAuthorize\Auth\Sample;

use Poirot\Collection\Entity;
use yimaAuthorize\Auth\AbstractResource;
use yimaAuthorize\Auth\GuardInterface;
use yimaAuthorize\Auth\IdentityInterface;
use yimaAuthorize\Auth\PermissionInterface;

class Permission implements PermissionInterface
{
    /**
     * Is allowed to features?
     *
     * - get currently identity object if $role not passed
     *
     * @param null|IdentityInterface $role
     * @param null|AbstractResource $resource
     *
     * @throws \Exception
     * @return boolean
     */
    public function isAllowed(IdentityInterface $role = null, /*Resource*/ $resource = null)
    {
        $role = ($role) ?: $this->getIdentity();
        if (!is_object($resource)
            || (!$resource instanceof Resource || !method_exists($resource, 'getRouteName'))
        )
            throw new \Exception('Invalid Resource To Check The Permissions.');

        $isAllowed = false;
        switch($resource->getRouteName()) {
            case 'home':
                // all has access to home
                $isAllowed = true;
                break;
            default:
                if ($role->getUid() == 1)
                    // only super admin access to all routes(pages)
                    $isAllowed = true;
        }

        return $isAllowed;
    }

    /**
     * Get Identity
     *
     * - if user authorized
     *   it will get identity data for authorized user
     * else
     *   return false for unauthorized access
     *
     * @return mixed|false
     */
    public function getIdentity()
    {
        $identity = new Identity();

        if (isset($_SESSION['auth_user'])) {
            $session = $_SESSION['auth_user'];
            $identity->setUid($session['uid']);
            $identity->data()->setFrom(new Entity($session['data']));
        }

        return $identity;
    }

    /**
     * Get guard
     *
     * @return GuardInterface
     */
    public function getGuard()
    {
        return new Guard($this);
    }
}
