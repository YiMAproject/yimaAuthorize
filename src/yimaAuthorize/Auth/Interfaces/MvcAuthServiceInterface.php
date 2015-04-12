<?php
namespace yimaAuthorize\Auth\Interfaces;

/**
 * Mvc Authentication Services Attached To Event Manager
 * On Application Bootstrap
 *
 */
interface MvcAuthServiceInterface extends AuthServiceInterface
{
    /**
     * Get guard
     *
     * @return GuardInterface
     */
    public function getGuard();
}
