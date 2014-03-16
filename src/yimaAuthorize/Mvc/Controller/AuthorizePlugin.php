<?php
namespace yimaAuthorize\Mvc\Controller;

use yimaAuthorize\Mvc\AuthorizeAbstractHelper;
use Zend\Mvc\Controller\Plugin\PluginInterface;
use Zend\Stdlib\DispatchableInterface as Dispatchable;

/**
 * Class AuthorizeHelper
 *
 * @package yimaAuthorize\Mvc
 */
class AuthorizePlugin extends AuthorizeAbstractHelper implements
    PluginInterface
{
    protected $controller;

    /**
     * Set the current controller instance
     *
     * @param  Dispatchable $controller
     * @return void
     */
    public function setController(Dispatchable $controller)
    {
        $this->controller = $controller;
    }

    /**
     * Get the current controller instance
     *
     * @return null|Dispatchable
     */
    public function getController()
    {
        return $this->controller;
    }
}
