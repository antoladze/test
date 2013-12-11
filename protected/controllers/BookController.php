<?php

class BookController extends Controller
{
	public $actions = array('index', 'update', 'delete');

	public function actionView($id)
	{
		$this->render('view', array('model' => $this->loadModel($id)));
	}

	/**
	 * Действие рендерит список удовлетворяющих условиям поиска записей.
	 *
	 * @param string $text
	 * @param string $exclude
	 */
	public function actionDropdown($text, $exclude)
	{
		$text = trim($text);
		if ($text !== '') {
			$criteria = new DbCriteria;
			$criteria->fulltextSearch('t.title', $text, true);

			//Исключаются уже привязанные к модели записи.
			$exclude = explode(',', $exclude);
			if ($exclude)
				$criteria->addNotInCondition('t.id', $exclude);

			$items = Book::model()->findAll($criteria);

			if ($items) {
				echo '<ul class="dropdown-menu">';
				foreach ($items as $item)
					echo '<li>' . $item->getLink(array('data-id' => $item->id)) . '</li>';
				echo '</ul>';
			}
		}
	}

	/**
	 * Действие реализует добавление записи ajax-запросом и возвращает json-результат.
	 * @param string $text
	 */
	public function actionAddAuthor($text)
	{
		$model = new Author();

		$model->attributes = array(
			'name' => trim($text),
		);

		if (!$model->save())
			$result = array('error' => 'Не удалось добавить автора.');
		else
			$result = array(
				'id' => $model->id,
				'name' => $model->name,
				'url' => $this->createUrl('/author/view', array('id' => $model->id)),
			);

		echo CJSON::encode($result);
		exit;
	}

	/**
	 * Действие реализует добавление записи ajax-запросом и возвращает json-результат.
	 * @param string $text
	 */
	public function actionAddReader($text)
	{
		$model = new Reader();

		$model->attributes = array(
			'name' => trim($text),
		);

		if (!$model->save())
			$result = array('error' => 'Не удалось добавить читателя.');
		else
			$result = array(
				'id' => $model->id,
				'name' => $model->name,
				'url' => $this->createUrl('/reader/view', array('id' => $model->id)),
			);

		echo CJSON::encode($result);
		exit;
	}
}
