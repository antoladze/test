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
class Book extends CActiveRecord
{
	public function tableName()
	{
		return 'book';
	}

	public function rules()
	{
		return array(
			array('title', 'required'),
			array('title', 'length', 'max' => 128),
			array('title, create, update', 'safe', 'on' => 'search'),
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

		$criteria->fulltextSearch('t.title', $this->title);
		$criteria->compareDate('t.create', $this->create);
		$criteria->compareDate('t.update', $this->update);

		return new CActiveDataProvider($this,
			array(
				 'criteria' => $criteria,
				 'sort' => array(
					 'defaultOrder' => 't.title',
				 ),
				 'pagination' => array('pageSize' => 25),
			));
	}

	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	public function behaviors()
	{
		return array('dateBehavior' => array('class' => 'DateBehavior'));
	}
}
