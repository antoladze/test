<?php

class AuthorController extends Controller
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
			$criteria->fulltextSearch('t.name', $text, true);

			//Исключаются уже привязанные к модели записи.
			$exclude = explode(',', $exclude);
			if ($exclude)
				$criteria->addNotInCondition('t.id', $exclude);

			$items = Author::model()->findAll($criteria);

			if ($items) {
				echo '<ul class="dropdown-menu">';
				foreach ($items as $item)
					echo '<li>' . $item->getLink(array('data-id' => $item->id)) . '</li>';
				echo '</ul>';
			}
		}
	}
}
