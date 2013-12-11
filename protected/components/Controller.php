<?php

class Controller extends CController
{
	public $layout = '//layouts/column1';

	public $breadcrumbs = array();

	/**
	 * Упрощенный способ подключения действий, вынесенных в отдельный класс.
	 * @var array
	 */
	public $actions = array();

	/**
	 * Имя используемой в контроллере модели.
	 * @var string
	 */
	public $modelName;

	/**
	 * Сообщение, выводимое в случае неудачного поиска записи модели.
	 * @var string
	 */
	public $modelNotFoundMessage = 'Не удалось загрузить необходимые данные.';

	public function init()
	{
		parent::init();

		//Если имя модели не указано, ему присваивается имя контроллера.
		if (!isset($this->modelName))
			$this->modelName = ucfirst($this->id);
	}

	/**
	 * Метод возвращает информацию о подключаемых действиях.
	 * Получает данные из свойства $this->actions.
	 *
	 * @return array
	 */
	function actions()
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

	/**
	 * Метод производит поиск записи в модели по первичному ключу и обрабатывает результат.
	 *
	 * @param mixed $pk
	 * @param array $criteria
	 * @param bool  $allowNull
	 *
	 * @return string
	 * @throws CHttpException
	 * @throws CException
	 */
	public function loadModel($pk, $criteria = array(), $allowNull = false)
	{
		//Имя модели передается в переменной $criteria.
		if (isset($criteria['model'])) {
			$model = $criteria['model'];
			unset($criteria['model']);
		} else
			$model = $this->modelName;

		//Сообщение о ненайденной записи передается в переменной $criteria.
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

		//Если запись не найдена и пустое значение не допустимо вызывается исключение.
		if (!$allowNull && $model === null)
			throw new CHttpException(404, $message);

		return $model;
	}

	/**
	 * Валидация формы и вывод json-результата.
	 *
	 * @param mixed $model
	 * @param string $ajax
	 */
	public function performAjaxValidation($model, $ajax = 'data-form')
	{
		if (Yii::app()->request->isAjaxRequest && isset($_POST['ajax']) && $_POST['ajax'] === $ajax) {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	/**
	 * Рендеринг табов навигации.
	 *
	 * @param string $active
	 * @param mixed $model
	 *
	 * @return string
	 */
	public function getNavTabs($active, $model = null)
	{
		$result = '<ul class="nav nav-tabs">';

		$tabs = $this->getNavTabsItems($model);

		foreach ($tabs as $i => $tab)
			$result .= '<li' . ($active == $i ? ' class="active"' : '') . '>' . $tab . '</li>';

		return $result . '</ul>';
	}

	/**
	 * Метод возвращает список табов для данного контроллера.
	 *
	 * @param $model
	 *
	 * @return array
	 */
	public function getNavTabsItems($model)
	{
		return array(
			'view' => '<a href="' . $this->createUrl('view', array('id' => $model->id)) . '"><i class="icon-info-sign"></i> Информация</a>',
			'update' => '<a href="' . $this->createUrl('update', array('id' => $model->id)) . '"><i class="icon-pencil"></i> Редактировать</a>',
		);
	}
}