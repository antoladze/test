<?php

/**
 * Действие создания и обновления записи.
 */
class ActionUpdate extends CAction
{
	public $view;

	public $criteria = array();

	public $success = 'Данные успешно сохранены.';

	public function run($id = null)
	{
		$controller = Yii::app()->controller;
		$modelName = isset($this->criteria['model']) ? $this->criteria['model'] : $controller->modelName;
		$view = isset($this->view) ? $this->view : 'update';

		if ($id === null)
			$model = new $modelName();
		else
			$model = $controller->loadModel($id, $this->criteria);

		$controller->performAjaxValidation($model);

		if (isset($_POST[$modelName])) {
			$model->attributes = $_POST[$modelName];

			if ($model->save()) {
				Yii::app()->user->setFlash('success', $this->success);
				$controller->redirect(array($view, 'id' => $model->id));
			}
		}

		$controller->render($view, array('model' => $model));
	}
}
