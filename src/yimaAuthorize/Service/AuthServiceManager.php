<?php
namespace yimaAuthorize\Service;

use yimaAuthorize\Auth\Interfaces\MvcAuthServiceInterface;
use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\ConfigInterface;

/**
 * Class PermissionsPluginManager
 *
 * @package yimaAuthorize\Service
 */
class AuthServiceManager extends AbstractPluginManager
{
    /**
     * Constructor
     *
     * @param  null|ConfigInterface $configuration
     */
	public function __construct(ConfigInterface $configuration = null)
	{
		parent::__construct($configuration);
	}

    /**
     * Validate the plugin
     *
     * @param mixed $plugin
     *
     * @throws \Exception
     */
    public function validatePlugin($plugin)
    {
        if ($plugin instanceof MvcAuthServiceInterface) {
            // we're okay
            return;
        }

        throw new \Exception(
            sprintf(
                'Plugin of type %s is invalid; must implement MvcAuthServiceInterface',
                is_object($plugin) ? get_class($plugin) : gettype($plugin)
            )
        );
    }
}
