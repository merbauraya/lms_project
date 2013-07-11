<?php
/**
 * main.php
 *
 * @author: antonio ramirez <antonio@clevertech.biz>
 * Date: 7/22/12
 * Time: 5:48 PM
 *
 * This file holds the configuration settings of your backend application.
 **/
$backendConfigDir = dirname(__FILE__);

$root = $backendConfigDir . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..';

$params = require_once($backendConfigDir . DIRECTORY_SEPARATOR . 'params.php');

// Setup some default path aliases. These alias may vary from projects.
Yii::setPathOfAlias('root', $root);
Yii::setPathOfAlias('common', $root . DIRECTORY_SEPARATOR . 'common');
Yii::setPathOfAlias('backend', $root . DIRECTORY_SEPARATOR . 'backend');
Yii::setPathOfAlias('www', $root. DIRECTORY_SEPARATOR . 'backend' . DIRECTORY_SEPARATOR . 'www');

//root directory for our uploaded file
Yii::setPathOfAlias('upload', $root. DIRECTORY_SEPARATOR . 'backend' . DIRECTORY_SEPARATOR . 'www'.DIRECTORY_SEPARATOR.'upload' );
Yii::setPathOfAlias('uploadtmp', $root. DIRECTORY_SEPARATOR . 'backend' . DIRECTORY_SEPARATOR . 'www'.DIRECTORY_SEPARATOR.'upload'.DIRECTORY_SEPARATOR.'tmp' );
Yii::setPathOfAlias('uploadMarc',Yii::getPathOfAlias('upload').DIRECTORY_SEPARATOR.'marc'.DIRECTORY_SEPARATOR);

Yii::setPathOfAlias('extcommon', $root . DIRECTORY_SEPARATOR . 'common' . DIRECTORY_SEPARATOR . 'extensions');
Yii::setPathOfAlias('xsl', Yii::getPathOfAlias('backend') . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'xsl'.DIRECTORY_SEPARATOR);


//Yii::setPathOfAlias('auth', $root . DIRECTORY_SEPARATOR . 'common' . DIRECTORY_SEPARATOR . 'modules'. DIRECTORY_SEPARATOR . 'auth');

/* uncomment if you need to use frontend folders */
/* Yii::setPathOfAlias('frontend', $root . DIRECTORY_SEPARATOR . 'frontend'); */


$mainLocalFile = $backendConfigDir . DIRECTORY_SEPARATOR . 'main-local.php';
$mainLocalConfiguration = file_exists($mainLocalFile)? require($mainLocalFile): array();

$mainEnvFile = $backendConfigDir . DIRECTORY_SEPARATOR . 'main-env.php';
$mainEnvConfiguration = file_exists($mainEnvFile) ? require($mainEnvFile) : array();

return CMap::mergeArray(
	array(
		'name' => 'LMS Admin Site',
		// @see http://www.yiiframework.com/doc/api/1.1/CApplication#basePath-detail
		'basePath' => 'backend',
		// set parameters
		'params' => $params,
		// preload components required before running applications
		// @see http://www.yiiframework.com/doc/api/1.1/CModule#preload-detail
		'preload' => array('bootstrap', 'log'),
		// @see http://www.yiiframework.com/doc/api/1.1/CApplication#language-detail
		'language' => 'en',
        'timeZone' => 'Asia/Kuala_Lumpur',

		// using bootstrap theme ? not needed with extension
//		'theme' => 'bootstrap',
		// setup import paths aliases
		// @see http://www.yiiframework.com/doc/api/1.1/YiiBase#import-detail
		'import' => array(
			'common.components.*',
			'common.extensions.*',
			'common.extensions.xupload.models.*',
			'common.modules.auth.*',
			'common.modules.auth.components.*',
			'backend.components.z3950.*',
			/* uncomment if required */
			/* 'common.extensions.behaviors.*', */
			/* 'common.extensions.validators.*', */
			'common.models.*',
			'common.lib.vendor.*',
			// uncomment if behaviors are required
			// you can also import a specific one
			/* 'common.extensions.behaviors.*', */
			// uncomment if validators on common folder are required
			/* 'common.extensions.validators.*', */
			'application.components.*',
			'application.controllers.*',
			'application.models.*',
			'application.models.base.*',
			'application.models.wizard.*',
			
		),
		'aliases'=>array(
			'xupload'=>'common.extensions.xupload',
            
		
		),
		/* uncomment and set if required */
		// @see http://www.yiiframework.com/doc/api/1.1/CModule#setModules-detail
		 'modules' => array(
			'gii' => array(
				'class' => 'system.gii.GiiModule',
				'password' => 'saga123',
                'ipFilters' => false,
				'generatorPaths' => array(
					'bootstrap.gii',
					'application.gii.generators',
				)
			),
			'auth'=>array(
				'userClass' => 'Patron', // the name of the user model class.
				'userNameColumn' => 'username', // the name of the user name column.
				'userIdColumn' => 'id', // the name of the user id column.
                'class'=>'common.modules.auth.AuthModule', 
			),
		), 
		'components' => array(
			'user' => array(
				'allowAutoLogin'=>true,
                'class' => 'auth.components.AuthWebUser',
			),
			/* load bootstrap components */
			'bootstrap' => array(
				'class' => 'common.extensions.bootstrap.components.Bootstrap',
				'responsiveCss' => true,
			),
			'errorHandler' => array(
				// @see http://www.yiiframework.com/doc/api/1.1/CErrorHandler#errorAction-detail
				'errorAction'=>'site/error'
			),
			'log'=>array(
				'class'=>'CLogRouter',
				'routes'=>array(
					array(
						'class'=>'CFileLogRoute',//'class'=>'CDbLogRoute',
						//'connectionID' => 'db',
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
		      'config' => array(
		               'class'=>'common.extensions.EConfig',
		      ),
			  'authManager'=>array(
				'class'=> 'auth.components.CachedDbAuthManager',//  'CDbAuthManager',
				'cachingDuration'=>3600,
				'connectionID'=>'db',
				'behaviors' => array(
					'auth'=>array(
						'class'=>'common.modules.auth.components.AuthBehavior',
						'admins'=>array('admin'),
						),
					),
				),
//			'db'=> array(
//				'connectionString' => $params['db.connectionString'],
//				'username' => $params['db.username'],
//				'password' => $params['db.password'],
//				'schemaCachingDuration' => YII_DEBUG ? 0 : 86400000, // 1000 days
//				'enableParamLogging' => YII_DEBUG,
//				'charset' => 'utf8'
//			),
			'urlManager' => array(
				'urlFormat' => 'path',
				'showScriptName' => false,
				'urlSuffix' => '/',
				'rules' => $params['url.rules']
			),
			/* make sure you have your cache set correctly before uncommenting */
			/* 'cache' => $params['cache.core'], */
			/* 'contentCache' => $params['cache.content'] */
		),
		'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
		'dateFormat'=>'dd/mm/yyyy'
        )		
	),
	CMap::mergeArray($mainEnvConfiguration, $mainLocalConfiguration)
);
