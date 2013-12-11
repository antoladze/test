<?php

/**
 * This is the model class for table "author".
 *
 * The followings are the available columns in table 'author':
 * @property string $id
 * @property string $name
 * @property string $create
 * @property string $update
 */
class Author extends LibraryModel
{
	public $newBooks = array();

	public function tableName()
	{
		return 'author';
	}

	public function rules()
	{
		return array(
			array('name', 'required'),
			array('name', 'length', 'max' => 64),
			array('newBooks', 'type', 'type' => 'array'),
			array('name, create, update', 'safe', 'on' => 'search'),
		);
	}

	public function relations()
	{
		return array(
			//Книги автора.
			'books' => array(self::MANY_MANY, 'Book', 'book_author(author_id, book_id)'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Имя',
			'create' => 'Дата добавления',
			'update' => 'Дата редактирования',
		);
	}

	public function search()
	{
		$criteria = new DbCriteria;
		$criteria->with = array('books');

		$criteria->fulltextSearch('t.name', $this->name);
		$criteria->compareDate('t.create', $this->create);
		$criteria->compareDate('t.update', $this->update);

		return new CActiveDataProvider($this,
			array(
				 'criteria' => $criteria,
				 'sort' => array(
					 'defaultOrder' => 't.name',
				 ),
				 'pagination' => array('pageSize' => 15),
			));
	}

	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * Метод возвращает авторов, сгруппированных и найденных по книгам.
	 * @static
	 *
	 * @param array $books
	 *
	 * @return array
	 */
	public static function getItemsByBook($books)
	{
		$rows = Yii::app()->db->createCommand()
			->select('ba.book_id, t.name')
			->from('author t')
			->join('book_author ba', 'ba.author_id = t.id')
			->where(array('in', 'ba.book_id', $books))
			->queryAll();

		$result = array();
		foreach ($rows as $row) {
			$id = $row['book_id'];
			if (!isset($result[$id]))
				$result[$id] = array();
			$result[$id][] = $row['name'];
		}
		return $result;
	}

	/**
	 * Удаление связей с книгами.
	 * @static
	 *
	 * @param mixed $book
	 * @param mixed $author
	 */
	public static function remove($book = null, $author = null)
	{
		$condition = array();
		$params = array();

		if ($book !== null) {
			$condition[] = 'book_id = :book';
			$params[':book'] = $book;
		}

		if ($author !== null) {
			$condition[] = 'author_id = :author';
			$params[':author'] = $author;
		}

		if ($condition)
			Yii::app()->db->createCommand()
				->delete('book_author', implode(' AND ', $condition), $params);
	}

	/**
	 * Обновление связанных данных после сохранения записи.
	 */
	protected function afterSave()
	{
		self::remove(null, $this->id);

		foreach ($this->newBooks as $book)
			Yii::app()->db->createCommand()
				->insert('book_author', array('book_id' => $book, 'author_id' => $this->id));
	}

	/**
	 * Удаление связанных данных после удаления записи.
	 */
	protected function afterDelete()
	{
		self::remove(null, $this->id);
	}
}
