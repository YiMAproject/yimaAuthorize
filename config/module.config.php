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

    'view_manager' => array(
        // Set Exceptions Specific LayoutScript
        # used with ExceptionMvcStrategyListener
        'layout_exception' => [
            // Access Denied Template, Usually Rise From Guards
            'Poirot\AuthSystem\Authenticate\Exceptions\AccessDeniedException' => 'spec/error',
        ],
    ),
);
