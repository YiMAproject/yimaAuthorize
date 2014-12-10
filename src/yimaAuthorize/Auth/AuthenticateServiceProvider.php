<?php
namespace yimaAuthorize\Auth;

use Zend\Authentication\AuthenticationService;

/**
 * Permissions can implement Authentication Service-
 * Provider to Authenticate Identity
 *
 */
interface AuthenticateServiceProvider
{
    /**
     * Get Authentication Service
     *
     * @return AuthenticationService
     */
    function getAuthService();
} 