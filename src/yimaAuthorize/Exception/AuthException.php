<?php
namespace yimaAuthorize\Exception;

use Poirot\AuthSystem\Authenticate\Exceptions\AccessDeniedException as BaseException;
use yimaAuthorize\Auth\Interfaces\AuthServiceInterface;

/**
 * // default AccessDeniedException
 * $this->authorize('yima_authorize.sample')->riseException();
 * or
 * // Custom Reason Exception
 * $this->authorize('yima_authorize.sample')->riseException(new UserNotFoundException());
 *
 * ! we have injected authService that can catch on related exception handler later
 */
class AuthException extends BaseException
{
    /**
     * @var AuthServiceInterface
     */
    protected $authService;

    function __construct(
        AuthServiceInterface $authService,
        $code = 403,
        \Exception $previous = null
    )
    {
        $this->setAuthService($authService);

        parent::__construct(null, $code, $previous);
    }

    /**
     * @return AuthServiceInterface
     */
    function getAuthService()
    {
        return $this->authService;
    }

    /**
     * @param AuthServiceInterface $authService
     */
    function setAuthService($authService)
    {
        $this->authService = $authService;
    }
}
 