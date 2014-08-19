<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'PPSDM Portal',
	'sourceLanguage'=>'en_us',
	'language'=>'id',

	// preloading 'log' component
	'preload'=>array('log',
					'bootstrap',
					),
	
	'aliases'=>array(
		'bootstrap'=>realpath(__DIR__ . '/../extensions/bootstrap'),
	),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.controllers.*',
		'application.extensions.*',
		//'bootstrap.widgets.*',
		//		'bootstrap.helpers.TbHtml',
			//	'bootstrap.helpers.*',
				// 'bootstrap.helpers.TbHtml',
        //'bootstrap.helpers.TbArray',
        //'bootstrap.behaviors.TbWidget',
		'application.extensions.phpmailer.JPhpMailer',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'manager',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','*','::1'),
			'generatorPaths'=>array('bootstrap.gii'),
		),
		
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
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),

		// uncomment the following to use a MySQL database
		
		'db'=>array(
	

//			'connectionString' => 'mysql:host=localhost;dbname=ppsdm_portal',
//			'username' => 'root',
//			'password' => '',
			
			'emulatePrepare' => true,
			
			'connectionString' => 'mysql:host=localhost;dbname=aplikasi_ppsdm_com',
			'username' => 'ppsdm',
			'password' => 'ppsdM2014',
			
			
		/*	
		'connectionString' => 'mysql:host=ppsdm.com;dbname=ppsdmcom_portal',
			'username' => 'ppsdmcom_portal',
			'password' => 'portal',
			*/

			'charset' => 'utf8',
		),
		
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
			/*	
				array(
					'class'=>'CWebLogRoute',
				),
			*/	
			),
		),
		'bootstrap' => array(
            //'class' => 'bootstrap.components.TbApi',   
			 'class' => 'bootstrap.components.Bootstrap',
			 'responsiveCss' => true,
        ),


	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'ppsdm@ppsdm.com',
	),
);
