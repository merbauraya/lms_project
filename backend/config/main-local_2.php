<?php
/**
 * main-local.php
 *
 * @author: antonio ramirez <antonio@clevertech.biz>
 * Date: 7/22/12
 * Time: 6:25 PM
 *
 * This file should have the configuration settings of your backend application that will be merged to the main.php.
 *
 * This configurations should be only related to your development machine.
 */

return array(
	'components' => array(
		'db'=> array(
			'connectionString' => 'pgsql:host=localhost;dbname=lms',
			'username' => 'lms',
			'password' => 'saga123',
			'schemaCachingDuration' => YII_DEBUG ? 0 : 86400000, // 1000 days
			'enableParamLogging' => YII_DEBUG,
			'charset' => 'utf8'
		),
		'urlManager' => array(
			'urlFormat' => 'path',//$params['url.format'],
			'showScriptName' => false,//$params['url.showScriptName'],
			'rules' => array('<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',),//$params['url.rules']
		)
	)
);