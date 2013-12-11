<?php

/**
 * This is the model class for table "reader".
 *
 * The followings are the available columns in table 'reader':
 * @property string $id
 * @property string $name
 * @property string $create
 * @property string $update
 */
class Reader extends LibraryModel
{
	public $newBooks = array();

	public function tableName()
	{
		return 'reader';
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
			//Книги у читателя.
			'books' => array(self::MANY_MANY, 'Book', 'book_reader(reader_id, book_id)'),
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

		$criteria->compare('t.name', $this->name, true);
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
	 * Метод возвращает читателей, сгруппированных и найденных по книгам.
	 * @static
	 *
	 * @param array $books
	 *
	 * @return array
	 */
	public static function getItemsByBook($books)
	{
		$rows = Yii::app()->db->createCommand()
			->select('br.book_id, t.name')
			->from('reader t')
			->join('book_reader br', 'br.reader_id = t.id')
			->where(array('in', 'br.book_id', $books))
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
	 * @param mixed $reader
	 */
	public static function remove($book = null, $reader = null)
	{
		$condition = array();
		$params = array();

		if ($book !== null) {
			$condition[] = 'book_id = :book';
			$params[':book'] = $book;
		}

		if ($reader !== null) {
			$condition[] = 'reader_id = :reader';
			$params[':reader'] = $reader;
		}

		if ($condition)
			Yii::app()->db->createCommand()
				->delete('book_reader', implode(' AND ', $condition), $params);
	}

	/**
	 * Обновление связанных данных после сохранения записи.
	 */
	protected function afterSave()
	{
		self::remove(null, $this->id);

		foreach ($this->newBooks as $book)
			Yii::app()->db->createCommand()
				->insert('book_reader', array('book_id' => $book, 'reader_id' => $this->id));
	}

	/**
	 * Удаление связанных данных после удаления записи.
	 */
	protected function afterDelete()
	{
		self::remove(null, $this->id);
	}
}
