<?php
return array(
    'yima_authorize' => array(
        'permissions' => array(
            # registered service that must return PermissionInterface instance
            'sample' => 'yimaAuthorize.Permission.Sample',
        ),
    ),

    'service_manager' => array(
        'invokables' => array(
            'yimaAuthorize.Permission.Sample' => 'yimaAuthorize\Permission\PermissionSample',
        ),
    ),
);
