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

$components = require 'component.php';
return CMap::mergeArray(
	array(
		'name' => 'LMS Admin Site',
		// @see http://www.yiiframework.com/doc/api/1.1/CApplication#basePath-detail
		'basePath' => 'backend',
		// set parameters
		'params' => $params,
		// preload components required before running applications
		// @see http://www.yiiframework.com/doc/api/1.1/CModule#preload-detail
		'preload' => array('bootstrap', 'log','chartjs'),
		// @see http://www.yiiframework.com/doc/api/1.1/CApplication#language-detail
		'sourceLanguage' => 'en_us',
        'language' => 'ms_MY',
        'timeZone' => 'Asia/Kuala_Lumpur',

		// setup import paths aliases
        'aliases'=>array(
			'xupload'=>'common.extensions.xupload',
            'chartjs' => 'common.extensions.chartjs',
 
            
		
		),
        
        
        // @see http://www.yiiframework.com/doc/api/1.1/YiiBase#import-detail
		'import' => array(
			'common.components.*',
			'common.extensions.*',
			'common.extensions.xupload.models.*',
			'common.modules.auth.*',
			'common.modules.auth.components.*',
			'backend.components.z3950.*',
  
			'common.models.*',
			'common.lib.vendor.*',

			'application.components.*',
			'application.controllers.*',
			'application.models.*',
			'application.models.base.*',
			'application.models.wizard.*',
			
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
				'userNameColumn' => 'name', // the name of the user name column.
				'userIdColumn' => 'id', // the name of the user id column.
                'class'=>'common.modules.auth.AuthModule', 
			),
            'usermgmt'=>array(
                'class'=>'common.modules.usermgmt.UsermgmtModule',
            ),
            'report'=>array(
                'class'=>'backend.modules.report.ReportModule',
            ),
            'inquiry'=>array(
                'class'=>'backend.modules.inquiry.InquiryModule',
            ),
		), 
		'components'=>array(),
			
		'params'=>array(
		// this is used in contact page
            'adminEmail'=>'webmaster@example.com',
            'dateFormat'=>'dd/mm/yyyy'
        )		
	),
	CMap::mergeArray($mainEnvConfiguration, $mainLocalConfiguration,$components)
);
