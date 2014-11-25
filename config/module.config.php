<?php
use yimaAuthorize\Service\PermissionManager;

return array(
    'yima_authorize' => array(
        /**
         * @see PermissionManager
         * @see Zend\ServiceManager\Config
         */
        'permissions' => array(
            'invokables' => array(
                'yima_authorize.sample' => 'yimaAuthorize\Permission\PermissionSample',
            ),
        ),
    ),
);
