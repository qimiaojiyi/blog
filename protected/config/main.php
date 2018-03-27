<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'七秒记忆',
        'defaultController'=>'home/index',
	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
                'application.modules.manager.controller.*',
                'ext.image.*',
                'ext.category.*',
                'ext.wechat.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
                'manager'=>array(
                    'layout'=>'manager',
                    'defaultController' => 'default/login',
                ),
                'ucenter'=>array(
                    'layout'=>'umanager',
                    'defaultController' => 'Index/index',
                ),
		//'gii'=>array(
		//	'class'=>'system.gii.GiiModule',
		//	'password'=>'Enter Your Password Heres',
		//	// If removed, Gii defaults to localhost only. Edit carefully to taste.
		//	'ipFilters'=>array('127.0.0.1','::1'),
		//),
	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),

		// uncomment the following to enable URLs in path-format
		'urlManager'=>array(
			'urlFormat'=>'path',
                        'urlSuffix'=>'.html',
			'rules'=>array(
//                                'http://bj.qimiaojiyi.com' => 'note/index',
//				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
//				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
//				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
                                'article/<aid:\d+>'=>'home/article',
                                'manager'=>'manager/admin/login',
                                'ucenter'=>'ucenter/user/login',
                                'note'=>'note/add'
			),
		),

		// database settings are configured in database.php
		'db'=>require(dirname(__FILE__).'/database.php'),

		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>YII_DEBUG ? null : 'site/error',
		),

		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
//				array(
//					'class'=>'CWebLogRoute',
//                                        'levels'=>'trace, info error, warning',
//				),
			),
		),
            //开启缓存
            'cache'=>array(
                'class'=>'system.caching.CFileCache',
		'directoryLevel' => 1,
            ),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
	),
);
