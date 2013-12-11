<?php
Yii::setPathOfAlias('bootstrap', dirname(__FILE__).'/../extensions/bootstrap');

return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Библиотека Компании',
	'language' => 'ru',
	'defaultController' => 'reader',

	'preload'=>array('debug'),

	'import'=>array(
		'application.models.*',
		'application.components.*',
	),

	'modules'=>array(
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'123',
			'generatorPaths'=>array(
				'bootstrap.gii',
			),
		),
	),

	'components'=>array(
		'user'=>array(
			'allowAutoLogin'=>true,
		),

		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName' => false,
		),

		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=abc',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
			'enableProfiling' => YII_DEBUG,
		),

		'errorHandler'=>array(
			'errorAction'=>'site/error',
		),

		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
			),
		),

		'bootstrap'=>array(
			'class'=>'bootstrap.components.Bootstrap',
		),

		'format' => array(
			'datetimeFormat' => 'd.m.Y H:i:s',
		),

		'debug' => array(
			'enabled' => YII_DEBUG,
			'class' => 'ext.yii2-debug.Yii2Debug',
		),
	),

	'params'=>array(),
);