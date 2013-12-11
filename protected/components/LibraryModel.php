<?php

/**
 * Родительский класс для моделей.
 * Содержит специфические методы, используемые в системе.
 */
class LibraryModel extends CActiveRecord
{
	/**
	 * Перед сохранением обновляются поля дат.
	 * @return bool
	 */
	protected function beforeSave()
	{
		if (parent::beforeSave()) {
			$date = date('Y-m-d H:i:s');
			$this->update = $date;
			if ($this->isNewRecord)
				$this->create = $date;
			return true;
		} else
			return false;
	}

	/**
	 * Метод возвращает html-ссылку на страницу просмотра записи.
	 *
	 * @param array $options
	 *
	 * @return mixed
	 */
	public function getLink($options = array())
	{
		$label = isset($this->title) ? $this->title : $this->name;
		$route = '/' . $this->tableName() . '/view';

		return CHtml::link($label, array($route, 'id' => $this->id), $options);
	}

	/**
	 * Список читателей.
	 *
	 * @param string $separator
	 *
	 * @return string
	 */
	public function getReaders($separator = ', ')
	{
		return $this->getItems('readers', $separator);
	}

	/**
	 * Список авторов.
	 *
	 * @param string $separator
	 *
	 * @return string
	 */
	public function getAuthors($separator = ', ')
	{
		return $this->getItems('authors', $separator);
	}

	/**
	 * Список книг.
	 *
	 * @param string $separator
	 *
	 * @return string
	 */
	public function getBooks($separator = ', ')
	{
		return $this->getItems('books', $separator);
	}

	/**
	 * Метод возвращает html-строку с элементами из связи модели.
	 *
	 * @param string $name
	 * @param string $separator
	 *
	 * @return string
	 */
	protected function getItems($name, $separator)
	{
		$items = array();

		foreach ($this->$name as $item)
			$items[] = $item->getLink();

		return $items ? implode($separator, $items) : '-';
	}
}
