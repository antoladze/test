<?php

/**
 * This is the model class for table "book".
 *
 * The followings are the available columns in table 'book':
 * @property string $id
 * @property string $title
 * @property string $create
 * @property string $update
 */
class Book extends LibraryModel
{
	public $newAuthors = array();
	public $newReaders = array();

	public function tableName()
	{
		return 'book';
	}

	public function rules()
	{
		return array(
			array('title', 'required'),
			array('title', 'length', 'max' => 128),
			array('newAuthors, newReaders', 'type', 'type' => 'array'),
			array('title, create, update', 'safe', 'on' => 'search'),
		);
	}

	public function relations()
	{
		return array(
			//Авторы книги.
			'authors' => array(self::MANY_MANY, 'Author', 'book_author(book_id, author_id)'),
			//Читатели книги.
			'readers' => array(self::MANY_MANY, 'Reader', 'book_reader(book_id, reader_id)'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Название',
			'create' => 'Дата добавления',
			'update' => 'Дата редактирования',
		);
	}

	public function search()
	{
		$criteria = new DbCriteria;
		$criteria->with = array('authors', 'readers');

		$criteria->fulltextSearch('t.title', $this->title);
		$criteria->compareDate('t.create', $this->create);
		$criteria->compareDate('t.update', $this->update);

		return new CActiveDataProvider($this,
			array(
				 'criteria' => $criteria,
				 'sort' => array(
					 'defaultOrder' => 't.title',
				 ),
				 'pagination' => array('pageSize' => 15),
			));
	}

	/**
	 * Метод возвращает провайдер данных для отчета #1.
	 * @return CArrayDataProvider
	 */
	public function report1()
	{
		$items = Yii::app()->db->createCommand()
			->select('t.id, t.title,' .
			'(SELECT COUNT(a.id) FROM author a JOIN book_author ba ON ba.author_id = a.id WHERE ba.book_id = t.id) AS authors,' .
			'(SELECT COUNT(r.id) FROM reader r JOIN book_reader br ON br.reader_id = r.id WHERE br.book_id = t.id) AS readers')
			->from('book t')
			->having('authors > 2 AND readers')
			->order('t.title')
			->queryAll();

		$ids = array();
		foreach ($items as $item)
			$ids[] = $item['id'];

		$authors = Author::getItemsByBook($ids);
		$readers = Reader::getItemsByBook($ids);

		foreach ($items as $i => $item) {
			$items[$i]['authors'] = $authors[$item['id']];
			$items[$i]['readers'] = $readers[$item['id']];
		}

		return new CArrayDataProvider($items);
	}

	/**
	 * Метод возвращает провайдер данных для отчета #2.
	 * @return CArrayDataProvider
	 */
	public function report2()
	{
		$query = Yii::app()->db->createCommand()
			->select('COUNT(r.id)')
			->from('reader r')
			->join('book_reader br', 'br.reader_id = r.id')
			->join('book_author ba', 'ba.book_id = br.book_id')
			->where('ba.author_id = t.id')
			->text;

		$items = Yii::app()->db->createCommand()
			->select('t.id, t.name,' .
			'(' . $query . ') AS readers')
			->from('author t')
			->having('readers > 3')
			->order('t.name')
			->queryAll();

		$ids = array();
		foreach ($items as $item)
			$ids[] = $item['id'];

		$rows = Yii::app()->db->createCommand()
			->select('ba.author_id, t.title')
			->from('book t')
			->join('book_author ba', 'ba.book_id = t.id')
			->where(array('in', 'ba.author_id', $ids))
			->order('t.title')
			->queryAll();

		$books = array();
		foreach ($rows as $row) {
			$id = $row['author_id'];
			if (!isset($books[$id]))
				$books[$id] = array();
			$books[$id][] = $row['title'];
		}

		foreach ($items as $i => $item)
			$items[$i]['books'] = isset($books[$item['id']]) ? $books[$item['id']] : array();

		return new CArrayDataProvider($items);
	}

	/**
	 * Метод возвращает провайдер данных для отчета #3.
	 * @return CArrayDataProvider
	 */
	public function report3()
	{
		$items = array();
		$ids = array();

		if ($range = Yii::app()->db->createCommand()->select('MAX(id)')->from('book')->queryScalar()) {
			$range = range(1, $range);
			shuffle($range);

			$i = 0;
			while (count($items) < 5 && $i < count($range)) {
				$id = $range[$i++];

				if ($result = Yii::app()->db->createCommand()
					->select('id, title')
					->from('book')
					->where('id = :id', array(':id' => $id))
					->queryRow()
				){
					$items[] = $result;
					$ids[] = $id;
				}
			}

			$authors = Author::getItemsByBook($ids);
			$readers = Reader::getItemsByBook($ids);

			foreach ($items as $i => $item) {
				$items[$i]['authors'] = isset($authors[$item['id']]) ? $authors[$item['id']] : array();
				$items[$i]['readers'] = isset($readers[$item['id']]) ? $readers[$item['id']] : array();
			}
		}

		return new CArrayDataProvider($items);
	}

	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * Обновление связанных данных после сохранения записи.
	 */
	protected function afterSave()
	{
		Author::remove($this->id);
		Reader::remove($this->id);

		foreach ($this->newAuthors as $author)
			Yii::app()->db->createCommand()
				->insert('book_author', array('book_id' => $this->id, 'author_id' => $author));

		foreach ($this->newReaders as $reader)
			Yii::app()->db->createCommand()
				->insert('book_reader', array('book_id' => $this->id, 'reader_id' => $reader));
	}

	/**
	 * Удаление связанных данных после удаления записи.
	 */
	protected function afterDelete()
	{
		Author::remove($this->id);
		Reader::remove($this->id);
	}
}
