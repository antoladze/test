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
class Reader extends CActiveRecord
{
	public function tableName()
	{
		return 'reader';
	}

	public function rules()
	{
		return array(
			array('name', 'required'),
			array('name', 'length', 'max' => 64),
			array('name, create, update', 'safe', 'on' => 'search'),
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

		$criteria->compare('t.name', $this->name, true);
		$criteria->compareDate('t.create', $this->create);
		$criteria->compareDate('t.update', $this->update);

		return new CActiveDataProvider($this,
			array(
				 'criteria' => $criteria,
				 'sort' => array(
					 'defaultOrder' => 't.name',
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
