<?php

/**
 * Действие вывода списка элементов.
 */
class ActionIndex extends CAction
{
	public $modelName;

	public $view;

	public function run()
	{
		$controller = Yii::app()->controller;
		$modelName = isset($this->modelName) ? $this->modelName : $controller->modelName;
		$view = isset($this->view) ? $this->view : 'index';

		$model = new $modelName('search');

		$model->unsetAttributes();

		if (isset($_GET[$modelName]))
			$model->attributes = $_GET[$modelName];

		if (Yii::app()->request->isAjaxRequest)
			$controller->renderPartial('_'.$_GET['ajax'], array('model' => $model));
		else
			$controller->render($view, array('model' => $model));
	}
}
