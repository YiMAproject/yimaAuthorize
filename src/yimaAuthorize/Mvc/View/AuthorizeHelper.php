<?php
namespace yimaAuthorize\Mvc\View;

use yimaAuthorize\Mvc\AuthorizeAbstractHelper;
use Zend\View\Helper\HelperInterface;
use Zend\View\Renderer\RendererInterface;

class AuthorizeHelper extends AuthorizeAbstractHelper
    implements HelperInterface
{
    /**
     * View object instance
     *
     * @var RendererInterface
     */
    protected $view = null;

    /**
     * Set the View object
     *
     * @param RendererInterface $view
     *
     * @return $this
     */
    public function setView(RendererInterface $view)
    {
        $this->view = $view;

        return $this;
    }

    /**
     * Get the view object
     *
     * @return null|RendererInterface
     */
    public function getView()
    {
        return $this->view;
    }
}
