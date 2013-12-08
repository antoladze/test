<?php

class DateBehavior extends CActiveRecordBehavior
{
	public function beforeSave($event)
	{
		$date = date('Y-m-d H:i:s');
		$model = $this->owner;

		$model->update = $date;
		if ($model->isNewRecord)
			$model->create = $date;
	}
}
