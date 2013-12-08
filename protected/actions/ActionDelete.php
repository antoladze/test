<?php

class ActionDelete extends CAction
{
	public $redirect = array('index');

	public $criteria = array();

	public function run($id)
	{
		$controller = Yii::app()->controller;

		$controller->loadModel($id, $this->criteria)->delete();

		if (!Yii::app()->request->isAjaxRequest) {
			if ($this->redirect === null)
				$controller->refresh();
			else
				$controller->redirect($this->redirect);
		}
	}
}
