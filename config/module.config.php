<?php
use yimaAuthorize\Service\PermissionsPluginManager;

return array(
    'yima_authorize' => array(
        /**
         * @see PermissionsPluginManager
         * @see Zend\ServiceManager\Config
         */
        'permissions' => array(
            'invokables' => array(
                'yima.permission.sample' => 'yimaAuthorize\Permission\PermissionSample',
            ),
        ),
    ),
);
