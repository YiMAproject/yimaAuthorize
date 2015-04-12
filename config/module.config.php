<?php
return array(
    'yima_authorize' => [
        /**
         * @see AuthServiceManager
         * @see Zend\ServiceManager\Config
         */
        'services' => [
            'invokables' => [
                'yima_authorize.sample' => 'yimaAuthorize\Auth\Sample\AuthService',
            ],
        ],
    ],
);
