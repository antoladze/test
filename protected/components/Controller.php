<?php

class Controller extends CController
{
	public $layout = '//layouts/column1';

	public $breadcrumbs = array();

	public $actions = array();

	public $modelName;

	public $modelNotFoundMessage = 'Не удалось загрузить необходимые данные.';

	public function init()
	{
		parent::init();

		if (!isset($this->modelName))
			$this->modelName = ucfirst($this->id);
	}

	public function actions()
	{
		$actions = array();

		foreach ($this->actions as $i => $item) {
			$options = array();

			if (is_string($i)) {
				if (is_string($item))
					$options['class'] = $item;
				else
					$options = $item;
			} elseif (is_string($item))
				$i = $item;

			$options['class'] = 'application.actions.' . (isset($options['class']) ? $options['class'] : 'Action' . ucfirst($i));

			$actions[$i] = $options;
		}

		return $actions;
	}

	public function loadModel($pk, $criteria = array(), $allowNull = false)
	{
		if (isset($criteria['model'])) {
			$model = $criteria['model'];
			unset($criteria['model']);
		} else
			$model = $this->modelName;

		if (isset($criteria['message'])) {
			$message = $criteria['message'];
			unset($criteria['message']);
		} else
			$message = $this->modelNotFoundMessage;

		if (!$criteria)
			$criteria = '';

		if (is_numeric($pk))
			$model = $model::model()->findByPk($pk, $criteria, array());
		elseif (is_array($pk))
			$model = $model::model()->findByAttributes($pk, $criteria, array());
		else
			throw new CException('Неизвестный тип параметра.');

		if (!$allowNull && $model === null)
			throw new CHttpException(404, $message);

		return $model;
	}

	public function performAjaxValidation($model, $ajax = 'data-form')
	{
		if (Yii::app()->request->isAjaxRequest && isset($_POST['ajax']) && $_POST['ajax'] === $ajax) {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function getNavTabs($active, $model = null)
	{
		$result = '<ul class="nav nav-tabs">';

		$tabs = $this->getNavTabsItems($model);

		foreach ($tabs as $i => $tab)
			$result .= '<li' . ($active == $i ? ' class="active"' : '') . '>' . $tab . '</li>';

		return $result . '</ul>';
	}

	public function getNavTabsItems($model)
	{
		return array(
			'view' => '<a href="' . $this->createUrl('view', array('id' => $model->id)) . '"><i class="icon-info-sign"></i> Информация</a>',
			'update' => '<a href="' . $this->createUrl('update', array('id' => $model->id)) . '"><i class="icon-pencil"></i> Редактировать</a>',
		);
	}
}